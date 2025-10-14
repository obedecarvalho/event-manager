<?php

namespace App\Filament\Actions;

use App\Mail\RegistrationRejected;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

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
            Notification::make()
                ->title(__('Registration rejected'))
                ->body(__('Your :name registration has been rejected.', ['name' => $this->record->name,]))
                ->sendToDatabase($this->record->owner);
            Mail::to($this->record->owner)
                ->send(new RegistrationRejected($this->record));
        });
    }
}
