@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('messages.welcome') }} {{ trans('messages.doctor') }}</h1>
        </div>
        <div class="row">

            {{-- Clickable div
            <a href="#" style="text-decoration:none; color: inherit;">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12" onclick="location.href='/your-desired-route';" style="cursor: pointer;">
             Clickable div --}}

            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <a href="{{ route('doctor.orders.index') }}"
                    style="text-decoration:none; color: inherit;">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('messages.new_cases') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $currentOrders }}
                            </div>
                        </div>
                    </div>
                </a>

            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <a href="{{ route('doctor.orders.delivered') }}" style="text-decoration:none; color: inherit;">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('messages.delivered') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $deliveredOrders }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <a href="{{ route('doctor.orders.rejected') }}"
                    style="text-decoration:none; color: inherit;">

                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('messages.rejected_orders') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $rejectedOrders }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <div class="section-body">
        </div>
    </section>
@endsection
