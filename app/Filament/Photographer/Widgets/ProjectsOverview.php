<?php

namespace App\Filament\Photographer\Widgets;

use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ProjectsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $photographerId = Auth::guard('photographer')->id();

        // Total projects
        $totalProjects = Project::where('photographer_id', $photographerId)->count();

        // In progress projects
        $inProgressProjects = Project::where('photographer_id', $photographerId)
            ->where('status', 'in_progress')
            ->count();

        // Delivered projects
        $deliveredProjects = Project::where('photographer_id', $photographerId)
            ->where('status', 'delivered')
            ->count();

        // Total photos
        $totalPhotos = Project::where('photographer_id', $photographerId)
            ->withCount('photos')
            ->get()
            ->sum('photos_count');

        // Total views
        $totalViews = Project::where('photographer_id', $photographerId)
            ->sum('view_count');

        // Total downloads
        $totalDownloads = Project::where('photographer_id', $photographerId)
            ->sum('download_count');

        // Recent 7 days views
        $recentViews = Project::where('photographer_id', $photographerId)
            ->whereHas('accesses', function ($query) {
                $query->where('accessed_at', '>=', now()->subDays(7));
            })
            ->withCount(['accesses' => function ($query) {
                $query->where('accessed_at', '>=', now()->subDays(7));
            }])
            ->get()
            ->sum('accesses_count');

        // Most active project
        $mostActiveProject = Project::where('photographer_id', $photographerId)
            ->orderBy('view_count', 'desc')
            ->first();

        return [
            Stat::make('Total Projects', $totalProjects)
                ->description($inProgressProjects . ' in progress, ' . $deliveredProjects . ' delivered')
                ->descriptionIcon('heroicon-m-folder')
                ->color('success'),

            Stat::make('Total Photos', number_format($totalPhotos))
                ->description('Total photos across all projects')
                ->descriptionIcon('heroicon-m-photo')
                ->color('info'),

            Stat::make('Total Views', number_format($totalViews))
                ->description('Last 7 days: ' . number_format($recentViews) . ' views')
                ->descriptionIcon('heroicon-m-eye')
                ->color('warning')
                ->chart($this->getViewsChart($photographerId)),

            Stat::make('Total Downloads', number_format($totalDownloads))
                ->description('Total downloads across all projects')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('danger'),

            Stat::make('Most Active Project', $mostActiveProject ? $mostActiveProject->title : 'None')
                ->description($mostActiveProject ? $mostActiveProject->view_count . ' views' : '-')
                ->descriptionIcon('heroicon-m-fire')
                ->color('success'),
        ];
    }

    protected function getViewsChart(int $photographerId): array
    {
        // Get last 7 days access data
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = Project::where('photographer_id', $photographerId)
                ->whereHas('accesses', function ($query) use ($date) {
                    $query->whereDate('accessed_at', $date);
                })
                ->withCount(['accesses' => function ($query) use ($date) {
                    $query->whereDate('accessed_at', $date);
                }])
                ->get()
                ->sum('accesses_count');
            $data[] = $count;
        }

        return $data;
    }
}
