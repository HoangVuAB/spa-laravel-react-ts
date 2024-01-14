@component('mail::message')
{{ $notifiable->user_name }} {{ __('email.common.greeting') }}

{{ __('email.verify_email.description') }}

@component('mail::button', ['url' => $url])
{{ __('email.verify_email.verify_button') }}
@endcomponent



{{ config('app.name') }} Team



@component('mail::subcopy')
{{__('email.verify_email.follow_link')}}
 <a href="{{  $url }}"> {{$url}}</a> <br>

{{ __('email.common.footer') }}


@endcomponent

@endcomponent


