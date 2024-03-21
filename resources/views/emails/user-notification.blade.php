@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => 'https://hometheaterproz.com/users/dashboard'])
<div style="display: flex; align-items: center;">
    <strong style="text-decoration: underline; font-size: 26px;">
        Status: <span style="color: #4e81ee">Awaiting shipment</span></strong>
</div>

@endcomponent
@endslot
Dear <b>{{$user->first_name }} {{$user->last_name }}</b></br>, <br>

<p>Thank you for your order listed below.  </p>
 

@if($service)
<strong style="padding-bottom: 8px">1. Service appointment scheduled for: </strong> <br>
@foreach($service->services as  $key=> $ser)
@php
      $serv = \App\Models\Service::where('id', $ser->service_id)->first();
@endphp
@if($serv)
<strong>#{{$key+1}}</strong> {{ $serv->title }} 
@endif
@endforeach <br>  <br>
<strong>Date Time: </strong>  
<table style="padding: 0; margin: 0;">
    @foreach($service->orderdate as $key=> $date)
    <tr>
        <td>Item #{{$key+1}}</td>
        <td>:</td>
        <td>
            <strong>{{\Carbon\Carbon::parse($date->date)->format('d M Y')}}
                {{ \Carbon\Carbon::parse($date->time)->format('g:i A') }}</strong>
        </td>
    </tr>
    @endforeach
</table>
<br><br>
@endif 
@if($product)

<strong style="padding-bottom: 8px">2. Product shipment: </strong> <br>
@foreach($product->services as  $key=> $pro)
@php
      $prod = \App\Models\Service::where('id', $pro->service_id)->first();
@endphp
@if($prod)
<strong>#{{$key+1}} </strong> {{ $prod->title }} 
@endif
@endforeach 
Estimated arrival date-time:  <strong>{{ $product->delivery_time }}</strong>
@endif
<br>
<br>
Thanks, <br>
<a href="mailto:admin@hometheaterproz.com"
    style="text-decoration: none; border-bottom: 1px dotted rgb(133, 133, 133)">admin@hometheaterproz.com</a>
    <br/>


@component('mail::button', ['url' => 'https://hometheaterproz.com/users/dashboard'])
Please login to see more details
@endcomponent

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
{{ config('app.name') }}
@endcomponent
@endslot
@endcomponent
