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
                            <h4>All Print Files</h4>
                            <div class="card-header-action">
                                <a href="{{ route('lab.printfiles.create') }}" class="btn btn-success">{{ trans('messages.create_new') }} <i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="printfiles" class="display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Print File ID</th>
                                        <th>Scans</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($printFiles as $printFile)
                                        <tr>
                                            <td>{{ $printFile->id }}</td>
                                            <td>
                                                @if($printFile->scans->isEmpty())
                                                    <p>No scans associated</p>
                                                @else
                                                    <ul>
                                                        @foreach ($printFile->scans as $scan)
                                                            <li>{{ $scan->id }} - {{ $scan->doctor->last_name }}, {{ $scan->doctor->first_name }} - {{ $scan->patient->last_name }}, {{ $scan->patient->first_name }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-primary" href="{{ route('lab.printfiles.download', $printFile->id) }}"><i class="fas fa-download"></i> Download Print File</a>
                                                <div class="btn-group dropleft">
                                                    <button type="button" class="btn btn-dark dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropleft">
                                                        <a class="dropdown-item" href="{{ route('lab.printfiles.download', $printFile->id) }}"><i class="fas fa-download"></i> Download The File</a>
                                                        <a class="dropdown-item" href="{{ route('lab.printfiles.edit', $printFile->id) }}"><i class="fas fa-edit"></i> Edit Print File</a>
                                                        <form action="{{ route('lab.printfiles.destroy', $printFile->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item text-danger" type="submit"><i class="fas fa-trash"></i> Delete Print File</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <form action="{{ route('lab.printfiles.attach') }}" method="post">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="print_file_id">Select Print File to Attach Scans</label>
                                        <select name="print_file_id" id="print_file_id" class="form-control select2">
                                            @foreach ($printFiles as $printFile)
                                                <option value="{{ $printFile->id }}">{{ $printFile->id }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <table id="scans" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all"></th>
                                            <th>Scan ID</th>
                                            <th>Doctor</th>
                                            <th>Patient</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Type of Work</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($scans as $scan)
                                            <tr>
                                                <td><input type="checkbox" name="scan_ids[]" value="{{ $scan->id }}"></td>
                                                <td>{{ $scan->id }}</td>
                                                <td>Dr. {{ $scan->doctor->last_name }}, {{ $scan->doctor->first_name }}</td>
                                                <td>{{ $scan->patient->last_name }}, {{ $scan->patient->first_name }}</td>
                                                <td>{{ $scan->last_due_date->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="badge
                                                        {{ optional($scan->latestStatus)->status == 'new' ? 'badge-primary' : '' }}
                                                        {{ optional($scan->latestStatus)->status == 'downloaded' ? 'badge-light' : '' }}
                                                        {{ optional($scan->latestStatus)->status == 'pending' ? 'badge-warning' : '' }}
                                                        {{ optional($scan->latestStatus)->status == 'resubmitted' ? 'badge-info' : '' }}
                                                        {{ optional($scan->latestStatus)->status == 'completed' ? 'badge-success' : '' }}
                                                        {{ optional($scan->latestStatus)->status == 'rejected' ? 'badge-danger' : '' }}">
                                                        {{ trans('messages.' . optional($scan->latestStatus)->status) ?? trans('messages.no_status') }}
                                                    </div>
                                                </td>
                                                <td>{{ $scan->typeofwork->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">{{ trans('messages.attach_scans') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        new DataTable('#printfiles', {
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });

        // Select all checkbox
        $('#select-all').on('click', function(){
            var rows = table.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

        var table = new DataTable('#scans', {
            layout: {
                topStart: {
                    buttons: [
                        'excel',
                        'pdf',
                        'print',
                        {
                            text: '<i class="fa fa-download"></i> Download',
                            action: function(e, dt, node, config) {
                                var selectedData = dt.rows({ selected: true }).data().toArray();
                                if (selectedData.length === 1) {
                                    var scanId = selectedData[0][0];
                                    var url = "{{ route('lab.scans.downloadStl', ':id') }}".replace(':id', scanId);
                                    $.ajax({
                                        url: url,
                                        method: 'GET',
                                        xhrFields: {
                                            responseType: 'blob'
                                        },
                                        success: function(data) {
                                            var a = document.createElement('a');
                                            var url = window.URL.createObjectURL(data);
                                            a.href = url;
                                            a.download = 'stl-files-' + scanId + '.zip';
                                            document.body.appendChild(a);
                                            a.click();
                                            window.URL.revokeObjectURL(url);
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error:', status, error);
                                        }
                                    });
                                } else if (selectedData.length > 1) {
                                    var scanIds = selectedData.map(function(data) {
                                        return data[0];
                                    });
                                    var url = "{{ route('lab.scans.printMultiple') }}";
                                    $.ajax({
                                        url: url,
                                        method: 'POST',
                                        data: JSON.stringify({
                                            ids: scanIds,
                                            _token: '{{ csrf_token() }}'
                                        }),
                                        contentType: 'application/json',
                                        xhrFields: {
                                            responseType: 'blob'
                                        },
                                        success: function(data) {
                                            var a = document.createElement('a');
                                            var url = window.URL.createObjectURL(data);
                                            a.href = url;
                                            a.download = 'multiple-scans.zip';
                                            document.body.appendChild(a);
                                            a.click();
                                            window.URL.revokeObjectURL(url);
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error:', status, error);
                                        }
                                    });
                                }
                            }
                        },
                        {
                            text: '<i class="fa fa-file-pdf"></i> Print Prescriptions',
                            action: function(e, dt, node, config) {
                                var selectedData = dt.rows({ selected: true }).data().toArray();
                                if (selectedData.length === 1) {
                                    var scanId = selectedData[0][0];
                                    var url = "{{ route('lab.scans.printScan', ':id') }}".replace(':id', scanId);
                                    $.ajax({
                                        url: url,
                                        method: 'GET',
                                        xhrFields: {
                                            responseType: 'blob'
                                        },
                                        success: function(data) {
                                            var a = document.createElement('a');
                                            var url = window.URL.createObjectURL(data);
                                            a.href = url;
                                            a.download = 'prescription-' + scanId + '.pdf';
                                            document.body.appendChild(a);
                                            a.click();
                                            window.URL.revokeObjectURL(url);
                                        }
                                    });
                                } else if (selectedData.length > 1) {
                                    var scanIds = selectedData.map(function(data) {
                                        return data[0];
                                    });
                                    scanIds.forEach(function(scanId) {
                                        var url = "{{ route('lab.scans.printScan', ':id') }}".replace(':id', scanId);
                                        $.ajax({
                                            url: url,
                                            method: 'GET',
                                            xhrFields: {
                                                responseType: 'blob'
                                            },
                                            success: function(data) {
                                                var a = document.createElement('a');
                                                var url = window.URL.createObjectURL(data);
                                                a.href = url;
                                                a.download = 'prescription-' + scanId + '.pdf';
                                                document.body.appendChild(a);
                                                a.click();
                                                window.URL.revokeObjectURL(url);
                                            }
                                        });
                                    });
                                }
                            }
                        }
                    ]
                }
            },
            select: true
        });
    </script>
@endpush
