@extends('website-about.index')

@section('title')
About more
@endsection
@section('style') 
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css">
@endsection
@section('website-about')
<form action="{{ route('website.about.aboutmore.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                  About more section
                </div>
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="title" class=" form-control-label">Title <span
                                class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control"
                            value="{{ !empty($edit) ? $edit->title : '' }}"
                            placeholder="Enter title">
                            @if(!empty($edit))
                            <input type="hidden" id="id" name="id" class="form-control" value="{{$edit->id}}">
                            @endif
                    </div>

                    <div class="form-group">
                        <label for="details" class="form-control-label">Description<span
                                class="text-danger"> *</span></label>
                        <textarea name="details" cols="5" rows="5" id="details" class="form-control">  {{ !empty($edit) ? $edit->details : '' }}</textarea>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

    @push('script')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    @endpush
