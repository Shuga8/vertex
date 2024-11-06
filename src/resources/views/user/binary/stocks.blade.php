@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>

                    <div class="table-container">
                        <table id="myTable" class="table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Pair') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stocks as $stock)
                                    <tr>
                                        <td data-label="{{ __('Pair') }}">
                                            <div
                                                class="name d-flex align-items-center justify-content-md-start justify-content-end gap-lg-3 gap-2">
                                                <div class="icon">
                                                    <img src="{{ asset('assets/icons/' . $stock->symbol . '.png') }}"
                                                        class="avatar--sm" alt="{{ __('Crypto-Image') }}">
                                                </div>
                                                <div class="content">
                                                    <h6 class="fs-14">{{ $stock->symbol }}/USDT</h6>
                                                    <span class="fs-13 text--light">{{ $stock->name }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td data-label="{{ __('Action') }}">
                                            <a href="{{ route('user.binary.trade', ['stock', $stock->symbol]) }}"
                                                class="i-btn btn--sm btn--primary capsuled">{{ __('Trade') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $stocks->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
