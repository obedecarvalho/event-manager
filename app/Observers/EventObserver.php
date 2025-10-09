<?php

namespace App\Observers;

use App\Filament\Widgets\EventMapWidget;
use App\Models\Event;
use Illuminate\Support\Facades\Cache;

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
    }

    public function approved(Event $event): void
    {
        $this->clearCache();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($event)
            ->event('approved')
            ->log(__('Approved'));
    }

    private function clearCache(): void
    {
        Cache::forget(EventMapWidget::CACHE_KEY);
    }
}
