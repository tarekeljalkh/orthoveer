@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>New Scan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">New Scan</a></div>
            </div>
        </div>

        <div class="section-body">
            <form action="{{ route('doctor.scans.new.store', $patient->id) }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- Doctor Section --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Doctor:</label>
                                        <label class="form-control">Dr. {{ auth()->user()->last_name }},
                                            {{ auth()->user()->first_name }}</label>
                                    </div>
                                    <input type="hidden" name="doctor_id" value="{{ auth()->user()->id }}">
                                    <div class="form-group col-md-6 col-12">
                                        <label>License:</label>
                                        <label class="form-control">License:</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Doctor Section --}}

                    {{-- Patient Section --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Patient:</h4>
                                {{-- <div class="card-header-action">
                                    <a href="{{ route('doctor.patients.create') }}" class="btn btn-success">Add New Patient <i class="fas fa-plus"></i></a>
                                </div> --}}
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    {{-- Send Patient ID --}}
                                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                                    <div class="form-group col-md-6 col-12">
                                        <label>First Name</label>
                                        <input name="patient_first_name" type="text" class="form-control" value="{{ $patient->first_name }}" disabled>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Last Name</label>
                                        <input name="patient_last_name" type="text" class="form-control" value="{{ $patient->last_name }}" disabled>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>Date Of Birth</label>
                                        <input name="patient_dob" type="date" class="form-control" value="{{ $patient->dob->format('Y-m-d') }}" disabled>
                                    </div>

                                    <div class="form-group col-md-5 col-12">
                                        <label class="form-label">Gender</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="patient_gender" value="male" class="selectgroup-input" checked="" disabled>
                                                <span class="selectgroup-button">Male</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="patient_gender" value="female" class="selectgroup-input" disabled>
                                                <span class="selectgroup-button">Female</span>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Chart Number:</label>
                                        <input class="form-control" type="text"  name="chart_number" value="{{ $patient->chart_number }}" disabled>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- End Patient Section --}}


                    {{-- Order Section --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Order:</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>Due Date</label>
                                        <input type="date" name="due_date" class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Send To</label>
                                        <select class="form-control select2" name="lab">
                                            @foreach ($labs as $lab)
                                                <option value="{{ $lab->id }}">{{ $lab->first_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>STL UPPER</label>
                                        <input type="file" name="stl_upper" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>STL LOWER</label>
                                        <input type="file" name="stl_lower" class="form-control">
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- End Order Section --}}


                    {{-- Notes --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Notes:</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group col-12">
                                        <textarea class="form-control" name="notes" id="notes" cols="30" rows="10" placeholder="Add Note"></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Done</button>
                            </div>

                        </div>


                    </div>
                    {{-- End Notes --}}

                </div>
            </form>

        </div>
    </section>
@endsection

@push('scripts')
@endpush
