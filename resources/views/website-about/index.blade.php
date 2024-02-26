@extends('layouts.app')

@section('title')
website about
@endsection

@section('style')

@endsection
@section('content')
<div class="content">
     @include('website-about.partials.header')
    @yield('website-about')
</div>
@endsection
@push('script')

@endpush
