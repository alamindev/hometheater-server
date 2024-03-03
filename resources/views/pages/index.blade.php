@extends('layouts.app')
@section('title')
Dashboard
@endsection
@section('content')
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!-- Widgets  -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card color-purple">
                    <div class="card-body">
                        <div class="stat-widget-five ">
                            <div class="stat-icon dib flat-color-4">
                                <i class="pe-7s-users text-white"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text text-white"><span class="count">{{ $user_count }}</span></div>
                                    <div class="stat-heading text-white">Users</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card color-blue">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-4">
                               <i class="fa fa-book text-white" aria-hidden="true"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text text-white"><span class="count">{{$order_count}}</span></div>
                                    <div class="stat-heading text-white">All Orders</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card color-red">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-4">
                             <i class="fa fa-refresh text-white"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text text-white"><span class="count">{{$pending_order}}</span></div>
                                    <div class="stat-heading text-white">Pending order</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card color-green">
                    <div class="card-body">
                        <div class="stat-widget-five ">
                            <div class="stat-icon dib flat-color-4">
                            <i class="fa fa-usd text-white" aria-hidden="true"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text text-white">$<span class="count">{{$payments ? $payments : ''}}</span></div>
                                    <div class="stat-heading text-white">Payments</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Widgets -->

        <!--  /Traffic -->
        <div class="clearfix"></div>
        <!-- Orders -->
        <div class="orders">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="box-title">Recent Service Booking</h4>
                        </div>
                        <div class="card-body--">
                            @if(count($orders) > 0)
                            <div class="table-stats order-table ov-h">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th class="serial">#</th>
                                            <th class="avatar">Avatar</th>
                                            <th>Order ID</th>
                                            <th>Name</th>
                                            <th>Customer Phone no.</th>
                                            <th>Quantity</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach($orders as $order)
                                        <tr>
                                            <td class="serial">{{ $i++}}.</td>
                                            <td class="avatar">
                                                <div class="round-img">
                                                    @if($order->user && $order->user->photo!= null)
                                                        <img class="rounded-circle" src="{{asset($order->user->photo)}}" alt="">
                                                        @else
                                                        <img class="rounded-circle" src="{{asset('storage/uploads/avater.svg')}}" alt="">
                                                   @endif
                                                </div>
                                            </td>
                                            <td> #{{$order->order_id}} </td>
                                            <td>  <span class="name">{{ $order->user->first_name}} {{ $order->user->last_name}}</span> </td>
                                            <td> <span class="product">{{ $order->user->phone }}</span> </td>
                                            <td><span class="count">{{ collect($order->quantity)->pluck('quantity')->sum()}}</span></td>
                                            <td>{{ \carbon\carbon::parse($order->created_at)->format('d M y h:i:s A')}}</td>
                                            <td>
                                                @if($order->status == 'pending')
                                                <span class="badge btn-yellow">{{ $order->status}}</span>
                                                @elseif($order->status == 'complete')
                                                    <span class="badge btn-blue">{{ $order->status}}</span>
                                                @elseif($order->status == 'approved')
                                                    <span class="badge btn-green ">{{ $order->status}}</span>
                                                @elseif($order->status == 'cancel')
                                                    <span class="badge btn-red">{{ $order->status}}</span>
                                                @endif
                                            </td>
                                            <td>
                                               <a href="{{route('order.details', $order->order_id)}}" class="btn btn-info btn-blue">Order Details</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div> <!-- /.table-stats -->
                            @else 
                               <h4 class="text-center p-3">No Data availble</h4>
                            @endif
                        </div>
                    </div> <!-- /.card --> 
                    @if(count($orders) > 0)
                    <div class="card">
                        <div class="card-body d-flex justify-content-center">
                            <a href="{{route('order')}}" class="btn btn-success">Show all</a>
                        </div>
                    </div> 
                    @endif
                        <div class="card">
                            <div class="card-body">
                                <h4 class="box-title">Recent Product Order</h4>
                            </div>
                            <div class="card-body--">
                                @if(count($products) > 0)
                                <div class="table-stats order-table ov-h">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th class="serial">#</th>
                                                <th class="avatar">Avatar</th>
                                                <th>Order ID</th>
                                                <th>Name</th>
                                                <th>Customer Phone no.</th>
                                                <th>Quantity</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i = 1;
                                            @endphp
                                            @foreach($products as $order)
                                            <tr>
                                                <td class="serial">{{ $i++}}.</td>
                                                <td class="avatar">
                                                    <div class="round-img">
                                                        @if($order->user && $order->user->photo!= null)
                                                            <img class="rounded-circle" src="{{asset($order->user->photo)}}" alt="">
                                                            @else
                                                            <img class="rounded-circle" src="{{asset('storage/uploads/avater.svg')}}" alt="">
                                                       @endif
                                                    </div>
                                                </td>
                                                <td> #{{$order->order_id}} </td>
                                                <td>  <span class="name">{{ $order->user->first_name}} {{ $order->user->last_name}}</span> </td>
                                                <td> <span class="product">{{ $order->user->phone }}</span> </td>
                                                <td><span class="count">{{ collect($order->quantity)->pluck('quantity')->sum()}}</span></td>
                                                <td>{{ \carbon\carbon::parse($order->created_at)->format('d M y h:i:s A')}}</td>
                                                <td>
                                                    @if($order->status == 'pending')
                                                    <span class="badge btn-yellow">{{ $order->status}}</span>
                                                    @elseif($order->status == 'complete')
                                                        <span class="badge btn-blue">{{ $order->status}}</span>
                                                    @elseif($order->status == 'approved')
                                                        <span class="badge btn-green ">{{ $order->status}}</span>
                                                    @elseif($order->status == 'cancel')
                                                        <span class="badge btn-red">{{ $order->status}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                   <a href="{{route('order.details', $order->order_id)}}" class="btn btn-info btn-blue">Order Details</a>
                                                </td>
                                            </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- /.table-stats -->
                                @else 
                               <h4 class="text-center p-3">No Data availble</h4>
                            @endif
                            </div>
                        </div> <!-- /.card -->
                        
                        @if(count($products) > 0)
                    <div class="card">
                        <div class="card-body d-flex justify-content-center">
                            <a href="{{route('order')}}" class="btn btn-success">Show all</a>
                        </div>
                    </div>
                    @endif
                </div>  <!-- /.col-lg-8 -->

            </div>
        </div> 
    </div>
    <!-- .animated -->
</div>
@endsection
