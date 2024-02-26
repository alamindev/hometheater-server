@extends('website-about.index')

@section('title')
   Edit member
@endsection

@section('website-about')
<div class="content">
    <form action="{{ route('website.about.member.update', $edit->id) }}" method="post"  enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h3> Edit member</h3>
                 <a href="{{ route('website.about.member') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
                </div>
                    <div class="card-body card-block">
                       <div class="form-group">
                            <label for="title" class=" form-control-label">User name <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" value="{{ $edit->title }}" class="form-control" placeholder="Enter service title">
                        </div>
                        <div class="form-group">
                            <label for="details" class=" form-control-label">Designation<span class="text-danger">(Optional)</span></label>
                            <input type="text" id="details" name="details" value="{{ $edit->details }}" class="form-control" placeholder="Enter service title">
                        </div>
                        <div class="form-group">
                            <label for="photo" class=" form-control-label">Upload Photo<span class="text-danger">*</span></label>
                            <input type="file" name="photo" id="photo" class="form-control" />
                            <img src="{{ asset('storage'. $edit->image) }}" width="150" class="mt-2" alt="gallery-photo">
                            @if($errors->has('photo'))
                            <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @endif
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
