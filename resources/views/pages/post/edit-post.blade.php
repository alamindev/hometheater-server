 @extends('layouts.app')

@section('title')
   Update post
@endsection

@section('style')
    <link href="{{ asset('assets/css/lib/chosen/chosen.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css">
@endsection
@section('content')
<div class="content">
    <form action="{{ route('post.update', $edit->id) }}" method="post"  enctype="multipart/form-data" class="form-horizontal">
        @csrf
       <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                       Edit Post
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="title" class=" form-control-label">Title <span class="text-danger">*</span></label>
                            <input type="text" required id="title" name="title" value="{{ $edit->title }}" class="form-control" placeholder="Enter service title">
                            @if($errors->has('title'))
                                <div class="text-danger">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                           <div class="form-group">
                            <label for="category" class=" form-control-label">Select Category <span class="text-danger">*</span></label>
                           <select required data-placeholder="Choose Category" value="{{ old('category_id') }}" name="category_id" id="category" class="form-control">
                               <option value="" label="default"></option>
                                @foreach ($categories as $cate)
                                    <option value="{{ $cate->id }}" @if($cate->id == $edit->category_id) selected @endif>{{ $cate->name }}</option>
                                @endforeach
                           </select>
                            @if($errors->has('category_id'))
                                <div class="text-danger">{{ $errors->first('category_id') }}</div>
                            @endif
                        </div>
                         <div class="form-group">
                            <label for="tag" class=" form-control-label" >Select Tag  </label> <span class="text-danger">*</span></label>
                           <select required  multiple name="tag[]" id="tag" class="form-control" value="{{ old('tag') }}">
                               <option value="" label="default"></option>
                                @foreach ($tags as $tag)
                                    <option  @if(in_array($tag->id,   $edit->tags->pluck('id')->toArray())) selected @endif  value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                           </select>
                            @if($errors->has('tag'))
                                <div class="text-danger">{{ $errors->first('tag') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="photo" class=" form-control-label">Upload Photo <span class="text-danger">*</span></label>
                           <input  type="file" name="photo"   id="photo" class="form-control" />
                           @if($edit->photo)
                                <img src="{{ asset('storage'. $edit->photo) }}" width="200" alt="post-image" class="py-2">
                           @endif
                            @if($errors->has('photo'))
                                <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="details" class="form-control-label">Description<span class="text-danger">(optional)</span></label>
                            <textarea name="details" id="details" class="form-control">{!! $edit->details !!}</textarea>
                             @if($errors->has('details'))
                                <div class="text-danger">{{ $errors->first('details') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="seo_details" class="form-control-label">Description </label>
                            <textarea name="seo_details" cols="5" rows="5" id="seo_details"
                                class="form-control">  {{ !empty($edit) ? $edit->seo_details : '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class=" form-control-label">Keyword <span class="text-danger">(keyword by comma)</span></label>
                            <input type="text" id="keyword" name="keyword" class="form-control"
                                value="{{ !empty($edit) ? $edit->keyword : '' }}" placeholder="Enter keyword by comma">
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
<script type="importmap">
	{
		"imports": {
			"ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
			"ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/"
		}
	}
</script>

<script type="module">
	import {
		ClassicEditor,
	Autoformat,
	Bold,
	Italic,
	Underline,
	BlockQuote,
	Base64UploadAdapter,
	CKFinder,
	CKFinderUploadAdapter,
	CloudServices,
	CKBox,
	Essentials,
	Heading,
	Image,
	ImageCaption,
	ImageResize,
	ImageStyle,
	ImageToolbar,
	ImageUpload,
	PictureEditing,
	Indent,
	IndentBlock,
	Link,
	List,
	MediaEmbed,
	Mention,
	Paragraph,
	PasteFromOffice,
	Table,
	TableColumnResize,
	TableToolbar,
	TextTransformation,
	} from 'ckeditor5';
	ClassicEditor
		.create( document.querySelector( '#details' ), {
			plugins: [
			Autoformat,
			BlockQuote,
			Bold,
			CKFinder,
			CKFinderUploadAdapter,
			CloudServices, 
			Essentials,
			Heading,
			Image,
			ImageCaption,
			ImageResize,
			ImageStyle,
			ImageToolbar,
			ImageUpload,
			Base64UploadAdapter,
			Indent,
			IndentBlock,
			Italic,
			Link,
			List,
			MediaEmbed,
			Mention,
			Paragraph,
			PasteFromOffice,
			PictureEditing,
			Table,
			TableColumnResize,
			TableToolbar,
			TextTransformation,
			Underline, 
		],
		toolbar: [
			'undo',
			'redo',
			'|',
			'heading',
			'|',
			'bold',
			'italic',
			'underline',
			'|',
			'link',
			'uploadImage',
			'ckbox',
			'insertTable',
			'blockQuote',
			'mediaEmbed',
			'|',
			'bulletedList',
			'numberedList',
			'|',
			'outdent',
			'indent',
		],
		heading: {
			options: [
				{
					model: 'paragraph',
					title: 'Paragraph',
					class: 'ck-heading_paragraph',
				},
				{
					model: 'heading1',
					view: 'h1',
					title: 'Heading 1',
					class: 'ck-heading_heading1',
				},
				{
					model: 'heading2',
					view: 'h2',
					title: 'Heading 2',
					class: 'ck-heading_heading2',
				},
				{
					model: 'heading3',
					view: 'h3',
					title: 'Heading 3',
					class: 'ck-heading_heading3',
				},
				{
					model: 'heading4',
					view: 'h4',
					title: 'Heading 4',
					class: 'ck-heading_heading4',
				},
			],
		},
		image: {
			resizeOptions: [
				{
					name: 'resizeImage:original',
					label: 'Default image width',
					value: null,
				},
				{
					name: 'resizeImage:50',
					label: '50% page width',
					value: '50',
				},
				{
					name: 'resizeImage:75',
					label: '75% page width',
					value: '75',
				},
			],
			toolbar: [
				'imageTextAlternative',
				'toggleImageCaption',
				'|',
				'imageStyle:inline',
				'imageStyle:wrapText',
				'imageStyle:breakText',
				'|',
				'resizeImage',
			],
		},
		link: {
			addTargetToExternalLinks: true,
			defaultProtocol: 'https://',
		},
		table: {
			contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells'],
		}, 
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( error => {
			console.error( error );
		} );
</script>
<script src="{{ asset('assets/js/lib/chosen/chosen.jquery.min.js') }}"></script>
<script> 
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
