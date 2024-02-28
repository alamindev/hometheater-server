@extends('layouts.app')
@section('title')
Order details
@endsection
@section('style')
<link rel="stylesheet" href="{{asset('assets/magnific-popup/magnific-popup.css')}}">
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                   
                    @if($order->type === 0)
                    <h4>Booking Details</h4>
                    @else 
                    <h4>Order Details</h4>
                    @endif
                    <a href="{{ url()->previous() }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
                </div>
                <div class="card-body card-block">
                        <div class="row">
                            <div class="col-lg-6 pb-4 pb-md-0">
                                @if($order->status !== 'cancel')
                                <form class="d-flex align-items-center flex-wrap" action="{{ route('order.status') }}" method="post"
                                    class="form-horizontal">
                                    @csrf
                                    <h4>Order Status</h4>
                                    <div class="form-group pl-3 mb-0 pb-4 pb-md-0">
                                        <input type="hidden" name="id" value="{{ $order->id }}">
                                        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                        <select name="status" id="" class="form-control">
                                            <option value="cancel" @if($order->status =='cancel') selected @endif>Cancel</option>
                                            <option value="pending" @if($order->status =='pending') selected @endif>Pending</option>
                                            <option value="approved" @if($order->status =='approved') selected @endif>Approved</option>
                                            <option value="complete" @if($order->status =='complete') selected @endif>Complete</option>
                                        </select>
                                    </div>
                                    <button type="submit" onclick="return confirm('Are you sure!')" class="btn btn-success ml-5"> Update </button>
                                </form>
                                @else
                                <button type="submit" disabled  class="btn btn-danger ml-5"> Canceled </button>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                @if($order->type === 0)
                                <h4 class="pb-3">Appointment Booked At: <strong>{{\Carbon\Carbon::parse($order->created_at)->format('d M Y')}} {{ \Carbon\Carbon::parse($order->created_at)->format('g:i A') }}</strong></h4>
                                @else 
                                <h4 class="pb-3">Ordered At: <strong>{{\Carbon\Carbon::parse($order->created_at)->format('d M Y')}} {{ \Carbon\Carbon::parse($order->created_at)->format('g:i A') }}</strong></h4>
                                @endif
                                <div class="d-flex">
                                    <h4 class="pb-3 pr-5">Price: <strong>${{ $order->price}}</strong></h4>
                                    <h4>Payment: <strong>{{ $order->payment}} Payment</strong></h4>
                                </div>
                            </div>
                        </div>
                    <table class="table mt-3">
                        <tr>
                            <td>Order ID</td>
                            <td>:</td>
                            <td><strong>#{{$order->order_id}}</strong></td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td>:</td>
                            <td><strong>@if($order->discount){{$order->discount}}% @endif</strong></td>
                        </tr>
                        <tr>
                            <td>Order Quantity</td>
                            <td>:</td>
                            <td><strong>{{ collect($order->quantity)->pluck('quantity')->sum()}}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            @if($order->type === 0)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Appointment Date</h4>
                </div>
                <div class="card-body card-block">
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
                </div>
            </div>
                    @else 
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 style="color: red">Deliver Date</h4>
                        </div>
                        <div class="card-body card-block">
                            <div class="row"> 
                                    @php
                                        $collection = collect($order->services);
                                        $ids = $collection->pluck('service_id');
                                       
                                        $delivery_time = \App\Models\Service::whereIn('id', $ids)->avg('delivery_time');
                                        $startDate = carbon\carbon::parse($order->created_at);
 
                                        $date = $startDate->copy()->addDays(round($delivery_time))->format('d M y - h:i:s A');
                                    @endphp 
                                <h3 class="px-3 text-danger"><strong>{{ $date  }}</strong></h3>
                            </div>
                        </div>
                    </div>
                    @endif
        
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>User Details</h4>
                </div>
                <div class="card-body card-block">
                    <table class="table">
                        <tr>
                            <td>Photo</td>
                            <td>:</td>
                            <td class="avatar">
                                <div class="round-img">
                                    @if($order->user && $order->user->photo!= null)
                                    <img width="60" class="rounded-circle" src="{{asset($order->user->photo)}}" alt="">
                                    @else
                                    <img width="60" class="rounded-circle" src="{{asset('storage/uploads/avater.svg')}}" alt="">
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td>:</td>
                            <td><strong>{{ $order->user->first_name}} {{ $order->user->last_name}}</strong></td>
                        </tr>
                        <tr>
                            <td>Location</td>
                            <td>:</td>
                            <td><strong>
                                @if($order->user)
                                    {{ $order->user->address ? $order->user->address. ',': ''}}
                                    {{ $order->user->city ? $order->user->city. ',': ''}}
                                    {{ $order->user->state ? $order->user->state. ',': ''}}
                                    {{ $order->user->zipcode ? $order->user->zipcode. ',': ''}}
                                @endif
                         </strong></td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td><strong>{{ $order->user->phone}} </strong></td>
                        </tr>
                    </table>
                    <a href="https://hometheaterproz.com/users/{{$order->user->id}}/profile" target="_blank" class="btn btn-info">Full Details</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Service Details</h4>
                </div>
                <div class="card-body card-block">
                    <div class="row">
                        @foreach($order->services as $ser)
                            @php
                                  $service = \App\Models\Service::where('id', $ser->service_id)->first();
                            @endphp
                            @if($service)
                            <div class="col-lg-6">
                                <a href="{{route('order.show', $service->id)}}">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="pb-3"><strong>{{ $service->title }}</strong></h4>
                                            <h4 class="pb-3">Price: <strong>${{ $service->basic_price}}</strong></h4>
                                            @php
                                                $quantity = \App\Models\OrderQuantity::where('order_id', $order->id)->where('service_id', $service->id)->first();
                                            @endphp
                                            <h4 class="pb-3">Qualtity: <strong>{{ $quantity ? $quantity->quantity : '' }}</strong></h4>
                                            <h4 class="pb-3">Total Price: <strong>${{ $quantity ? $quantity->quantity * $service->basic_price : '' }}</strong></h4>
                                            <h4 class="pb-3">Duration: <strong>{{ $service->duration == 1 ? $service->duration. ' hour' : $service->duration .' hours' }}</strong></h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @if($order->type === 0)  
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Service Questions</h4>
                </div>
                <div class="card-body card-block">
                    <div class="row">
                        @foreach($order->questions as $que)
                            <div class="col-lg-6">
                               <div class="card">
                                   <div class="card-body">
                                       @php
                                        $question = \App\Models\ServiceQuestion::with('question_option')->where('id', $que->question_id)->where('service_id',
                                        $que->service_id)->first();
                                        @endphp
                                        <style>
                                            .service--details span{
                                               color: rgb(78, 129, 238);
                                                padding-left: 5px;
                                            }
                                        </style>
                                        @if($question)
                                        <h1 class="pb-3 service--details" style="font-size: 20px"><strong>{!! $que->service_title !!}</strong></h1>
                                        <h4 class="pb-4">Question: <strong>{{ $question->name }}</strong></h4>
                                        @php
                                            $option = \App\Models\QuestionOption::where('id', $que->option_id)->where('question_id', $question->id)->first();
                                        @endphp
                                        @if(!empty($option))
                                            <h4 class="pb-2">Answer: <strong>{{ $option->title }}</strong></h4>
                                            <h4>Price: <strong>${{ $option->price }}</strong></h4>
                                        @endif
                                        @endif
                                   </div>
                               </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
           
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>User provide images</h4>
                </div>
                <div class="card-body card-block">
                    <div class="row parent-container">
                        @forelse($order->images as $img)
                        <a class="col-lg-4"href="{{asset($img->image)}}">
                            <div class="card">
                                <div class="card-body ">
                                    <img src="{{asset($img->image)}}" alt="image">
                                </div>
                            </div>
                      </a>
                        @empty
                        <p class="pl-2">No photo provide</p>
                        @endforelse
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('script')
<!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!-- Magnific Popup core JS file -->
<script src="{{asset('assets/magnific-popup/jquery.magnific-popup.js')}}"></script>
<script>
 $('.parent-container').magnificPopup({
    delegate: 'a', // child items selector, by clicking on it popup will open
    type: 'image'
    // other options
    });
</script>
@endpush
