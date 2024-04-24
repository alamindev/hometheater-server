@extends('layouts.app')
@section('title')
Setting
@endsection
@section('content')
<form action="{{ route('setting.update') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
<div class="content">
   <div class="card">
    <div class="card-header">
        Update Setting
    </div>
        <div class="card-body card-block">
                @csrf
                <input type="hidden" name="id" value="{{ $setting ? $setting->id : '' }}"/>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="site_logo" class=" form-control-label">Google Analytics</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="analytics_id" name="analytics_id" class="form-control" value="{{ $setting ? $setting->analytics_id : old('analytics_id') }}" >
                        @if($errors->has('analytics_id'))
                            <div class="text-danger">{{ $errors->first('analytics_id') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="site_logo" class=" form-control-label">Google Tag Manager</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="tag_manager" name="tag_manager" class="form-control" value="{{ $setting ? $setting->tag_manager : old('tag_manager') }}" >
                        @if($errors->has('tag_manager'))
                            <div class="text-danger">{{ $errors->first('tag_manager') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="site_logo" class=" form-control-label">Header Logo title</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="site_title" name="site_title" class="form-control" value="{{ $setting ? $setting->site_title : old('site_title') }}" >
                        @if($errors->has('site_title'))
                            <div class="text-danger">{{ $errors->first('site_title') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="site_logo" class=" form-control-label">Header Logo </label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="file" id="site_logo" name="site_logo" class="form-control-file">
                        @if($errors->has('site_logo'))
                                <div class="alert alert-danger">{{ $errors->first('site_logo') }}</div>
                            @endif
                            <div  class="py-2">
                        @if(!empty($setting) && $setting->site_logo != '')
                            <img src="{{ url('storage'.$setting->site_logo) }}" alt="site logo" width="100">
                        @endif
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="copyright" class="form-control-label">Copyright</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="copyright" value="{{ $setting ? $setting->copyright : old('copyright') }}"  name="copyright" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="Taxes" class="form-control-label">Taxes</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="Taxes" value="{{ $setting ? $setting->taxes : old('taxes') }}"  name="taxes" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Footer information
            </div>
            <div class="card-body card-block">
                <div class="form-group">
                    <label for="footer_logo" class="form-control-label">Footer logo</label>
                    <input type="file" id="footer_logo" name="footer_logo" class="form-control-file">
                    @if($errors->has('footer_logo'))
                    <div class="alert alert-danger">{{ $errors->first('footer_logo') }}</div>
                    @endif
                    <div class="py-2 px-5" style="background: black">
                        @if(!empty($setting) && $setting->footer_logo != '')
                        <img src="{{ url('storage'.$setting->footer_logo) }}" alt="footer_logo" width="100">
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="footer_details" class="form-control-label">Description</label>
                    <textarea name="footer_details" cols="5" rows="5" id="footer_details"
                        class="form-control">  {{ !empty($setting) ? $setting->footer_details : old('footer_details') }}</textarea>
                </div>
            <div class="form-group">
                <label for="facebook" class=" form-control-label">Facebook link</label>
                <input type="text" id="facebook" name="facebook" class="form-control" value="{{ !empty($setting) ? $setting->facebook : old('facebook') }}"
                    placeholder="Enter facebook link">
            </div>
            <div class="form-group">
                <label for="instagram" class=" form-control-label">Instagram link</label>
                <input type="text" id="instagram" name="instagram" class="form-control" value="{{ !empty($setting) ? $setting->instagram : old('instagram') }}"
                    placeholder="Enter instagram link">
            </div>
            <div class="form-group">
                <label for="twitter" class=" form-control-label">Twitter link</label>
                <input type="text" id="twitter" name="twitter" class="form-control" value="{{ !empty($setting) ? $setting->twitter : old('twitter') }}"
                    placeholder="Enter twitter link">
            </div>
            <div class="form-group">
                <label for="contact_email" class=" form-control-label">Contact Email Address</label>
                <input type="text" id="contact_email" name="contact_email" class="form-control" value="{{ !empty($setting) ? $setting->contact_email  : old('contact_email') }}"
                    placeholder="Enter contact email address link">
            </div>
            <div class="form-group">
                <label for="contact_number" class=" form-control-label">Contact numer </label>
                <input type="text" id="contact_number" name="contact_number" class="form-control" value="{{ !empty($setting) ? $setting->contact_number  : old('contact_number') }}"
                    placeholder="Enter contact number">
            </div>
                <br>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-info">Update</button>
            </div>
        </div>
    </div>
</form>
@endsection
