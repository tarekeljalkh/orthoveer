@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.patients') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('doctor.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.patients') }}</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('messages.all_patients') }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('doctor.patients.create') }}"
                                    class="btn btn-success">{{ trans('messages.add_new_patient') }} <i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('messages.name') }}</th>
                                            <th>{{ trans('messages.chart_number') }}</th>
                                            <th>{{ trans('messages.date_of_birth') }}</th>
                                            <th>{{ trans('messages.scans_count') }}</th>
                                            <th>{{ trans('messages.last_scan_date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($patients as $patient)
                                            <tr onclick="window.location='{{ route('doctor.patients.show', $patient->id) }}';"
                                                style="cursor:pointer;">
                                                <td>{{ $patient->last_name }}, {{ $patient->first_name }}</td>
                                                <td>{{ $patient->chart_number }}</td>
                                                <td>{{ $patient->dob->format('d/m/Y') }}</td>
                                                <td>{{ count($patient->scans) }}</td>
                                                    {{-- <td>{{ \Carbon\Carbon::parse($patient->lastScan->scan_date)->format('d/m/Y') }}
                                                    </td> --}}
                                                    <td>
                                                        {{ $patient->lastScan ? \Carbon\Carbon::parse($patient->lastScan->scan_date)->format('d/m/Y') : 'No scan available' }}
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
