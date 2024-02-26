@extends('website-home.index')


@section('website-home')
<form action="{{ route('website.home.blog.store') }}" method="post" enctype="multipart/form-data"
    class="form-horizontal">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   Blog Header
                </div>
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="title" class=" form-control-label">Title <span
                                class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control"
                            value="{{ !empty($edit) ? $edit->title : '' }}" placeholder="Enter title">
                        @if(!empty($edit))
                        <input type="hidden" id="id" name="id" class="form-control" value="{{$edit->id}}">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="details" class="form-control-label">Description<span class="text-danger">
                                *</span></label>
                        <textarea name="details" id="details"
                            class="form-control">  {{ !empty($edit) ? $edit->details : '' }}</textarea>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
