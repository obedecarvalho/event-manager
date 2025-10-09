<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Webbingbrasil\FilamentMaps;
use Webbingbrasil\FilamentMaps\Marker;
use Webbingbrasil\FilamentMaps\Widgets\MapWidget;

class EventMapWidget extends MapWidget
{
    use InteractsWithPageFilters;

    protected static ?string $pollingInterval = null;

    protected string $height = '600px';

    protected int | string | array $columnSpan = 2;

    const CACHE_KEY = 'app:widget:eventMap';

    public function getActions(): array
    {
        return [
            FilamentMaps\Actions\ZoomAction::make(),
            FilamentMaps\Actions\CenterMapAction::make()
                ->centerTo(config('app-custom.map.location'))
                ->zoom(config('app-custom.map.zoom')),
        ];
    }

    public function setUp(): void
    {
        $this->mapOptions([
            'center' => config('app-custom.map.location'),
            'zoom' => config('app-custom.map.zoom'),
        ]);
    }

    private static function makeMarker($event)
    {
        return Marker::make($event->id)
            ->lat($event->latitude)
            ->lng($event->longitude)
            ->tooltip($event->name)
            ->callback('Livewire.dispatch("app:event:detail:open", [' . $event->id . '])');
    }

    private function searchEvents($categoriesFilter)
    {
        $eventQuery = Event::select(['id', 'latitude', 'longitude', 'name'])
            ->where('is_public', true);

        if ($categoriesFilter){
            $eventQuery = $eventQuery
                ->whereHas('categories', function(Builder $query) use ($categoriesFilter){
                    $query->whereIn('categories.id', $categoriesFilter);
                });
            return $eventQuery->get();
        }

        return Cache::remember(static::CACHE_KEY, 1440, function() use ($eventQuery){
            return $eventQuery->get();
        });
    }

    public function getMarkers(): array
    {
        $categoriesFilter = fluent($this->filters)->get('categories', []);

        $events = $this->searchEvents($categoriesFilter);

        return $events->map(function($event){
            return static::makeMarker($event);
        })->all();
    }

    #[On('app:eventMapWidget:updateMarkers')]
    public function updateMarkers(){
        $categoriesFilter = fluent($this->filters)->get('categories', []);

        $events = $this->searchEvents($categoriesFilter);

        if ($events){
            $eventsMarkers = $events->map(function($event){
                return static::makeMarker($event);
            })->all();

            $this->mapMarkers($eventsMarkers);
        }
    }
}
