<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /*public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'approved' => ApprovedTab::make(),
            'rejected' => RejectedTab::make(),
            'pending' => PendingTab::make(),
        ];
    }*/
}
