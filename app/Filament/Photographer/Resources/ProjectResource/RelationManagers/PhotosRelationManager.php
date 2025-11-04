<?php

namespace App\Filament\Photographer\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    protected static ?string $title = 'Photo Management';

    protected static ?string $modelLabel = 'Photo';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('photos')
                    ->label('Upload Photos')
                    ->image()
                    ->multiple()
                    ->directory(fn () => 'photos/' . now()->format('Y/m/d'))
                    ->disk('public')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->maxSize(102400)
                    ->maxFiles(20)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
                    ->helperText('Supports JPG, PNG, WEBP formats. Max file size: 100MB. Max 20 photos per upload. Files will preserve original filenames.')
                    ->required()
                    ->columnSpanFull()
                    ->imagePreviewHeight('250')
                    ->panelLayout('grid')
                    ->reorderable()
                    ->appendFiles(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('original_name')
            ->columns([
                Tables\Columns\ImageColumn::make('file_path')
                    ->label('Photo')
                    ->disk('public')
                    ->height(200)
                    ->width(200)
                    ->extraImgAttributes(['class' => 'rounded-lg object-cover'])
                    ->grow(false),
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('original_name')
                        ->label('Filename')
                        ->searchable()
                        ->limit(25)
                        ->weight('bold'),
                    Tables\Columns\TextColumn::make('width')
                        ->label('Dimensions')
                        ->formatStateUsing(fn ($record) => $record->width && $record->height ? "{$record->width} × {$record->height}" : '-')
                        ->icon('heroicon-m-photo')
                        ->color('gray'),
                    Tables\Columns\TextColumn::make('file_size_formatted')
                        ->label('Size')
                        ->icon('heroicon-m-arrow-down-tray')
                        ->color('gray'),
                    Tables\Columns\TextColumn::make('download_count')
                        ->label('Downloads')
                        ->suffix(' times')
                        ->icon('heroicon-m-chart-bar')
                        ->color('success'),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
                '2xl' => 4,
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Upload Photos')
                    ->icon('heroicon-o-cloud-arrow-up')
                    ->action(function (array $data): void {
                        if (empty($data['photos'])) {
                            return;
                        }

                        $photos = is_array($data['photos']) ? $data['photos'] : [$data['photos']];
                        $maxOrder = $this->ownerRecord->photos()->max('order') ?? 0;

                        foreach ($photos as $index => $photoPath) {
                            $fullPath = Storage::disk('public')->path($photoPath);
                            $imageSize = @getimagesize($fullPath);

                            // Get original filename (extract from path)
                            $originalName = basename($photoPath);

                            $this->ownerRecord->photos()->create([
                                'file_path' => $photoPath,
                                'thumbnail_path' => null,
                                'original_name' => $originalName,
                                'file_size' => Storage::disk('public')->size($photoPath),
                                'mime_type' => Storage::disk('public')->mimeType($photoPath),
                                'width' => $imageSize[0] ?? null,
                                'height' => $imageSize[1] ?? null,
                                'order' => $maxOrder + $index + 1,
                                'download_count' => 0,
                            ]);
                        }

                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Photos Uploaded Successfully')
                            ->body('Successfully uploaded ' . count($photos) . ' photos. Files saved to photos/' . now()->format('Y/m/d') . ' directory')
                            ->send();
                    })
                    ->modalWidth('4xl'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View Full Size')
                    ->icon('heroicon-o-magnifying-glass-plus')
                    ->color('info')
                    ->modalContent(fn ($record) => view('filament.photographer.photo-preview', [
                        'photo' => $record,
                        'url' => Storage::disk('public')->url($record->file_path)
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalWidth('5xl')
                    ->slideOver(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('download')
                        ->label('Download')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function ($record) {
                            return Storage::disk('public')->download($record->file_path, $record->original_name);
                        }),
                    Tables\Actions\EditAction::make()
                        ->label('Edit Order')
                        ->form([
                            Forms\Components\TextInput::make('order')
                                ->label('Order')
                                ->numeric()
                                ->required(),
                        ]),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('download_selected')
                        ->label('Bulk Download')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('success')
                        ->action(function ($records) {
                            $zip = new \ZipArchive;
                            $zipPath = storage_path('app/temp/photos-' . time() . '.zip');

                            if (!is_dir(dirname($zipPath))) {
                                mkdir(dirname($zipPath), 0755, true);
                            }

                            if ($zip->open($zipPath, \ZipArchive::CREATE) === true) {
                                foreach ($records as $photo) {
                                    $filePath = Storage::disk('public')->path($photo->file_path);
                                    if (file_exists($filePath)) {
                                        $zip->addFile($filePath, $photo->original_name);
                                    }
                                }
                                $zip->close();

                                return response()->download($zipPath, 'photos-bundle.zip')->deleteFileAfterSend(true);
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withTrashed())
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->paginated([12, 24, 48, 96])
            ->poll('30s')
            ->deferLoading();
    }
}
