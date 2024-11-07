@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="" style="max-width: 300px;margin-bottom: 30px;">
            <form class="d-flex flex-wrap gap-2 justify-content-end" action="" method="GET">

                <div class="input-group flex-fill w-auto">
                    <input class="form-control bg--white" name="email" type="search" value="{{ request('email') }}"
                        placeholder="email">
                    <button class="btn btn--primary" type="submit"><i class="la la-search"></i></button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('Initiated At') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Open Amout') }}</th>
                            <th>{{ __('Current/Closed Amount') }}</th>
                            <th>{{ __('Price Is') }}</th>
                            <th>{{ __('Price Was') }}</th>
                            <th>{{ __('Direction') }}</th>
                            <th>{{ __('Ticker') }}</th>
                            <th>{{ __('Take Profit') }}</th>
                            <th>{{ __('Stop Loss') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($tradeLogs as $tradeLog)
                            <tr>
                                <td data-label="Initiated At">
                                    {{ showDateTime($tradeLog->created_at) }}
                                </td>
                                <td data-label="{{ __('User') }}">
                                    {{ $tradeLog->user->email }}
                                </td>
                                <td data-label="{{ __('Open Amount') }}">
                                    {{ getCurrencySymbol() }}{{ number_format($tradeLog->open_amount, 4, '.', ',') }}
                                </td>
                                <td data-label="{{ __('Current Amount') }}">
                                    {{ getCurrencySymbol() }}{{ number_format($tradeLog->amount, 4, '.', ',') }}
                                </td>
                                <td data-label="{{ __('Price Is') }}">
                                    {{ getCurrencySymbol() }}{{ number_format($tradeLog->price_is, 4, '.', ',') }}
                                </td>
                                <td data-label="{{ __('Price Was') }}">
                                    {{ getCurrencySymbol() }}{{ number_format($tradeLog->price_was, 4, '.', ',') }}
                                </td>
                                <td data-label="{{ __('Direction') }}">
                                    <span
                                        class="badge {{ $tradeLog->trade_type == 'sell' ? 'badge--danger' : 'badge--success' }}">{{ strtoupper($tradeLog->trade_type) }}</span>
                                </td>
                                <td data-label="{{ __('Ticker') }}">

                                    @php
                                        if ($tradeLog->isCommodity == true) {
                                            $ticker = $tradeLog->commodity;
                                        } elseif ($tradeLog->isForex == true) {
                                            $ticker = $tradeLog->forex;
                                        } elseif ($tradeLog->isStock == true) {
                                            $ticker = $tradeLog->stock;
                                        }
                                    @endphp

                                    {{ $ticker }}
                                </td>
                                <td data-label="{{ __('Take Profit') }}">
                                    <span class="badge badge--success">
                                        {{ getCurrencySymbol() }}{{ number_format($tradeLog->take_profit, 4, '.', ',') }}
                                    </span>
                                </td>
                                <td data-label="{{ __('Stop Loss') }}">
                                    <span class="badge badge--danger">
                                        {{ getCurrencySymbol() }}{{ number_format($tradeLog->stop_loss, 4, '.', ',') }}
                                    </span>
                                </td>


                                <td data-label="{{ __('Status') }}">
                                    <span
                                        class="badge {{ $tradeLog->status == false ? 'badge--danger' : 'badge--success' }}">
                                        {{ $tradeLog->status == false ? 'running' : 'completed' }}
                                    </span>
                                </td>

                                <td data-label="{{ __('Action') }}">
                                    <button class="editBtn btn btn--sm btn--primary capsuled"
                                        data-binary="{{ json_encode($tradeLog) }}">
                                        Edit
                                    </button>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td class="text-white text-center" colspan="100%">{{ __('No Data Found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($tradeLogs->hasPages())
                <div class="mt-4">{{ $tradeLogs->links() }}</div>
            @endif
        </div>
    </section>

    <div class="modal fade" id="binaryModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Binary Trade')</h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Type')</label>
                            <input class="form-control" name="type" type="text" step="any" disabled>
                        </div>

                        <div class="form-group">
                            <label>@lang('Symbol')</label>
                            <input class="form-control" name="symbol" type="text" step="any" disabled>
                        </div>

                        <div class="form-group">
                            <label>@lang('Open amount')</label>
                            <input class="form-control" name="open_amount" type="number" step="any" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('Stop Loss')</label>
                            <input class="form-control" name="stop_loss" type="number" step="any" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Take Profit')</label>
                            <input class="form-control" name="take_profit" type="number" step="any" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('Current Amount')</label>
                            <input class="form-control" name="amount" type="number" step="any" required>
                        </div>


                        <div class="form-group open_at_field" hidden>
                            <label>@lang('Open Trade When Rate Is')</label>
                            <input class="form-control" name="open_at" type="number" step="any">
                        </div>

                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        "use strict";


        let modal = $('#binaryModal');

        $('.editBtn').on('click', function(e) {
            let action = `{{ route('admin.user.binary.edit', ':id') }}`;
            let data = JSON.parse(this.getAttribute("data-binary"));

            if (data.isForex == true) {
                modal.find("input[name=type]").val("Foreign Currency")
                modal.find("input[name=symbol]").val(data.forex)
            } else if (data.isStock == true) {
                modal.find("input[name=type]").val("Stock Ticker")
                modal.find("input[name=symbol]").val(data.stock)
            } else if (data.isCommodity == true) {
                modal.find("input[name=type]").val("Commodity Ticker")
                modal.find("input[name=symbol]").val(data.commodity)
            }
            modal.find('form').prop('action', action.replace(':id', data.id))
            modal.find("input[name=stop_loss]").val(data.stop_loss)
            modal.find("input[name=take_profit]").val(data.take_profit)
            modal.find("input[name=amount]").val(data.amount)
            modal.find("input[name=open_amount]").val(data.open_amount)
            $(modal).modal('show');
        })
    </script>
@endsection
