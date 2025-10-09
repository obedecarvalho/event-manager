<?php

namespace App\Services;

use Dotswan\MapPicker\Infolists\MapEntry;
use Filament\Infolists;

class EventService
{
    public static function getInfolistSchema($display_location = false)
    {
        $tabs = [];

        $tabs[] = Infolists\Components\Tabs\Tab::make(__('Details'))
            ->schema([
                Infolists\Components\TextEntry::make('name')
                    ->label(__('Name')),
                Infolists\Components\TextEntry::make('description')
                    ->label(__('Description')),
                Infolists\Components\Grid::make(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('start_at')
                            ->label(__('Start at'))
                            ->dateTime('d/m/Y H:i'),
                        Infolists\Components\TextEntry::make('end_at')
                            ->label(__('End at'))
                            ->dateTime('d/m/Y H:i'),
                    ]),
            ]);

        if ($display_location){
            $tabs[] = Infolists\Components\Tabs\Tab::make(__('Location'))
                ->schema([
                    MapEntry::make('location')
                        ->state(function($record) { 
                            return ['lat' => $record?->latitude, 'lng' => $record?->longitude];
                        })
                        ->draggable(false)
                        ->zoom(config('app-custom.map.zoom'))
                        ->geoman(false)
                        ->showFullscreenControl(false)
                        ->showMyLocationButton(false)
                        ->extraTileControl([ 
                            'tileSize' => 256,
                            'zoomOffset' => 0,
                            ]
                        ),
                ]);
        }


        return [
            Infolists\Components\Tabs::make('Tabs')
                ->tabs($tabs)
        ];
    }
}
