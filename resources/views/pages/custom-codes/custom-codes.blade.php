@extends('layouts.app')
@section('title')
Custom css and js code
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('custom.css.store') }}" method="post" enctype="multipart/form-data"
                class="form-horizontal">
                @csrf
                <div class="card">
                    <div class="card-header">
                        Write custom css
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <textarea name="css" cols="5" rows="15" id="css"
                                class="form-control">  {{ !empty($css) ? $css : '' }}</textarea>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
            </form>
        </div>
        {{-- <div class="col-lg-6">
            <form action="{{ route('custom.js.store') }}" method="post" enctype="multipart/form-data"
                class="form-horizontal">
                @csrf
                <div class="card">
                    <div class="card-header">
                        Write custom js
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <textarea name="js" cols="5" rows="15" id="css"
                                class="form-control">  {{ !empty($js) ? $js : '' }}</textarea>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
            </form>
        </div> --}}
    </div>
</div>

@endsection
