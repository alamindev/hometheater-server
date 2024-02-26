@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => 'https://hometheaterproz.com/users/booking/{{$order->id}}/details'])
<div style="display: flex; align-items: center;">
    <strong style="text-decoration: underline; font-size: 26px;">
        Status: <span style="color: #4e81ee">Pending</span></strong>
</div>

@endcomponent
@endslot
Dear <b>{{$user->first_name }} {{$user->last_name }}</b></br>, <br>

<p>We received your request for: </p>
<ul style="list-style: none">
@foreach($services as $key => $service)
<li><strong>{{ $key + 1 }}. {{$service->title}}</strong></li>
@endforeach
</ul>
<br>
Please login to your <a href="https://hometheaterproz.com/users/booking/{{$order->id}}/details" target="_blank" style="color: #4e81ee">dashboard</a> if you need to make any changes or upload images of task. You will receive another
email once your appointment is confirmed by installer.
<br>
<br>
<br>
Thanks, <br>
<a href="mailto:admin@hometheaterproz.com"
    style="text-decoration: none; border-bottom: 1px dotted rgb(133, 133, 133)">admin@hometheaterproz.com</a>
    <br/>


@component('mail::button', ['url' => 'https://hometheaterproz.com/users/booking/'. $order->id .'/details'])
Please login to see more details
@endcomponent

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
{{ config('app.name') }}
@endcomponent
@endslot
@endcomponent
