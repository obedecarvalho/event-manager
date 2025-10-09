<?php

namespace App\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;

class ApprovalAction extends Action
{
    protected function setUp(): void {
        parent::setUp();

        $this->label(__('Approval'));

        $this->disabled(function () {
            return !$this->record->isPending();
        });

        $this->modal();

        $this->modalFooterActions([
            RejectAction::make('reject')
                ->close(),
            ApproveAction::make('approve')
                ->close(),
        ]);

        $this->modalAlignment(Alignment::Center);

        $this->modalFooterActionsAlignment(Alignment::Center);

        $this->modalWidth(MaxWidth::Small);

    }

}
