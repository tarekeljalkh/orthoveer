@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Add New Type of Work</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.type-of-works.index') }}">Type of Works</a></div>
                <div class="breadcrumb-item">Add New Type of Work</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.type-of-works.store') }}" method="post" class="needs-validation"
                            novalidate="" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4>Add New Type of Work</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ trans('messages.image') }}</label>
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload"
                                                id="image-label">{{ trans('messages.choose_image') }}</label>
                                            <input type="file" name="image" id="image-upload" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" required="">
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Lab Price</label>
                                        <input type="number" name="lab_price" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>My Price</label>
                                        <input type="number" name="my_price" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Cash Out</label>
                                        <input type="number" name="cash_out" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>My Benefit</label>
                                        <input type="number" name="my_benefit" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Accessories</label>
                                        <input type="number" name="accessories" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>VAT (%)</label>
                                        <input type="number" name="vat" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Select Primary Lab</label>
                                        <select class="form-control select2" id="lab_id" name="lab_id">
                                            @foreach ($labs as $lab)
                                                <option value="{{ $lab->id }}">{{ $lab->first_name }}
                                                    {{ $lab->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ trans('messages.lab_due_date') }}</label>
                                        <input name="lab_due_date" type="number" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Select Second Lab</label>
                                        <select class="form-control select2" id="second_lab_id" name="second_lab_id">
                                            <option value="">None</option>
                                            <!-- Set value to an empty string which represents null -->
                                            @foreach ($second_labs as $second_lab)
                                                <option value="{{ $second_lab->id }}">{{ $second_lab->first_name }}
                                                    {{ $second_lab->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ trans('messages.second_lab_due_date') }}</label>
                                        <input name="second_lab_due_date" type="number" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Select External Lab</label>
                                        <select class="form-control select2" id="external_lab_id" name="external_lab_id">
                                            <option value="">None</option>
                                            <!-- Set value to an empty string which represents null -->
                                            @foreach ($external_labs as $external_lab)
                                                <option value="{{ $external_lab->id }}">{{ $external_lab->first_name }}
                                                    {{ $external_lab->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ trans('messages.external_lab_due_date') }}</label>
                                        <input name="external_lab_due_date" type="number" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Doctor Specific Prices (Optional)</label>
                                        <div id="doctor-prices">
                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <select class="form-control select2"
                                                        name="doctor_prices[0][doctor_id]">
                                                        <option value="">Select Doctor</option>
                                                        @foreach ($doctors as $doctor)
                                                            <option value="{{ $doctor->id }}">{{ $doctor->first_name }}
                                                                {{ $doctor->last_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="number" name="doctor_prices[0][price]"
                                                        class="form-control" placeholder="Price">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success" id="add-doctor-price">Add Doctor
                                            Price</button>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            var doctorPriceIndex = 1;

            $('#add-doctor-price').on('click', function() {
            var newDoctorPrice = `
                <div class="row mb-2">
                    <div class="col-md-6">
                        <select class="form-control select2" name="doctor_prices[${doctorPriceIndex}][doctor_id]">
                            <option value="">Select Doctor</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->first_name }} {{ $doctor->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="number" name="doctor_prices[${doctorPriceIndex}][price]" class="form-control" placeholder="Price">
                    </div>
                </div>`;
            $('#doctor-prices').append(newDoctorPrice);
            doctorPriceIndex++;
            });
            });
        </script>
    @endpush
@endsection
