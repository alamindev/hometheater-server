@extends('layouts.app')

@section('title')
Add new Photo
@endsection

@section('style')
<link href="{{ asset('assets/css/lib/chosen/chosen.css') }}" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css">
@endsection
@section('content')
<div class="content">
    <form action="{{ route('gallery.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
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
                            <input type="text" id="title" name="title" class="form-control"
                                placeholder="Enter service title">
                        </div>
                        <div class="form-group">
                            <label for="photo" class=" form-control-label">Upload Photo<span
                                    class="text-danger">*</span></label>
                            <input type="file" name="photo" required id="photo" class="form-control" />
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
                                <option value="{{ $album->id }}">{{ $album->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('album_id'))
                            <div class="text-danger">{{ $errors->first('album_id') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="datepicker" class=" form-control-label">Installed Date<span
                                    class="text-danger">(optional)</span></label>
                            <input type="text" name="install_date" required id="datepicker" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="details" class="form-control-label">Description<span
                                    class="text-danger">(optional)</span></label>
                            <textarea name="details" id="details" class="form-control"></textarea>
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
<script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
<script src="{{ asset('assets/js/lib/chosen/chosen.jquery.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
<script> 
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
