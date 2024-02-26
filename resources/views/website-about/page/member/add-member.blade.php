@extends('website-about.index')

@section('title')
   Add new dummy member
@endsection

@section('website-about')
<div class="content">
    <form action="{{ route('website.about.member.store') }}" method="post"  enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                   <div class="card-header d-flex justify-content-between align-items-center">
                        <h3> Add New member</h3>
                     <a href="{{ route('website.about.member') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="user_name" class=" form-control-label">User name <span class="text-danger">*</span></label>
                            <input type="text" id="user_name" name="user_name" value="{{ old('username')}}" class="form-control" placeholder="Enter Username">
                        </div>
                        <div class="form-group">
                            <label for="designation" class=" form-control-label">Designation<span class="text-danger">(Optional)</span></label>
                            <input type="text" id="designation" name="designation" value="{{ old('designation')}}" class="form-control" placeholder="Enter Location">
                        </div>
                        <div class="form-group">
                            <label for="photo" class=" form-control-label">User Photo<span class="text-danger">*</span></label>
                           <input  type="file" name="photo" required id="photo" class="form-control" />
                            @if($errors->has('photo'))
                                <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @endif
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
