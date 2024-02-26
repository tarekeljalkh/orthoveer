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

            <div class="row">

                {{-- Doctor Section --}}
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Doctor:</label>
                                    <label class="form-control">Dr. {{ auth()->user()->last_name }}, {{ auth()->user()->first_name }}</label>
                                </div>

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
                        <form method="post" class="needs-validation" novalidate="">
                            <div class="card-header">
                                <h4>Patient:</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" value="Ujang" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" value="Maman" required="">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>Date Of Birth</label>
                                        <input type="date" class="form-control" value="ujang@maman.com" required="">
                                    </div>

                                    <div class="form-group col-md-5 col-12">
                                        <label class="form-label">Gender</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="value" value="50"
                                                    class="selectgroup-input" checked="">
                                                <span class="selectgroup-button">Male</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="value" value="100"
                                                    class="selectgroup-input">
                                                <span class="selectgroup-button">Female</span>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Chart Number:</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- End Patient Section --}}

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
                    </div>
                </div>
                {{-- End Notes --}}
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
