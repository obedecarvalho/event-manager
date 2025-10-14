<?php

namespace App\Filament\Actions;

use App\Mail\RegistrationApproved;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

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
            Notification::make()
                ->title(__('Registration approved'))
                ->body(__('Your :name registration has been approved.', ['name' => $this->record->name,]))
                ->sendToDatabase($this->record->owner);
            Mail::to($this->record->owner)
                ->send(new RegistrationApproved($this->record));
        });
    }
}
