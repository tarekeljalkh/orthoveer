@extends('lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Scan ID: {{ $scan->id }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('lab.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('lab.scans.index') }}">Scans</a></div>
                <div class="breadcrumb-item"><a href="#">{{ $scan->id }}</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-8 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                @if ($scan->stl_upper || $scan->stl_lower)
                                    <a href="{{ route('lab.scans.downloadStl', $scan->id) }}"
                                        class="btn btn-primary">Download
                                        Files <i class="fas fa-download"></i></a>
                                @endif
                                @if ($scan->stl_upper)
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Upper Stl</h4>
                                                <div class="card-header-action">
                                                    <a href="{{ $scan->stl_upper }}" download
                                                        class="btn btn-success">Download <i class="fas fa-download"></i></a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div id="stl_upper" style="width:500px;height:500px;margin:0 auto;"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($scan->stl_lower)
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Lower Stl</h4>
                                                <div class="card-header-action">
                                                    <a href="{{ $scan->stl_lower }}" download
                                                        class="btn btn-success">Download <i class="fas fa-download"></i></a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div id="stl_lower" style="width:500px;height:500px;margin:0 auto;"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!$scan->pdf)
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Image Or Pdf</h4>
                                                <div class="card-header-action">
                                                    <a href="{{ $scan->pdf }}" download class="btn btn-success">Download
                                                        <i class="fas fa-download"></i></a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <img src="{{ $scan->pdf }}"
                                                    style="width:200px;height:200px;margin:0 auto;">
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                @if (!$scan->stl_upper && !$scan->stl_lower)
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>No Stl Available</h4>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <p>Status Updates: {{ $scan->status->count() }}</p>
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
                                <form action="{{ route('lab.scans.updateStatus', $scan->id) }}" method="post">
                                    @csrf
                                    @method('post')

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="note" placeholder="Enter Note"
                                            required>
                                    </div>

                                    <button type="submit" name="action" value="reject" class="btn btn-danger">
                                        Reject
                                    </button>

                                    <button type="submit" name="action" value="complete" class="btn btn-success">
                                        Complete
                                    </button>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>

            </div>


        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/stl_js/stl_viewer.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var stl_viewer_upper = new StlViewer(
                document.getElementById("stl_upper"), {
                    models: [{
                        id: 1,
                        filename: "{{ asset($scan->stl_upper) }}",
                        display: "smooth",
                        color: "#FFC0CB"
                    }]
                }
            );

            var stl_viewer_lower = new StlViewer(
                document.getElementById("stl_lower"), {
                    models: [{
                        id: 2,
                        filename: "{{ asset($scan->stl_lower) }}",
                        display: "smooth",
                        color: "#FFC0CB"
                    }]
                }
            );
            stl_viewer.download_model(2, '{{ asset($scan->stl_lower) }}');
        });
    </script>

@endpush
