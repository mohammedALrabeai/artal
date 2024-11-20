<?php

namespace App\Filament\Resources\PatternResource\Pages;

use App\Filament\Resources\PatternResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPattern extends EditRecord
{
    protected static string $resource = PatternResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}