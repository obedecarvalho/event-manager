<?php

namespace App\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;

class RejectAction extends Action
{
    protected function setUp(): void {

        parent::setUp();

        $this->label(__('Reject'));

        $this->color('danger');

        $this->action(function () {
            $this->record->reject();
            Notification::make()
                ->title(__('Rejected'))
                ->success()
                ->duration(3000)
                ->send();
        });
    }
}
