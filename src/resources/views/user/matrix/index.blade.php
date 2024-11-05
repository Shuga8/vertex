@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                @if($matrixLog)
                    <div class="i-card-sm mb-4">
                        <h4 class="title">{{ __('Matrix Enrolled Information') }}</h4>
                        <div class="row g-3 row-cols-xl-4 row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1">
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Initiated At') }}</p>
                                    <h5 class="title-sm mb-0">{{ showDateTime($matrixLog->created_at) }}</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Trx') }}</p>
                                    <h5 class="title-sm mb-0">{{ $matrixLog->trx }}</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Schema Name') }}</p>
                                    <h5 class="title-sm mb-0">{{ $matrixLog->name }}</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Invest Amount') }}</p>
                                    <h5 class="title-sm mb-0">{{ getCurrencySymbol() }}{{shortAmount($matrixLog->price)}}</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('User-Based Referral Bonus') }}</p>
                                    <h5 class="title-sm mb-0">{{ getCurrencySymbol() }}{{shortAmount($matrixLog->referral_reward)}}</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Referral Commission') }}</p>
                                    <h5 class="title-sm mb-0">{{ getCurrencySymbol() }}{{shortAmount($matrixLog->referral_commissions)}}</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Level Commission') }}</p>
                                    <h5 class="title-sm mb-0">{{ getCurrencySymbol() }}{{shortAmount($matrixLog->level_commissions)}}</h5>
                                </div>
                            </div>

                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Status') }}</p>
                                    <h5 class="title-sm mb-0">{{ \App\Enums\Matrix\InvestmentStatus::getName($matrixLog->status) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="i-card-sm">
                    <div class="card-body">
                        <div class="row align-items-center gy-4">
                            @include('user.partials.matrix.plan')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


