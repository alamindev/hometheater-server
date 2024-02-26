@extends('layouts.app')

@section('title')
website Meta info
@endsection

@section('style')

@endsection
@section('content')
<div class="content">
     @include('website-meta-info.partials.header')
    @yield('website-meta')
</div>
@endsection
@push('script')

@endpush
