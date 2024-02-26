@extends('layouts.app')

@section('title')
Edit User photo
@endsection

@section('content')
<div class="content">
    <form action="{{ route('user.update', $edit->id) }}" method="post" enctype="multipart/form-data"
        class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Edit user photo
                    </div>
                    <div class="card-body card-block">

                        <div class="form-group">
                            <label for="photo" class=" form-control-label">Upload Photo<span
                                    class="text-danger">*</span></label>
                            <input type="file" name="photo" id="photo" class="form-control" />
                            <img src="{{   asset($edit->photo) }}" width="150" class="mt-2"
                                alt="photo">
                            @if($errors->has('photo'))
                            <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
