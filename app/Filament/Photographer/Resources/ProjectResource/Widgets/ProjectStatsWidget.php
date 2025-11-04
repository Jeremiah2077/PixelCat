<?php

namespace App\Filament\Photographer\Resources\ProjectResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class ProjectStatsWidget extends BaseWidget
{
    public ?Model $record = null;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Photos', $this->record->photos()->count())
                ->description('Total photos in project')
                ->descriptionIcon('heroicon-m-photo')
                ->color('primary'),

            Stat::make('View Count', $this->record->view_count)
                ->description('Client view count')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),

            Stat::make('Download Count', $this->record->download_count)
                ->description('Photo download count')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('warning'),

            Stat::make('7-Day Views', $this->record->getRecentAccessesCount())
                ->description('Last week access')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
        ];
    }
}
