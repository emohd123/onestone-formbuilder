@component('mail::message')

    # New Feedback Submitted #

    {{ $message }}

    Thanks,
    
    {{ config('app.name') }}
@endcomponent
