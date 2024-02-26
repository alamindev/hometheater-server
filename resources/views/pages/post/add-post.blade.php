 @extends('layouts.app')

@section('title')
   Add new  post
@endsection

@section('style')
    <link href="{{ asset('assets/css/lib/chosen/chosen.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="content">
    <form action="{{ route('post.store') }}" method="post"  enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                       Post
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="title" class=" form-control-label">Title <span class="text-danger">*</span></label>
                            <input type="text" required id="title" name="title" value="{{ old('title') }}" class="form-control" placeholder="Enter Post title">
                            @if($errors->has('title'))
                                <div class="text-danger">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                         <div class="form-group">
                            <label for="category" class=" form-control-label">Select Category <span class="text-danger">*</span></label>
                           <select required data-placeholder="Choose Category" value="{{ old('category_id') }}" name="category_id" id="category" class="form-control">
                               <option value="" label="default"></option>
                                @foreach ($categories as $cate)
                                    <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                @endforeach
                           </select>
                            @if($errors->has('category_id'))
                                <div class="text-danger">{{ $errors->first('category_id') }}</div>
                            @endif
                        </div>
                         <div class="form-group">
                            <label for="tag" class=" form-control-label" >Select Tag <span class="text-danger">*</span></label>
                           <select required  multiple name="tag[]"   id="tag" class="form-control" value="{{ old('tag') }}">
                               <option value="" label="default"></option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                           </select>
                            @if($errors->has('tag'))
                                <div class="text-danger">{{ $errors->first('tag') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="photo" class=" form-control-label">Upload Photo<span class="text-danger">*</span></label>
                           <input  type="file" name="photo"   id="photo" class="form-control" />
                            @if($errors->has('photo'))
                                <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="details" class="form-control-label">Description<span class="text-danger">*</span></label>
                            <textarea name="details" id="details" class="form-control">{{ old('details') }}</textarea>
                            @if($errors->has('details'))
                                <div class="text-danger">{{ $errors->first('details') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="seo_details" class="form-control-label">Description </label>
                            <textarea name="seo_details" cols="5" rows="5" id="seo_details"
                                class="form-control">  {{ old('seo_details') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class=" form-control-label">Keyword <span class="text-danger">(keyword by comma)</span></label>
                            <input type="text" id="keyword" name="keyword" class="form-control" value="{{ old('keyword') }}"
                                placeholder="Enter keyword by comma">
                        </div>
                        <div class="form-group">
                            <label for="status" class=" form-control-label">Select Status  </label>
                           <select  name="status" id="category" class="form-control">
                               <option value="1" >Active</option>
                               <option value="2" >Deactive</option>
                           </select>
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

     CKEDITOR.replace('details', {
            filebrowserUploadUrl: "{{asset('/post/uploads?_token=' . csrf_token()) }}&type=file",
            imageUploadUrl: "{{asset('/post/uploads?_token='. csrf_token() )  }}&type=image",
            filebrowserBrowseUrl: "{{asset('/post/file_browser') }}",
            filebrowserUploadMethod: 'form'
		});
    jQuery("#category").chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
    });
    jQuery("#tag").chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
    });
</script>
@endpush
