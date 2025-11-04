<?php

namespace App\Filament\Photographer\Resources;

use App\Filament\Photographer\Resources\ProjectResource\Pages;
use App\Filament\Photographer\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    protected static ?string $modelLabel = 'Project';

    protected static ?string $pluralModelLabel = 'Projects';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Project Title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('client_name')
                    ->label('Client Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\DatePicker::make('project_date')
                    ->label('Project Date')
                    ->required()
                    ->default(now())
                    ->native(false),

                Forms\Components\TextInput::make('location')
                    ->label('Location')
                    ->maxLength(255),

                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->rows(2)
                    ->maxLength(1000),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'in_progress' => 'In Progress',
                        'delivered' => 'Delivered',
                    ])
                    ->required()
                    ->default('in_progress')
                    ->native(false),

                Forms\Components\Toggle::make('allow_download')
                    ->label('Allow Download')
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Project Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Client Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('project_date')
                    ->label('Project Date')
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'in_progress',
                        'success' => 'delivered',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'in_progress' => 'In Progress',
                        'delivered' => 'Delivered',
                    }),
                Tables\Columns\TextColumn::make('photos_count')
                    ->label('Photos')
                    ->counts('photos')
                    ->sortable(),
                Tables\Columns\TextColumn::make('view_count')
                    ->label('Views')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('download_count')
                    ->label('Downloads')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('allow_download')
                    ->label('Allow Download')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'in_progress' => 'In Progress',
                        'delivered' => 'Delivered',
                    ]),
                Tables\Filters\Filter::make('recent_access')
                    ->label('Accessed in Last 7 Days')
                    ->query(fn (Builder $query): Builder =>
                        $query->whereHas('accesses', function ($q) {
                            $q->where('accessed_at', '>=', now()->subDays(7));
                        })
                    ),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('share')
                        ->label('Share')
                        ->icon('heroicon-o-share')
                        ->color('success')
                        ->url(fn (Project $record): string => route('gallery.show', $record->share_token))
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('copy_link')
                        ->label('Copy Link')
                        ->icon('heroicon-o-link')
                        ->action(fn (Project $record) => null)
                        ->requiresConfirmation()
                        ->modalHeading('Share Link')
                        ->modalDescription(fn (Project $record) => $record->share_url)
                        ->modalSubmitAction(false)
                        ->modalCancelActionLabel('Close'),
                    Tables\Actions\Action::make('qrcode')
                        ->label('QR Code')
                        ->icon('heroicon-o-qr-code')
                        ->color('info')
                        ->modalHeading('Project Share QR Code')
                        ->modalDescription(fn (Project $record) => 'Scan QR code to access: ' . $record->share_url)
                        ->modalContent(fn (Project $record) => view('filament.photographer.qrcode', [
                            'qrcode' => QrCode::size(300)->generate($record->share_url),
                            'url' => $record->share_url
                        ]))
                        ->modalSubmitAction(false)
                        ->modalCancelActionLabel('Close'),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('project_date', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Project Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->label('Project Title'),
                        Infolists\Components\TextEntry::make('client_name')
                            ->label('Client Name'),
                        Infolists\Components\TextEntry::make('project_date')
                            ->label('Project Date')
                            ->date('Y-m-d'),
                        Infolists\Components\TextEntry::make('location')
                            ->label('Location'),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'in_progress' => 'warning',
                                'delivered' => 'success',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'in_progress' => 'In Progress',
                                'delivered' => 'Delivered',
                            }),
                        Infolists\Components\IconEntry::make('allow_download')
                            ->label('Allow Download')
                            ->boolean(),
                        Infolists\Components\TextEntry::make('notes')
                            ->label('Notes')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Statistics')
                    ->schema([
                        Infolists\Components\TextEntry::make('photos_count')
                            ->label('Total Photos')
                            ->getStateUsing(fn (Project $record) => $record->photos()->count()),
                        Infolists\Components\TextEntry::make('view_count')
                            ->label('View Count'),
                        Infolists\Components\TextEntry::make('download_count')
                            ->label('Download Count'),
                        Infolists\Components\TextEntry::make('recent_accesses')
                            ->label('Last 7 Days Accesses')
                            ->getStateUsing(fn (Project $record) => $record->getRecentAccessesCount()),
                    ])
                    ->columns(4),

                Infolists\Components\Section::make('Share Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('share_url')
                            ->label('Share Link')
                            ->copyable()
                            ->url(fn (Project $record) => $record->share_url)
                            ->openUrlInNewTab()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PhotosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('photographer_id', Auth::guard('photographer')->id());
    }
}
