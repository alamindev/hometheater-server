@extends('website-home.index')

@section('title')
   Edit Review
@endsection

@section('website-home')
<div class="content">
    <form action="{{ route('website.home.review.update', $edit->id) }}" method="post"  enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h3> Edit review</h3>
                 <a href="{{ route('website.home.review') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
                </div>
                    <div class="card-body card-block">
                       <div class="form-group">
                            <label for="user_name" class=" form-control-label">User name <span class="text-danger">*</span></label>
                            <input type="text" id="user_name" name="user_name" value="{{ $edit->user_name }}" class="form-control" placeholder="Enter service title">
                        </div>
                        <div class="form-group">
                            <label for="location" class=" form-control-label">Location<span class="text-danger">(Optional)</span></label>
                            <input type="text" id="location" name="location" value="{{ $edit->location }}" class="form-control" placeholder="Enter service title">
                        </div>
                        <div class="form-group">
                            <label for="photo" class=" form-control-label">Upload Photo<span class="text-danger">*</span></label>
                            <input type="file" name="photo" id="photo" class="form-control" />
                            <img src="{{ asset('storage'. $edit->image) }}" width="150" class="mt-2" alt="gallery-photo">
                            @if($errors->has('photo'))
                            <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="rating" class=" form-control-label">Rating<span class="text-danger">*</span></label>
                            <input type="text" id="rating" name="rating" value="{{ $edit->rating }}"class="form-control" placeholder="Enter service title">
                        </div>
                        <div class="form-group">
                            <label for="text" class="form-control-label">Rating text<span class="text-danger">*</span></label>
                            <textarea name="text" rows="5" id="text" class="form-control">{{ $edit->text }}</textarea>
                        </div>
                        <br>
                         <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
