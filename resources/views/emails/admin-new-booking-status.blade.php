@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => 'https://admin.hometheaterproz.com/dashboard'])
<div style="display: flex; align-items: center;">
<strong style="text-decoration: underline">New Order Received</strong>
</div>

@endcomponent
@endslot
<strong></strong><br>

Dear <b>Admin </b></br>, <br>

<p><strong>{{$user->first_name }} {{$user->last_name }}</strong> Ordered Services / Products</p>

@if($service)
<strong>1. Service appointment scheduled for: </strong> <br>
@foreach($service->services as  $key=> $ser)
@php
      $serv = \App\Models\Service::where('id', $ser->service_id)->first();
@endphp
@if($serv)
#{{$key+1}} {{ $serv->title }} 
@endif
@endforeach <br>
<strong>Date Time: </strong>  
<table >
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

<strong>2. Product shipment  date for: </strong> <br>
@foreach($product->services as  $key=> $pro)
@php
      $prod = \App\Models\Service::where('id', $pro->service_id)->first();
@endphp
@if($prod)
#{{$key+1}}  {{ $prod->title }} 
@endif
@endforeach 
 Need to deliver order to -  <strong>{{ $product->delivery_time }}</strong>
@endif
<br>

@component('mail::button', ['url' => 'https://admin.hometheaterproz.com/home'])
Please login to see more details
@endcomponent

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
{{ config('app.name') }}
@endcomponent
@endslot
@endcomponent
