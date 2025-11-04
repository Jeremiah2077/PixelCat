<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhotographerResource\Pages;
use App\Filament\Resources\PhotographerResource\RelationManagers;
use App\Models\Photographer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PhotographerResource extends Resource
{
    protected static ?string $model = Photographer::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    protected static ?string $modelLabel = '摄影师';

    protected static ?string $pluralModelLabel = '摄影师管理';

    protected static ?string $navigationGroup = '用户管理';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('账号信息')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('邮箱')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('password')
                            ->label('密码')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->revealable(),
                        Forms\Components\Select::make('status')
                            ->label('状态')
                            ->options([
                                'active' => '已激活',
                                'inactive' => '未激活',
                                'pending' => '待审核',
                            ])
                            ->required()
                            ->default('pending'),
                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('邮箱验证时间'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('基本信息')
                    ->schema([
                        Forms\Components\FileUpload::make('avatar')
                            ->label('头像')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->directory('avatars')
                            ->visibility('public')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('name')
                            ->label('姓名')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('brand_name')
                            ->label('品牌名称')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('联系电话')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('bio')
                            ->label('个人简介')
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('社交媒体')
                    ->schema([
                        Forms\Components\TextInput::make('website')
                            ->label('个人网站')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                        Forms\Components\TextInput::make('instagram')
                            ->label('Instagram')
                            ->maxLength(255)
                            ->prefix('@'),
                        Forms\Components\TextInput::make('facebook')
                            ->label('Facebook')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('头像')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                Tables\Columns\TextColumn::make('name')
                    ->label('姓名')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('邮箱')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('brand_name')
                    ->label('品牌名称')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('电话')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('状态')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'pending',
                        'danger' => 'inactive',
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 'active',
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-x-circle' => 'inactive',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => '已激活',
                        'inactive' => '未激活',
                        'pending' => '待审核',
                    }),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('已验证')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('注册时间')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新时间')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('状态')
                    ->options([
                        'active' => '已激活',
                        'inactive' => '未激活',
                        'pending' => '待审核',
                    ]),
                Tables\Filters\Filter::make('verified')
                    ->label('已验证邮箱')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('unverified')
                    ->label('未验证邮箱')
                    ->query(fn (Builder $query): Builder => $query->whereNull('email_verified_at')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('activate')
                        ->label('激活')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Photographer $record): bool => $record->status !== 'active')
                        ->action(fn (Photographer $record) => $record->update(['status' => 'active'])),
                    Tables\Actions\Action::make('deactivate')
                        ->label('停用')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->visible(fn (Photographer $record): bool => $record->status === 'active')
                        ->action(fn (Photographer $record) => $record->update(['status' => 'inactive'])),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('批量激活')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['status' => 'active'])),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhotographers::route('/'),
            'create' => Pages\CreatePhotographer::route('/create'),
            'edit' => Pages\EditPhotographer::route('/{record}/edit'),
        ];
    }
}
