<x-filament::modal 
    id="event-detail-modal"
    stickyHeader
    stickyFooter
    width="xl"
    :closeButton="true"
>
    <x-slot name="heading">
        {{ $this->getHeading() }}
    </x-slot>
    @if (property_exists($this, 'event'))
        {{ $this->eventInfolist }}
    @endif
</x-filament::modal>