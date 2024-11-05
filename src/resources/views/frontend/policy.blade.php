@extends('layouts.main')
@section('content')
    @include('frontend.partials.breadcrumb')
    <section class="privacy-policy pt-110 pb-110">
        <div class="container">
            @php echo getArrayValue($content?->meta, 'descriptions') @endphp
        </div>
    </section>
@endsection
