<x-mail::message>
# {{ __('Registration approved') }}

{{ __('Your :name registration has been approved.', ['name' => $record->name]) }}

{{ __('Thanks') }},<br>
{{ config('app.name') }}
</x-mail::message>
