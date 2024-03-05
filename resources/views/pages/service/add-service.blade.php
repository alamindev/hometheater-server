@extends('layouts.app')

@section('title')
Add new Service
@endsection

@section('style')
<link href="{{ asset('assets/css/lib/chosen/chosen.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="content">
    <form action="{{ route('services.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
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
                            <input type="text" required id="title" name="title" value="{{ old('title') }}"
                                class="form-control" placeholder="Enter service title">
                            @if($errors->has('title'))
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="slug" class=" form-control-label">Slug <span>(Optional)</span> <span class="text-danger">  (slug should
                                    small letter and no space example:- indoor-outdoor-speaker-installation-single )
                                </span></label>
                            <input type="text" required id="slug" name="slug" value="{{ old('slug') }}"
                                class="form-control" placeholder="Enter service slug">
                            @if($errors->has('slug'))
                            <div class="text-danger">{{ $errors->first('slug') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="service_type" class=" form-control-label">Service Type <span
                                    class="text-danger">*</span></label>
                            <input type="text" required id="service_type" minlength="6" maxlength="7"
                                name="service_type" value="{{ old('service_type') }}" class="form-control"
                                placeholder="Example:- TV1001">
                            @if($errors->has('service_type'))
                            <div class="text-danger">{{ $errors->first('service_type') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="duration" class=" form-control-label">Duration <span
                                    class="text-danger">*</span></label>
                            <select name="duration" id="duration" required class="form-control">
                                <option value="1">1 Hour</option>
                                <option value="2">2 Hours</option>
                                <option value="3">3 Hours</option>
                                <option value="4">4 Hours</option>
                                <option value="5">5 Hours</option>
                                <option value="6">6 Hours</option>
                                <option value="7">7 Hours</option>
                                <option value="8">8 Hours - 1 day </option>
                            </select>
                            @if($errors->has('duration'))
                            <div class="text-danger">{{ $errors->first('duration') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="basic_price" class="form-control-label">Basic price <span
                                    class="text-danger">*</span></label>
                            <input type="number" min="0" step="0.01" required id="basic_price" name="basic_price"
                                value="{{ old('basic_price') }}" class="form-control">
                            @if($errors->has('basic_price'))
                            <div class="text-danger">{{ $errors->first('basic_price') }}</div>
                            @endif
                        </div>
                         {{-- <div class="form-group" >
                            <label for="icon" class="form-control-label">Service Icon Type</label>
                            <select required name="type" id="type" class="form-control">
                                <option value="0">Icon</option>
                                <option value="1">Svg</option>
                            </select>
                        </div> --}}
                        <div class="form-group"  id="fonticon">
                            <label for="icon" class="form-control-label">Icon  <span
                                    class="text-danger">(fontawesome icon class name)</span></label>
                            <input type="text" id="icon" name="icon" value="{{ old('icon') }}" class="form-control">
                        </div>
                     {{--   <div class="form-group" id='svg'>
                            <label for="svg" class="form-control-label">Svg </label>
                            <textarea name="svg" cols="5" rows="5" id="svg"
                                class="form-control">  {{ old('svg') }}</textarea>
                        </div> --}}
                        <div class="form-group">
                            <label for="category" class=" form-control-label">Select Category <span
                                    class="text-danger">*</span></label>
                            <select required data-placeholder="Choose Category" name="category_id" id="category"
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
                                @foreach (App\Models\Service::orderBy('created_at','desc')->where('type', 0)->get() as $service)
                                <option value="{{ $service->id }}">{{ $service->title }}</option>
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
                            <textarea name="details" id="details" class="form-control">{{old('details')}}</textarea>
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
                                    <div class="list-group-item d-flex align-items-center  list--group-main">
                                        <div class="pr-2" style="flex: 1">
                                            <div class="py-1">
                                                <div class="d-flex">
                                                    <input type="text" required name="question_title[][title]"
                                                        placeholder="Question title" class="form-control">
                                                    <button type="button"
                                                        class="btn btn-sm btn-success ml-2 add_question_option"><i
                                                            class="fa fa-plus"></i></button>
                                                </div>
                                                <div class="list-group list-group-sub" data-main-id="0">
                                                    <div class="list-group-item d-flex align-items-center mt-2">
                                                        <div class="pr-2" style="flex: 1">
                                                            <div class="py-1">
                                                                <input type="text" required
                                                                    name="question_title[0][0][option]"
                                                                    placeholder="Write option" class="form-control">
                                                                <input type="number" required
                                                                    name="question_title[0][0][price]"
                                                                    placeholder="Price" class="form-control mt-1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="question__trash bg-danger text-white p-2"><i
                                                class="fa fa-trash"></i></div>
                                    </div>
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
