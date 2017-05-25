@component('mail::message')
# Estimado {{ $user->name }}

Has sido registrado

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
