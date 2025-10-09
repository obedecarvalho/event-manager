<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\EventCalendarWidget;
use App\Models\Event;
use App\Services\CategoryService;
use Filament\Forms;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Illuminate\Contracts\Support\Htmlable;

class EventCalendarPage extends BaseDashboard
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static string $routePath = 'event-calendar';

    public function getTitle(): string | Htmlable
    {
        return __("Events Calendar");
    }

    public static function getNavigationLabel(): string
    {
        return __("Events Calendar");
    }

    public function getSubheading(): ?string
    {
        return '';
    }

    public function getWidgets(): array
    {
        return [
            EventCalendarWidget::class,
        ];
    }

    public function filtersForm(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Select::make('categories')
                ->label(__('Categories'))
                ->options(CategoryService::getCachedCategories())
                ->multiple()
                ->preload()
                ->searchable()
                ->columnSpanFull()
                ->live()
                ->afterStateUpdated(fn ($state) => $this->dispatch('calendar--refresh', $state)),
        ]);
    }

    public function persistsFiltersInSession(): bool
    {
        return false;
    }
}
