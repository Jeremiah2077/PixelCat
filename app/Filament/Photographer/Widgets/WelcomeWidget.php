<?php

namespace App\Filament\Photographer\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected static string $view = 'filament.photographer.widgets.welcome-widget';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = -1;

    public function getPhotographer()
    {
        return auth('photographer')->user();
    }
}
