@component('mail::message')
# Hello {{ $user->name }},

This is a friendly reminder that your vaccination is scheduled on
**{{ \Carbon\Carbon::parse($user->scheduled_at)->format('D, d M Y h:i A') }}** at **{{ $user->vaccineCenter->name }}**.

Please arrive **15 minutes before** your scheduled time.

If you have any questions or need to reschedule, please contact us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent