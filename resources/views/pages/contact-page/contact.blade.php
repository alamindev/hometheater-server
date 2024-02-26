@extends('layouts.app')
@section('title')
Contact page
@endsection
@section('content')
<form action="{{ route('contactpage.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
<div class="content">
   <div class="card">
    <div class="card-header">
       Contact Page details
    </div>
        <div class="card-body card-block">
                @csrf
                <input type="hidden" name="id" value="{{ $edit ? $edit->id : '' }}"/>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="title" class=" form-control-label">Contact Header Title</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="title" name="title" class="form-control" value="{{ $edit ? $edit->title : old('title') }}" >
                        @if($errors->has('title'))
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="image" class=" form-control-label">Contact Page Image</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="file" id="image" name="image" class="form-control-file">
                        @if($errors->has('image'))
                                <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                            @endif
                            <div  class="py-2">
                        @if(!empty($edit) && $edit->image != '')
                            <img src="{{ url('storage'. $edit->image) }}" alt="site logo" width="100">
                        @endif
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="phone" class=" form-control-label">Contact page Phone</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="phone" name="phone" class="form-control"
                            value="{{ $edit ? $edit->phone : old('phone') }}">
                        @if($errors->has('phone'))
                        <div class="text-danger">{{ $errors->first('phone') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="email" class=" form-control-label">Contact page Email</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="email" name="email" class="form-control"
                            value="{{ $edit ? $edit->email : old('email') }}">
                        @if($errors->has('email'))
                        <div class="text-danger">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-info">Update</button>
            </div>
        </div>
    </div>
</form>
@endsection
