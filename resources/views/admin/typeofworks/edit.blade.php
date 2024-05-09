@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Edit Type of Work</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.type-of-works.index') }}">Type of Work</a></div>
            <div class="breadcrumb-item">Edit Type of Work</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('admin.type-of-works.update', $typeofwork->id) }}" method="post" class="needs-validation"
                        novalidate="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4>Edit Type of Works</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $typeofwork->name }}" required="">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Lab Price</label>
                                    <input type="number" name="lab_price" class="form-control" value="{{ $typeofwork->lab_price }}" required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Bag Coule</label>
                                    <input type="number" name="bag_coule" class="form-control" value="{{ $typeofwork->bag_coule }}" required="">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>My Price</label>
                                    <input type="number" name="my_price" class="form-control" value="{{ $typeofwork->my_price }}" required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Invoice To</label>
                                    <input type="number" name="invoice_to" class="form-control" value="{{ $typeofwork->invoice_to }}" required="">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Cash Out</label>
                                    <input type="number" name="cash_out" class="form-control" value="{{ $typeofwork->cash_out }}" required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>My Benefit</label>
                                    <input type="number" name="my_benefit" class="form-control" value="{{ $typeofwork->my_benefit }}" required="">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Accessories</label>
                                    <input type="number" name="accessories" class="form-control" value="{{ $typeofwork->accessories }}" required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Select Primary Lab</label>
                                    <select class="form-control" id="primary_lab" name="lab_id">
                                        @foreach ($labs as $lab)
                                            <option value="{{ $lab->id }}" @if($lab->id == $typeofwork->lab_id) selected @endif>
                                                {{ $lab->first_name }} {{ $lab->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Select Secondary Lab (Optional)</label>
                                    <select class="form-control" id="secondary_lab" name="second_lab_id">
                                        <option value="">None</option>
                                        @foreach ($labs as $lab)
                                            <option value="{{ $lab->id }}" @if($lab->id == $typeofwork->second_lab_id) selected @endif>
                                                {{ $lab->first_name }} {{ $lab->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const primaryLabSelect = document.getElementById('primary_lab');
        const secondaryLabSelect = document.getElementById('secondary_lab');

        function updateDisabledOptions() {
            const primarySelected = primaryLabSelect.value;
            const secondarySelected = secondaryLabSelect.value;

            Array.from(primaryLabSelect.options).forEach(option => {
                option.disabled = option.value === secondarySelected && secondarySelected !== '';
            });

            Array.from(secondaryLabSelect.options).forEach(option => {
                option.disabled = option.value === primarySelected && primarySelected !== '';
            });
        }

        primaryLabSelect.addEventListener('change', updateDisabledOptions);
        secondaryLabSelect.addEventListener('change', updateDisabledOptions);

        // Initialize on page load
        updateDisabledOptions();
    });
</script>
@endpush

@endsection
