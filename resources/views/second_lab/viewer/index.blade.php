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
                                    <a href="{{ route('second_lab.scans.downloadStl', $scan->id) }}"
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
                                            <p class="note"><span style="font-weight: bold">Note:</span> {{ $status->note }}</p>
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



                        {{-- Complete Scan Section --}}
                        @if ($lastStatus !== 'delivered')
                            <div class="card">
                                <div class="card-header">
                                    <h4>STL FILES from First Lab</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Begin Form Content -->
                                    <div class="row">
                                        @if ($scan->stl_upper_lab)
                                            <div class="form-group col-md-6 col-12">
                                                <label>{{ trans('messages.stl_upper') }} <i class="fas fa-arrow-up"></i></label>
                                                <div id="stl_upper_lab_container">
                                                    <div id="stl_upper_lab_viewer" style="width:150px; height:150px;"></div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($scan->stl_lower_lab)
                                            <div class="form-group col-md-6 col-12">
                                                <label>{{ trans('messages.stl_lower') }} <i class="fas fa-arrow-down"></i></label>
                                                <div id="stl_lower_lab_container">
                                                    <div id="stl_lower_lab_viewer" style="width:150px; height:150px;"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- End Form Content -->
                                </div>
                            </div>
                        @endif

                        {{-- End Complete Scan Section --}}


                        {{-- Attach Print Files Section --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>Attached Print Files</h4>
                            </div>
                            <div class="card-body">
                                @if ($scan->printFiles->isEmpty())
                                    <p>No print files attached.</p>
                                @else
                                    <ul>
                                        @foreach ($scan->printFiles as $printFile)
                                            <li>
                                                <a href="{{ route('second_lab.printfiles.download', $printFile->id) }}">
                                                    {{ $printFile->file_path }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        {{-- End Attach Print Files Section --}}


                    </div>


                </div>
    </section>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/stl_js/stl_viewer.min.js') }}"></script>
<script>
    $(document).ready(function() {
        @if ($scan->stl_upper)
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
        @endif

        @if ($scan->stl_lower)
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
        @endif

        @if ($scan->stl_upper_lab)
            var stl_viewer_upper_lab = new StlViewer(
                document.getElementById("stl_upper_lab_viewer"), {
                    models: [{
                        id: 3,
                        filename: "{{ asset($scan->stl_upper_lab) }}",
                        display: "smooth",
                        color: "#ADD8E6"
                    }]
                }
            );
        @endif

        @if ($scan->stl_lower_lab)
            var stl_viewer_lower_lab = new StlViewer(
                document.getElementById("stl_lower_lab_viewer"), {
                    models: [{
                        id: 4,
                        filename: "{{ asset($scan->stl_lower_lab) }}",
                        display: "smooth",
                        color: "#ADD8E6"
                    }]
                }
            );
        @endif
    });
</script>

@endpush
