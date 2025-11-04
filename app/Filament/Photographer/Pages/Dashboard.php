<?php

namespace App\Filament\Photographer\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $routePath = '/';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Photographer\Widgets\WelcomeWidget::class,
            \App\Filament\Photographer\Widgets\ProjectsOverview::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return [
            'default' => 1,
            'sm' => 2,
            'md' => 3,
            'lg' => 4,
        ];
    }

    public function getHeader(): ?\Illuminate\Contracts\View\View
    {
        return null;
    }

    protected static ?string $title = '';

    protected static ?string $navigationLabel = 'Dashboard';

    public function getHeading(): string
    {
        return '';
    }
}
