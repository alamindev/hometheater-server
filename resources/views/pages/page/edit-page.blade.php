 @extends('layouts.app')

@section('title')
   Update page
@endsection

@section('style')
    <link href="{{ asset('assets/css/lib/chosen/chosen.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="content">
    <form action="{{ route('page.update', $edit->id) }}" method="post"  enctype="multipart/form-data" class="form-horizontal">
        @csrf
       <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                       Page
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="name" class=" form-control-label">Menu Name <span class="text-danger">*</span></label>
                            <input type="text" required id="name" name="name" value="{{ $edit->main_title }}" class="form-control" placeholder="Enter page menu name">
                            @if($errors->has('name'))
                            <div class="text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="title" class=" form-control-label">Title <span class="text-danger">*</span></label>
                            <input type="text" required id="title" name="title" value="{{ $edit->title }}" class="form-control" placeholder="Enter service title">
                            @if($errors->has('title'))
                                <div class="text-danger">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="type" class=" form-control-label">Page Type <span class="text-danger">*</span></label>
                            <select type="text" required id="type" name="type" class="form-control">
                                <option value="company" @if($edit->type == 'company') selected @endif >Company</option>
                                <option value="service" @if($edit->type == 'service') selected @endif>Service</option>
                            </select>
                            @if($errors->has('type'))
                            <div class="text-danger">{{ $errors->first('type') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="thumb" class=" form-control-label">Upload Photo<span class="text-danger">*</span></label>
                           <input  type="file" name="thumb"   id="thumb" class="form-control" />
                           <img src="{{ asset('storage'. $edit->thumb) }}" width="200" alt="page-image" class="py-2">
                            @if($errors->has('thumb'))
                                <div class="text-danger">{{ $errors->first('thumb') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="content" class="form-control-label">Description<span class="text-danger">(optional)</span></label>
                            <textarea name="content" id="content" class="form-control">{!! $edit->content !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="seo_details" class="form-control-label">Description </label>
                            <textarea name="seo_details" cols="5" rows="5" id="seo_details"
                                class="form-control">  {{ !empty($edit) ? $edit->seo_details : '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class=" form-control-label">keyword <span class="text-danger">(optional)</span></label>
                            <input type="text" id="keyword" value="{{ $edit->keyword }}" name="keyword" class="form-control" placeholder="Enter keywords">
                        </div>
                        <button type="submit" class="btn btn-info">Submit</button>
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
<script>
       CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{asset('/page/uploads?_token=' . csrf_token()) }}&type=file",
            imageUploadUrl: "{{asset('/page/uploads?_token='. csrf_token() )  }}&type=image",
            filebrowserBrowseUrl: "{{asset('/page/file_browser') }}",
            filebrowserUploadMethod: 'form'
		});
    jQuery("#type").chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
    });
</script>
@endpush
