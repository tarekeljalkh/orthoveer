@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.edit_patient') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ route('doctor.patients.index') }}">{{ trans('messages.patients') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.edit_patient') }}</a></div>
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
                                <h4>{{ trans('messages.edit_patient') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.first_name') }}</label>
                                        <input type="text" name="first_name" class="form-control" value="{{ $patient->first_name }}" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.last_name') }}</label>
                                        <input type="text" name="last_name" class="form-control" value="{{ $patient->last_name }}" required="">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.date_of_birth') }}</label>
                                        <input type="date" name="dob" class="form-control" value="{{ date('Y-m-d', strtotime($patient->dob)) }}" required="">
                                    </div>

                                    <div class="form-group col-md-5 col-12">
                                        <label class="form-label">{{ trans('messages.gender') }}</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="gender" value="male"
                                                    class="selectgroup-input" {{ $patient->gender === 'male' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">{{ trans('messages.male') }}</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="gender" value="female"
                                                    class="selectgroup-input" {{ $patient->gender === 'female' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">{{ trans('messages.female') }}</span>
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                <input type="hidden" name="doctor_id" value="{{ auth()->user()->id }}">

                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">{{ trans('messages.update') }}</button>
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
