@extends('lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.all_scans') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.all_scans') }}</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('messages.all_scans') }}</h4>
                        </div>
                        <div class="card-body">
                            <table id="example" class="display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{ trans('messages.doctor') }}</th>
                                        <th>{{ trans('messages.due_date') }}</th>
                                        <th>{{ trans('messages.note') }}</th>
                                        <th>{{ trans('messages.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scans as $scan)
                                        <tr onclick="window.location='{{ route('lab.scans.show', $scan->id) }}';"
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
                                                    {{ trans('messages.' . optional($scan->latestStatus)->status) ?? trans('messages.no_status') }}
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
