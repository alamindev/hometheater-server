@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => 'https://hometheaterproz.com/users/booking/'. $order->id .'/details'])
<div style="display: flex; align-items: center;">  <strong
    style="margin-left: 30px; text-decoration: underline">Notification for booking status</strong>
</div>
@endcomponent
@endslot

Dear  {{$user->first_name }} {{$user->last_name }}</br>, <br>

@if($status == 'approved')
@if($order->type === 0)
<strong>Your appointment status in now marked as <span style="color: #4e81ee">approved</span>. We will see you on:</strong>
<table class="table table-bordered">
@foreach($order->orderdate as $key=> $date)
<tr>
<td>
<strong>{{\Carbon\Carbon::parse($date->date)->format('d M Y')}}  {{ \Carbon\Carbon::parse($date->time)->format('g:i A') }}</strong>
</td>
</tr>
@endforeach
</table>
@else 
<strong>Your Order Shipped! </strong>
<table class="table table-bordered"> 
<tr>
<td>
Delivery Date: 
</td>
<td>  
<p class="px-3 text-danger"><strong>{{ $date  }}</strong></p>
</td>
</tr> 
<tr>
<td>Tracking Number: </td>
<td><a href="{{ $order->tracking_link }}" style="color: green; text-decoration: underline">Track you order</a></td>
</tr>
</table>
@endif
@elseif($status == 'cancel')
<strong>Your appointment status in now marked as <span style="color: red">cancelled</span>.</strong>
@elseif($status == 'complete')
<strong>Your task is now <span style="color: green">completed</span>. Please take the time to leave a review for your installer.</strong>
@endif


<br>
Thanks, <br>
<a href="mailto:admin@hometheaterproz.com" style="text-decoration: none; border-bottom: 1px dotted rgb(133, 133, 133)">admin@hometheaterproz.com</a>

</br>
</br>

@if($status == 'complete')
<div style="text-align: center; withd: 100%">
<a style="margin-top: 20px;padding: 6px 20px; border-radius:5px; background-color: #4e81ee; color: white; display:inline-block; text-decoration: none;"
        href="https://hometheaterproz.com/users/booking/{{$order->id}}/review">Leave a review</a>
</div>
@endif
@if(!$status == 'complete')
@component('mail::button', ['url' => 'https://hometheaterproz.com/users/booking/'. $order->id .'/details'])
Please login to see more details
@endcomponent
@endif
{{-- Footer --}}
@slot('footer')
@component('mail::footer')
{{ config('app.name') }}
@endcomponent
@endslot
@endcomponent
