@extends('website-about.index')
@section('title')
 Slider view
@endsection
@section('website-about')
<div class="content">
  <div class="row">
  <div class="col-lg-12">
   <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
       <h4>View slider</h4>
       <a href="{{ route('website.about.slider') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
    </div>
        <div class="card-body card-block">
             <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Title</td>
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
                        <td>{{ $view->details }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
</div>
@endsection
