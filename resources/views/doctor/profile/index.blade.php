@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('messages.profile') }}</h1>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ trans('messages.update_user_settings') }}</h4>

                </div>
                <div class="card-body">
                    <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">{{ trans('messages.choose_image') }}</label>
                                <input type="file" name="image" id="image-upload" />
                              </div>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('messages.first_name') }}</label>
                            <input type="text" class="form-control" name="first_name" value="{{ auth()->user()->first_name }}">
                        </div>

                        <div class="form-group">
                            <label>{{ trans('messages.last_name') }}</label>
                            <input type="text" class="form-control" name="last_name" value="{{ auth()->user()->last_name }}">
                        </div>

                        <div class="form-group">
                            <label>{{ trans('messages.email') }}</label>
                            <input type="text" class="form-control" name="email" value="{{ auth()->user()->email }}">
                        </div>
                        <button class="btn btn-primary" type="submit">{{ trans('messages.save') }}</button>
                    </form>
                </div>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ trans('messages.update_password') }}</h4>

                </div>
                <div class="card-body">
                    <form action="{{ route('doctor.profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ trans('messages.current_password') }}</label>
                            <input type="password" class="form-control" name="current_password">
                        </div>

                        <div class="form-group">
                            <label>{{ trans('messages.new_password') }}</label>
                            <input type="password" class="form-control" name="password">
                        </div>

                        <div class="form-group">
                            <label>{{ trans('messages.confirm_password') }}</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>

                        <button class="btn btn-primary" type="submit">{{ trans('messages.save') }}</button>

                    </form>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>


        $(document).ready(function(){
            $('.image-preview').css({
                'background-image': 'url({{ asset(auth()->user()->image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        })
    </script>
@endpush
