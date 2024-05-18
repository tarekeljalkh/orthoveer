@extends('second_lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.create_new_order') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('second_lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ route('second_lab.orders.index') }}">{{ trans('messages.orders') }}</a>
                </div>
                <div class="breadcrumb-item">{{ trans('messages.create_new_order') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">

                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('second_lab.orders.store') }}" method="post" class="needs-validation" novalidate
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4>{{ trans('messages.create_new_order') }}</h4>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="second_lab_id" value="{{ auth()->user()->id }}">

                                <div class="form-group col-md-12 col-12">
                                    <label for="scans">Select Scans:</label>
                                    <select class="form-control select2" name="scans[]" id="scans" multiple>
                                        @foreach ($completedScans as $scan)
                                            <option value="{{ $scan->id }}">{{ $scan->name }} - {{ $scan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.status') }}</label>
                                        <select class="form-control" name="status" required>
                                            <option value="pending">Pending</option>
                                            <option value="shipped">Shipped</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.date') }}</label>
                                        <input type="date" class="form-control" name="date" required>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.to_name') }}</label>
                                        <input type="text" class="form-control" name="to_name" required>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.destination_street') }}</label>
                                        <input type="text" class="form-control" name="destination_street" required>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.destination_city') }}</label>
                                        <input type="text" class="form-control" name="destination_city" required>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.destination_state') }}</label>
                                        <input type="text" class="form-control" name="destination_state" required>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.destination_country') }}</label>
                                        <input type="text" class="form-control" name="destination_country" required>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.destination_postcode') }}</label>
                                        <input type="text" class="form-control" name="destination_postcode" required>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.destination_email') }}</label>
                                        <input type="email" class="form-control" name="destination_email">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.destination_phone') }}</label>
                                        <input type="tel" class="form-control" name="destination_phone" required>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.item_name') }}</label>
                                        <input type="text" class="form-control" name="item_name">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.item_price') }}</label>
                                        <input type="number" class="form-control" name="item_price" step="0.01">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.weight') }}</label>
                                        <input type="number" class="form-control" name="weight" step="0.01">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.shipping_method') }}</label>
                                        <input type="text" class="form-control" name="shipping_method">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.reference') }}</label>
                                        <input type="text" class="form-control" name="reference">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.sku') }}</label>
                                        <input type="text" class="form-control" name="sku">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.qty') }}</label>
                                        <input type="number" class="form-control" name="qty">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.company') }}</label>
                                        <input type="text" class="form-control" name="company">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.carrier') }}</label>
                                        <input type of="text" class="form-control" name="carrier">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.carrier_product_code') }}</label>
                                        <input type of="text" class="form-control" name="carrier_product_code">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit"
                                    class="btn btn-primary">{{ trans('messages.place_order') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
