<?php

namespace App\Observers;

use App\Filament\Widgets\EventMapWidget;
use App\Mail\RegistrationApproved;
use App\Mail\RegistrationRejected;
use App\Models\Event;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     */
    public function created(Event $event): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Event "restored" event.
     */
    public function restored(Event $event): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Event "force deleted" event.
     */
    public function forceDeleted(Event $event): void
    {
        $this->clearCache();
    }

    public function rejected(Event $event): void
    {
        $this->clearCache();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($event)
            ->event('rejected')
            ->log(__('Rejected'));
        Notification::make()
            ->title(__('Registration rejected'))
            ->body(__('Your :name registration has been rejected.', ['name' => $event->name,]))
            ->sendToDatabase($event->owner);
        Mail::to($event->owner)
            ->send(new RegistrationRejected($event));
    }

    public function approved(Event $event): void
    {
        $this->clearCache();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($event)
            ->event('approved')
            ->log(__('Approved'));
        Notification::make()
            ->title(__('Registration approved'))
            ->body(__('Your :name registration has been approved.', ['name' => $event->name,]))
            ->sendToDatabase($event->owner);
        Mail::to($event->owner)
            ->send(new RegistrationApproved($event));
    }

    private function clearCache(): void
    {
        Cache::forget(EventMapWidget::CACHE_KEY);
    }
}
