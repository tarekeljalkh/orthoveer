@extends('second_lab.layouts.master')


@push('styles')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .invoice,
            .invoice * {
                visibility: visible;
            }

            .invoice {
                position: fixed;
                left: 50%;
                top: 0;
                transform: translateX(-50%);
                /* Centers the div horizontally */
                width: 100%;
                max-width: 210mm;
                /* Assuming you want an A4 width or adjust accordingly */
                margin: 0;
                padding: 0;
            }

            #invoicePrint {
                border: none;
            }

            @page {
                size: auto;
                /* Auto scale the page */
                margin: 0mm;
                /* Adjust margin to zero */
            }
        }
    </style>
@endpush


@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('second_lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Scan ID: {{ $scan->id }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('second_lab.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('second_lab.scans.index') }}">Scans</a></div>
                <div class="breadcrumb-item"><a href="#">Scan</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4>Adjust Invoice Size & Upload Image</h4>
                </div>
                <div class="card-body">
                    <div class="form-inline justify-content-center">
                        <div class="form-group mb-2">
                            <label for="invoiceWidth" class="mr-2">Width (mm):</label>
                            <input type="number" class="form-control" id="invoiceWidth" placeholder="Width in mm"
                                value="210">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="invoiceHeight" class="mr-2">Height (mm):</label>
                            <input type="number" class="form-control" id="invoiceHeight" placeholder="Height in mm"
                                value="297">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="invoiceImage" class="btn btn-info">Choose Image</label>
                            <input type="file" id="invoiceImage" class="form-control-file d-none"
                                onchange="adjustSize()">
                        </div>
                        <button type="button" class="btn btn-primary mb-2" onclick="adjustSize()">Apply Size</button>
                    </div>
                </div>
                <div class="card-footer text-md-right">
                    <button class="btn btn-primary btn-icon icon-left" onclick="window.print()"><i class="fas fa-print"></i>
                        Print</button>
                </div>
            </div>

            <div class="row">

                <div class="col-8 col-md-8 col-lg-8">

                    <div class="invoice">
                        <div class="invoice-print" id="invoicePrint">

                            <div class="card">

                                <div id="imageContainer" style="text-align: center; margin: 20px 0;">
                                    <!-- Image will be displayed here -->
                                </div>

                                <div class="card-header">
                                    <h4>General Informations</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-6 col-md-6">
                                            <label for="site-title" class="form-control-label"
                                                style="font-weight: bold;">Patient:</label>
                                            <label for="site-title"
                                                class="form-control-label">{{ $scan->patient->first_name }}</label>

                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <label for="site-title" class="form-control-label"
                                                style="font-weight: bold;">Graph
                                                Number:</label>
                                            <label for="site-title" class="form-control-label">safasfg</label>
                                        </div>
                                    </div>

                                    <hr>
                                    {{-- <div class="live-divider"></div> --}}

                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-6 col-md-6">
                                            <label for="site-title" class="form-control-label"
                                                style="font-weight: bold;">Doctor:</label>
                                            <label for="site-title" class="form-control-label">Dr.
                                                {{ $scan->doctor->last_name }},
                                                {{ $scan->doctor->first_name }}</label>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-6 col-md-6">
                                            <label for="site-title" class="form-control-label"
                                                style="font-weight: bold;">Procedure:</label>
                                            <label for="site-title"
                                                class="form-control-label">{{ $scan->typeofwork->name }}</label>
                                        </div>
                                    </div>


                                    <hr>
                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-6 col-md-6">
                                            <label for="site-title" class="form-control-label d-block"
                                                style="font-weight: bold;">Cabinet:</label>
                                            <label for="site-title" class="form-control-label d-block">safasfg</label>
                                            <label for="another-field" class="form-control-label d-block"
                                                style="font-weight: bold;">Delivery Address:</label>
                                            <label for="another-field"
                                                class="form-control-label d-block">{{ $scan->doctor->address }}</label>
                                        </div>
                                        <div class="col-sm-3 col-md-3">
                                            <label for="site-title" class="form-control-label d-block"
                                                style="font-weight: bold;">Scan Date:</label>
                                            <label for="site-title"
                                                class="form-control-label d-block">{{ \Carbon\Carbon::parse($scan->scan_date)->format('d/m/Y') }}</label>
                                            <label for="another-field" class="form-control-label d-block"
                                                style="font-weight: bold;">Due Date:</label>
                                            <label for="another-field"
                                                class="form-control-label d-block">{{ \Carbon\Carbon::parse($scan->due_date)->format('d/m/Y') }}</label>
                                            <label for="yet-another-field" class="form-control-label d-block"
                                                style="font-weight: bold;">Status:</label>
                                            <label for="yet-another-field"
                                                class="form-control-label d-block">{{ $scan->latestStatus->status }}</label>
                                        </div>
                                        <div class="col-sm-3 col-md-3">
                                            <label for="site-title" class="form-control-label d-block"
                                                style="font-weight: bold;">Signature:</label>
                                            <label for="site-title" class="form-control-label d-block">safasfg</label>
                                            <label for="another-field" class="form-control-label d-block"
                                                style="font-weight: bold;">License:</label>
                                            <label for="another-field" class="form-control-label d-block">example</label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="col-4 col-md-4 col-lg-4">
                    {{-- Status and Rejection Section --}}

                    <div class="card">
                        <div class="card-header">
                            <h4>Status Updates: {{ $scan->status->count() }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="activities">
                                @forelse ($scan->status as $status)
                                    <div class="activity">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                            <i class="fas fa-comment-alt"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <div class="mb-2">
                                                <span
                                                    class="text-job text-primary">{{ $status->updatedBy->role ?? 'User' }},
                                                    {{ $status->updatedBy->last_name }},
                                                    {{ $status->updatedBy->first_name }},
                                                </span>
                                                <span class="bullet"></span>
                                                <span
                                                    class="text-job text-info">{{ $status->created_at->format('d/m/Y') }}</span>
                                            </div>
                                            <p><span style="font-weight: bold">Status:</span> {{ $status->status }}</p>
                                            <p><span style="font-weight: bold">Note:</span> {{ $status->note }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p>No status updates available.</p>
                                @endforelse
                            </div>
                        </div>
                        @php
                            $lastStatus = $scan->status->sortByDesc('created_at')->first()?->status ?? '';
                        @endphp



                        {{-- Only show "Complete" and "Reject" buttons for "pending" or "resubmitted" statuses --}}
                        @if ($lastStatus === 'pending' || $lastStatus === 'resubmitted')
                            <div class="card-footer">
                                <form action="{{ route('second_lab.scans.updateStatus', $scan->id) }}" method="post">
                                    @csrf
                                    @method('post')

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="note" placeholder="Enter Note"
                                            required>
                                    </div>

                                    <button type="submit" name="action" value="reject" class="btn btn-danger">
                                        Reject
                                    </button>

                                </form>
                            </div>
                        @endif

                    </div>
                    {{-- End Status and Rejection Section --}}

                    {{-- Comple Scan Section --}}
                    @if ($lastStatus === 'pending')
                        <div class="card">
                            <div class="card-header">
                                <h4>Upload 3D And Complete Scan</h4>
                            </div>
                            <div class="card-body">
                                <!-- Begin Form Content -->
                                <form action="{{ route('second_lab.scans.complete', $scan->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('post')

                                    <div class="form-group">
                                        <label for="lab_file">Upload Finished Files as ZIP:</label>
                                        <input type="file" name="lab_file" id="lab_file" class="form-control" required>
                                    </div>

                                    <button type="submit" name="action" value="complete" class="btn btn-success">
                                        Complete
                                    </button>
                                </form>
                                <!-- End Form Content -->
                            </div>
                        </div>
                    @endif

                    {{-- End Complete Scan Section --}}

                </div>
            </div>


        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function adjustSize() {
            const width = document.getElementById('invoiceWidth').value || 210; // Default A4 width in mm
            const height = document.getElementById('invoiceHeight').value || 297; // Default A4 height in mm
            const invoicePrint = document.getElementById('invoicePrint');

            // Convert mm to pixels for on-screen display (approximation, 1mm = 3.78px)
            invoicePrint.style.width = `${width * 3.78}px`;
            invoicePrint.style.height = `${height * 3.78}px`;

            const imageInput = document.getElementById('invoiceImage');
            const imageContainer = document.getElementById('imageContainer');
            imageContainer.innerHTML = ''; // Clear previous image

            if (imageInput.files && imageInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100%'; // Ensure the image fits in the invoice
                    img.style.height = 'auto';
                    imageContainer.appendChild(img);
                };

                reader.readAsDataURL(imageInput.files[0]);
            }
        }
    </script>
@endpush
