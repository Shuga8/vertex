@extends('layouts.app')
@section('panel')
    @include('frontend.partials.header')
    @yield('content')
    @include('frontend.partials.footer')
@endsection
