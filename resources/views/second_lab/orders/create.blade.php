@extends('second_lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('second_lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.create_new_order') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('second_lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ route('second_lab.orders.index') }}">{{ trans('messages.dhl_orders') }}</a></div>
                <div class="breadcrumb-item">{{ trans('messages.create_new_order') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('second_lab.orders.store') }}" method="post" class="needs-validation" novalidate>
                            @csrf
                            <div class="card-header">
                                <h4>{{ trans('messages.create_new_order') }}</h4>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="second_lab_id" value="{{ auth()->user()->id }}">

                                <div class="form-group col-md-12 col-12">
                                    <label for="scans">Select Scans:</label>
                                    <select class="form-control select2" name="scans[]" id="scans" multiple required>
                                        @foreach ($completedScans as $scan)
                                            <option value="{{ $scan->id }}">{{ $scan->name }} - {{ $scan->id }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select at least one scan.
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">{{ trans('messages.place_order') }}</button>
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
