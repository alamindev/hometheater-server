@extends('layouts.app')

@section('title')
Edit Service
@endsection

@section('style')
<link href="{{ asset('assets/css/lib/chosen/chosen.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="content">
    <form action="{{ route('service.update', $edit->id) }}" method="post" enctype="multipart/form-data"
        class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        Service
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="title" class=" form-control-label">Title <span
                                    class="text-danger">*</span></label>
                            <input type="text" required id="title" name="title" value="{{ $edit->title }}"
                                class="form-control" placeholder="Enter service title">
                            @if($errors->has('title'))
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="slug" class=" form-control-label">Slug <span class="text-danger">* (slug should
                                    small letter and no space example:- indoor-outdoor-speaker-installation-single )
                                </span></label>
                            <input type="text" required id="slug" name="slug" value="{{ $edit->slug }}"
                                class="form-control" placeholder="Enter service slug">
                            @if($errors->has('slug'))
                            <div class="text-danger">{{ $errors->first('slug') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="service_type" class="form-control-label">Service Type <span
                                    class="text-danger">*</span></label>
                            <input type="text" required id="service_type" name="service_type"
                                value="{{ $edit->service_type }}" class="form-control" placeholder="Example:- TV1001">
                            @if($errors->has('service_type'))
                            <div class="text-danger">{{ $errors->first('service_type') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="duration" class=" form-control-label">Duration <span
                                    class="text-danger">*</span></label>
                            <select name="duration" id="duration" required class="form-control">
                                <option value="1" @if($edit->duration === 1) selected @endif>1 Hour</option>
                                <option value="2" @if($edit->duration === 2) selected @endif>2 Hours</option>
                                <option value="3" @if($edit->duration === 3) selected @endif>3 Hours</option>
                                <option value="4" @if($edit->duration === 4) selected @endif>4 Hours</option>
                                <option value="5" @if($edit->duration === 5) selected @endif>5 Hours</option>
                                <option value="6" @if($edit->duration === 6) selected @endif>6 Hours</option>
                                <option value="7" @if($edit->duration === 7) selected @endif>7 Hours</option>
                                <option value="8" @if($edit->duration === 8) selected @endif>8 Hours - 1 day </option>
                            </select>
                            @if($errors->has('duration'))
                            <div class="text-danger">{{ $errors->first('duration') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="basic_price" class="form-control-label">Basic price <span
                                    class="text-danger">*</span></label>
                            <input type="number" required id="basic_price" name="basic_price"
                                value="{{ $edit->basic_price }}" class="form-control">
                            @if($errors->has('basic_price'))
                            <div class="text-danger">{{ $errors->first('basic_price') }}</div>
                            @endif
                        </div>

                        {{-- <div class="form-group" >
                            <label for="icon" class="form-control-label">Service Icon Type</label>
                            <select required name="type" id="type" class="form-control">
                                <option value="0" @if($edit->type===0) selected @endif>Icon</option>
                                <option value="1" @if($edit->type===1) selected @endif>Svg</option>
                            </select>
                        </div>--}}
                       <div class="form-group" id="fonticon">
                            <label for="icon" class="form-control-label">  Icon <span class="text-danger">(fontawesome icon class
                                    name)</span></label>
                            <input type="text" id="icon" name="icon" value="{{ $edit->icon }}" class="form-control">
                        </div>
                     {{--   <div class="form-group" id='svg'>
                            <label for="svg" class="form-control-label">Svg </label>
                            <textarea name="svg" cols="5" rows="5" id="svg" class="form-control">  {{ old('svg') }}</textarea>
                      {{--    </div> --}}
                        <div class="form-group">
                            <label for="category" class=" form-control-label">Select Category <span
                                    class="text-danger">*</span></label>
                            <select required data-placeholder="Choose Category" name="category_id" id="category"
                                class="form-control">
                                <option label="default"></option>
                                @foreach (App\Models\ServiceCategory::orderBy('created_at','desc')->get() as $cate)
                                <option value="{{ $cate->id }}" @if($cate->id == $edit->category_id) selected
                                    @endif>{{ $cate->cate_name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category_id'))
                            <div class="text-danger">{{ $errors->first('category_id') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                                <label for="thumbnail" class="form-control-label">Upload Thumbnail<span class="text-danger">*</span></label>
                                <input type="file"  id="thumbnail" name="thumbnail" value="{{ old('thumbnail') }}" class="form-control">
                                @if($errors->has('thumbnail'))
                                <div class="text-danger">{{ $errors->first('thumbnail') }}</div>
                                @endif
                                <img class="pt-2 " width="100" src="{{ asset('storage'. $edit->thumbnail )}}" alt="service-thumbnail">
                            </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between pb-2">
                                <label for="image" class=" form-control-label">Upload photo<span
                                        class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-info update-new-photo"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            <div class="photos">
                                <div class="list-group list-group-img">
                                    @foreach($edit->serviceImage as $key => $image)
                                    <div class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <input type="file" name="image[{{$key}}][img]" data-key="{{$key}}"
                                                data-id="{{$image->id}}" id="image"
                                                class="form-control mr-1 select_img" />
                                            <input type="hidden" name="update_img[]" value="" />
                                            <input type="hidden" name="image[{{$key}}][id]" value="{{$image->id}}" />
                                            <div class="photo__trash bg-danger text-white p-2"><i
                                                    class="fa fa-trash"></i></div>
                                        </div>
                                        <img class="pt-2 " width="100" src="{{ asset('storage'. $image->image )}}"
                                            alt="service-image">
                                    </div>
                                    @endforeach
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
                                @php
                                $features = explode('||#||', $edit->datas);
                                array_pop($features);
                                @endphp
                                <div class="list-group">
                                    @foreach($features as $data)
                                    <div class="list-group-item d-flex align-items-center">
                                        <div class="px-1 w-100"><input type="text" name="feature[]"
                                                placeholder="Feature details" value="{{  $data }}" class="form-control">
                                        </div>
                                        <div class="feature__trash bg-danger text-white p-2"><i class="fa fa-trash"></i>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="seo_details" class="form-control-label">Seo Description </label>
                            <textarea name="seo_details" cols="5" rows="5" id="seo_details"
                                class="form-control"> {{ !empty($edit) ? $edit->seo_details : '' }}								</textarea>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class=" form-control-label">Keyword <span class="text-danger">(keyword
                                    by comma)</span></label>
                            <textarea name="keyword" cols="5" rows="5" id="keyword" class="form-control"
                                placeholder="Enter keyword by comma"> {{ !empty($edit) ? $edit->keyword : '' }}</textarea>
                        </div>
                        <div class="form-group">
                            @php
                            $suggestion_id = explode(',', $edit->suggestion);
                            @endphp
                            <label for="keyword" class=" form-control-label">Suggestion</label>
                            <select data-placeholder="Suggestion" multiple name="suggestion[]" id="suggestion"
                                class="form-control">
                                <option label="default"></option>
                                @foreach (App\Models\Service::where('id','!=',
                                $edit->id)->where('type', 0)->orderBy('created_at','desc')->get() as $service)
                                <option @if(in_array($service->id, $suggestion_id)) selected @endif value="{{
                                    $service->id }}">{{ $service->title }}</option>
                                @endforeach
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
                            <textarea name="details" id="details" class="form-control">{{$edit->details}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Service Questions
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group pb-3">
                            <div class="d-flex justify-content-between pb-2">
                                <label for="image" class=" form-control-label">Service Questions <span
                                        class="text-danger">(optional)</span></label>
                                <button type="button" class="btn btn-sm btn-success add-new-question"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            <div class="service-question">
                                <div class="list-group list-group-main">
                                    @foreach ($edit->serviceQuestion as $key=> $question)
                                    <div class="list-group-item d-flex align-items-center  list--group-main">
                                        <div class="pr-2" style="flex: 1">
                                            <div class="py-1 option_id_put">
                                                <div class="d-flex">
                                                    <input type="text" required name="question_title[][title]"
                                                        placeholder="Question title" class="form-control"
                                                        value="{{ $question->name }}">
                                                    <input type="hidden" name="question_id[]" value="{{$question->id}}">
                                                    <button type="button"
                                                        class="btn btn-sm btn-success ml-2 add_question_option"><i
                                                            class="fa fa-plus"></i></button>
                                                </div>
                                                <div class="list-group list-group-sub" data-main-id="{{ $key }}">
                                                    @foreach ($question->question_option as $k=>$option)
                                                    <div class="list-group-item d-flex align-items-center mt-2">
                                                        <div class="pr-2" style="flex: 1">
                                                            <div class="py-1">
                                                                <input type="text" required
                                                                    name="question_title[{{$key}}][{{$k}}][option]"
                                                                    placeholder="Write option" class="form-control"
                                                                    value="{{ $option->title }}">
                                                                <input type="text" required
                                                                    name="question_title[{{$key}}][{{$k}}][price]"
                                                                    placeholder="Price" class="form-control mt-1"
                                                                    value="{{ $option->price }}">
                                                                <input type="hidden" class="question_option_id"
                                                                    name="question_title[{{$key}}][{{$k}}][option_id]"
                                                                    value="{{ $option->id }}">
                                                            </div>
                                                        </div>
                                                        <div class="question_option__trash bg-danger text-white p-2"><i
                                                                class="fa fa-trash"></i></div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="question__trash bg-danger text-white p-2"><i
                                                class="fa fa-trash"></i>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
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
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script src="{{ asset('assets/js/lib/chosen/chosen.jquery.min.js') }}"></script>
<script>
    CKEDITOR.replace( 'details' );
    jQuery("#category").chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
    });
   jQuery("#suggestion").chosen();
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
