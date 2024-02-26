@extends('layouts.app')

@section('title')
Edit Photo
@endsection

@section('style')
<link href="{{ asset('assets/css/lib/chosen/chosen.css') }}" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
<div class="content">
    <form action="{{ route('gallery.update', $edit->id) }}" method="post" enctype="multipart/form-data"
        class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Photo
                    </div>
                    <div class="card-body card-block">


                        <div class="form-group">
                            <label for="title" class=" form-control-label">Title <span
                                    class="text-danger">(Optional)</span></label>
                            <input type="text" id="title" name="title" value="{{ $edit->title }}" class="form-control"
                                placeholder="Enter service title">
                        </div>
                        <div class="form-group">
                            <label for="photo" class=" form-control-label">Upload Photo<span
                                    class="text-danger">*</span></label>
                            <input type="file" name="photo" id="photo" class="form-control" />
                            <img src="{{ asset('storage'. $edit->photo) }}" width="150" class="mt-2"
                                alt="gallery-photo">
                            @if($errors->has('photo'))
                            <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="category" class=" form-control-label">Select Album <span
                                    class="text-danger">*</span></label>
                            <select required data-placeholder="Choose Album" name="album_id" id="category"
                                class="form-control">
                                <option value="" label="default"></option>
                                @foreach (App\Models\Album::orderBy('created_at','desc')->get() as $album)
                                <option value="{{ $album->id }}" @if($album->id == $edit->album_id) selected @endif>{{
                                    $album->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('album_id'))
                            <div class="text-danger">{{ $errors->first('album_id') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="datepicker" class=" form-control-label">Installed Date<span
                                    class="text-danger">(optional)</span></label>
                            <input type="text" name="install_date" required id="datepicker"
                                value="{{ $edit->install_date }}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="details" class="form-control-label">Description<span
                                    class="text-danger">(optional)</span></label>
                            <textarea name="details" id="details" class="form-control">{{ $edit->details }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('script')
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script src="{{ asset('assets/js/lib/chosen/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/chosen/chosen.jquery.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    CKEDITOR.replace( 'details' );
    jQuery("#category").chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
    });

    $(function(){
        $( "#datepicker" ).datepicker({
             dateFormat: "yy-mm-dd",
        });
    })
</script>
@endpush
