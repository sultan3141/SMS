<?php

namespace App\Filament\Teacher\Resources\MarkResource\Pages;

use App\Filament\Teacher\Resources\MarkResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateMark extends CreateRecord
{
    protected static string $resource = MarkResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['teacher_id'] = auth()->user()->teacher?->id;
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Mark Recorded')
            ->body('The student mark has been successfully recorded.');
    }
}
