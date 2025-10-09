<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\EventMapWidget;
use App\Services\CategoryService;
use Filament\Forms;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Illuminate\Contracts\Support\Htmlable;

class EventMapPage extends BaseDashboard
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static string $view = 'filament.pages.event-map-page';

    protected static string $routePath = 'event-map';

    public function getTitle(): string | Htmlable
    {
        return __("Event Map");
    }

    public static function getNavigationLabel(): string
    {
        return __("Event Map");
    }

    public function getSubheading(): ?string
    {
        return '';
    }

    public function getWidgets(): array
    {
        return [
            EventMapWidget::class,
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
                ->afterStateUpdated(fn ($state) => $this->dispatch('app:eventMapWidget:updateMarkers')),
        ]);
    }

    public function persistsFiltersInSession(): bool
    {
        return false;
    }
}
