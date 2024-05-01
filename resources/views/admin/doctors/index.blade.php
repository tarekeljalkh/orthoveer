@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.doctors') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.doctors') }}</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('messages.doctors') }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.doctors.create') }}" class="btn btn-success">{{ trans('messages.create_new') }} <i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('messages.first_name') }}</th>
                                            <th>{{ trans('messages.last_name') }}</th>
                                            <th>{{ trans('messages.email') }}</th>
                                            <th>{{ trans('image') }}</th>
                                            <th>{{ trans('messages.mobile') }}</th>
                                            <th>{{ trans('messages.landline') }}</th>
                                            <th>{{ trans('messages.address') }}</th>
                                            <th>{{ trans('messages.postal_code') }}</th>
                                            <th>{{ trans('messages.siret_number') }}</th>
                                            <th>{{ trans('messages.email_verified') }}</th>
                                            <th>{{ trans('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($doctors as $doctor)
                                            <tr>
                                                <td>{{ $doctor->first_name }}</td>
                                                <td>{{ $doctor->last_name }}</td>
                                                <td>{{ $doctor->email }}</td>
                                                <td><img style="width: 50px" src="{{ asset($doctor->image) }}"></td>
                                                <td>{{ $doctor->mobile }}</td>
                                                <td>{{ $doctor->landline }}</td>
                                                <td>{{ $doctor->address }}</td>
                                                <td>{{ $doctor->postal_code }}</td>
                                                <td>{{ $doctor->siret_number }}</td>
                                                @if ($doctor->email_verified_at)
                                                    <td>
                                                        <div class="badge badge-success">{{ trans('messages.yes') }}</div>
                                                    </td>
                                                @else
                                                    <td>
                                                        <div class="badge badge-danger">{{ trans('messages.no') }}</div>
                                                    </td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('admin.doctors.edit', $doctor->id) }}"
                                                        class="btn btn-primary">{{ trans('messages.edit') }}</a>


                                                    @if ($doctor->doctorScans->isNotEmpty())
                                                        <a href="{{ route('admin.doctors.show', $doctor->id) }}"
                                                            class="btn btn-info">{{ trans('messages.scans') }}</a>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        new DataTable('#example', {
            layout: {
                topStart: {
                    buttons: ['excel', 'pdf', 'print']
                }
            }
        });
    </script>
@endpush
