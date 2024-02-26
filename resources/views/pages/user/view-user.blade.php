@extends('layouts.app')
@section('title')
  View Users
@endsection
@section('content')
<div class="content">
  <div class="row">
  <div class="col-lg-12">
   <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
       <h4>View Users</h4>
       <a href="{{ route('users') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
    </div>
        <div class="card-body card-block">
             <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Photo</td>
                        <td>:</td>
                        <td>
                           @if ($view->photo)
                        <img src='{{   asset($row->photo) }}' width="100" alt="user-image">
                        @else
                        no photo
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>:</td>
                        <td><p class="badge badge-danger">{{ $view->address }}, {{ $view->city }}, {{$view->state}} {{$view->zipcode}}</p></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td>{{ $view->first_name }} {{$view->last_name}}</td>
                    </tr>
                    <tr>
                        <td>Total Orders</td>
                        <td>:</td>
                        <td>{{ $view->orders->count() }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>{{ $view->email }}</td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td>:</td>
                       <td>{!! $view->phone !!}</td>
                    </tr>
                    <tr>
                        <td>Bio</td>
                        <td>:</td>
                       <td>{!! $view->bio !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
@endsection
