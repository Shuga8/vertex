@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
            'is_filter' => false,
            'is_modal' => false,
        ])
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.mail.update')}}" method="POST">
                    @csrf
                    <div class="row g-3 mb-3">
                            <div class="col-lg-6">
                                <label for="from_email" class="form-label">{{ __('admin.input.from_email') }}</label>
                                <input type="email" name="mail_configuration[from_email]" value="{{getArrayValue((array)$setting->mail_configuration, 'from_email')}}" class="form-control" id="from_email" placeholder="@lang('Enter Email Address')">
                            </div>

                            <div class="col-lg-6">
                                <label for="from_name" class="form-label">{{ __('admin.input.from_email_name') }}</label>
                                <input type="text" name="mail_configuration[from_name]" value="{{getArrayValue((array)$setting->mail_configuration, 'from_name')}}"  class="form-control" id="from_name" placeholder="@lang('Enter Email Name')">
                            </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-lg-6">
                            <label for="host" class="form-label">{{ __('admin.input.host') }}</label>
                            <input type="text" name="mail_configuration[host]" class="form-control" id="host" value="{{getArrayValue((array)$setting->mail_configuration, 'host')}}" placeholder="@lang('Email Address Or Host')">
                        </div>

                        <div class="col-lg-6">
                            <label for="port" class="form-label">{{ __('admin.input.port') }}</label>
                            <input type="text" name="mail_configuration[port]" class="form-control" id="port" value="{{getArrayValue((array)$setting->mail_configuration, 'port')}}" placeholder="@lang('Enter Port')">
                        </div>

                        <div class="col-12">
                            <label for="encryption" class="form-label">{{ __('admin.input.encryption') }}</label>
                            <select class="form-select" name="mail_configuration[encryption]" id="encryption" required>
                                <option value="ssl" @if(getArrayValue((array)$setting->mail_configuration, 'encryption') == "ssl") selected @endif>@lang('ssl')</option>
                                <option value="tls" @if(getArrayValue((array)$setting->mail_configuration, 'encryption') == "tls") selected @endif>@lang('tls')</option>
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <label for="username" class="form-label">{{ __('admin.input.username') }}</label>
                            <input type="text" name="mail_configuration[username]" class="form-control" id="username" value="{{getArrayValue((array)$setting->mail_configuration, 'username')}}" placeholder="@lang('Enter Username or Email')">
                        </div>

                        <div class="col-lg-6">
                            <label for="password" class="form-label">{{ __('admin.input.password') }}</label>
                            <input type="text" name="mail_configuration[password]" class="form-control" value="{{getArrayValue((array)$setting->mail_configuration, 'password')}}" id="password" placeholder="@lang('Enter Password')">
                        </div>
                    </div>
                    <button class="i-btn btn--primary btn--lg">{{ __('admin.button.save') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
