@extends('website-home.index')
@section('title')
 Dummy review view
@endsection
@section('website-home')
<div class="content">
  <div class="row">
  <div class="col-lg-12">
   <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
       <h4>View review</h4>
       <a href="{{ route('website.home.review') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
    </div>
        <div class="card-body card-block">
             <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>UserName</td>
                        <td>:</td>
                        <td>{{ $view->user_name }}</td>
                    </tr>
                    <tr>
                        <td>Location</td>
                        <td>:</td>
                        <td>{{ $view->location }}</td>
                    </tr>
                    <tr>
                        <td>Photo</td>
                        <td>:</td>
                        <td><img src="{{ asset('storage'. $view->image) }}" width="200" alt="service-image"></td>
                    </tr>
                    <tr>
                        <td>Rating</td>
                        <td>:</td>
                        <td>{{ $view->rating }}</td>
                    </tr>
                    <tr>
                        <td>Rating text</td>
                        <td>:</td>
                        <td>{{ $view->text }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
</div>
@endsection
