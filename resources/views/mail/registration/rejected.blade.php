<x-mail::message>
# {{ __('Registration rejected') }}

{{ __('Your :name registration has been rejected.', ['name' => $record->name]) }}

{{ __('Thanks') }},<br>
{{ config('app.name') }}
</x-mail::message>
