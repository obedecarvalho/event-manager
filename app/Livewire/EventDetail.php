<?php

namespace App\Livewire;

use App\Models\Event;
use App\Services\EventService;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class EventDetail extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;

    use InteractsWithForms;
    
    public function render()
    {
        return view('livewire.event-detail');
    }

    public function mount()
    {
    }

    public function getHeading(): string | Htmlable
    {
        return __("Event Map");
    }

    #[On('app:event:detail:open')]
    public function open(int $event_id)
    {
        $event = Event::find($event_id);

        if ($event){
            $this->event = $event;
            $this->dispatch('open-modal', id: 'event-detail-modal');
        }

    }

    protected function eventInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->event)
            ->schema(EventService::getInfolistSchema());
    }
}
