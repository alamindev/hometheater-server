@extends('layouts.app')
@section('title')
Edit Zipcode
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Edit Zip code</h4>
                    <a href="{{route('zipcode')}}" class="btn btn-success">Back</a>
                </div>
                <div class="card-body card-block">
                    <form action="{{ route('zipcode.update', $edit->id) }}" method="post" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label for="area_name" class=" form-control-label">Area Name <span
                                    class="text-danger">(optional)</span></label>
                            <input type="text" id="area_name" name="area_name" class="form-control"
                                placeholder="Area name" value="{{$edit->area_name}}">
                            @if($errors->has('area_name'))
                            <div class="text-danger">{{ $errors->first('area_name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="zipcode" class=" form-control-label">Zip code <span
                                    class="text-danger">*</span></label>
                            <input type="number" id="zipcode" value="{{$edit->zipcode}}" name="zipcode" class="form-control" placeholder="Zipcode">
                            @if($errors->has('zipcode'))
                            <div class="text-danger">{{ $errors->first('zipcode') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="amount" class=" form-control-label">Min amount for service <span
                                    class="text-danger">(*)</span></label>
                            <input type="number" id="amount" name="amount" class="form-control"
                                placeholder="Set amount" value="{{$edit->amount}}">
                            @if($errors->has('amount'))
                            <div class="text-danger">{{ $errors->first('amount') }}</div>
                            @endif
                        </div>
                        <div class="p-2">
                            <button type="submit" class="btn btn-success btn-sm">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
