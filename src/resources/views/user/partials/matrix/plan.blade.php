@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::MATRIX_PLAN, \App\Enums\Frontend\Content::FIXED);
@endphp
@foreach($matrix as $key => $plan)
    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6">
        <div class="pricing-item card-style">
            @if($plan->is_recommend)
                <div class="recommend">
                    <span>{{ __('Recommend') }}</span>
                </div>
            @endif
            <div class="icon">
                <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'award_image')) }}" alt="{{ __('Award Image') }}" border="0">
            </div>
            <div class="header">
                <div class="price">{{getCurrencySymbol()}}{{ shortAmount($plan->amount) }}</div>
                <h4 class="title">{{ $plan->name }}</h4>
                <div class="price-info">
                    <h6 class="mb-1">{{ __('Straightforward Referral Reward') }}: {{getCurrencySymbol()}}{{ shortAmount($plan->referral_reward) }}</h6>
                    <h6 class="mb-2">{{ __('Aggregate Level Commission') }}: {{ getCurrencySymbol() }}{{ \App\Services\Investment\MatrixService::calculateAggregateCommission((int)$plan->id) }}</h6>
                    <p class="mb-0">{{ __('Get back') }} <span>{{ shortAmount((\App\Services\Investment\MatrixService::calculateAggregateCommission((int)$plan->id) / $plan->amount) * 100) }}%</span> {{ __('of what you invested') }}</p>
                </div>
            </div>
            <div class="body">
                <ul class="pricing-list">
                    @foreach (\App\Services\Investment\MatrixService::calculateTotalLevel($plan->id) as $value)
                        @php
                            $matrix = pow(\App\Services\Investment\MatrixService::getMatrixWidth(), $loop->iteration)
                        @endphp
                        <li>
                            {{ __('Level') }}-{{ $loop->iteration }} <span class="px-2">>></span>
                            {{getCurrencySymbol()}}{{shortAmount($value->amount)}}x{{$matrix}} =
                            {{getCurrencySymbol()}}{{ shortAmount($value->amount * $matrix) }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="footer">
                <button class="i-btn btn--primary btn--lg capsuled w-100 enroll-matrix-process"
                    data-bs-toggle="modal"
                    data-bs-target="#enrollMatrixModal"
                    data-uid="{{ $plan->uid }}"
                    data-name="{{ $plan->name }}"
                >{{ __('Start Investing Now') }}</button>
            </div>
        </div>
    </div>
@endforeach

<div class="modal fade" id="enrollMatrixModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg--dark">
                <h5 class="modal-title" id="matrixTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('user.matrix.store') }}">
                @csrf
                <input type="hidden" name="uid" value="">
                <div class="modal-body">
                    <p>{{ __("Are you sure you want to enroll in this matrix scheme?") }}</p>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="i-btn btn--primary btn--sm">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.enroll-matrix-process').click(function () {
                const uid = $(this).data('uid');
                const name = $(this).data('name');

                $('input[name="uid"]').val(uid);
                const title = " Join " + name + " Matrix Scheme";
                $('#matrixTitle').text(title);
            });
        });
    </script>
@endpush
