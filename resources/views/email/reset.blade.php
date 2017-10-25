@component('mail::message')
# Hello {{$user->name}}

You have offered to change your password, so please click button below to get new password:

@component('mail::button', ['url' => route('resetpassword', $user->reset_password_token)])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
