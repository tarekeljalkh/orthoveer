@extends('lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Create New Order</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('lab.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('lab.orders.index') }}">Orders</a></div>
                <div class="breadcrumb-item"><a href="#">Create New Order</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                {{-- Order Section --}}
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('lab.orders.store') }}" method="post" class="needs-validation"
                            novalidate="" enctype="multipart/form-data">
                            @csrf

                            <div class="card-header">
                                <h4>Create New Order</h4>
                            </div>
                            <div class="card-body">

                                <!-- Scan Select -->

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label for="scans">Select Scans:</label>
                                        <select class="form-control select2" name="scans[]" id="scans" multiple>
                                            @foreach ($completedScans as $scan)
                                                <option value="{{ $scan->id }}">{{ $scan->name }} -
                                                    {{ $scan }}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                </div>
                                <!-- End Scan Select -->

                                <!-- DHL Credentials -->
                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label for="tracking_number">DHL Tracking Number:</label>
                                        <input type="text" class="form-control" id="tracking_number"
                                            name="tracking_number" required>
                                    </div>
                                </div>
                                <!-- End DHL Credentials -->

                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">Place Order</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- End Order Section --}}

            </div>
        </div>
    </section>
@endsection

