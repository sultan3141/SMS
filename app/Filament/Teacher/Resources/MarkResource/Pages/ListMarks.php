<?php

namespace App\Filament\Teacher\Resources\MarkResource\Pages;

use App\Filament\Teacher\Resources\MarkResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListMarks extends ListRecords
{
    protected static string $resource = MarkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add New Mark'),
        ];
    }
}
