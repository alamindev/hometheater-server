@extends('website-home.index')


@section('website-home')
<form action="{{ route('website.home.productheader.store') }}" method="post" 
    class="form-horizontal">
    @csrf 
    <div class="card">
        <div class="card-header">
           Shop header
        </div>
        <div class="card-body card-block">
            <div class="form-group">
                <label for="title" class=" form-control-label">Title <span class="text-danger">*</span></label>
                <input type="text" id="title" name="title" class="form-control"
                    value="{{ !empty($edit) ? $edit->title : '' }}" placeholder="Enter title">
                    @if(!empty($edit))
                    <input type="hidden" id="id" name="id" class="form-control" value="{{$edit->id}}">
                    @endif
            </div>
            <div class="form-group">
                <label for="description" class="form-control-label">Description<span class="text-danger">
                        *</span></label>
                <textarea name="description" id="description"
                    class="form-control">  {{ !empty($edit) ? $edit->description : '' }}</textarea>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <button type="submit" class="btn btn-info">Update</button>
        </div>
    </div>
</form>
@endsection
