@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.edit') }} {{ trans('messages.external_lab') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.labs.index') }}">{{ trans('messages.external_labs') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.edit') }} {{ trans('messages.external_lab') }}</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                {{-- External Lab Section --}}
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.external_labs.update', $external_lab->id) }}" method="post" class="needs-validation"
                            novalidate="" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="card-header">
                                <h4>{{ trans('messages.edit') }} {{ trans('messages.external_lab') }}</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ trans('messages.image') }}</label>
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label">{{ trans('messages.choose_image') }}</label>
                                            <input type="file" name="image" id="image-upload" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.first_name') }}</label>
                                        <input type="text" name="first_name" class="form-control"
                                            value="{{ $external_lab->first_name }}" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.last_name') }}</label>
                                        <input type="text" name="last_name" class="form-control"
                                            value="{{ $external_lab->last_name }}" required="">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ trans('messages.email') }}</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $external_lab->email }}" required="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ trans('messages.mobile') }}</label>
                                        <input type="number" name="mobile" class="form-control"
                                            value="{{ $external_lab->mobile }}" required="">
                                    </div>
                                </div>

                                <div class="form-group col-md-12 col-12">
                                    <label>{{ trans('messages.email_verified') }}</label>
                                    <select class="form-control" name="verified">
                                        <option value="yes" {{ $external_lab->email_verified_at ? 'selected' : '' }}>{{ trans('messages.yes') }}
                                        </option>
                                        <option value="no" {{ !$external_lab->email_verified_at ? 'selected' : '' }}>{{ trans('messages.no') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">{{ trans('messages.update') }}</button>
                            </div>

                    </div>
                    </form>
                </div>
            </div>
            {{-- End External Lab Section --}}

            {{-- Password Section --}}
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('admin.external_labs.updatePassword', $external_lab->id) }}" method="post"
                        class="needs-validation" novalidate="" enctype="multipart/form-data">
                        @method('put')
                        @csrf

                        <div class="card-header">
                            <h4>{{ trans('messages.edit_password') }}</h4>
                        </div>
                        <div class="card-body">


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

                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">{{ trans('messages.update_password') }}</button>
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
                'background-image': 'url({{ asset($external_lab->image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        })
    </script>
@endpush
