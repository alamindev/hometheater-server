@extends('layouts.app')
@section('title')
Photo view
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>View photo</h4>
                    <a href="{{ route('galleries') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i>
                        Back</a>
                </div>
                <div class="card-body card-block">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Photo title</td>
                                <td>:</td>
                                <td>{{ $view->title }}</td>
                            </tr>
                            <tr>
                                <td>Album</td>
                                <td>:</td>
                                <td>{{ $view->album->name }}</td>
                            </tr>
                            <tr>
                                <td>Photo</td>
                                <td>:</td>
                                <td><img src="{{ asset('storage'. $view->photo) }}" width="200" alt="service-image">
                                </td>
                            </tr>
                            <tr>
                                <td>Photo details</td>
                                <td>:</td>
                                <td>{!! $view->details !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
