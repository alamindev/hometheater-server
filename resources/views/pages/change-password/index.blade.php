@extends('layouts.app')

@section('title')
 change password
@endsection
@section('content')
<div class="content">
    <form action="{{ route('customcodes.store') }}" method="post" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                       Change password
                    </div>
                    <div class="card-body card-block">
                        @if(Session::has('success'))
                        <p class="alert alert-info">{{ Session::get('success') }}</p>
                        @endif
                        <div class="form-group">
                            <label for="name" class=" form-control-label">Current Password <span class="text-danger">*</span></label>
                            <input type="password" required id="name" name="current_password" value="{{old('current_password')}}" class="form-control" placeholder="Enter current password" >
                            @if($errors->has('current_password'))
                                <div class="text-danger">{{ $errors->first('current_password') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name" class=" form-control-label">New Password <span class="text-danger">*</span></label>
                            <input type="password" required id="name" name="password" value="{{old('password')}}" class="form-control" placeholder="Enter  new password" minlength="8">
                            @if($errors->has('password'))
                                <div class="text-danger">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name" class=" form-control-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" required id="name" name="password_confirmation"  class="form-control" placeholder="Enter confirm password" minlength="8">
                        </div>

                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

