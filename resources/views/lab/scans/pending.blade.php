@extends('lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Pending Scans</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('lab.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Pending Scans</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pending Scans</h4>
                        </div>
                        <div class="card-body">
                                <div class="mb-3">
                                    <button class="btn btn-primary" id="printSelected">Print Selected</button>
                                    <button class="btn btn-primary" id="downloadSelected">Download Selected</button>
                                </div>
                                <table id="example" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Doctor Name</th>
                                            <th>Due Date</th>
                                            <th>Note</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pendingScans as $scan)
                                            <tr>
                                                <td><input type="checkbox" class="orderCheckbox"
                                                        value="{{ $scan->id }}"></td>
                                                <td>Dr. {{ $scan->doctor->last_name }}, {{ $scan->doctor->first_name }}
                                                </td>
                                                <td>{{ $scan->due_date->format('d/m/Y') }}</td>
                                                <td>{{ $scan->note }}</td>
                                                <td>
                                                    <div
                                                        class="badge
                                                        {{ $scan->status == 'pending' ? 'badge-warning' : '' }}
                                                        {{ $scan->status == 'in_progress' ? 'badge-info' : '' }}
                                                        {{ $scan->status == 'completed' ? 'badge-success' : '' }}
                                                        {{ $scan->status == 'cancelled' ? 'badge-danger' : '' }}">
                                                        {{ $scan->status }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group dropleft">
                                                        <button type="button" class="btn btn-dark dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Dropleft
                                                        </button>
                                                        <div class="dropdown-menu dropleft">
                                                            <a class="dropdown-item" href="{{ route('lab.scans.viewer', $scan->id) }}">Open Viewer</a>
                                                            <a class="dropdown-item" href="{{ route('lab.scans.prescription', $scan->id) }}">Open Prescription</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#"><i class="fas fa-print"></i> Print Prescription</a>
                                                            <a class="dropdown-item" href="{{ route('lab.scans.downloadStl', $scan->id) }}"><i class="fas fa-download"></i> Download The Scan</a>
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
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.orderCheckbox');
            const printButton = document.getElementById('printSelected');
            const downloadButton = document.getElementById('downloadSelected');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    updateButtonStatus();
                });
            });

            updateButtonStatus(); // Call the function when the page loads

            function updateButtonStatus() {
                const checkedCheckboxes = document.querySelectorAll('.orderCheckbox:checked');
                const count = checkedCheckboxes.length;

                if (count > 0) {
                    printButton.disabled = false;
                    downloadButton.disabled = false;
                    printButton.textContent = `Print Selected (${count})`;
                    downloadButton.textContent = `Download Selected (${count})`;
                } else {
                    printButton.disabled = true;
                    downloadButton.disabled = true;
                    printButton.textContent = `Print Selected`;
                    downloadButton.textContent = `Download Selected`;
                }
            }

            printButton.addEventListener('click', function() {
                printSelectedOrders();
            });

            downloadButton.addEventListener('click', function() {
                downloadSelectedOrders();
            });

            function printSelectedOrders() {
                const checkedCheckboxes = document.querySelectorAll('.orderCheckbox:checked');
                checkedCheckboxes.forEach(function(checkbox) {
                    console.log('Printing order with ID: ' + checkbox.value);
                });
            }

            function downloadSelectedOrders() {
                const checkedCheckboxes = document.querySelectorAll('.orderCheckbox:checked');
                checkedCheckboxes.forEach(function(checkbox) {
                    console.log('Downloading order with ID: ' + checkbox.value);
                });
            }
        });
    </script>
@endpush
