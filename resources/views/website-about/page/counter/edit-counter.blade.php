@extends('website-about.index')

@section('title')
   Edit Review
@endsection

@section('website-about')
<div class="content">
    <form action="{{ route('website.about.counter.update', $edit->id) }}" method="post"  enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h3> Edit counter</h3>
                 <a href="{{ route('website.about.counter') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
                </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="counter" class=" form-control-label">Counter <span class="text-danger">*</span></label>
                            <input type="text" id="counter" name="counter" value="{{  $edit->title }}" class="form-control"
                                placeholder="Enter Counter">
                        </div>
                        <div class="form-group">
                            <label for="title" class=" form-control-label">Title<span class="text-danger">(Optional)</span></label>
                            <input type="text" id="title" name="title" value="{{  $edit->details }}" class="form-control"
                                placeholder="Enter title">
                        </div>

                        <br>
                         <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
