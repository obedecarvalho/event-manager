<?php

namespace App\Filament\Http\Responses\Auth;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class CustomLogoutResponse implements LogoutResponse
{
    public function toResponse($request): RedirectResponse | Redirector
    {

        return redirect()->to(
            //TODO: use this: route('filament.public.home')
            route('filament.app.auth.login')
        );
    }
}
