@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.show_scan') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('doctor.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.order') }}: {{ $order->id }}</a></div>
            </div>
        </div>

        <div class="section-body">
            <form action="{{ route('doctor.scans.update', $order->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if ($order->latestStatus->status !== 'completed')
                    <div class="row">
                        {{-- Patient Section --}}
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ trans('messages.patient') }}:</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.first_name') }}</label>
                                            <input name="patient_first_name" type="text" class="form-control"
                                                value="{{ $order->patient->first_name }}" disabled>
                                        </div>

                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.last_name') }}</label>
                                            <input name="patient_last_name" type="text" class="form-control"
                                                value="{{ $order->patient->last_name }}" disabled>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.date_of_birth') }}</label>
                                            <input name="patient_dob" type="text" class="form-control"
                                                value="{{ $order->patient->dob->format('d/m/y') }}" disabled>
                                        </div>

                                        <div class="form-group col-md-5 col-12">
                                            <label class="form-label">{{ trans('messages.gender') }}</label>
                                            <div class="selectgroup w-100">
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="patient_gender" value="male"
                                                        class="selectgroup-input" checked="" disabled>
                                                    <span class="selectgroup-button">{{ trans('messages.male') }}</span>
                                                </label>
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="patient_gender" value="female"
                                                        class="selectgroup-input" disabled>
                                                    <span class="selectgroup-button">{{ trans('messages.female') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Patient Section --}}

                        {{-- Order Section --}}
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ trans('messages.order') }}:</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.due_date') }}</label>
                                            <input type="date" name="due_date" class="form-control"
                                                value="{{ $order->due_date instanceof \DateTime ? $order->due_date->format('Y-m-d') : \Carbon\Carbon::parse($order->due_date)->format('Y-m-d') }}"
                                                min="{{ now()->toDateString() }}">
                                        </div>

                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.type') }}</label>
                                            <select class="form-control select2" id="typeOfWorkSelect" name="typeofwork_id">
                                                @foreach ($typeofWorks as $typeofWork)
                                                    <option value="{{ $typeofWork->id }}">{{ $typeofWork->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Order Section --}}

                        {{-- Note Section --}}
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                @if (count($order->status) > 0)
                                    <div class="card-header">
                                        <h4>{{ trans('messages.notes') }} ({{ count($order->status) }})</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="activities">
                                                    @forelse ($order->status as $status)
                                                        <div class="activity">
                                                            <div class="activity-icon bg-primary text-white shadow-primary">
                                                                <i class="fas fa-comment-alt"></i>
                                                            </div>
                                                            <div class="activity-detail" style="word-break: break-word">
                                                                <div class="mb-2">
                                                                    <span
                                                                        class="text-job text-primary">{{ $status->updatedBy->role ?? 'User' }},
                                                                        {{ $status->updatedBy->last_name }},
                                                                        {{ $status->updatedBy->first_name }},</span>
                                                                    <span class="bullet"></span>
                                                                    <span
                                                                        class="text-job text-info">{{ $status->created_at->format('d/m/Y') }}</span>
                                                                </div>
                                                                <p><span
                                                                        style="font-weight: bold">{{ trans('messages.status') }}:</span>
                                                                    {{ $status->status }}</p>
                                                                <p><span
                                                                        style="font-weight: bold">{{ trans('messages.note') }}:</span>
                                                                    {{ $status->note }}</p>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p>{{ trans('messages.no_status_updates_available') }}.</p>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="card-footer text-right">
                                    <div class="form-group col-md-8 col-8">
                                        <input class="form-control" type="text" name="note"
                                            placeholder="Enter New Note" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Note Section --}}

                        {{-- Image Section --}}
                        @php
                            // Ensure $order->pdf is not null and is a valid JSON string before decoding
                            $filePaths = $order->pdf ? json_decode($order->pdf, true) : [];
                        @endphp
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ trans('messages.upload_image_or_pdf') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <div class="form-group col-12" id="previewContainer"
                                                style="display: flex; align-items: center; flex-wrap: nowrap; overflow-x: auto; gap: 20px;">
                                                @if (!empty($filePaths))
                                                    @foreach ($filePaths as $filePath)
                                                        @if (pathinfo($filePath, PATHINFO_EXTENSION) === 'pdf')
                                                            {{-- PDF: Display as a downloadable link --}}
                                                            <a href="{{ asset($filePath) }}" download
                                                                style="flex-shrink: 0; display: inline-flex; align-items: center;">View
                                                                PDF</a>
                                                        @else
                                                            {{-- Image: Display and make it downloadable --}}
                                                            <a href="{{ asset($filePath) }}" download
                                                                style="flex-shrink: 0; display: inline-flex; align-items: center;">
                                                                <img src="{{ asset($filePath) }}" alt="Uploaded Image"
                                                                    style="height: 40px; width: auto;">
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <input type="file" name="pdf[]" id="pdfInput" class="form-control"
                                                multiple>
                                        </div>
                                        <div class="form-group col-12 text-right">
                                            <button type="button" class="btn btn-danger"
                                                id="clearFilesButton">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Image Section --}}

                        {{-- STL Section --}}
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>STL FILES</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.stl_upper') }} <i
                                                    class="fas fa-arrow-up"></i></label>
                                            <div id="stl_upper"
                                                style="width:300px; height:300px; margin:0 auto;{{ !$order->stl_upper ? ' display:none;' : '' }}">
                                            </div>
                                            <input type="file" name="stl_upper" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.stl_lower') }} <i
                                                    class="fas fa-arrow-down"></i></label>
                                            <div id="stl_lower"
                                                style="width:300px; height:300px; margin:0 auto;{{ !$order->stl_lower ? ' display:none;' : '' }}">
                                            </div>
                                            <input type="file" name="stl_lower" class="form-control">
                                        </div>
                                        <div class="form-group col-12 text-right">
                                            <button type="button" class="btn btn-danger"
                                                id="clearSTLFilesButton">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary"
                                        id="submitBtn">{{ trans('messages.update') }}</button>
                                </div>
                            </div>
                        </div>
                        {{-- End STL Section --}}
                    </div>
                @else
                    <div class="row">
                        {{-- Patient Section --}}
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ trans('messages.patient') }}:</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.first_name') }}</label>
                                            <input name="patient_first_name" type="text" class="form-control"
                                                value="{{ $order->patient->first_name }}" disabled>
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.last_name') }}</label>
                                            <input name="patient_last_name" type="text" class="form-control"
                                                value="{{ $order->patient->last_name }}" disabled>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.date_of_birth') }}</label>
                                            <input name="patient_dob" type="text" class="form-control"
                                                value="{{ $order->patient->dob->format('d/m/y') }}" disabled>
                                        </div>

                                        <div class="form-group col-md-5 col-12">
                                            <label class="form-label">{{ trans('messages.gender') }}</label>
                                            <div class="selectgroup w-100">
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="patient_gender" value="male"
                                                        class="selectgroup-input" checked="" disabled>
                                                    <span class="selectgroup-button">{{ trans('messages.male') }}</span>
                                                </label>
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="patient_gender" value="female"
                                                        class="selectgroup-input" disabled>
                                                    <span class="selectgroup-button">{{ trans('messages.female') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Patient Section --}}

                        {{-- Order Section --}}
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ trans('messages.order') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.due_date') }}</label>
                                            <input type="date" name="due_date" class="form-control"
                                                value="{{ $order->due_date instanceof \DateTime ? $order->due_date->format('Y-m-d') : \Carbon\Carbon::parse($order->due_date)->format('Y-m-d') }}"
                                                min="{{ now()->toDateString() }}" disabled>
                                        </div>

                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.type') }}</label>
                                            <select class="form-control select2" id="typeOfWorkSelect"
                                                name="typeofwork_id" disabled>
                                                @foreach ($typeofWorks as $typeofWork)
                                                    <option value="{{ $typeofWork->id }}">{{ $typeofWork->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Order Section --}}

                        {{-- Note Section --}}
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                @if (count($order->status) > 0)
                                    <div class="card-header">
                                        <h4>{{ trans('messages.notes') }} ({{ count($order->status) }})</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="activities">
                                                    @forelse ($order->status as $status)
                                                        <div class="activity">
                                                            <div
                                                                class="activity-icon bg-primary text-white shadow-primary">
                                                                <i class="fas fa-comment-alt"></i>
                                                            </div>
                                                            <div class="activity-detail">
                                                                <div class="mb-2">
                                                                    <span
                                                                        class="text-job text-primary">{{ $status->updatedBy->role ?? 'User' }},
                                                                        {{ $status->updatedBy->last_name }},
                                                                        {{ $status->updatedBy->first_name }},</span>
                                                                    <span class="bullet"></span>
                                                                    <span
                                                                        class="text-job text-info">{{ $status->created_at->format('d/m/Y') }}</span>
                                                                </div>
                                                                <p><span
                                                                        style="font-weight: bold">{{ trans('messages.status') }}:</span>
                                                                    {{ $status->status }}</p>
                                                                <p><span
                                                                        style="font-weight: bold">{{ trans('messages.note') }}:</span>
                                                                    {{ $status->note }}</p>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p>{{ trans('messages.no_status_updates_available') }}.</p>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="card-footer text-right">
                                    <div class="form-group col-md-8 col-8">
                                        <input class="form-control" type="text" name="note"
                                            placeholder="Enter New Note" required hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Note Section --}}

                        {{-- Image Section --}}
                        @php
                            // Ensure $order->pdf is not null and is a valid JSON string before decoding
                            $filePaths = $order->pdf ? json_decode($order->pdf, true) : [];
                        @endphp
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ trans('messages.upload_image_or_pdf') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <div class="form-group col-12">
                                                <div class="form-group col-12" id="previewContainer"
                                                    style="display: flex; align-items: center; flex-wrap: nowrap; overflow-x: auto; gap: 20px;">
                                                </div>
                                            </div>
                                            <div
                                                style="display: flex; align-items: center; flex-wrap: nowrap; overflow-x: auto; gap: 20px;">
                                                <!-- Flex container with spacing -->
                                                @if (!empty($filePaths))
                                                    @foreach ($filePaths as $filePath)
                                                        @if (pathinfo($filePath, PATHINFO_EXTENSION) === 'pdf')
                                                            {{-- PDF: Display as a downloadable link --}}
                                                            <a href="{{ asset($filePath) }}" download
                                                                style="flex-shrink: 0; display: inline-flex; align-items: center;"></a>
                                                        @else
                                                            {{-- Image: Display and make it downloadable --}}
                                                            <a href="{{ asset($filePath) }}" download
                                                                style="flex-shrink: 0; display: inline-flex; align-items: center;">
                                                                <img src="{{ asset($filePath) }}" alt="Uploaded Image"
                                                                    style="height: 40px; width: auto;">
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <input type="file" name="pdf[]" id="pdfInput" class="form-control"
                                                multiple webkitdirectory>
                                        </div>
                                        <div class="form-group col-12 text-right">
                                            <button type="button" class="btn btn-danger"
                                                id="clearFilesButton">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Image Section --}}

                        {{-- STL Section --}}
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>STL FILES</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.stl_upper') }} <i
                                                    class="fas fa-arrow-up"></i></label>
                                            <div id="stl_upper"
                                                style="width:300px; height:300px; margin:0 auto;{{ !$order->stl_upper ? ' display:none;' : '' }}">
                                            </div>
                                            <input type="file" name="stl_upper" class="form-control" hidden>
                                        </div>

                                        <div class="form-group col-md-6 col-12">
                                            <label>{{ trans('messages.stl_lower') }} <i
                                                    class="fas fa-arrow-down"></i></label>
                                            <div id="stl_lower"
                                                style="width:300px; height:300px; margin:0 auto;{{ !$order->stl_lower ? ' display:none;' : '' }}">
                                            </div>
                                            <input type="file" name="stl_lower" class="form-control" hidden>
                                        </div>
                                        <div class="form-group col-12 text-right">
                                            <button type="button" class="btn btn-danger" id="clearSTLFilesButton">Clear
                                                STL Files</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary" id="submitBtn" hidden>Update</button>
                                </div>
                            </div>
                        </div>
                        {{-- End STL Section --}}
                    </div>
                @endif
            </form>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/stl_js/stl_viewer.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var stl_viewer_upper, stl_viewer_lower;

            // Function to initialize or update STL viewer
            function initializeOrUpdateStlViewer(viewerId, fileUrl, existingViewer = null) {
                var container = document.getElementById(viewerId);
                // Clear the existing content of the container
                while (container.firstChild) {
                    container.removeChild(container.firstChild);
                }

                // If an existing viewer is passed, update it. Otherwise, create a new viewer.
                if (existingViewer) {
                    existingViewer = new StlViewer(container, {
                        models: [{
                            filename: fileUrl,
                            display: "smooth",
                            color: "#FFC0CB"
                        }]
                    });
                } else {
                    return new StlViewer(container, {
                        models: [{
                            filename: fileUrl,
                            display: "smooth",
                            color: "#FFC0CB"
                        }]
                    });
                }
            }

            // Initialize viewers for existing STL files
            @if ($order->stl_upper)
                $('#stl_upper').show();
                stl_viewer_upper = initializeOrUpdateStlViewer("stl_upper", "{{ asset($order->stl_upper) }}");
            @endif

            @if ($order->stl_lower)
                $('#stl_lower').show();
                stl_viewer_lower = initializeOrUpdateStlViewer("stl_lower", "{{ asset($order->stl_lower) }}");
            @endif

            // Update viewer on new file selection
            $('input[name="stl_upper"]').change(function(e) {
                if (this.files && this.files[0]) {
                    var url = URL.createObjectURL(this.files[0]);
                    $('#stl_upper').show();
                    stl_viewer_upper = initializeOrUpdateStlViewer("stl_upper", url, stl_viewer_upper);
                }
            });

            $('input[name="stl_lower"]').change(function(e) {
                if (this.files && this.files[0]) {
                    var url = URL.createObjectURL(this.files[0]);
                    $('#stl_lower').show();
                    stl_viewer_lower = initializeOrUpdateStlViewer("stl_lower", url, stl_viewer_lower);
                }
            });

            // Clear files function
            $('#clearFilesButton').click(function() {
                // Clear the file input value
                $('#pdfInput').val('');
                // Clear the preview container
                $('#previewContainer').empty();
            });

            $('#clearSTLFilesButton').click(function() {
                $('input[name="stl_upper"]').val('');
                $('input[name="stl_lower"]').val('');
                $('#stl_upper').hide().empty();
                $('#stl_lower').hide().empty();
            });
        });

        // Form submission event
        $('form').on('submit', function() {
            $('#submitBtn').prop('disabled', true).text('Submitting...');
        });

        // Preview files before submitting
        document.getElementById('pdfInput').addEventListener('change', function(event) {
            var files = event.target.files;
            var previewContainer = document.getElementById('previewContainer');
            // Do not clear existing previews
            // previewContainer.innerHTML = ''; // Commented out this line to keep existing previews

            for (var i = 0; i < files.length; i++) {
                (function(file) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var div = document.createElement('div');
                        div.style.marginBottom = '20px'; // Add some space between previews

                        // Check if the file is an image
                        if (file.type.match('image.*')) {
                            var img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.maxWidth = '200px'; // Set a max width for the image
                            img.style.height = 'auto';
                            div.appendChild(img);
                        } else if (file.type.match('application/pdf')) {
                            // If it's a PDF, create a link to download/view it
                            var link = document.createElement('a');
                            link.href = e.target.result;
                            link.textContent = 'View PDF';
                            link.target = '_blank'; // Open in new tab
                            div.appendChild(link);
                        }

                        previewContainer.appendChild(div);
                    };

                    if (file) {
                        reader.readAsDataURL(file);
                    }
                })(files[i]);
            }
        });
    </script>
@endpush
