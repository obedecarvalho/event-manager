<?php

namespace App\Providers;

use Filament\Forms\Components\Field;
use Filament\Tables\Columns\Column;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Field::configureUsing(function (Field $field){
            $field->translateLabel();
        });

        Column::configureUsing(function (Column $column){
            $column->translateLabel();
        });
    }
}
