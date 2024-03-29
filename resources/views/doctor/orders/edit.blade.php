@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Show Scan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Order: {{ $order->id }}</a></div>
            </div>
        </div>

        <div class="section-body">
            <form action="{{ route('doctor.scans.update', $order->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Doctor Section --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Doctor:</label>
                                        <label class="form-control">Dr. {{ auth()->user()->last_name }},
                                            {{ auth()->user()->first_name }}</label>
                                    </div>
                                    <input type="hidden" name="doctor_id" value="{{ auth()->user()->id }}">
                                    @if (Auth::user()->license)
                                        <div class="form-group col-md-6 col-12">
                                            <label>License:</label>
                                            <label class="form-control">License:</label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Doctor Section --}}

                    {{-- Patient Section --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Patient:</h4>
                                {{-- <div class="card-header-action">
                                    <a href="{{ route('doctor.patients.create') }}" class="btn btn-success">Add New Patient <i class="fas fa-plus"></i></a>
                                </div> --}}
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>First Name</label>
                                        <input name="patient_first_name" type="text" class="form-control"
                                            value="{{ $order->patient->first_name }}" disabled>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Last Name</label>
                                        <input name="patient_last_name" type="text" class="form-control"
                                            value="{{ $order->patient->last_name }}" disabled>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>Date Of Birth</label>
                                        <input name="patient_dob" type="text" class="form-control"
                                            value="{{ $order->patient->dob->format('d/m/y') }}" disabled>
                                    </div>

                                    <div class="form-group col-md-5 col-12">
                                        <label class="form-label">Gender</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="patient_gender" value="male"
                                                    class="selectgroup-input" checked="" disabled>
                                                <span class="selectgroup-button">Male</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="patient_gender" value="female"
                                                    class="selectgroup-input" disabled>
                                                <span class="selectgroup-button">Female</span>
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
                                <h4>Order:</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>Due Date</label>
                                        <input type="date" name="due_date" class="form-control"
                                            value="{{ $order->due_date->format('d/m/y') }}">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Send To</label>
                                        <select class="form-control select2" name="lab">
                                            @foreach ($labs as $lab)
                                                <option value="{{ $lab->id }}">{{ $lab->first_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>STL UPPER <i class="fas fa-arrow-up"></i></label>
                                        <div id="stl_upper"
                                            style="width:300px; height:300px; margin:0 auto;{{ !$order->stl_upper ? ' display:none;' : '' }}">
                                        </div>
                                        <input type="file" name="stl_upper" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>STL LOWER <i class="fas fa-arrow-down"></i></label>
                                        <div id="stl_lower"
                                            style="width:300px; height:300px; margin:0 auto;{{ !$order->stl_lower ? ' display:none;' : '' }}">
                                        </div>
                                        <input type="file" name="stl_lower" class="form-control">
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- End Order Section --}}

                    {{-- Image --}}
                    @php
                        // Ensure $order->pdf is not null and is a valid JSON string before decoding
                        $filePaths = $order->pdf ? json_decode($order->pdf, true) : [];
                    @endphp
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Upload Image Or PDF if Needed:</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group col-12">
                                        <div class="form-group col-12">
                                            <div class="form-group col-12" id="previewContainer"></div>
                                            {{-- Preview Container --}}
                                        </div>

                                        <div
                                            style="display: flex; align-items: center; flex-wrap: nowrap; overflow-x: auto; gap: 20px;">
                                            <!-- Flex container with spacing -->
                                            @if (!empty($filePaths))
                                                @foreach ($filePaths as $filePath)
                                                    @if (pathinfo($filePath, PATHINFO_EXTENSION) === 'pdf')
                                                        {{-- PDF: Display as a downloadable link --}}
                                                        <a href="{{ asset($filePath) }}" download
                                                            style="flex-shrink: 0; display: inline-flex; align-items: center;">
                                                        </a>
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
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Image --}}



                    {{-- Note --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Note:</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group col-12">
                                        <textarea class="form-control" name="note" id="note" cols="30" rows="10" placeholder="Add Note">{{ $order->note }}</textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Done</button>
                            </div>

                        </div>


                    </div>
                    {{-- End Note --}}

                </div>
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
                // If an existing viewer is passed, update it. Otherwise, create a new viewer.
                if (existingViewer) {
                    existingViewer.clear();
                    existingViewer.add_model({
                        filename: fileUrl,
                        display: "smooth",
                        color: "#FFC0CB"
                    });
                } else {
                    return new StlViewer(document.getElementById(viewerId), {
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


        });

        // Form submission event
        $('form').on('submit', function() {
            $('#submitBtn').prop('disabled', true).text('Submitting...');
        });

        //preview files before submitting
        document.getElementById('pdfInput').addEventListener('change', function(event) {
            var files = event.target.files;
            var previewContainer = document.getElementById('previewContainer');
            previewContainer.innerHTML = ''; // Clear existing previews

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

        // $(document).ready(function() {
        //     $('.select2').select2().on('select2:select', function(e) {
        //         var data = e.params.data;

        //         // Assuming the data attributes are correctly set on the option elements
        //         var firstName = $(data.element).data('first-name');
        //         var lastName = $(data.element).data('last-name');
        //         var dob = $(data.element).data('dob');
        //         var gender = $(data.element).data('gender');

        //         // Fill the form fields
        //         $('input[name="patient_first_name"]').val(firstName);
        //         $('input[name="patient_last_name"]').val(lastName);
        //         $('input[name="patient_dob"]').val(dob);

        //         // Set gender radio button
        //         if (gender) {
        //             $(`input[name="patient_gender"][value=${gender}]`).prop('checked', true);
        //         }
        //     });
        // });
    </script>
@endpush
