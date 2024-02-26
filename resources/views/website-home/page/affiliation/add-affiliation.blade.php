@extends('website-home.index')

@section('title')
   Add new Clients and affiliations
@endsection

@section('website-home')
<div class="content">
    <form action="{{ route('website.home.affiliation.store') }}" method="post"  enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                   <div class="card-header d-flex justify-content-between align-items-center">
                        <h3> List of clients and affiliation</h3>

                        <a href="{{ route('website.home.affiliation') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="link" class=" form-control-label">Website link<span class="text-danger">(optional)</span></label>
                            <input type="text" id="link" name="link" value="{{ old('link') }}"
                                class="form-control" placeholder="Enter website link">
                        </div>
                        <div class="form-group">
                            <label for="photo" class=" form-control-label">Upload Photo<span class="text-danger">*</span></label>
                           <input  type="file" name="photo" required id="photo" class="form-control" />
                            @if($errors->has('photo'))
                                <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @endif
                        </div>
                        <br>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('script')
