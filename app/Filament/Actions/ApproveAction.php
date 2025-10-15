<?php

namespace App\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ApproveAction extends Action
{
    protected function setUp(): void {

        parent::setUp();

        $this->label(__('Approve'));

        $this->color('primary');

        $this->action(function () {
            $this->record->approve();
            Notification::make()
                ->title(__('Approved'))
                ->success()
                ->duration(3000)
                ->send();
        });
    }
}
