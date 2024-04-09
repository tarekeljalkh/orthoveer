@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>New Scan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">New Scan</a></div>
            </div>
        </div>

        <div class="section-body">
            <form action="{{ route('doctor.scans.store') }}" method="post" enctype="multipart/form-data">
                @csrf

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
                                <div class="card-header-action">
                                    <select class="form-control select2" name="patient_id" id="patientSelect">
                                        <option value="0" disabled selected>Select Existing Patient...</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}" data-first-name="{{ $patient->first_name }}"
                                                data-last-name="{{ $patient->last_name }}"
                                                data-dob="{{ $patient->dob->format('Y-m-d') }}"
                                                data-gender="{{ $patient->gender }}">{{ $patient->last_name }},
                                                {{ $patient->first_name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="#" id="clearForm" class="btn btn-success"
                                        style="pointer-events: none; opacity: 0.5;">Clear</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>First Name</label>
                                        <input name="patient_first_name" type="text" class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Last Name</label>
                                        <input name="patient_last_name" type="text" class="form-control" required="">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>Date Of Birth</label>
                                        <input name="patient_dob" type="date" class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-5 col-12">
                                        <label class="form-label">Gender</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="patient_gender" value="male"
                                                    class="selectgroup-input" checked="">
                                                <span class="selectgroup-button">Male</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="patient_gender" value="female"
                                                    class="selectgroup-input">
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

                                    <div class="form-group col-md-12 col-12">
                                        <label>Due Date</label>
                                        <input type="date" name="due_date" class="form-control" required="" min="{{ now()->toDateString() }}">
                                    </div>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Procedure</label>
                                        <select class="form-control select2" id="categorySelect" name="category_id">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Type</label>
                                        <select class="form-control select2" id="typeOfWorkSelect" name="typeofwork_id">
                                            {{-- @foreach ($labs as $lab)
                                                <option value="{{ $lab->id }}">{{ $lab->first_name }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>


                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>STL UPPER <i class="fas fa-arrow-up"></i></label>
                                        <div id="stl_upper_container">
                                            <div id="stl_upper_viewer" style="width:300px; height:300px;"></div>
                                        </div>
                                        <input type="file" name="stl_upper" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>STL LOWER <i class="fas fa-arrow-down"></i></label>
                                        <div id="stl_lower_container">
                                            <div id="stl_lower_viewer" style="width:300px; height:300px;"></div>
                                        </div>
                                        <input type="file" name="stl_lower" class="form-control">
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- End Order Section --}}

                    {{-- Image --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Upload Image Or PDF if Needed:</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group col-12">
                                        <div class="form-group col-12" id="previewContainer"></div> {{-- Preview Container --}}
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
                                        <textarea class="form-control" name="note" id="note" cols="30" rows="10" placeholder="Add Note"></textarea>
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
        function initializeOrUpdateStlViewer(containerId, fileUrl) {
            // Check if the viewer container already exists
            let container = $(`#${containerId}`);

            if (!container.length) {
                // If it doesn't exist, create it
                $('body').append(`<div id="${containerId}" style="width:300px; height:300px;"></div>`);
                container = $(`#${containerId}`);
            } else {
                // If it exists, clear its contents (assuming it might contain a previous STL viewer instance)
                container.empty();
            }

            // Initialize a new STL viewer in the container with the new STL file
            const viewerElement = document.getElementById(containerId);
            new StlViewer(viewerElement, {
                models: [{
                    filename: fileUrl,
                    color: "#FFC0CB"
                }]
            });
        }

        $(document).ready(function() {
            $('input[name="stl_upper"]').change(function(e) {
                if (this.files && this.files[0]) {
                    const url = URL.createObjectURL(this.files[0]);
                    initializeOrUpdateStlViewer("stl_upper_viewer", url);
                }
            });

            $('input[name="stl_lower"]').change(function(e) {
                if (this.files && this.files[0]) {
                    const url = URL.createObjectURL(this.files[0]);
                    initializeOrUpdateStlViewer("stl_lower_viewer", url);
                }
            });


            // Initialize select2
            $('.select2').select2();

            // Disable clear button initially
            $('#clearForm').css({
                'pointer-events': 'none',
                'opacity': '0.5'
            });

            // Enable clear button on selecting an option
            $('#patientSelect').on('select2:select', function(e) {
                $('#clearForm').css({
                    'pointer-events': 'auto',
                    'opacity': '1'
                });

                var data = e.params.data;
                var firstName = $(data.element).data('first-name');
                var lastName = $(data.element).data('last-name');
                var dob = $(data.element).data('dob');
                var gender = $(data.element).data('gender');

                // Fill the form fields
                $('input[name="patient_first_name"]').val(firstName);
                $('input[name="patient_last_name"]').val(lastName);
                $('input[name="patient_dob"]').val(dob);

                // Set gender radio button
                $(`input[name="patient_gender"][value="${gender}"]`).prop('checked', true);
            });

            // Reset functionality when clear button is clicked
            $('#clearForm').click(function(e) {
                e.preventDefault();

                // Clear the Select2 selection
                $('#patientSelect').val(0).trigger('change');

                // Reset text inputs and radio buttons
                $('input[name="patient_first_name"], input[name="patient_last_name"], input[name="patient_dob"], input[type="text"]')
                    .val('');
                $('input[name="patient_gender"][value="male"]').prop('checked', true);
                //$('input[name="patient_gender"]').prop('checked', false);

                // Disable clear button again
                $(this).css({
                    'pointer-events': 'none',
                    'opacity': '0.5'
                });
            });

            // Listen to changes on the Select2 to enable/disable clear button
            $('#patientSelect').on('select2:select select2:unselect', function() {
                var selected = !!$(this).val();
                $('#clearForm').css({
                    'pointer-events': selected ? 'auto' : 'none',
                    'opacity': selected ? '1' : '0.5'
                });
            });
        });

        // Form submission event
        $('form').on('submit', function() {
            $('#submitBtn').prop('disabled', true).text('Submitting...');
        });


        // convert this data into a JavaScript variable within your Blade template
        var categoriesAndTypes = @json(
            $categories->mapWithKeys(function ($category) {
                return [$category->id => $category->TypeOfWorks->pluck('name', 'id')];
            }));

        $('#categorySelect').on('change', function() {
            var categoryId = $(this).val();
            var typesOfWork = categoriesAndTypes[categoryId] || {};
            var $typeOfWorkSelect = $('#typeOfWorkSelect');

            $typeOfWorkSelect.empty().append('<option value="">Select Type</option>'); // Reset and add placeholder

            $.each(typesOfWork, function(id, name) {
                $typeOfWorkSelect.append('<option value="' + id + '">' + name + '</option>');
            });
        });

        //



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
