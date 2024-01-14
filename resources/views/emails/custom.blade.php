@component('mail::message')

{{ $name }} {{ __('email.common.greeting') }}


{{ $data['content']}}

{{ config('app.name') }} Team

@component('mail::subcopy')


{{ __('email.common.footer') }}


@endcomponent

@endcomponent


