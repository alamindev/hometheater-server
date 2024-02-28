@extends('website-meta-info.index')


@section('website-meta')
<form action="{{ route('website.info.store','product') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   Product page meta
                </div>
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="title" class=" form-control-label">Title </label>
                        <input type="text" id="title" name="title" class="form-control"
                            value="{{ !empty($edit) ? $edit->title : '' }}"
                            placeholder="Enter title">
                            @if(!empty($edit))
                            <input type="hidden" id="id" name="id" class="form-control" value="{{$edit->id}}">
                            @endif
                    </div>
                    <div class="form-group">
                        <label for="details" class="form-control-label">Description </label>
                        <textarea name="details" cols="5" rows="5" id="details" class="form-control">  {{ !empty($edit) ? $edit->description : '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="photo" class=" form-control-label">Upload Photo</label>
                        <input type="file" name="photo"   id="photo" class="form-control" />
                        @if(!empty($edit) && $edit->image != '')
                            <img class="pt-2" src="{{ asset('storage'. $edit->image) }}" alt="top header image" width="100">
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="keyword" class=" form-control-label">Keyword <span class="text-danger">(keyword by comma)</span></label>
                        <input type="text" id="keyword" name="keyword" class="form-control" value="{{ !empty($edit) ? $edit->keyword : '' }}"
                            placeholder="Enter keyword by comma">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

