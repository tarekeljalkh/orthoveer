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
                                        <th>Status</th>
                                        <th>Note</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendingScans as $scan)
                                        <tr>
                                            <td><input type="checkbox" class="scanCheckbox" value="{{ $scan->id }}">
                                            </td>
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
                                                        Dropleft
                                                    </button>
                                                    <div class="dropdown-menu dropleft">
                                                        <a class="dropdown-item"
                                                            href="{{ route('lab.scans.viewer', $scan->id) }}">Open
                                                            Viewer</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('lab.scans.prescription', $scan->id) }}">Open
                                                            Prescription</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#"><i class="fas fa-print"></i>
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
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.scanCheckbox');
            const printButton = document.getElementById('printSelected');
            const downloadButton = document.getElementById('downloadSelected');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    updateButtonStatus();
                });
            });

            function updateButtonStatus() {
                const checkedCheckboxes = document.querySelectorAll('.scanCheckbox:checked');
                const count = checkedCheckboxes.length;

                printButton.disabled = downloadButton.disabled = count === 0;
                printButton.textContent = `Print Selected (${count})`;
                downloadButton.textContent = `Download Selected (${count})`;
            }

            updateButtonStatus(); // Initial status update

            downloadButton.addEventListener('click', function() {
                const selectedIds = Array.from(document.querySelectorAll('.scanCheckbox:checked')).map(
                    checkbox => checkbox.value);
                downloadSelectedScans(selectedIds);
            });

            function downloadSelectedScans(selectedIds) {
                fetch('{{ route('lab.scans.downloadMultiple') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            ids: selectedIds
                        })
                    })
                    .then(response => response.blob())
                    .then(blob => {
                        // Create a link element, use it to download the blob, and remove it
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        // the filename you need
                        a.download = 'scans.zip';
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        alert('Download has started!');
                    })
                    .catch(error => {
                        console.error('Download failed:', error);
                        alert('Download failed!');
                    });
            }
        });
    </script>
@endpush
