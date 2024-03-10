@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => ''])
<div style="position: relative;">
    <strong style="text-decoration: underline; font-size: 26px;">Payment Notification</strong>
</div>

@endcomponent
@endslot
Hi <b>{{$user->first_name }} {{$user->last_name }}</b></br>, <br>

<p>Your transaction of $<strong>{{$price}}</strong> for <strong>
    @foreach($services as $key => $service)
            {{ $key + 1 }}. {{$service->title}},
    @endforeach
</strong> was successful.
Thank you for your payment.  </p>


<br>
Thanks, <br>
<a href="mailto:noreply@hometheaterproz.com"
    style="text-decoration: none; border-bottom: 1px dotted rgb(133, 133, 133)">noreply@hometheaterproz.com</a>
<br />

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
{{ config('app.name') }}
@endcomponent
@endslot
@endcomponent
