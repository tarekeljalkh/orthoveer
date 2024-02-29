@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Edit Doctor</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">Doctors</a></div>
                <div class="breadcrumb-item"><a href="#">Edit Doctor</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                {{-- Doctor Section --}}
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="post"
                            class="needs-validation" novalidate="" enctype="multipart/form-data">
                            @method('put')
                            @csrf

                            <div class="card-header">
                                <h4>Edit Doctor</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Image</label>
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label">Choose File</label>
                                            <input type="file" name="image" id="image-upload" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>First Name</label>
                                        <input type="text" name="first_name" class="form-control"
                                            value="{{ $doctor->first_name }}" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name" class="form-control"
                                            value="{{ $doctor->last_name }}" required="">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $doctor->email }}" required="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Mobile</label>
                                        <input type="number" name="mobile" value="{{ $doctor->mobile }}"
                                            class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Landline</label>
                                        <input type="number" name="landline" class="form-control"
                                            value="{{ $doctor->landline }}" required="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Address</label>
                                        <input type="text" name="address" value="{{ $doctor->address }}"
                                            class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Postal Code</label>
                                        <input type="text" name="postal_code" value="{{ $doctor->postal_code }}"
                                            class="form-control" required="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Verified</label>
                                        <select class="form-control" name="verified">
                                            <option value="yes" {{ $doctor->email_verified_at ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="no" {{ !$doctor->email_verified_at ? 'selected' : '' }}>No
                                            </option>
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
                {{-- End Doctor Section --}}

                {{-- Password Section --}}
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.doctors.updatePassword', $doctor->id) }}" method="post"
                            class="needs-validation" novalidate="" enctype="multipart/form-data">
                            @method('put')
                            @csrf

                            <div class="card-header">
                                <h4>Edit Password</h4>
                            </div>
                            <div class="card-body">


                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            required="">
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- End Password Section --}}

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.image-preview').css({
                'background-image': 'url({{ asset(auth()->user()->image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        })
    </script>
@endpush
