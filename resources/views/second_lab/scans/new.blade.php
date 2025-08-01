@extends('second_lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('second_lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.new_scans') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('second_lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.new_scans') }}</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('messages.new_scans') }}</h4>
                        </div>
                        <div class="card-body">

                            <button id="print-prescriptions" class="btn btn-primary"><i class="fa fa-file-pdf"></i> Print
                                Prescriptions</button>
                            <button id="download-scans" class="btn btn-danger"><i class="fa fa-download"></i> Download
                                Scans</button>

                            <table id="scans" class="display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th hidden>ID</th> <!-- Hidden ID Column -->
                                        <th><input type="checkbox" id="select-all"></th>
                                        <th>Doctor Name</th>
                                        <th>Patient Name</th>
                                        <th>ID Number</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Note</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($newScans as $scan)
                                        <tr>
                                            <td style="display:none;">{{ $scan->id }}</td> <!-- Hidden ID Cell -->
                                            <td><input type="checkbox" class="select-row" data-id="{{ $scan->id }}">
                                            </td>
                                            <td>Dr. {{ $scan->doctor->last_name }}, {{ $scan->doctor->first_name }}
                                            </td>
                                            <td>
                                                {{ $scan->patient->first_name }} {{ $scan->patient->last_name }}
                                            </td>
                                            <td>
                                                {{ $scan->id }}
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
                                                            href="{{ route('second_lab.scans.viewer', $scan->id) }}">Open
                                                            Viewer</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('second_lab.scans.prescription', $scan->id) }}">Open
                                                            Prescription</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item"
                                                            href="{{ route('second_lab.scans.printScan', $scan->id) }}"><i
                                                                class="fas fa-print"></i>
                                                            Print Prescription</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('second_lab.scans.downloadStl', $scan->id) }}"><i
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
        $(document).ready(function() {
            var table = $('#scans').DataTable({
                order: [
                    [4, 'desc']
                ], // Sort by due date column in ascending order
                dom: 'Bfrtip', // Define the elements in the control layout
                buttons: [
                    'excel',
                    'pdf',
                    'print'
                ],
            });

            function toggleActionButtons() {
                var count = $('.select-row:checked').length;
                var anyChecked = count > 0;
                $('#print-prescriptions').prop('disabled', !anyChecked).toggleClass('no-click', !anyChecked);
                $('#download-scans').prop('disabled', !anyChecked).toggleClass('no-click', !anyChecked);

                if (anyChecked) {
                    $('#print-prescriptions').text('Print Prescriptions (' + count + ')');
                    $('#download-scans').text('Download Scans (' + count + ')');
                } else {
                    $('#print-prescriptions').text('Print Prescriptions');
                    $('#download-scans').text('Download Scans');
                }
            }

            // Handle select all checkbox
            $('#select-all').on('click', function() {
                var rows = table.rows({
                    'search': 'applied'
                }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
                toggleActionButtons();
            });

            // Handle individual row checkboxes
            $('#scans tbody').on('change', 'input[type="checkbox"]', function() {
                if (!this.checked) {
                    var el = $('#select-all').get(0);
                    if (el && el.checked && ('indeterminate' in el)) {
                        el.indeterminate = true;
                    }
                }
                toggleActionButtons();
            });

            // Initial state of action buttons
            toggleActionButtons();

            // Print Prescriptions
            $('#print-prescriptions').on('click', function() {
                var selectedIds = [];

                // Collect selected IDs
                $('.select-row:checked').each(function() {
                    selectedIds.push($(this).data('id'));
                });

                if (selectedIds.length === 1) {
                    var scanId = selectedIds[0];
                    var url = "{{ route('second_lab.scans.printScan', ':id') }}".replace(':id', scanId);

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
                } else if (selectedIds.length > 1) {
                    selectedIds.forEach(function(scanId) {
                        var url = "{{ route('second_lab.scans.printScan', ':id') }}".replace(':id',
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
                    });
                }
            });

            // Download Scans
            $('#download-scans').on('click', function() {
                var selectedIds = [];

                // Collect selected IDs
                $('.select-row:checked').each(function() {
                    selectedIds.push($(this).data('id'));
                });

                if (selectedIds.length === 1) {
                    var scanId = selectedIds[0];
                    var url = "{{ route('second_lab.scans.downloadStl', ':id') }}".replace(':id', scanId);

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

                            // Refresh the page after download
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', status, error);
                        }
                    });
                } else if (selectedIds.length > 1) {
                    var url = "{{ route('second_lab.scans.printMultiple') }}";

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: JSON.stringify({
                            ids: selectedIds,
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

                            // Refresh the page after download
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', status, error);
                        }
                    });
                }
            });
        });
    </script>
@endpush
