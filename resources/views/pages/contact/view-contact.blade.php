@extends('layouts.app')
@section('title')
   Contact view
@endsection 
@section('content')
<div class="content">
  <div class="row"> 
  <div class="col-lg-12">
   <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
       <h4>View contact</h4>
       <a href="{{ route('contacts') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
    </div>
        <div class="card-body card-block">
             <table class="table table-bordered"> 
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td>{{ $view->name }}</td>
                    </tr> 
                    <tr>
                        <td>Phone</td>
                        <td>:</td>
                        <td>{{ $view->phone }}</td>
                    </tr> 
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>{{ $view->email }}</td>
                    </tr> 
                    <tr>
                        <td>Contact Reason</td>
                        <td>:</td>
                        <td>{{ $view->reason }}</td>
                    </tr> 
                    <tr>
                        <td>Content</td>
                        <td>:</td>
                       <td>{!! $view->details !!}</td>
                    </tr>
                    <tr>
                        <td>Contact Date</td>
                        <td>:</td>
                       <td>{{ Carbon\Carbon::parse($view->created_at)->format('d-m-Y') }}</td>
                    </tr>
              </tbody>
            </table>
        </div> 
    </div>
    
  </div>
  </div>
</div>
@endsection 