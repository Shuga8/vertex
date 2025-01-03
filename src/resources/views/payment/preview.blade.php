@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <h3 class="page-title">{{ __($setTitle) }}</h3>
        <div class="i-card-sm">
            <div class="row">
                <div class="user-form">
                    <h5 class="card-header text-center">{{ __('Payment Details') }}</h5>
                    <div class="card-body mb-4 mt-2">
                        @php echo $gateway->details ?? '' @endphp
                    </div>
                    @if (
                        $gateway->type == \App\Enums\Payment\GatewayType::AUTOMATIC->value &&
                            $gateway->code == \App\Enums\Payment\GatewayCode::BLOCK_CHAIN->value)
                        <div class="card-body card-body-deposit text-center">
                            <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success">
                                    {{ $payment->btc_amount }}</span> @lang('BTC')</h4>
                            <h5 class="mb-2">@lang('TO') <span class="text-success">
                                    {{ $payment->btc_wallet ?? '' }}</span></h5>
                            <img src="{{ cryptoQRCode($payment->btc_wallet ?? '') }}" alt="@lang('Image')">
                            <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
                        </div>
                    @endif

                    @if ($gateway->type == \App\Enums\Payment\GatewayType::MANUAL->value)
                        <div class="col-lg-12 mb-4">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Rate') }}
                                    <span>{{ getCurrencySymbol() }}1 = {{ shortAmount($payment->rate) }}
                                        {{ $gateway->currency ?? getCurrencyName() }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Deposit Amount') }}
                                    <span>{{ getCurrencySymbol() }}{{ shortAmount($payment->amount) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Charge') }}
                                    <span>{{ getCurrencySymbol() }}{{ shortAmount($payment->charge) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Final Amount') }}
                                    <span>{{ getCurrencySymbol() }}{{ shortAmount($payment->final_amount) }}</span>
                                </li>

                            </ul>

                            <hr>
                            {{-- <select class="form-select form-select-lg" aria-label="Default select example" id="country">
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

                            </select> --}}
                        </div>

                        <form method="POST" action="{{ route('user.payment.traditional') }}" enctype="multipart/form-data"
                            class="manual_form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="payment_intent" value="{{ $payment->trx }}">
                            <input type="hidden" name="gateway_code" value="{{ $gateway->code }}">
                            <div class="row">
                                @foreach ($gateway->parameter as $key => $parameter)
                                    @php
                                        $parameter = is_array($parameter) ? $parameter : [];
                                    @endphp
                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label
                                                for="{{ getArrayValue($parameter, 'field_label') }}">{{ __(getArrayValue($parameter, 'field_label')) }}</label>
                                            @if (getArrayValue($parameter, 'field_type') == 'file')
                                                <input type="file" id="{{ getArrayValue($parameter, 'field_label') }}"
                                                    name="{{ getArrayValue($parameter, 'field_name') }}" required>
                                            @elseif(getArrayValue($parameter, 'field_type') == 'text')
                                                <input type="text" id="{{ getArrayValue($parameter, 'field_label') }}"
                                                    name="{{ getArrayValue($parameter, 'field_name') }}"
                                                    placeholder="{{ __('Enter ' . getArrayValue($parameter, 'field_label')) }}"
                                                    required>
                                            @elseif(getArrayValue($parameter, 'field_type') == 'textarea')
                                                <textarea id="{{ getArrayValue($parameter, 'field_label') }}" name="{{ getArrayValue($parameter, 'field_name') }}"
                                                    placeholder="{{ __('Enter ' . getArrayValue($parameter, 'field_label')) }}" required></textarea>
                                            @endif
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                            <div class="col-12">
                                <button type="submit" class="i-btn btn--primary btn--lg">{{ __('Save') }}</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
