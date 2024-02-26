@extends('website-home.index')


@section('website-home')
<form action="{{ route('website.home.serviceheader.store') }}" method="post" enctype="multipart/form-data"
    class="form-horizontal">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Home service header
                </div>
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="home_title" class=" form-control-label">Title <span class="text-danger">*</span></label>
                        <input type="text" id="home_title" name="home_title" class="form-control"
                            value="{{ !empty($edit) ? $edit->home_title : '' }}" placeholder="Enter title">
                        @if(!empty($edit))
                        <input type="hidden" id="id" name="id" class="form-control" value="{{$edit->id}}">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="home_details" class="form-control-label">Description<span class="text-danger">
                                *</span></label>
                        <textarea name="home_details" id="home_details"
                            class="form-control">  {{ !empty($edit) ? $edit->home_details : '' }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                   Services page header
                </div>
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="service_title" class=" form-control-label">Title <span class="text-danger">*</span></label>
                        <input type="text" id="service_title" name="service_title" class="form-control"
                            value="{{ !empty($edit) ? $edit->service_title : '' }}" placeholder="Enter title">
                        @if(!empty($edit))
                        <input type="hidden" id="id" name="id" class="form-control" value="{{$edit->id}}">
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="service_btn_text" class=" form-control-label">Button text <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="service_btn_text" name="service_btn_text"
                                    value="{{ !empty($edit) ? $edit->service_btn_text : '' }}" class="form-control"
                                    placeholder="Enter button text">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="service_btn_link" class=" form-control-label">Button link <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="service_btn_link" name="service_btn_link"
                                    value="{{ !empty($edit) ? $edit->service_btn_link : '' }}" class="form-control"
                                    placeholder="Enter button link">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="service_details" class="form-control-label">Description<span class="text-danger">
                                *</span></label>
                        <textarea cols="5" rows="5" name="service_details" id="service_details"
                            class="form-control">  {{ !empty($edit) ? $edit->service_details : '' }}</textarea>
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
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
           Booking header
        </div>
        <div class="card-body card-block">
            <div class="form-group">
                <label for="booking_title" class=" form-control-label">Title <span class="text-danger">*</span></label>
                <input type="text" id="booking_title" name="booking_title" class="form-control"
                    value="{{ !empty($edit) ? $edit->booking_title : '' }}" placeholder="Enter title">
            </div>
            <div class="form-group">
                <label for="booking_details" class="form-control-label">Description<span class="text-danger">
                        *</span></label>
                <textarea name="booking_details" id="booking_details"
                    class="form-control">  {{ !empty($edit) ? $edit->booking_details : '' }}</textarea>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <button type="submit" class="btn btn-info">Update</button>
        </div>
    </div>
</form>
@endsection
