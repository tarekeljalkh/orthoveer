@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Edit Patient</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('doctor.patients.index') }}">Patients</a></div>
                <div class="breadcrumb-item"><a href="#">Edit Patient</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                {{-- Patient Section --}}
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('doctor.patients.update', $patient->id) }}" method="post" class="needs-validation" novalidate="">
                            @csrf
                            @method('put')

                            <div class="card-header">
                                <h4>Edit Patient</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>First Name</label>
                                        <input type="text" name="first_name" class="form-control" value="{{ $patient->first_name }}" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name" class="form-control" value="{{ $patient->last_name }}" required="">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>Date Of Birth</label>
                                        <input type="date" name="dob" class="form-control" value="{{ $patient->dob->format('d/m/y') }}" required="">
                                    </div>

                                    <div class="form-group col-md-5 col-12">
                                        <label class="form-label">Gender</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="gender" value="male"
                                                    class="selectgroup-input" {{ $patient->gender === 'male' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">Male</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="gender" value="female"
                                                    class="selectgroup-input" {{ $patient->gender === 'female' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">Female</span>
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                <input type="hidden" name="doctor_id" value="{{ auth()->user()->id }}">

                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- End Patient Section --}}

            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
