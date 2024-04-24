@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => 'https://admin.hometheaterproz.com/order/details/'. $order->order_id])
<div style="display: flex; align-items: center;">
    <strong style="text-decoration: underline">User edit booking</strong>
</div>

@endcomponent
@endslot
<strong></strong><br>

Dear <b>Admin </b></br>, <br>

<p><strong>{{$user->first_name }} {{$user->last_name }}</strong>  Edit or update booking</p>
<ul style="list-style: none">
    @foreach($services as $key => $service)
    <li><strong>{{ $key + 1 }}. {{$service->title}}</strong></li>
    @endforeach
</ul>
<br>

@component('mail::button', ['url' => 'https://admin.hometheaterproz.com/order/details/'. $order->order_id])
Please login to see more details
@endcomponent

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
{{ config('app.name') }}
@endcomponent
@endslot
@endcomponent
