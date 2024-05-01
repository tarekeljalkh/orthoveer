@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.external_labs') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.external_labs') }}</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('messages.external_labs') }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.external_labs.create') }}" class="btn btn-success">{{ trans('messages.create_new') }} <i
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
                                            <th>{{ trans('messages.image') }}</th>
                                            <th>{{ trans('messages.mobile')}}</th>
                                            <th>{{ trans('messages.email_verified') }}</th>
                                            <th>{{ trans('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($external_labs as $external_lab)
                                            <tr>
                                                <td>{{ $external_lab->first_name }}</td>
                                                <td>{{ $external_lab->last_name }}</td>
                                                <td>{{ $external_lab->email }}</td>
                                                <td><img style="width: 50px" src="{{ asset($external_lab->image) }}"></td>
                                                <td>{{ $external_lab->mobile }}</td>
                                                @if ($external_lab->email_verified_at)
                                                    <td>
                                                        <div class="badge badge-success">{{ trans('messages.yes') }}</div>
                                                    </td>
                                                @else
                                                    <td>
                                                        <div class="badge badge-danger">{{ trans('no') }}</div>
                                                    </td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('admin.external_labs.edit', $external_lab->id) }}"
                                                        class="btn btn-primary">{{ trans('messages.edit') }}</a>

                                                    <a href="{{ route('admin.external_labs.destroy', $external_lab->id) }}"
                                                        class="btn btn-danger delete-item">{{ trans('messages.delete') }}</a>

                                                        @if ($external_lab->externalLabScans->isNotEmpty())
                                                        <a href="{{ route('admin.external_labs.show', $external_lab->id) }}"
                                                            class="btn btn-info">{{ trans('messages.see scans') }}</a>
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
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    </script>
@endpush
