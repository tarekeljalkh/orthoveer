@extends('lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.pending_scans') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.pending_scans') }}</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('messages.pending_scans') }}</h4>
                        </div>
                        <div class="card-body">
                            <table id="pending" class="display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th hidden>ID</th> <!-- Hidden ID Column -->
                                        <th>Doctor Name</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Note</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendingScans as $scan)
                                        <tr>
                                            <td style="display:none;">{{ $scan->id }}</td> <!-- Hidden ID Cell -->
                                            <td>Dr. {{ $scan->doctor->last_name }}, {{ $scan->doctor->first_name }}
                                            </td>
                                            <td>{{ $scan->due_date->format('d/m/Y') }}</td>
                                            <td>
                                                <div
                                                    class="badge
                                                    {{ $scan->latestStatus->status == 'pending' ? 'badge-warning' : '' }}
                                                    {{ $scan->latestStatus->status == 'delivered' ? 'badge-info' : '' }}
                                                    {{ $scan->latestStatus->status == 'completed' ? 'badge-success' : '' }}
                                                    {{ $scan->latestStatus->status == 'rejected' ? 'badge-danger' : '' }}">
                                                    {{ $scan->latestStatus->status }}
                                                </div>
                                            </td>
                                            <td>{{ $scan->latestStatus->note }}</td>
                                            <td>
                                                <div class="btn-group dropleft">
                                                    <button type="button" class="btn btn-dark dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropleft">
                                                        <a class="dropdown-item"
                                                            href="{{ route('lab.scans.viewer', $scan->id) }}">Open
                                                            Viewer</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('lab.scans.prescription', $scan->id) }}">Open
                                                            Prescription</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item"
                                                            href="{{ route('lab.scans.printScan', $scan->id) }}"><i
                                                                class="fas fa-print"></i>
                                                            Print Prescription</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('lab.scans.downloadStl', $scan->id) }}"><i
                                                                class="fas fa-download"></i> Download The Scan</a>
                                                    </div>
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
        new DataTable('#pending', {
            layout: {
                topStart: {
                    buttons: [
                        'excel',
                        'pdf',
                        'print',
                        {
                            text: '<i class="fa fa-download"></i> Download',
                            action: function(e, dt, node, config) {
                                var selectedData = dt.rows({
                                    selected: true
                                }).data().toArray();

                                if (selectedData.length === 1) {
                                    var scanId = selectedData[0][0];
                                    var url = "{{ route('lab.scans.downloadStl', ':id') }}".replace(':id',
                                        scanId);

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
                                        }), // Send as JSON string
                                        contentType: 'application/json', // Specify content type as JSON
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
                                var selectedData = dt.rows({
                                    selected: true
                                }).data().toArray();

                                if (selectedData.length === 1) {
                                    // Single selection
                                    var scanId = selectedData[0][0]; // Assuming scan ID is at index 0
                                    var url = "{{ route('lab.scans.printScan', ':id') }}".replace(':id',
                                        scanId);

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
                                    // Multiple selections
                                    var scanIds = selectedData.map(function(data) {
                                        return data[0];
                                    }); // Assuming scan ID is at index 0

                                    scanIds.forEach(function(scanId) {
                                        var url = "{{ route('lab.scans.printScan', ':id') }}"
                                            .replace(':id', scanId);

                                        $.ajax({
                                            url: url,
                                            method: 'GET',
                                            xhrFields: {
                                                responseType: 'blob'
                                            },
                                            success: function(data) {
                                                var a = document.createElement('a');
                                                var url = window.URL.createObjectURL(
                                                    data);
                                                a.href = url;
                                                a.download = 'prescription-' + scanId +
                                                    '.pdf';
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

        // new DataTable('#pending', {
        //     dom: 'Bfrtip', // Define the elements in the control layout
        //     buttons: [{
        //             extend: 'copyHtml5',
        //             text: '<i class="fas fa-files-o"></i>', // Using FontAwesome icons
        //             titleAttr: 'Copy'
        //         },

        //         <
        //         i class = "fas fa-file-excel" > < /i> {
        //             extend: 'excelHtml5',
        //             text: '<i class="fa fa-file-excel-o"></i>',
        //             titleAttr: 'Excel'
        //         },
        //         {
        //             extend: 'csvHtml5',
        //             text: '<i class="fa fa-file-text-o"></i>',
        //             titleAttr: 'CSV'
        //         },
        //         {
        //             extend: 'pdfHtml5',
        //             text: '<i class="fa fa-file-pdf-o"></i>',
        //             titleAttr: 'PDF'
        //         },
        //         {
        //             extend: 'print',
        //             text: '<i class="fa fa-print"></i> Print all (not just selected)',
        //             titleAttr: 'Print',
        //             exportOptions: {
        //                 modifier: {
        //                     selected: null
        //                 }
        //             }
        //         }
        //     ],
        //     select: true
        // });
    </script>
@endpush
