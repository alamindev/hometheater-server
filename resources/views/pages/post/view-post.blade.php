@extends('layouts.app')
@section('title')
   Page view
@endsection
@section('content')
<div class="content">
  <div class="row">
  <div class="col-lg-12">
   <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
       <h4>View page</h4>
       <a href="{{ route('posts') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
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
                        <td>Slug</td>
                        <td>:</td>
                        <td>{{ $view->slug }}</td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>:</td>
                        <td>{{ $view->category->name }}</td>
                    </tr>
                    <tr>
                        <td>Tag</td>
                        <td>:</td>
                        <td>
                            @php
                                foreach($view->tags()->pluck('name')->toArray() as $arr){
                                  echo "<span class='mx-1 badge badge-success'>$arr</span>";
                                }
                            @endphp

                        </td>
                    </tr>
                    <tr>
                        <td>Photo</td>
                        <td>:</td>
                        <td>
                        @if($view->photo)
                        <img src="{{ asset('storage'. $view->photo) }}" width="200" alt="page-image">
                        @else
                        no photo
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>:</td>
                       <td>{!! $view->details !!}</td>
                    </tr>
                    <tr>
                        <td>Seo details</td>
                        <td>:</td>
                        <td>{!! $view->seo_details !!}</td>
                    </tr>
                    <tr>
                        <td>Keyword</td>
                        <td>:</td>
                        <td>{!! $view->keyword !!}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:</td>
                       <td>{{  $view->active == 1 ? 'Active' : 'Deactive'  }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

  </div>
  </div>
</div>
@endsection
