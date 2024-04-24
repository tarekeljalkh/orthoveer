@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.patients.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.patient') }}: {{ $patient->last_name }}, {{ $patient->first_name }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.patients.index') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('messages.patient') }}</div>
            </div>
        </div>
        <div class="section-body">

            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-3">
                    <div class="card profile-widget">
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">{{ trans('messages.patient_name') }}: <div
                                    class="text-muted d-inline font-weight-normal">
                                    <div class="slash"></div><a href="{{ route('doctor.patients.edit', $patient->id) }}"><i
                                            class="fas fa-user-edit"></i></a>
                                </div>
                            </div>
                            {{ $patient->last_name }}, {{ $patient->first_name }}
                            <br>
                            <br>
                            <a href="{{ route('doctor.scans.new', $patient->id) }}" class="btn btn-outline-primary">{{ trans('messages.new_scan') }}</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-9">
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate="">
                            <div class="card-header">
                                <h4>{{ trans('messages.scans') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('messages.id') }}</th>
                                                <th>{{ trans('messages.scan_date') }}</th>
                                                <th>{{ trans('messages.procedure') }}</th>
                                                <th>{{ trans('messages.status')}}</th>
                                                <th>{{ trans('messages.note') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($patient->scans as $scan)
                                            <tr onclick="window.location='{{ route('doctor.orders.edit', $scan->id) }}';" style="cursor:pointer;">
                                                <td>{{ $scan->id }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($scan->scan_date)->format('d/m/Y') }}</td>
                                                    <td>{{ $scan->typeofwork->name }}</td>
                                                    <td>

                                                        @isset($scan->latestStatus)
                                                            <div
                                                                class="badge
                                                                    {{ $scan->latestStatus->status == 'pending' ? 'badge-primary' : '' }}
                                                                    {{ $scan->latestStatus->status == 'resubmitted' ? 'badge-warning' : '' }}
                                                                    {{ $scan->latestStatus->status == 'delivered' ? 'badge-info' : '' }}
                                                                    {{ $scan->latestStatus->status == 'completed' ? 'badge-success' : '' }}
                                                                    {{ $scan->latestStatus->status == 'rejected' ? 'badge-danger' : '' }}">
                                                                {{ $scan->latestStatus->status }}
                                                            </div>
                                                        @endisset
                                                    </td>

                                                    <td>{{ optional($scan->latestStatus)->note }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </form>
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
