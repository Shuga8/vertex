@extends('layouts.auth')
@section('content')
    @include('user.partials.top-bar')
    @include('user.partials.side-bar')
    <main class="main-content" data-simplebar>
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
                                            "height": "900",
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

                        <div class="d-block market-widget my-3">
                            <p class="text-success">
                                <b class="text-primary">TRADE BALANCE</b> :
                                ${{ number_format($wallet->trade_balance, '4', '.', ',') }}
                            </p>

                            <p class="my-1 text-success">
                                <b class="text-primary">PRIMARY BALANCE</b> :
                                ${{ number_format($wallet->primary_balance, '4', '.', ',') }}
                            </p>
                        </div>

                        <div class="market-widget mb-4">
                            <form method="POST" action="{{ route('user.binary.trade' . ucfirst($type)) }}"
                                name="binary_form">
                                @csrf
                                <input type="hidden" name="type" value="{{ $type }}">
                                <input type="hidden" name="symbol" value="{{ $symbol }}">
                                <input type="hidden" name="rate" id="rate">

                                <div class="input-single">
                                    <label for="amount">{{ __('Amount') }}</label>
                                    <input type="text" id="amount" name="amount" placeholder="0.00" required>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label for="stop_loss" class="text-center">{{ __('Stop Loss') }}</label>
                                        <input type="number" id="stop_loss" name="stop_loss" placeholder="0.00" required
                                            readonly style="text-align:center;">

                                        <div class="d-flex gap-1" style="margin-top:4px;">

                                            <div class="col">
                                                <button class="sub-loss" type="button"
                                                    style="background: #ddd;color: #000;width:100%;">-</button>
                                            </div>
                                            <div class="col">
                                                <button class="add-loss" type="button"
                                                    style="background: #ddd;color: #000;width:100%;">+</button>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="take_profit" class="text-center">{{ __('Take Profit') }}</label>
                                        <input type="number" id="take_profit" name="take_profit" placeholder="0.00"
                                            required readonly style="text-align:center;">

                                        <div class="d-flex gap-1" style="margin-top:4px;">
                                            <div class="col">
                                                <button class="sub-profit" type="button"
                                                    style="background: #ddd;color: #000;width:100%;">-</button>
                                            </div>
                                            <div class="col">
                                                <button class="add-profit" type="button"
                                                    style="background: #ddd;color: #000;width:100%;">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="bot-col col-sm-6 gap-4">
                                        <div class="bot-trading bot-trading-1 fifty">
                                        </div>
                                        <p class="text-center" style="font-size: 10px">BOT AMOUNT: $50</p>
                                    </div>

                                    <div class="bot-col col-sm-6">
                                        <div class="bot-trading bot-trading-2 hundred">
                                        </div>
                                        <p class="text-center" style="font-size: 10px">BOT AMOUNT: $100</p>
                                    </div>

                                </div>

                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <button class="i-btn btn--md btn--danger capsuled w-100"
                                        style="display: flex;flex-direction:row;column-gap:3px;place-items: baseline;"
                                        name="action" value="sell">
                                        Sell
                                        <small class="small-loss" style="font-size: inherit;"></small>
                                    </button>

                                    <button class="i-btn btn--md btn--success capsuled w-100"
                                        style="display: flex;flex-direction:row;column-gap:3px;place-items: baseline;"
                                        name="action" value="buy">Buy<small class="small-profit"
                                            style="font-size: inherit;"></small></button>
                                </div>

                                <div class="row">

                                    <!-- TradingView Widget BEGIN -->
                                    <div class="tradingview-widget-container">
                                        <div class="tradingview-widget-container__widget"></div>
                                        <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/"
                                                rel="noopener nofollow" target="_blank"><span class="blue-text">Track
                                                    all
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
                    <div class=" scroll-design">
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>{{ __('Initiated At') }}</th>
                                        <th>{{ __('Open Amout') }}</th>
                                        <th>{{ __('Current/Closed Amount') }}</th>
                                        <th>{{ __('Profit/Loss') }}</th>
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


                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">{{ $tradeLogs->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('script-push')
        <script type="text/javascript">
            const fmp_api_key = "cARpiP1yH7faNhSWqnQLyGNV0mc7oTxl";
            const fastforex_api_key = "5952fd138c-5327d8b2a6-smk0x3";
            let rate = 0;
            let loss = 0;
            let profit = 0;
            let type = "{{ $type }}";

            console.log(type);
            async function getRate(symbol) {
                const myHeaders = new Headers();
                myHeaders.append("Accept", "application/json");
                const requestOptions = {
                    method: "GET",
                    redirect: "follow",
                };

                let response = null

                if (type == "commodity") {
                    response = await fetch(
                        `https://financialmodelingprep.com/api/v3/quote/${symbol}?apikey=${fmp_api_key}`,
                        requestOptions
                    );
                    const result = await response.json();
                    rate = parseFloat(result[0].price.toFixed(4));

                } else if (type == "forex") {
                    requestOptions.headers = myHeaders;
                    response = await fetch(
                        `https://api.fastforex.io/convert?from=${symbol}&to=USD&amount=1&api_key=${fastforex_api_key}`,
                        requestOptions
                    );
                    const result = await response.json();
                    rate = parseFloat(result.result.rate.toFixed(4));

                } else {
                    response = await fetch(
                        `https://financialmodelingprep.com/api/v3/profile/${symbol}?apikey=${fmp_api_key}`,
                        requestOptions
                    );
                    const result = await response.json();
                    rate = parseFloat(result[0].price.toFixed(4));

                }

                if (rate > 10) {
                    loss = rate - 0.9;
                    profit = rate + 0.9;
                    await setLoss(loss.toFixed(2));
                    await setProfit(profit.toFixed(2));
                } else {
                    loss = rate - 0.0009;
                    profit = rate + 0.0009;
                    await setLoss(loss.toFixed(4));
                    await setProfit(profit.toFixed(4));
                }

                document.querySelector("#rate").value = rate;



            }

            async function setLoss(amount) {
                document.querySelector("#stop_loss").value = amount;
                document.querySelector(".small-loss").textContent = `(${amount})`;
            }

            async function setProfit(amount) {
                document.querySelector("#take_profit").value = amount;
                document.querySelector(".small-profit").textContent = `(${amount})`;
            }

            document.querySelector(".add-loss").addEventListener("click", async function() {
                if (rate > 10) {
                    loss += 0.1;
                    await setLoss(loss.toFixed(2));
                } else {
                    loss += 0.0001;
                    await setLoss(loss.toFixed(4));
                }
            });

            document.querySelector(".sub-loss").addEventListener("click", async function() {
                if (rate > 10) {
                    loss -= 0.1;
                    await setLoss(loss.toFixed(2));
                } else {
                    loss -= 0.0001;
                    await setLoss(loss.toFixed(4));
                }
            });

            document.querySelector(".add-profit").addEventListener("click", async function() {
                if (rate > 10) {
                    profit += 0.1;
                    await setProfit(profit.toFixed(2));
                } else {
                    profit += 0.0001;
                    await setProfit(profit.toFixed(4));
                }
            });

            document.querySelector(".sub-profit").addEventListener("click", async function() {
                if (rate > 10) {
                    profit -= 0.1;
                    await setProfit(profit.toFixed(2));
                } else {
                    profit -= 0.0001;
                    await setProfit(profit.toFixed(4));
                }
            });

            document.querySelector(".fifty").addEventListener("click", async function() {
                document.querySelector("input[name='amount']").value = 50;
                const rand = Math.floor(Math.random() * 2);
                await new Promise((resolve) => setTimeout(resolve, 0));

                document.querySelectorAll("button[name='action']")[rand].click();
            });

            document.querySelector(".hundred").addEventListener("click", async function() {
                document.querySelector("input[name='amount']").value = 100;
                const rand = Math.floor(Math.random() * 2);
                await new Promise((resolve) => setTimeout(resolve, 0));

                document.querySelectorAll("button[name='action']")[rand].click();
            });


            getRate("{{ $symbol }}");
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            $(document).ready(function() {
                function fetchHistory() {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('user.binary.history') }}",
                        success: function(response) {
                            // Select the tbody element
                            const tbody = $('tbody');
                            tbody.empty(); // Clear any existing content in the tbody

                            if (response.length > 0) {
                                // Loop through each trade log in the response
                                response.forEach(tradeLog => {
                                    // Determine the ticker based on trade type
                                    let ticker = '';
                                    if (tradeLog.isCommodity) {
                                        ticker = tradeLog.commodity;
                                    } else if (tradeLog.isForex) {
                                        ticker = tradeLog.forex;
                                    } else if (tradeLog.isStock) {
                                        ticker = tradeLog.stock;
                                    }

                                    // Define the trade status and direction badge classes
                                    const statusBadge = tradeLog.status ? 'badge--success' :
                                        'badge--danger';
                                    const statusText = tradeLog.status ? 'completed' : 'running';
                                    const tradeTypeBadge = tradeLog.trade_type === 'sell' ?
                                        'badge--danger' : 'badge--success';

                                    const profitLoss = parseFloat(tradeLog.amount) - parseFloat(
                                        tradeLog.open_amount);

                                    const profitLossBadge = parseFloat(tradeLog.open_amount) >
                                        parseFloat(tradeLog.amount) ? 'badge--danger' :
                                        'badge--success';

                                    // Generate the row HTML
                                    const row = `
                        <tr>
                            <td data-label="Initiated At">${new Date(tradeLog.created_at).toLocaleString()}</td>
                            <td data-label="Open Amount">{{ getCurrencySymbol() }}${parseFloat(tradeLog.open_amount).toFixed(4)}</td>
                            <td data-label="Current Amount">{{ getCurrencySymbol() }}${parseFloat(tradeLog.amount).toFixed(4)}</td>
                            <td data-label="ProfitLoss">
                                <span class="i-badge ${profitLossBadge}">${parseFloat(profitLoss).toFixed(2)}</span>
                            </td>
                            <td data-label="Price Is">{{ getCurrencySymbol() }}${parseFloat(tradeLog.price_is).toFixed(4)}</td>
                            <td data-label="Price Was">{{ getCurrencySymbol() }}${parseFloat(tradeLog.price_was).toFixed(4)}</td>
                            <td data-label="Direction">
                                <span class="i-badge ${tradeTypeBadge}">${tradeLog.trade_type.toUpperCase()}</span>
                            </td>
                            <td data-label="Ticker">${ticker || '-'}</td>
                            <td data-label="Take Profit">
                                <span class="i-badge badge--success">{{ getCurrencySymbol() }}${parseFloat(tradeLog.take_profit).toFixed(4)}</span>
                            </td>
                            <td data-label="Stop Loss">
                                <span class="i-badge badge--danger">{{ getCurrencySymbol() }}${parseFloat(tradeLog.stop_loss).toFixed(4)}</span>
                            </td>
                            <td data-label="Status">
                                <span class="i-badge ${statusBadge}">${statusText}</span>
                            </td>
                            <td data-label="Action">
                                ${statusText == "running" ? `<a class="i-btn btn--md btn--danger capsuled" href="{{ config('app.url') }}/users/isolation/end/${tradeLog.id}">End</a>
                                                                                                                                                                                                                                                                                                        </td>` : `<a class="i-btn btn--md btn--success capsuled">Closed</a>
                                                                                                                                                                                                                                                                                                        </td>` }
                                
                        </tr>
                    `;

                                    // Append the generated row to the tbody
                                    tbody.append(row);
                                });
                            } else {
                                // If no data is found, display a message
                                tbody.append(`
                    <tr>
                        <td class="text-white text-center" colspan="100%">No Data Found</td>
                    </tr>
                `);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error: " + error);
                            console.error("Status: " + status);
                            console.error("Response: ", xhr.responseText);
                        }
                    });
                }

                setInterval(() => {
                    fetchHistory();
                }, 3000);
            });
        </script>
    @endpush
@endsection
