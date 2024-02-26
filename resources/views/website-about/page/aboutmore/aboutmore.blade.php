@extends('website-about.index')

@section('title')
About more
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
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/lib/chosen/chosen.jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        CKEDITOR.replace( 'details' );
    </script>
    @endpush
