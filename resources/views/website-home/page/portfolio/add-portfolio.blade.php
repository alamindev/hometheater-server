@extends('website-home.index')

@section('title')
   Add new portfolio
@endsection

@section('website-home')
<div class="content">
    <form action="{{ route('website.home.portfolio.store') }}" method="post"  enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                   <div class="card-header d-flex justify-content-between align-items-center">
                        <h3> Add new portfolio</h3>
                     <a href="{{ route('website.home.portfolio') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="title" class=" form-control-label">Title <span class="text-danger">(Optional)</span></label>
                            <input type="text" id="title" name="title" value="{{ old('title')}}" class="form-control" placeholder="Enter service title">
                        </div>
                        <div class="form-group">
                            <label for="photo" class=" form-control-label">Upload Photo<span class="text-danger">*</span></label>
                           <input  type="file" name="photo" required id="photo" class="form-control" />
                            @if($errors->has('photo'))
                                <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="details" class="form-control-label">Description<span class="text-danger">(optional)</span></label>
                            <textarea name="details" rows="5" id="details" class="form-control">{{ old('details')}}</textarea>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('script')
