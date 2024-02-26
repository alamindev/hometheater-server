@component('mail::layout')
    {{-- Header --}}
    @slot('header')
  @component('mail::header', ['url' => ''])
    <strong style="text-decoration: underline">Reset Passord Notification</strong>
    </div>

    @endcomponent
    @endslot

    <b>Hello!</b> <br>
    You are receiving this email because we received a password reset request for your account.
<br>

    Token: {{ $token }}
<br>
    This password reset token will expire in 60 minutes.
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            {{ config('app.name') }}
        @endcomponent
    @endslot
@endcomponent
