@extends('layouts.auth')
@section('content')
    <main>
        @push('style-push')
            <style>
                .bot-trading {
                    margin: 15px auto 5px auto;
                    width: 100px;
                    height: 100px;
                    background: url("{{ asset('assets/icons/bot.png') }}") no-repeat center center/cover;
                    cursor: pointer;
                }
            </style>
        @endpush
        <div class="trading-section pt-5 pb-110">
            <div class="container i-container">
                <div class="row g-4">
                    <div class="col-xl-9">
                        <div class="market-graph">
                            <div class="mb-5">
                                <div class="tradingview-widget-container p-2">
                                    <div class="tradingview-widget-container__widget"></div>
                                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                                        {
                                            "autosize": true,
                                            "width": "100%",
                                            "height": "700",
                                            "symbol": "{{ $pair }}",
                                            "interval": "1",
                                            "timezone": "Etc/UTC",
                                            "theme": "light",
                                            "style": "1",
                                            "locale": "en",
                                            "enable_publishing": true,
                                            "hide_legend": true,
                                            "withdateranges": true,
                                            "hide_side_toolbar": false,
                                            "allow_symbol_change": true,
                                            "details": true,
                                            "hotlist": true,
                                            "calendar": false,
                                            "support_host": "https://www.tradingview.com"
                                        }
                                    </script>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                            <div class="card--title mb-0">
                                <h5 class="mb-0">{{ __('Rise/Fall') }}</h5>
                            </div>
                            <a href="{{ route('user.dashboard') }}" class="i-btn btn--primary btn--md capsuled"><i
                                    class="bi bi-chevron-left me-1"></i>{{ __('Dashboard') }}</a>
                        </div>

                        <div class="market-widget mb-4">
                            <form method="POST" action="{{ route('user.binary.trade' . ucfirst($type)) }}">
                                @csrf
                                <input type="hidden" name="type" value="{{ $type }}">
                                <input type="hidden" name="symbol" value="{{ $symbol }}">
                                <input type="hidden" name="rate" id="rate">

                                <div class="input-single">
                                    <label for="amount">{{ __('Amount') }}</label>
                                    <input type="text" id="amount" name="amount" value="{{ old('amount') }}"
                                        placeholder="0.00" required>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label for="stop_loss">{{ __('Stop Loss') }}</label>
                                        <input type="number" id="stop_loss" name="stop_loss"
                                            value="{{ old('stop_loss') }}" placeholder="0.00" required>
                                    </div>
                                    <div class="col">
                                        <label for="take_profit">{{ __('Take Profit') }}</label>
                                        <input type="number" id="take_profit" name="take_profit"
                                            value="{{ old('take_profit') }}" placeholder="0.00" required>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="bot-col col-sm-6 gap-4">
                                        <div class="bot-trading bot-trading-1">
                                        </div>
                                        <p class="text-center" style="font-size: 10px">BOT AMOUNT: $50</p>
                                    </div>

                                    <div class="bot-col col-sm-6">
                                        <div class="bot-trading bot-trading-2">
                                        </div>
                                        <p class="text-center" style="font-size: 10px">BOT AMOUNT: $100</p>
                                    </div>

                                </div>

                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <button class="i-btn btn--md btn--danger capsuled w-100"
                                        style="display: flex;flex-direction:row;column-gap:3px;place-items: baseline;">Sell<small
                                            class="small-loss" style="font-size: inherit;"></small></button>
                                    <button class="i-btn btn--md btn--success capsuled w-100"
                                        style="display: flex;flex-direction:row;column-gap:3px;place-items: baseline;">Buy<small
                                            class="small-profit" style="font-size: inherit;"></small></button>
                                </div>

                                <div class="row">

                                    <!-- TradingView Widget BEGIN -->
                                    <div class="tradingview-widget-container">
                                        <div class="tradingview-widget-container__widget"></div>
                                        <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/"
                                                rel="noopener nofollow" target="_blank"><span class="blue-text">Track all
                                                    markets on TradingView</span></a></div>
                                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-technical-analysis.js"
                                            async>
                                            {
                                                "interval": "1m",
                                                "width": "100%",
                                                "isTransparent": true,
                                                "height": "250",
                                                "symbol": "{{ $pair }}",
                                                "showIntervalTabs": true,
                                                "displayMode": "single",
                                                "locale": "en",
                                                "colorTheme": "dark"
                                            }
                                        </script>
                                    </div>
                                    <!-- TradingView Widget END -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('script-push')
        <script type="text/javascript">
            const fmp_api_key = "cARpiP1yH7faNhSWqnQLyGNV0mc7oTxl";
            let rate = 0;
            async function getRate(symbol) {
                const requestOptions = {
                    method: "GET",
                    redirect: "follow",
                };

                const response = await fetch(
                    `https://financialmodelingprep.com/api/v3/profile/${symbol}?apikey=${fmp_api_key}`,
                    requestOptions
                );
                const result = await response.json();
                rate = result[0].price;

                console.log(rate);

                let loss = 0;
                let profit = 0;

                if (rate > 10) {
                    loss = rate - 0.9;
                    profit = rate + 0.9;
                } else {
                    loss = rate - 0.0009;
                    profit = rate + 0.0009;
                }

                document.querySelector("#rate").value = rate;
                await setLoss(loss);
                await setProfit(profit);

            }

            async function setLoss(amount) {
                document.querySelector("#stop_loss").value = amount;
                document.querySelector(".small-loss").textContent = `(${amount})`;
            }

            async function setProfit(amount) {
                document.querySelector("#take_profit").value = amount;
                document.querySelector(".small-profit").textContent = `(${amount})`;
            }

            getRate("{{ $symbol }}");
        </script>
    @endpush
@endsection