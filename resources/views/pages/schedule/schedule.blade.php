@extends('layouts.app')

@section('style')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="content">
    <Calendar />

</div>
@endsection

@push('script')
<script src="{{asset('js/app.js')}}"></script>
@endpush
