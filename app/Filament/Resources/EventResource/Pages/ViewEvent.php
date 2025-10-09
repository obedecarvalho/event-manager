<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Actions\ApprovalAction;
use App\Filament\Resources\EventResource;
use App\Support\Enum\Roles;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ApprovalAction::make('approval')
                ->visible(auth()->user()->hasRole(Roles::getRolesContentManager())),
            /*
            Actions\Action::make('approval')
                ->label(__('Approval'))
                ->visible(auth()->user()->hasRole(Roles::getRolesContentManager()))
                ->disabled(function(){
                    return !$this->record->isPending();
                })
                ->modal()
                ->modalFooterActions([
                    Actions\Action::make('reject')
                        ->label(__('Reject'))
                        ->color('danger')
                        ->action(function() { 
                            $this->record->approve();
                            Notification::make()
                                ->title(__('Rejected'))
                                ->success()
                                ->duration(3000)
                                ->send();
                        })
                        ->close(),
                    Actions\Action::make('approve')
                        ->label(__('Approve'))
                        ->color('primary')
                        ->action(function() { 
                            $this->record->approve();
                            Notification::make()
                                ->title(__('Approved'))
                                ->success()
                                ->duration(3000)
                                ->send();
                        })
                        ->close(),
                ])
                ->modalAlignment(Alignment::Center)
                ->modalFooterActionsAlignment(Alignment::Center)
                ->modalWidth(MaxWidth::Small)
                ,
            */
            Actions\EditAction::make(),
        ];
    }
}
