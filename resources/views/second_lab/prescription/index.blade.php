@extends('second_lab.layouts.master')

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

            <div class="row">
                <div class="col-8 col-md-8 col-lg-8">
                    <div class="invoice-print">

                        <div class="card">
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
                                        <label for="site-title" class="form-control-label" style="font-weight: bold;">Graph
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
                                        <label for="site-title"
                                            class="form-control-label d-block">{{ $scan->doctor->signature }}</label>
                                        <label for="another-field" class="form-control-label d-block"
                                            style="font-weight: bold;">License:</label>
                                        <label for="another-field"
                                            class="form-control-label d-block">{{ $scan->doctor->license }}</label>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>

                    <div class="text-md-right">
                        <div class="float-lg-left mb-lg-0 mb-3">
                        </div>
                        <a href="{{ route('second_lab.scans.printScan', $scan->id) }}"
                            class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</a>
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
                                            <p class="note"><span style="font-weight: bold">Note:</span>
                                                {{ $status->note }}</p>
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
                        @if ($lastStatus === 'new' || $lastStatus === 'pending' || $lastStatus === 'resubmitted' || $lastStatus === 'downloaded')
                            <div class="card-footer">
                                <form action="{{ route('second_lab.scans.updateStatus', $scan->id) }}" method="post">
                                    @csrf
                                    @method('post')

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="note"
                                            placeholder="Enter Note" required>
                                    </div>

                                    <button type="submit" name="action" value="reject" class="btn btn-danger">
                                        Reject
                                    </button>

                                </form>
                            </div>
                        @endif

                    </div>
                    {{-- End Status and Rejection Section --}}


                </div>

            </div>


        </div>
    </section>
@endsection
