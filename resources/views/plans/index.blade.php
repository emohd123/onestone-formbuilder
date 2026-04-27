@php
    use Carbon\Carbon as Carbon;
    use App\Models\Setting;
    use App\Facades\UtilityFacades;
    $payment_type = [];
    $currency_symbol = env('CURRENCY_SYMBOL');
@endphp
@extends('layouts.main')
@section('title', __('Plans'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Plans') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Plans') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    @hasrole('Super Admin')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            {{ $dataTable->table(['width' => '100%']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endhasrole
    @hasrole('Admin')
        @section('breadcrumb')
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item">{{ __('Plans') }}</li>
            </ul>
        @endsection

        <div class="card-body">
            <section id="price" class="row">
                <div class="container">

                    <div class="col-6">
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                    </div>
                    <div class="row">
                        <style>
                            .custom-price-card {
                                height: 90%;
                                display: flex;
                                flex-direction: column;
                                justify-content: space-between;
                            }
                        </style>
                        @foreach ($plans as $plan)
                            @if ($plan->active_status == 1)
                                @if ($plan->id == 1)
                                    <div class="col-xl-4 col-lg- col-md-6 col-sm-12">
                                        <div class="card custom-price-card price-2 bg-primary wow animate__fadeInUp plan-style"
                                            data-wow-delay="0.4s">
                                            <div class="custom-card-body">
                                                <span class="custom-price-badge">{{ Str::upper($plan->name) }}</span>
                                                <br><br>
                                                <span class="mb-4 text-white f-w-600 custom-p-price d-block">
                                                    {{ $currency_symbol . '' . $plan->price }}
                                                    <small
                                                        class="text-sm">/{{ $plan->duration . ' ' . $plan->durationtype }}</small>
                                                </span>
                                                <ul class="text-white mt-4 " style="padding: 0 79px display: inline-block; ">
                                                    @if (!empty($plan->description1))
                                                        <li>{{ $plan->description1 }}</li>
                                                    @endif
                                                    @if (!empty($plan->description2))
                                                        <li>{{ $plan->description2 }}</li>
                                                    @endif
                                                    @if (!empty($plan->description3))
                                                        <li>{{ $plan->description3 }}</li>
                                                    @endif

                                                </ul>
                                                <ul class="custom-list-unstyled">
                                                    {{--                                                    <li> --}}
                                                    {{--                                                        <span class="custom-theme-avtar"> --}}
                                                    {{--                                                            <i class="text-primary ti ti-circle-plus"></i> --}}
                                                    {{--                                                        </span> --}}
                                                    {{--                                                        {{ $plan->max_users . ' ' . __('Users') }} --}}
                                                    {{--                                                    </li> --}}
                                                    {{--                                                    <li> --}}
                                                    {{--                                                        <span class="custom-theme-avtar"> --}}
                                                    {{--                                                            <i class="text-primary ti ti-circle-plus"></i> --}}
                                                    {{--                                                        </span> --}}
                                                    {{--                                                        {{ $plan->max_roles . ' ' . __('Roles') }} --}}
                                                    {{--                                                    </li> --}}
                                                    <li>
                                                        <span class="custom-theme-avtar">
                                                            <i class="text-primary ti ti-circle-plus"></i>
                                                        </span>
                                                        {{ $plan->max_form . ' ' . __('Forms') }}
                                                    </li>
                                                    {{--                                                    <li> --}}
                                                    {{--                                                        <span class="custom-theme-avtar"> --}}
                                                    {{--                                                            <i class="text-primary ti ti-circle-plus"></i> --}}
                                                    {{--                                                        </span> --}}
                                                    {{--                                                        {{ $plan->max_booking . ' ' . __('Bookings') }} --}}
                                                    {{--                                                    </li> --}}
                                                    {{--                                                    <li> --}}
                                                    {{--                                                        <span class="custom-theme-avtar"> --}}
                                                    {{--                                                            <i class="text-primary ti ti-circle-plus"></i> --}}
                                                    {{--                                                        </span> --}}
                                                    {{--                                                        {{ $plan->max_documents . ' ' . __('Documents') }} --}}
                                                    {{--                                                    </li> --}}
                                                    {{--                                                    <li> --}}
                                                    {{--                                                        <span class="custom-theme-avtar"> --}}
                                                    {{--                                                            <i class="text-primary ti ti-circle-plus"></i> --}}
                                                    {{--                                                        </span> --}}
                                                    {{--                                                        {{ $plan->max_polls . ' ' . __('Polls') }} --}}
                                                    {{--                                                    </li> --}}

                                                </ul>
                                                <br>
                                                <div class="text-center d-grid">
                                                    @if ($plan->id == 1)
                                                        <div class="pricing-cta  ">
                                                            @if ($plan->id == $user->plan_id && !empty($user->plan_expired_date))
                                                                <a href="javascript:void(0)" data-id="{{ $plan->id }}"
                                                                    style='    margin-top: 10px;'
                                                                    class=" btn btn-success   d-flex justify-content-center align-items-center mx-sm-5"
                                                                    data-amount="{{ $plan->price }}">{{ __('Expire at') }}
                                                                    {{ Carbon::parse($user->plan_expired_date)->format('d/m/Y') }}</a>
                                                            @elseif($user->plan_id == 0)
                                                                <a href="{{ route('payment', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                                                    class="mb-3 btn btn-success d-flex justify-content-center align-items-center mx-sm-5">{{ __('Free trial') }}
                                                                    <i class="ti ti-chevron-right ms-2"></i></a>
                                                            @else
                                                                <a style="margin-top: 130px"
                                                                    class=" btn btn-danger d-flex justify-content-center align-items-center mx-sm-5 "
                                                                    style=" font-weight: bold ; ">
                                                                    {{ __('Free trial Ended') }}
                                                                </a>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($plan->id !== 1)
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                        <div class="card custom-price-card price-1 wow animate__fadeInUp plan-style"
                                            data-wow-delay="0.4s">
                                            <div class="custom-card-body">
                                                <span
                                                    class="custom-price-badge bg-primary">{{ Str::upper($plan->name) }}</span>
                                                <br><br>
                                                <span class="mb-4 f-w-600 custom-p-price d-block ">
                                                    {{ $currency_symbol . '' . $plan->price }}
                                                    <small
                                                        class="text-sm">/{{ $plan->duration . ' ' . $plan->durationtype }}</small>
                                                </span>
                                                <ul class="mb-0 mt-4 mob " style="display: inline-block;">
                                                    @if (!empty($plan->description1))
                                                        <li>{{ $plan->description1 }}</li>
                                                    @endif
                                                    @if (!empty($plan->description2))
                                                        <li>{{ $plan->description2 }}</li>
                                                    @endif
                                                    @if (!empty($plan->description3))
                                                        <li>{{ $plan->description3 }}</li>
                                                    @endif
                                                    @if (!empty($plan->description4))
                                                        <li>{{ $plan->description4 }}</li>
                                                    @endif
                                                    @if (!empty($plan->description5))
                                                        <li>{{ $plan->description5 }}</li>
                                                    @endif
                                                    @if (!empty($plan->description6))
                                                        <li>{{ $plan->description6 }}</li>
                                                    @endif
                                                    @if (!empty($plan->description7))
                                                        <li>{{ $plan->description7 }}</li>
                                                    @endif
                                                    @if (!empty($plan->description8))
                                                        <li>{{ $plan->description8 }}</li>
                                                    @endif

                                                </ul>
                                                <ul class="custom-list-unstyled-price-1">
                                                    {{--                                                    <li> --}}
                                                    {{--                                                        <span class="custom-theme-avtar"> --}}
                                                    {{--                                                            <i class="text-primary ti ti-circle-plus"></i> --}}
                                                    {{--                                                        </span> --}}
                                                    {{--                                                        {{ $plan->max_users . ' ' . __('Users') }} --}}
                                                    {{--                                                    </li> --}}
                                                    {{--                                                    <li> --}}
                                                    {{--                                                        <span class="custom-theme-avtar"> --}}
                                                    {{--                                                            <i class="text-primary ti ti-circle-plus"></i> --}}
                                                    {{--                                                        </span> --}}
                                                    {{--                                                        {{ $plan->max_roles . ' ' . __('Roles') }} --}}
                                                    {{--                                                    </li> --}}
                                                    <li>
                                                        <span class="custom-theme-avtar">
                                                            <i class="text-primary ti ti-circle-plus"></i>
                                                        </span>
                                                        {{ $plan->max_form . ' ' . __('Forms') }}
                                                    </li>
                                                    {{--                                                    <li> --}}
                                                    {{--                                                        <span class="custom-theme-avtar"> --}}
                                                    {{--                                                            <i class="text-primary ti ti-circle-plus"></i> --}}
                                                    {{--                                                        </span> --}}
                                                    {{--                                                        {{ $plan->max_booking . ' ' . __('Bookings') }} --}}
                                                    {{--                                                    </li> --}}
                                                    {{--                                                    <li> --}}
                                                    {{--                                                        <span class="custom-theme-avtar"> --}}
                                                    {{--                                                            <i class="text-primary ti ti-circle-plus"></i> --}}
                                                    {{--                                                        </span> --}}
                                                    {{--                                                        {{ $plan->max_documents . ' ' . __('Documents') }} --}}
                                                    {{--                                                    </li> --}}
                                                    {{--                                                    <li> --}}
                                                    {{--                                                        <span class="custom-theme-avtar"> --}}
                                                    {{--                                                            <i class="text-primary ti ti-circle-plus"></i> --}}
                                                    {{--                                                        </span> --}}
                                                    {{--                                                        {{ $plan->max_polls . ' ' . __('Polls') }} --}}
                                                    {{--                                                    </li> --}}
                                                </ul>
                                            </div>
                                            <div class="text-center d-grid">
                                                @if ($plan->id != 1)
                                                    <div class="pricing-cta">
                                                        @if ($plan->id == $user->plan_id && !empty($user->plan_expired_date))
                                                            @if (Carbon::now()->gt(Carbon::parse($user->plan_expired_date)))
                                                                <!-- If plan is expired -->
                                                                <a href="javascript:void(0)" data-id="{{ $plan->id }}"
                                                                    class="mb-3 btn btn-primary d-flex justify-content-center align-items-center mx-sm-5"
                                                                    data-amount="{{ $plan->price }}">
                                                                    {{ __('Expire at') }}
                                                                    {{ Carbon::parse($user->plan_expired_date)->format('d/m/Y') }}
                                                                </a>
                                                                <a href="{{ route('payment', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                                                    class="mb-3 btn btn-primary d-flex justify-content-center align-items-center mx-sm-5">
                                                                    {{ __('Renew Now') }} <i
                                                                        class="ti ti-chevron-right ms-2"></i>
                                                                </a>
                                                            @else
                                                                <!-- If plan is active -->
                                                                <a style="margin-top: -30px" href="javascript:void(0)"
                                                                    data-id="{{ $plan->id }}"
                                                                    class="mb-3 btn btn-primary d-flex justify-content-center align-items-center mx-sm-5"
                                                                    data-amount="{{ $plan->price }}">
                                                                    {{ __('Expire at') }}
                                                                    {{ Carbon::parse($user->plan_expired_date)->format('d/m/Y') }}
                                                                </a>
                                                            @endif
                                                        @else
                                                            <!-- If user doesn't have this plan -->
                                                            <a style="margin-top: -30px"
                                                                href="{{ route('payment', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                                                class="mb-3 btn btn-primary d-flex justify-content-center align-items-center mx-sm-5">
                                                                {{ __('Buy Plan') }} <i class="ti ti-chevron-right ms-2"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
            </section>
        </div>
    @endhasrole
@endsection
@hasrole('Super Admin')
    @push('style')
        @include('layouts.includes.datatable-css')
    @endpush
    @push('script')
        @include('layouts.includes.datatable-js')
        {{ $dataTable->scripts() }}
    @endpush
@endhasrole
