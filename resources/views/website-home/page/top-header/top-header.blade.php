@extends('website-home.index')


@section('website-home')
<form action="{{ route('website.home.topheader.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   Top header section
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
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="btn_text" class=" form-control-label">Button text <span class="text-danger">*</span></label>
                                <input type="text" id="btn_text" name="btn_text" value="{{ !empty($edit) ? $edit->btn_text : '' }}" class="form-control" placeholder="Enter button text" >
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="btn_link" class=" form-control-label">Button link <span class="text-danger">*</span></label>
                                <input type="text" id="btn_link" name="btn_link" value="{{ !empty($edit) ? $edit->btn_link : '' }}" class="form-control" placeholder="Enter button link">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="second_btn_text" class=" form-control-label">Second button text <span class="text-danger">*</span></label>
                                <input type="text" id="second_btn_text" name="second_btn_text" value="{{ !empty($edit) ? $edit->second_btn_text : '' }}" class="form-control" placeholder="Enter button text" >
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="second_btn_link" class=" form-control-label">Second button link <span class="text-danger">*</span></label>
                                <input type="text" id="second_btn_link" name="second_btn_link" value="{{ !empty($edit) ? $edit->second_btn_link : '' }}" class="form-control" placeholder="Enter button link">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="details" class="form-control-label">Description<span
                                class="text-danger"> *</span></label>
                        <textarea name="details" cols="5" rows="5" id="details" class="form-control">  {{ !empty($edit) ? $edit->details : '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="photo" class=" form-control-label">Upload Photo<span class="text-danger">*</span></label>
                        <input type="file" name="photo"   id="photo" class="form-control" />
                        @if($errors->has('photo'))
                        <div class="text-danger">{{ $errors->first('photo') }}</div>
                        @endif
                        @if(!empty($edit))
                            <img class="pt-2" src="{{ asset('storage'. $edit->image) }}" alt="top header image" width="100">
                        @endif

                    </div>
                    <br>
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

