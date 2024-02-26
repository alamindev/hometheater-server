@extends('website-home.index')

@section('title')
   Edit Clients and Affiliations
@endsection

@section('website-home')
<div class="content">
    <form action="{{ route('website.home.affiliation.update', $edit->id) }}" method="post"  enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h3> Edit Clients and Affiliations</h3>
                 <a href="{{ route('website.home.affiliation') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
                </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="link" class=" form-control-label">Website link<span class="text-danger">(optional)</span></label>
                            <input type="text" id="link" name="link" value="{{  $edit->link }}" class="form-control"
                                placeholder="Enter website link">
                        </div>
                        <div class="form-group">
                            <label for="photo" class=" form-control-label">Upload Photo<span class="text-danger">*</span></label>
                            <input type="file" name="photo" id="photo" class="form-control" />
                            <img src="{{ asset('storage'. $edit->image) }}" width="150" class="mt-2" alt="gallery-photo">
                            @if($errors->has('photo'))
                            <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @endif
                        </div>
                         <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
