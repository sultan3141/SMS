<?php

namespace App\Filament\Teacher\Resources\MarkResource\Pages;

use App\Filament\Teacher\Resources\MarkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditMark extends EditRecord
{
    protected static string $resource = MarkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('submit')
                ->label('Submit Mark')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Submit Mark')
                ->modalDescription('Once submitted, this mark will be finalized. Are you sure?')
                ->visible(fn () => !$this->record->is_submitted)
                ->action(function () {
                    $this->record->update([
                        'is_submitted' => true,
                        'submitted_at' => now(),
                    ]);
                    
                    Notification::make()
                        ->success()
                        ->title('Mark Submitted')
                        ->body('The mark has been finalized successfully.')
                        ->send();
                        
                    $this->redirect($this->getResource()::getUrl('index'));
                }),
            Actions\DeleteAction::make()
                ->visible(fn () => !$this->record->is_submitted),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Mark Updated')
            ->body('The student mark has been successfully updated.');
    }
}
