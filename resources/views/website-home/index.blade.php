@extends('layouts.app')

@section('title')
website home
@endsection

@section('style')

@endsection
@section('content')
<div class="content">
     @include('website-home.partials.header')
    @yield('website-home')
</div>
@endsection
@push('script')

@endpush
