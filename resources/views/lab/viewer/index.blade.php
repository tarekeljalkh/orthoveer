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
                                                <div id="stl_upper" style="width:100%;height:500px;margin:0 auto;"></div>
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
                                                <div id="stl_lower" style="width:100%;height:500px;margin:0 auto;"></div>
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
                        @if ($lastStatus === 'new' || $lastStatus === 'pending' || $lastStatus === 'resubmitted' || $lastStatus === 'downloaded')
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

                                </form>
                            </div>
                        @endif

                    </div>
                    {{-- End Status and Rejection Section --}}

                    {{-- Comple Scan Section --}}
                    @if ($lastStatus === 'new' || $lastStatus === 'pending' || $lastStatus === 'resubmitted' || $lastStatus === 'downloaded')
                        <div class="card">
                            <div class="card-header">
                                <h4>Upload And Complete Scan</h4>
                            </div>
                            <div class="card-body">
                                <!-- Begin Form Content -->
                                <form action="{{ route('lab.scans.complete', $scan->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('post')

                                    <div class="row">

                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.stl_upper') }} <i
                                                    class="fas fa-arrow-up"></i></label>
                                            <div id="stl_upper_container">
                                                <div id="stl_upper_viewer_lab" style="width:150px; height:150px;"></div>
                                            </div>
                                            <input type="file" name="stl_upper_lab" class="form-control">
                                        </div>

                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.stl_lower') }} <i
                                                    class="fas fa-arrow-down"></i></label>
                                            <div id="stl_lower_container">
                                                <div id="stl_lower_viewer_lab" style="width:150px; height:150px;"></div>
                                            </div>
                                            <input type="file" name="stl_lower_lab" class="form-control">
                                        </div>

                                    </div>

                                    <button type="submit" name="action" value="complete" class="btn btn-success">
                                        Complete
                                    </button>
                                </form>
                                <!-- End Form Content -->
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
                                                        <a href="{{ route('lab.printfiles.download', $printFile->id) }}">
                                                            {{ $printFile->file_path }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif

                                        <form action="{{ route('lab.printfiles.attach') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="scan_ids[]" value="{{ $scan->id }}">
                                            <div class="form-group">
                                                <label for="print_file_id">Attach Print File</label>
                                                <select name="print_file_id" id="print_file_id"
                                                    class="form-control select2">
                                                    @foreach ($printFiles as $printFile)
                                                        <option value="{{ $printFile->id }}">{{ $printFile->file_path }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="new_print_file">Or Upload New Print File</label>
                                                <input type="file" name="new_print_file" id="new_print_file"
                                                    class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Attach</button>
                                        </form>
                                    </div>
                                </div>
                                {{-- End Attach Print Files Section --}}



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
    <script src="{{ asset('assets/js/stl_js/stl_viewer.min.js') }}"></script>
    <script>
        function initializeOrUpdateStlViewer(containerId, fileUrl) {
            let container = document.getElementById(containerId);

            if (!container) {
                const newContainer = document.createElement('div');
                newContainer.id = containerId;
                newContainer.style.width = '150px';
                newContainer.style.height = '150px';
                document.body.appendChild(newContainer);
                container = newContainer;
            } else {
                container.innerHTML = ''; // Clear previous content
            }

            new StlViewer(container, {
                models: [{
                    filename: fileUrl,
                    color: "#FFC0CB"
                }]
            });
        }

        $(document).ready(function() {
            // Initialize the STL viewers for the initial load
            if ("{{ $scan->stl_upper }}") {
                new StlViewer(
                    document.getElementById("stl_upper"), {
                        models: [{
                            id: 1,
                            filename: "{{ asset($scan->stl_upper) }}",
                            display: "smooth",
                            color: "#FFC0CB"
                        }]
                    }
                );
            }

            if ("{{ $scan->stl_lower }}") {
                new StlViewer(
                    document.getElementById("stl_lower"), {
                        models: [{
                            id: 2,
                            filename: "{{ asset($scan->stl_lower) }}",
                            display: "smooth",
                            color: "#FFC0CB"
                        }]
                    }
                );
            }

            // Handle file input change for lab uploads
            $('input[name="stl_upper_lab"]').change(function(e) {
                if (this.files && this.files[0]) {
                    const url = URL.createObjectURL(this.files[0]);
                    initializeOrUpdateStlViewer("stl_upper_viewer_lab", url);
                }
            });

            $('input[name="stl_lower_lab"]').change(function(e) {
                if (this.files && this.files[0]) {
                    const url = URL.createObjectURL(this.files[0]);
                    initializeOrUpdateStlViewer("stl_lower_viewer_lab", url);
                }
            });
        });
    </script>
@endpush
