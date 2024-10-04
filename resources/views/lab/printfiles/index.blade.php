@extends('lab.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>All Print Files</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
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
                                    <th>Action</th>
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
                                                {{ optional($scan->latestStatus)->status == 'completed' ? 'badge-success' : '' }}
                                                {{ optional($scan->latestStatus)->status == 'rejected' ? 'badge-danger' : '' }}">
                                            {{ trans('messages.' . optional($scan->latestStatus)->status) ?? trans('messages.no_status') }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($scan->printFiles->isEmpty())
                                            No Print Files
                                        @else
                                            @foreach ($scan->printFiles as $printFile)
                                                <a href="{{ asset('storage/' . $printFile->file_path) }}" class="btn btn-link" target="_blank">Download</a>
                                                <a href="{{ route('lab.printfiles.edit', $printFile->id) }}" class="btn btn-warning">Edit</a>
                                                <form action="{{ route('lab.printfiles.destroy', $printFile->id) }}" method="post" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this file?');">Delete</button>
                                                </form>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $scan->typeofwork->name }}</td>
                                    <td>
                                        <a href="{{ route('lab.printfiles.create', $scan->id) }}" class="btn btn-primary">Add Print File</a>
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
    new DataTable('#scans', {
        layout: {
            topStart: {
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            }
        }
    });
</script>
@endpush
