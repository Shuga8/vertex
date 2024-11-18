@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>

                    <div class="my-4">
                        <select class="form-select form-select-lg" aria-label="Default select example" id="country">
                            <option value="">Select Country</option>
                            <option value="AF">Afghanistan</option>
                            <option value="AX">Åland Islands</option>
                            <option value="AL">Albania</option>
                            <option value="DZ">Algeria</option>
                            <option value="AS">American Samoa</option>
                            <option value="AD">Andorra</option>
                            <option value="AO">Angola</option>
                            <option value="AI">Anguilla</option>
                            <option value="AQ">Antarctica</option>
                            <option value="AG">Antigua and Barbuda</option>
                            <option value="AR">Argentina</option>
                            <option value="AM">Armenia</option>
                            <option value="AW">Aruba</option>
                            <option value="AU">Australia</option>
                            <option value="AT">Austria</option>
                            <option value="AZ">Azerbaijan</option>
                            <option value="BS">Bahamas</option>
                            <option value="BH">Bahrain</option>
                            <option value="BD">Bangladesh</option>
                            <option value="BB">Barbados</option>
                            <option value="BY">Belarus</option>
                            <option value="BE">Belgium</option>
                            <option value="BZ">Belize</option>
                            <option value="BJ">Benin</option>
                            <option value="BM">Bermuda</option>
                            <option value="BT">Bhutan</option>
                            <option value="BO">Bolivia, Plurinational State of</option>
                            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                            <option value="BA">Bosnia and Herzegovina</option>
                            <option value="BW">Botswana</option>
                            <option value="BV">Bouvet Island</option>
                            <option value="BR">Brazil</option>
                            <option value="IO">British Indian Ocean Territory</option>
                            <option value="BN">Brunei Darussalam</option>
                            <option value="BG">Bulgaria</option>
                            <option value="BF">Burkina Faso</option>
                            <option value="BI">Burundi</option>
                            <option value="KH">Cambodia</option>
                            <option value="CM">Cameroon</option>
                            <option value="CA">Canada</option>
                            <option value="CV">Cape Verde</option>
                            <option value="KY">Cayman Islands</option>
                            <option value="CF">Central African Republic</option>
                            <option value="TD">Chad</option>
                            <option value="CL">Chile</option>
                            <option value="CN">China</option>
                            <option value="CX">Christmas Island</option>
                            <option value="CC">Cocos (Keeling) Islands</option>
                            <option value="CO">Colombia</option>
                            <option value="KM">Comoros</option>
                            <option value="CG">Congo</option>
                            <option value="CD">Congo, the Democratic Republic of the</option>
                            <option value="CK">Cook Islands</option>
                            <option value="CR">Costa Rica</option>
                            <option value="CI">Côte d'Ivoire</option>
                            <option value="HR">Croatia</option>
                            <option value="CU">Cuba</option>
                            <option value="CW">Curaçao</option>
                            <option value="CY">Cyprus</option>
                            <option value="CZ">Czech Republic</option>
                            <option value="DK">Denmark</option>
                            <option value="DJ">Djibouti</option>
                            <option value="DM">Dominica</option>
                            <option value="DO">Dominican Republic</option>
                            <option value="EC">Ecuador</option>
                            <option value="EG">Egypt</option>
                            <option value="SV">El Salvador</option>
                            <option value="GQ">Equatorial Guinea</option>
                            <option value="ER">Eritrea</option>
                            <option value="EE">Estonia</option>
                            <option value="ET">Ethiopia</option>
                            <option value="FK">Falkland Islands (Malvinas)</option>
                            <option value="FO">Faroe Islands</option>
                            <option value="FJ">Fiji</option>
                            <option value="FI">Finland</option>
                            <option value="FR">France</option>
                            <option value="GF">French Guiana</option>
                            <option value="TF">French Southern Territories</option>
                            <option value="GA">Gabon</option>
                            <option value="GM">Gambia</option>
                            <option value="GE">Georgia</option>
                            <option value="DE">Germany</option>
                            <option value="GH">Ghana</option>
                            <option value="GI">Gibraltar</option>
                            <option value="GR">Greece</option>
                            <option value="GL">Greenland</option>
                            <option value="GD">Grenada</option>
                            <option value="GP">Guadeloupe</option>
                            <option value="GU">Guam</option>
                            <option value="GT">Guatemala</option>
                            <option value="GG">Guernsey</option>
                            <option value="GN">Guinea</option>
                            <option value="GW">Guinea-Bissau</option>
                            <option value="GY">Guyana</option>
                            <option value="HT">Haiti</option>
                            <option value="HM">Heard Island and McDonald Islands</option>
                            <option value="VA">Holy See (Vatican City State)</option>
                            <option value="HN">Honduras</option>
                            <option value="HK">Hong Kong</option>
                            <option value="HU">Hungary</option>
                            <option value="IS">Iceland</option>
                            <option value="IN">India</option>
                            <option value="ID">Indonesia</option>
                            <option value="IR">Iran, Islamic Republic of</option>
                            <option value="IQ">Iraq</option>
                            <option value="IE">Ireland</option>
                            <option value="IM">Isle of Man</option>
                            <option value="IL">Israel</option>
                            <option value="IT">Italy</option>
                            <option value="JM">Jamaica</option>
                            <option value="JP">Japan</option>
                            <option value="JE">Jersey</option>
                            <option value="JO">Jordan</option>
                            <option value="KZ">Kazakhstan</option>
                            <option value="KE">Kenya</option>
                            <option value="KI">Kiribati</option>
                            <option value="KP">Korea, Democratic People's Republic of</option>
                            <option value="KR">Korea, Republic of</option>
                            <option value="KW">Kuwait</option>
                            <option value="KG">Kyrgyzstan</option>
                            <option value="LA">Lao People's Democratic Republic</option>
                            <option value="LV">Latvia</option>
                            <option value="LB">Lebanon</option>
                            <option value="LS">Lesotho</option>
                            <option value="LR">Liberia</option>
                            <option value="LY">Libya</option>
                            <option value="LI">Liechtenstein</option>
                            <option value="LT">Lithuania</option>
                            <option value="LU">Luxembourg</option>
                            <option value="MO">Macao</option>
                            <option value="MK">Macedonia, the Former Yugoslav Republic of</option>
                            <option value="MG">Madagascar</option>
                            <option value="MW">Malawi</option>
                            <option value="MY">Malaysia</option>
                            <option value="MV">Maldives</option>
                            <option value="ML">Mali</option>
                            <option value="MT">Malta</option>
                            <option value="MH">Marshall Islands</option>
                            <option value="MQ">Martinique</option>
                            <option value="MR">Mauritania</option>
                            <option value="MU">Mauritius</option>
                            <option value="YT">Mayotte</option>
                            <option value="MX">Mexico</option>
                            <option value="FM">Micronesia, Federated States of</option>
                            <option value="MD">Moldova, Republic of</option>
                            <option value="MC">Monaco</option>
                            <option value="MN">Mongolia</option>
                            <option value="ME">Montenegro</option>
                            <option value="MS">Montserrat</option>
                            <option value="MA">Morocco</option>
                            <option value="MZ">Mozambique</option>
                            <option value="MM">Myanmar</option>
                            <option value="NA">Namibia</option>

                        </select>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 d-none manual_form">
                            @foreach ($gateways as $key => $gateway)
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                    <div class="i-card-sm card--dark shadow-none rounded-3">
                                        <div class="row justify-content-between align-items-center g-lg-2 g-1">
                                            <div class="col-12">
                                                <div
                                                    class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3 gap-3">
                                                    <h5 class="title-sm mb-0">{{ __($gateway->name) }}</h5>
                                                    @if ($gateway->type == \App\Enums\Payment\GatewayType::MANUAL->value)
                                                        <button class="gateway-details" data-bs-toggle="modal"
                                                            data-bs-target="#paymentDetailsModal"
                                                            data-details="{{ $gateway->details }}"><i
                                                                class="bi bi-info-square-fill"></i></button>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5">
                                                <img src="{{ displayImage($gateway->file) }}" class="mxw-80"
                                                    alt="Vector">
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-7 text-end">
                                                <button class="i-btn btn--primary btn--md capsuled deposit-process"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                    data-name="{{ $gateway->name }}" data-code="{{ $gateway->code }}"
                                                    data-minimum="{{ getCurrencySymbol() }}{{ shortAmount($gateway->minimum) }}"
                                                    data-maximum="{{ getCurrencySymbol() }}{{ shortAmount($gateway->maximum) }}">{{ __('Deposit Now') }}<i
                                                        class="bi bi-box-arrow-up-right ms-2"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="zain-container row mx-auto d-none" style="max-width: 350px;margin: 0px auto;">
                            <div class="block my-2 text-primary" style="text-transform: uppercase;font-weight:500;">
                                Pay
                                With
                            </div>
                            <div class="col-6 my-3">
                                <img src="{{ asset('assets/icons/zain.png') }}" alt="">
                            </div>

                            <div class="my-3">

                                <p class="text-success">Contact us via whatsap</p>
                                <a href="http://wa.me/201144472763" style="width: 100%;">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"
                                        alt="" style="width: 50px;height:50px;object-fit:contain;">
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">{{ __('Deposit Logs') }}</h4>
                    </div>

                    <div class="filter-area">
                        <form action="{{ route('user.payment.index') }}">
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                <div class="col">
                                    <input type="text" name="search" placeholder="{{ __('Trx ID') }}"
                                        value="{{ request()->get('search') }}">
                                </div>
                                <div class="col">
                                    <select class="select2-js" name="status">
                                        @foreach (App\Enums\Payment\Deposit\Status::cases() as $status)
                                            @unless ($status->value == App\Enums\Payment\Deposit\Status::INITIATED->value)
                                                <option value="{{ $status->value }}"
                                                    @if ($status->value == request()->status) selected @endif>{{ $status->name }}
                                                </option>
                                            @endunless
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" id="date" class="form-control datepicker-here"
                                        name="date" value="{{ request()->get('date') }}" data-range="true"
                                        data-multiple-dates-separator=" - " data-language="en"
                                        data-position="bottom right" autocomplete="off"
                                        placeholder="{{ __('Date') }}">
                                </div>
                                <div class="col">
                                    <button type="submit" class="i-btn btn--lg btn--primary w-100"><i
                                            class="bi bi-search me-3"></i>{{ __('Search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center gy-4 mb-3">
                            <div class="table-container">
                                <table id="myTable" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('Initiated At') }}</th>
                                            <th scope="col">{{ __('Trx') }}</th>
                                            <th scope="col">{{ __('Gateway') }}</th>
                                            <th scope="col">{{ __('Amount') }}</th>
                                            <th scope="col">{{ __('Charge') }}</th>
                                            <th scope="col">{{ __('Final Amount') }}</th>
                                            <th scope="col">{{ __('Wallet') }}</th>
                                            <th scope="col">{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($deposits as $key => $deposit)
                                            <tr>
                                                <td data-label="{{ __('Initiated At') }}">
                                                    {{ showDateTime($deposit->created_at) }}
                                                </td>
                                                <td data-label="{{ __('Trx') }}">
                                                    {{ $deposit->trx }}
                                                </td>
                                                <td data-label="{{ __('Gateway') }}">
                                                    {{ $deposit?->gateway?->name ?? 'N/A' }}
                                                </td>
                                                <td data-label="{{ __('Amount') }}">
                                                    {{ getCurrencySymbol() }}{{ shortAmount($deposit->amount) }}
                                                </td>
                                                <td data-label="{{ __('Charge') }}">
                                                    {{ getCurrencySymbol() }}{{ shortAmount($deposit->charge) }}
                                                </td>
                                                <td data-label="{{ __('Final Amount') }}">
                                                    {{ getCurrencySymbol() }}{{ shortAmount($deposit->final_amount) }}
                                                </td>
                                                <td data-label="{{ __('Wallet') }}">
                                                    {{ __(\App\Enums\Transaction\WalletType::getWalletName($deposit->wallet_type)) }}
                                                </td>
                                                <td data-label="{{ __('Status') }}">
                                                    <span
                                                        class="i-badge {{ App\Enums\Payment\Deposit\Status::getColor($deposit->status) }}">{{ App\Enums\Payment\Deposit\Status::getName($deposit->status) }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-white text-center" colspan="100%">
                                                    {{ __('No Data Found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    {{ $deposits->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title" id="gatewayTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('user.payment.process') }}">
                    @csrf
                    <input type="hidden" name="code" value="">
                    <div class="modal-body">
                        <h6 id="paymentLimitTitle" class="mb-1 mt-1 text-center"></h6>
                        <div class="mb-3">
                            <label for="amount" class="col-form-label">{{ __('Amount') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="amount" name="amount"
                                    placeholder="{{ __('Enter Amount') }}" aria-label="Recipient's username"
                                    aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">{{ getCurrencyName() }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="col-form-label">{{ __('Wallet') }}</label>
                            <select class="form-control" name="wallet">
                                @foreach (App\Enums\Transaction\WalletType::cases() as $status)
                                    @unless ($status->value == \App\Enums\Transaction\WalletType::PRACTICE->value)
                                        <option value="{{ $status->value }}">
                                            {{ \App\Enums\Transaction\WalletType::getWalletName($status->value) }}</option>
                                    @endunless
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--light btn--md"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="i-btn btn--primary btn--md">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title">{{ __('Payment Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="payment-details"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function() {
            $('.deposit-process').click(function() {
                const name = $(this).data('name');
                const code = $(this).data('code');
                const minimum = $(this).data('minimum');
                const maximum = $(this).data('maximum');
                $('input[name="code"]').val(code);

                const gatewayTitle = "Deposit with " + name + " now";
                const paymentLimit = `Deposit Amount Limit ${minimum} - ${maximum}`;
                $('#paymentLimitTitle').text(paymentLimit);
                $('#gatewayTitle').text(gatewayTitle);
            });

            $('.gateway-details').click(function() {
                const details = $(this).data('details');
                $('.payment-details').empty();
                $('.payment-details').append(details);
            });

            $('document').ready(function() {
                var country = $("#country");
                var zain = document.querySelector(".zain-container");
                var manual = document.querySelector(".manual_form")
                country.change(function(e) {
                    if (e.target.value == "IQ") {
                        zain.classList.replace("d-none", "d-block");
                        manual.classList.replace("d-flex", "d-none");
                    } else {
                        zain.classList.replace("d-block", "d-none");
                        manual.classList.replace("d-none", "d-flex");
                    }
                })
            })
        });
    </script>
@endpush
