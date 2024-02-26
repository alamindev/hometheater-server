@extends('website-home.index')
@section('title')
   Choose us view
@endsection
@section('website-home')
<div class="content">
  <div class="row">
  <div class="col-lg-12">
   <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
       <h4>View choose us</h4>
       <a href="{{ route('website.home.chooseus') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
    </div>
        <div class="card-body card-block">
             <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>title</td>
                        <td>:</td>
                        <td>{{ $view->title }}</td>
                    </tr>
                    <tr>
                        <td>Photo</td>
                        <td>:</td>
                        <td><img src="{{ asset('storage'. $view->image) }}" width="200" alt="service-image"></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>:</td>
                       <td>{!! $view->details !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
</div>
@endsection
