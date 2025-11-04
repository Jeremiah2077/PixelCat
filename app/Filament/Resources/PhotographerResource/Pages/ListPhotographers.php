<?php

namespace App\Filament\Resources\PhotographerResource\Pages;

use App\Filament\Resources\PhotographerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhotographers extends ListRecords
{
    protected static string $resource = PhotographerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
