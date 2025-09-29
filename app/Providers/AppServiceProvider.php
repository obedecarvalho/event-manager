<?php

namespace App\Providers;

use App\Filament\Http\Responses\Auth\CustomLogoutResponse;
use App\Models\User;
use App\Providers\Filament\AdminPanelProvider;
use App\Support\Enum\Roles;
use BezhanSalleh\PanelSwitch\PanelSwitch;
use Filament\Forms\Components\Field;
use Filament\Http\Responses\Auth\LogoutResponse;
use Filament\Support\Facades\FilamentView;
use Filament\Tables\Columns\Column;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Gate;
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

        app()->bind(LogoutResponse::class, CustomLogoutResponse::class);

        Field::configureUsing(function (Field $field){
            $field->translateLabel();
        });

        Column::configureUsing(function (Column $column){
            $column->translateLabel();
        });

        FilamentView::registerRenderHook(
            PanelsRenderHook::GLOBAL_SEARCH_AFTER,
            function () {
                if (auth()->check())
                    return "";
                return view('login-button');
            },
        );

        Gate::define('viewPulse', function (User $user) {
            return $user->hasRole(Roles::ADMIN->name);
        });

        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch->modalHeading(__('Select a panel'));

            $panelSwitch
                ->labels([
                    'admin' => __('Administrator'),
                    'public' => __('Public'),
                    'app' => __('App'),
                ]);

            $panelSwitch->icons([
                'public' => 'heroicon-o-globe-alt',
            ], $asImage = false);

            $panelSwitch->panels(
                function () {
                    if (
                        auth()?->user()?->hasAnyRole(Roles::getRolesCanAccessAdminPanel())
                    ) {
                        $panels[] = 'admin';
                    }
                    $panels[] = 'app';
                    $panels[] = 'public';
                    return $panels;
                }
            );
        });
    }
}
