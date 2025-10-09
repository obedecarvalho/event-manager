<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Services\EventService;
use Filament\Infolists;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Guava\Calendar\Actions\ViewAction;
use Guava\Calendar\ValueObjects\CalendarEvent;
use Guava\Calendar\Widgets\CalendarWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;

class EventCalendarWidget extends CalendarWidget
{
    
    use InteractsWithPageFilters;

    protected bool $eventClickEnabled = true;

    public function authorize($ability, $arguments = []){
        return true;
    }

    public function getEvents(array $fetchInfo = []): Collection | array {
        
        $categoriesFilter = fluent($this->filters)->get('categories', []);

        $eventQuery = Event::query()
            ->where('end_at', '>=', $fetchInfo['start'])
            ->where('start_at', '<',  $fetchInfo['end'])
            ->where('is_public', true)
            //->where('approval_status', ApprovalStatuses::APPROVED)
        ;

        if ($categoriesFilter){
            $eventQuery = $eventQuery
                ->whereHas('categories', function(Builder $query) use ($categoriesFilter){
                    $query->whereIn('categories.id', $categoriesFilter);
                });
        }

        $events = $eventQuery->get();

        return $events->map(function($event){
            $start_at = Carbon::parse($event->start_at)->shiftTimezone('UTC');
            $end_at = Carbon::parse($event->end_at)->shiftTimezone('UTC');
            return CalendarEvent::make()
                ->title($event->name)
                ->start($start_at)
                ->end($end_at)
                ->key($event->id)
                ->model(Event::class);
        })->all();
    }

    public function getHeading(): string | HtmlString
    {
        //return "Event's Calendar";
        return "";
    }

    public function getOptions(): array
    {
        return [
            'buttonText' => [
                'close' => __('Close'),
                'dayGridMonth' => __('Month'),
                'listDay' => __('List'),
                'listMonth' => __('List'),
                'listWeek' => __('List'),
                'listYear' => __('List'),
                'resourceTimeGridDay' => 'resources',
                'resourceTimeGridWeek' => 'resources',
                'resourceTimelineDay' => 'timeline',
                'resourceTimelineMonth' => 'timeline',
                'resourceTimelineWeek' => 'timeline',
                'timeGridDay' => __('Day'),
                'timeGridWeek' => __('Week'),
                'today' => __('Today'),
                'prev' => __('Prev'),
                'next' => __('Next'),
            ],
            'headerToolbar' => [
                'start' => 'prev,next today',
                'center' => 'title',
                'end' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
            ],
            'firstDay' => 0,
        ];
    }

    public function getDateSelectContextMenuActions(): array
    {
        return [
            ViewAction::make('view')
                ->model(Event::class)
                ->modalHeading(__('Event'))
                ->infolist(EventService::getInfolistSchema(true))
                ->stickyModalHeader(),
        ];
    }
}
