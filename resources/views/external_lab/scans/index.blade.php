@extends('external_lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('external_lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Scans</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('external_lab.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Scans</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Scans</h4>
                        </div>
                        <div class="card-body">
                            <table id="example" class="display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Doctor Name</th>
                                        <th>Due Date</th>
                                        <th>Note</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scans as $scan)
                                        <tr onclick="window.location='{{ route('external_lab.scans.show', $scan->id) }}';"
                                            style="cursor:pointer;">
                                            <td>Dr. {{ $scan->doctor->last_name }}, {{ $scan->doctor->first_name }}</td>
                                            <td>{{ $scan->due_date->format('d/m/Y') }}</td>
                                            <td>{{ optional($scan->latestStatus)->note }}</td>
                                            <td>
                                                <div
                                                    class="badge
                                                        {{ optional($scan->latestStatus)->status == 'pending' ? 'badge-warning' : '' }}
                                                        {{ optional($scan->latestStatus)->status == 'resubmitted' ? 'badge-info' : '' }}
                                                        {{ optional($scan->latestStatus)->status == 'completed' ? 'badge-success' : '' }}
                                                        {{ optional($scan->latestStatus)->status == 'rejected' ? 'badge-danger' : '' }}">
                                                    {{ optional($scan->latestStatus)->status ?? 'No status' }}
                                                </div>
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
