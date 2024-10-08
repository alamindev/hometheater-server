@extends('layouts.app')

@section('title')
Add new Product
@endsection

@section('style')
<link href="{{ asset('assets/css/lib/chosen/chosen.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css">
@endsection
@section('content')
<div class="content">
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        Product
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="title" class=" form-control-label">Title <span
                                    class="text-danger">*</span></label>
                            <input type="text" required id="title" name="title" value="{{ old('title') }}"
                                class="form-control" placeholder="Enter service title">
                            @if($errors->has('title'))
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="slug" class=" form-control-label">Slug <span>(Optional)</span> </label>
                            <input type="text" required id="slug" name="slug" value="{{ old('slug') }}"
                                class="form-control" placeholder="Enter service slug">
                            @if($errors->has('slug'))
                            <div class="text-danger">{{ $errors->first('slug') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="service_type" class=" form-control-label">SKU <span
                                    class="text-danger">*</span></label>
                            <input type="text" required id="service_type"  
                                name="service_type" value="{{ old('service_type') }}" class="form-control"
                                placeholder="Example:- TV1001">
                            @if($errors->has('service_type'))
                            <div class="text-danger">{{ $errors->first('service_type') }}</div>
                            @endif
                        </div>
                   
                        <div class="form-group">
                            <label for="basic_price" class="form-control-label">Regular price <span
                                    class="text-danger">*</span></label>
                            <input type="number" min="0" step="0.01"  required id="basic_price" name="basic_price"
                                value="{{ old('basic_price') }}" class="form-control">
                            @if($errors->has('basic_price'))
                            <div class="text-danger">{{ $errors->first('basic_price') }}</div>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="discount_price" class="form-control-label">Price Discount <span
                                    class="text-danger">(optional)</span></label>
                            <input type="number" min="0" step="0.01"   placeholder="10%" id="discount_price" name="discount_price"
                                value="{{ old('discount_price') }}" class="form-control">
                            @if($errors->has('discount_price'))
                            <div class="text-danger">{{ $errors->first('discount_price') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="quantity" class="form-control-label">Quantity<span
                                    class="text-danger">*</span></label>
                            <input type="number"  required id="quantity" name="quantity"
                                value="{{ old('quantity') }}" class="form-control">
                            @if($errors->has('quantity'))
                            <div class="text-danger">{{ $errors->first('quantity') }}</div>
                            @endif
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="category" class=" form-control-label">Select Category <span
                                    class="text-danger">*</span></label>
                            <select  data-placeholder="Choose Category" name="category_id" id="category"
                                class="form-control">
                                <option label="default"></option>
                                @foreach (App\Models\ServiceCategory::orderBy('created_at','desc')->get() as $cate)
                                <option value="{{ $cate->id }}">{{ $cate->cate_name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category_id'))
                            <div class="text-danger">{{ $errors->first('category_id') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="thumbnail" class="form-control-label">Upload Thumbnail<span class="text-danger">*</span></label>
                            <input type="file" required id="thumbnail" name="thumbnail" value="{{ old('thumbnail') }}"
                                class="form-control">
                            @if($errors->has('thumbnail'))
                            <div class="text-danger">{{ $errors->first('thumbnail') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between pb-2">
                                <label for="image" class=" form-control-label">Upload photo<span
                                        class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-info add-new-photo"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            <div class="photos">
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <input type="file" name="image[]" required id="image"
                                            class="form-control mr-1" />
                                    </div>
                                </div>
                            </div>

                            @if($errors->has('image'))
                            <div class="text-danger">{{ $errors->first('image') }}</div>
                            @endif
                        </div>
                        <div class="form-group pb-3">
                            <div class="d-flex justify-content-between pb-2">
                                <label for="image" class=" form-control-label">Service Includes <span
                                        class="text-danger">(optional)</span></label>
                                <button type="button" class="btn btn-sm btn-info add-new-feature"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            <div class="feature">
                                <div class="list-group">
                                    <div class="list-group-item d-flex align-items-center">
                                        <div class="px-1 w-100"><input type="text" name="feature[]"
                                                placeholder="Feature details" class="form-control"></div>
                                        <div class="feature__trash bg-danger text-white p-2"><i class="fa fa-trash"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group pb-3">
                            <div class="d-flex justify-content-between pb-2">
                                <label for="image" class=" form-control-label">Colors<span
                                        class="text-danger">(optional)</span></label>
                                <button type="button" class="btn btn-sm btn-info add-new-color"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            <div class="color">
                                <div class="list-group">
                                    <div class="list-group-item d-flex align-items-center">
                                        <div class="d-flex w-100">
                                            <div class="px-1 w-50">
                                                <input type="text" name="color_name[]" placeholder="Color Name" class="form-control">
                                            </div>
                                            <div class="px-1 w-50">
                                                <input type="text" name="color_code[]" placeholder="Color Code" class="form-control">
                                            </div>
                                        </div>
                                        <div class="color__trash bg-danger text-white p-2 flex-shrink-0">
                                            <i class="fa fa-trash"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="conditions" class="form-control-label">Condition<span
                                    class="text-danger">*</span></label>
                           <select name="conditions" id="conditions" required class="form-control">
                            <option value="new">New</option>
                            <option value="used">Used</option>
                            <option value="out of box">Out of Box</option>
                            <option value="refurbished">Refurbished</option> 
                           </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="details" class="form-control-label">Description<span
                                    class="text-danger">(optional)</span></label>
                            <textarea name="details" id="details" class="form-control">{{old('details')}}</textarea>
                        </div>
                    </div>
                </div> 
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="delivery_time" class="form-control-label">Delivery Date<span
                                    class="text-danger">*</span></label>
                           <select name="delivery_time" id="delivery_time" required class="form-control">
                            <option value="1">01 Days</option>
                            <option value="2">02 Days</option>
                            <option value="3">03 Days</option>
                            <option value="4">04 Days</option>
                            <option value="5">05 Days</option>
                            <option value="6">06 Days</option>
                            <option value="7">07 Days</option>
                            <option value="8">08 Days</option>
                            <option value="9">09 Days</option>
                            <option value="10">10 Days</option>
                           </select>
                        </div>
                        <div class="form-group">
                            <label for="seo_details" class="form-control-label">Seo Description </label>
                            <textarea name="seo_details" cols="5" rows="5" id="seo_details"
                                class="form-control">  {{ old('seo_details') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class=" form-control-label">Keyword <span class="text-danger">(keyword
                                    by comma)</span></label>
                            <textarea name="keyword" cols="5" rows="5" id="keyword" class="form-control"
                                placeholder="Enter keyword by comma">  {{ old('keyword') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class=" form-control-label">Suggestion</label>
                            <select data-placeholder="Suggestion" multiple name="suggestion[]" id="suggestion"
                                class="form-control">
                                <option label="default"></option>
                                @foreach (App\Models\Service::orderBy('created_at','desc')->where('type', 1)->get() as $service)
                                <option value="{{ $service->id }}">{{ $service->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div> 
                
            </div>
        </div>
        <div class="card">
            <div class="card-body d-flex justify-content-center">
                <button type="submit" class="btn btn-info">Submit</button>
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
    jQuery("#suggestion").chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
    });
    document.getElementById('type').addEventListener('change', function () {
        controlType(this.value)
    });

    controlType(document.getElementById('type').value)
    function controlType(value){
        if(value == 1){
            document.getElementById('svg').style.display = 'block';
            document.getElementById('fonticon').style.display = 'none';
            }else{
            document.getElementById('fonticon').style.display = 'block';
            document.getElementById('svg').style.display = 'none';
            }
    }
</script>
@endpush
