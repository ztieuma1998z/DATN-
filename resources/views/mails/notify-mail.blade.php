@component('mail::message')
    {!! $content !!}


    Thanks for reading,<br>
    {{ config('app.name') }}
@endcomponent
