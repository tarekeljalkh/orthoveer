@extends('second_lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('second_lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>All Print Files</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('second_lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">All Print Files</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Attach Print Files to Scans</h4>
                        </div>
                        <div class="card-body">
                            <table id="scans" class="display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Scan ID</th>
                                        <th>Doctor</th>
                                        <th>Patient</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>PrintFile</th>
                                        <th>Type of Work</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scans as $scan)
                                        <tr>
                                            <td>{{ $scan->id }}</td>
                                            <td>Dr. {{ $scan->doctor->last_name }}, {{ $scan->doctor->first_name }}</td>
                                            <td>{{ $scan->patient->last_name }}, {{ $scan->patient->first_name }}</td>
                                            <td>{{ $scan->last_due_date->format('d/m/Y') }}</td>
                                            <td>
                                                <div
                                                    class="badge
                                                {{ optional($scan->latestStatus)->status == 'new' ? 'badge-primary' : '' }}
                                                {{ optional($scan->latestStatus)->status == 'downloaded' ? 'badge-light' : '' }}
                                                {{ optional($scan->latestStatus)->status == 'pending' ? 'badge-warning' : '' }}
                                                {{ optional($scan->latestStatus)->status == 'resubmitted' ? 'badge-info' : '' }}
                                                {{ optional($scan->latestStatus)->status == 'done' ? 'badge-success' : '' }}
                                                {{ optional($scan->latestStatus)->status == 'rejected' ? 'badge-danger' : '' }}">
                                                    {{ trans('messages.' . optional($scan->latestStatus)->status) ?? trans('messages.no_status') }}
                                                </div>
                                            </td>
                                            <td>
                                                @if ($scan->printFiles->isEmpty())
                                                    No Print Files
                                                @else
                                                    @foreach ($scan->printFiles as $printFile)
                                                        <a href="{{ route('second_lab.printfiles.download', $printFile->id) }}"
                                                            class="btn btn-link">Download</a>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>{{ $scan->typeofwork->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        new DataTable('#scans', {
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    </script>
@endpush
