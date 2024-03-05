@extends('layouts.app')

@section('title')
Edit Product
@endsection

@section('style')
<link href="{{ asset('assets/css/lib/chosen/chosen.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="content">
    <form action="{{ route('product.update', $edit->id) }}" method="post" enctype="multipart/form-data"
        class="form-horizontal">
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
                            <input type="text" required id="title" name="title" value="{{ $edit->title }}"
                                class="form-control" placeholder="Enter service title">
                            @if($errors->has('title'))
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="slug" class=" form-control-label">Slug <span>(Optional)</span>  </label>
                            <input type="text" required id="slug" name="slug" value="{{ $edit->slug }}"
                                class="form-control" placeholder="Enter service slug">
                            @if($errors->has('slug'))
                            <div class="text-danger">{{ $errors->first('slug') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="service_type" class="form-control-label">Model <span
                                    class="text-danger">*</span></label>
                            <input type="text" required id="service_type" name="service_type"
                                value="{{ $edit->service_type }}" class="form-control" placeholder="Example:- TV1001">
                            @if($errors->has('service_type'))
                            <div class="text-danger">{{ $errors->first('service_type') }}</div>
                            @endif
                        </div> 
                        <div class="form-group">
                            <label for="basic_price" class="form-control-label">Regular price <span
                                    class="text-danger">*</span></label>
                            <input type="number" min="0" step="0.01" required id="basic_price" name="basic_price"
                                value="{{ $edit->basic_price }}" class="form-control">
                            @if($errors->has('basic_price'))
                            <div class="text-danger">{{ $errors->first('basic_price') }}</div>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="discount_price" class="form-control-label">Price Discount  <span
                                    class="text-danger">(optional) </span></label>
                            <input type="number" min="0" step="0.01"   id="discount_price" name="discount_price"
                            value="{{ $edit->discount_price }}" class="form-control">
                            @if($errors->has('discount_price'))
                            <div class="text-danger">{{ $errors->first('discount_price') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="quantity" class="form-control-label">Quantity<span
                                    class="text-danger">*</span></label>
                            <input type="number" required id="quantity" name="quantity"
                            value="{{ $edit->quantity }}" class="form-control">
                            @if($errors->has('quantity'))
                            <div class="text-danger">{{ $errors->first('quantity') }}</div>
                            @endif
                        </div>
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
                        <div class="form-group pb-3">
                            <div class="d-flex justify-content-between pb-2">
                                <label for="image" class=" form-control-label">Colors<span
                                        class="text-danger">(optional)</span></label>
                                <button type="button" class="btn btn-sm btn-info add-new-color"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            <div class="color">
                                @php
                                $colors = explode('||#||', $edit->color);
                                array_pop($colors); 
                                @endphp
                                <div class="list-group">
                                    @foreach($colors as $data)
                                    <div class="list-group-item d-flex align-items-center">
                                        @php
                                        $color = explode('||*||', $data);  
                                        @endphp
                                        <div class="d-flex w-100">
                                            <div class="px-1 w-50">
                                                <input type="text" name="color_name[]" value="{{ array_key_exists(0, $color) ? $color[0] : '' }}" placeholder="Color Name" class="form-control">
                                            </div>
                                            <div class="px-1 w-50">
                                                <input type="text" name="color_code[]" value="{{  array_key_exists(1, $color) ? $color[1] : ''}}" placeholder="Color Code" class="form-control">
                                            </div>
                                        </div>
                                        <div class="color__trash bg-danger text-white p-2 flex-shrink-0">
                                            <i class="fa fa-trash"></i>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="conditions" class="form-control-label">Condition<span
                                    class="text-danger">*</span></label>
                           <select name="conditions" id="conditions" required class="form-control">
                            <option value="new" @if($edit->conditions === 'new') selected
                                @endif>New</option>
                            <option value="used" @if($edit->conditions === 'used') selected
                                @endif>Used</option>
                            <option value="out of box" @if($edit->conditions === 'out of box') selected
                                @endif>Out of Box</option>
                            <option value="refurbished" @if($edit->conditions === 'refurbished') selected
                                @endif>Refurbished</option> 
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
                    <div class="card-body">
                        <div class="form-group">
                            <label for="delivery_time" class="form-control-label">Delivery Date<span
                                    class="text-danger">*</span></label>
                           <select name="delivery_time" id="delivery_time" required class="form-control">
                            <option value="1" @if($edit->delivery_time === 1) selected
                                @endif>01 Days</option>
                            <option value="2" @if($edit->delivery_time === 2) selected
                                @endif>02 Days</option>
                            <option value="3" @if($edit->delivery_time === 3) selected
                                @endif>03 Days</option>
                            <option value="4" @if($edit->delivery_time === 4) selected
                                @endif> 04 Days</option>
                            <option value="5" @if($edit->delivery_time === 5) selected
                                @endif>05 Days</option>
                            <option value="6" @if($edit->delivery_time === 6) selected
                                @endif>06 Days</option>
                            <option value="7" @if($edit->delivery_time === 7) selected
                                @endif>07 Days</option>
                            <option value="8" @if($edit->delivery_time === 8) selected
                                @endif>08 Days</option>
                            <option value="9"@if($edit->delivery_time === 9) selected
                                @endif>09 Days</option>
                            <option value="10"@if($edit->delivery_time === 10) selected
                                @endif>10 Days</option>
                           </select>
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
                                $edit->id)->where('type', 1)->orderBy('created_at','desc')->get() as $service)
                                <option @if(in_array($service->id, $suggestion_id)) selected @endif value="{{
                                    $service->id }}">{{ $service->title }}</option>
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
