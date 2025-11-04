<?php

namespace App\Filament\Photographer\Resources\ProjectResource\Pages;

use App\Filament\Photographer\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['photographer_id'] = Auth::guard('photographer')->id();

        return $data;
    }
}
