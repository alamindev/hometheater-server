@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => 'https://admin.hometheaterproz.com/order/details/'. $order->order_id])
<div style="display: flex; align-items: center;">
<strong style="text-decoration: underline">New Booking Received</strong>
</div>

@endcomponent
@endslot
<strong></strong><br>

Dear <b>Admin </b></br>, <br>

<p><strong>{{$user->first_name }} {{$user->last_name }}</strong> Ordered Services / Products</p>
<ul style="list-style: none">
    @foreach($carts as $key => $cart)
     @if($key == 'services')
        <p>Appointment Scheduled for xyz date time</p>
        <table class="table table-bordered">
            @foreach($order->orderdate as $key=> $date)
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
     @endif
    @endforeach
</ul>
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
