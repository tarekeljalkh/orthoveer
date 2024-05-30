@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.add_new_doctor') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">{{ trans('messages.doctors') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.add_new_doctor') }}</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                {{-- Doctor Section --}}
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.doctors.store') }}" method="post" class="needs-validation"
                            novalidate="" enctype="multipart/form-data">
                            @csrf

                            <div class="card-header">
                                <h4>{{ trans('messages.add_new_doctor') }}</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Image</label>
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label">{{ trans('messages.choose_image') }}</label>
                                            <input type="file" name="image" id="image-upload" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.first_name') }}</label>
                                        <input type="text" name="first_name" class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.last_name') }}</label>
                                        <input type="text" name="last_name" class="form-control" required="">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ trans('messages.email') }}</label>
                                        <input type="email" name="email" class="form-control" required="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.mobile') }}</label>
                                        <input type="number" name="mobile" class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.landline') }}</label>
                                        <input type="number" name="landline" class="form-control" required="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.address') }}</label>
                                        <input type="text" name="address" class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.postcode') }}</label>
                                        <input type="text" name="postcode" class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.country') }}</label>
                                        <input type="text" name="country" class="form-control" required="">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.street') }}</label>
                                        <input type="text" name="street" class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.suburb') }}</label>
                                        <input type="text" name="suburb" class="form-control" required="">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.current_password') }}</label>
                                        <input type="password" name="password" class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.confirm_password') }}</label>
                                        <input type="password" name="password_confirmation" class="form-control" required="">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ trans('messages.email_verified') }}</label>
                                        <select class="form-control" name="verified">
                                            <option value="yes">{{ trans('yes') }}</option>
                                            <option value="no">{{ trans('no') }}</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">{{ trans('messages.add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- End Doctor Section --}}

            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('image-preview').css({
            'background-image': 'url({{ asset(auth()->user()->avatar) }})',
            'background-size': 'cover',
            'background-position': 'center center'
        })
    })
    </script>
@endpush
