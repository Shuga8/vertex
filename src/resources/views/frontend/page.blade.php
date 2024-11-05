@extends('layouts.main')
@section('content')
    @include('frontend.partials.breadcrumb')
    @if(!is_null($page->section_key))
        @foreach($page->section_key as $section)
            @include('frontend.component.'.$section)
        @endforeach
    @endif
@endsection
