<?php

namespace App\Filament\Photographer\Resources\ProjectResource\Pages;

use App\Filament\Photographer\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('share')
                ->label('Share Project')
                ->icon('heroicon-o-share')
                ->color('success')
                ->url(fn () => route('gallery.show', $this->record->share_token))
                ->openUrlInNewTab(),
            Actions\Action::make('qrcode')
                ->label('QR Code')
                ->icon('heroicon-o-qr-code')
                ->color('info')
                ->modalHeading('Project Share QR Code')
                ->modalContent(fn () => view('filament.photographer.qrcode', [
                    'qrcode' => \SimpleSoftwareIO\QrCode\Facades\QrCode::size(300)->generate($this->record->share_url),
                    'url' => $this->record->share_url
                ]))
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Close'),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProjectResource\Widgets\ProjectStatsWidget::class,
        ];
    }
}
