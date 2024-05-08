@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.new_scan') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.new_scan') }}</a></div>
            </div>
        </div>

        <div class="section-body">
            <form action="{{ route('doctor.scans.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="doctor_id" value="{{ auth()->user()->id }}">

                <div class="row">
                    {{-- Patient Section --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <input type="text" name="doctor_id" value={{ Auth::user()->id }} hidden >
                                <h4>{{ trans('messages.patient') }}:</h4>
                                {{-- <div class="card-header-action">
                                    <a href="{{ route('doctor.patients.create') }}" class="btn btn-success">Add New Patient <i class="fas fa-plus"></i></a>
                                </div> --}}
                                <div class="card-header-action">
                                    <select class="form-control select2" name="patient_id" id="patientSelect">
                                        <option value="0" disabled selected>{{ trans('messages.select_existing_patient') }}...</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}" data-first-name="{{ $patient->first_name }}"
                                                data-last-name="{{ $patient->last_name }}"
                                                data-dob="{{ $patient->dob->format('Y-m-d') }}"
                                                data-gender="{{ $patient->gender }}">{{ $patient->last_name }},
                                                {{ $patient->first_name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="#" id="clearForm" class="btn btn-success"
                                        style="pointer-events: none; opacity: 0.5;">{{ trans('messages.clear') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.first_name') }}</label>
                                        <input name="patient_first_name" type="text" class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.last_name') }}</label>
                                        <input name="patient_last_name" type="text" class="form-control" required="">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.date_of_birth') }}</label>
                                        <input name="patient_dob" type="date" class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-5 col-12">
                                        <label class="form-label">{{ trans('messages.gender') }}</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="patient_gender" value="male"
                                                    class="selectgroup-input" checked="">
                                                <span class="selectgroup-button">{{ trans('messages.male') }}</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="patient_gender" value="female"
                                                    class="selectgroup-input">
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
                                <h4>Order:</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ trans('messages.due_date') }}</label>
                                        <input type="date" name="due_date" class="form-control"
                                            value="{{ now()->toDateString() }}" min="{{ now()->toDateString() }}">
                                    </div>

                                <div class="form-group col-md-12 col-12">
                                    <label>{{ trans('messages.type') }}</label>
                                    <select class="form-control select2" id="typeOfWorkSelect" name="typeofwork_id">
                                        @foreach ($typeofWorks as $typeofWork)
                                            <option value="{{ $typeofWork->id }}">{{ $typeofWork->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ trans('messages.note') }}</label>

                                    <textarea class="form-control" name="note" id="note" cols="30" rows="10" placeholder="{{ trans('messages.add_note') }}"></textarea>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ trans('messages.upload_image_or_pdf') }}</label>

                                    <div class="form-group col-12" id="previewContainer"></div> {{-- Preview Container --}}
                                    <input type="file" name="pdf[]" id="pdfInput" class="form-control"
                                        multiple>
                                </div>





                                <div class="row">

                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- End Order Section --}}

                    {{-- STL SECTIONS --}}

                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.stl_upper') }} <i class="fas fa-arrow-up"></i></label>
                                        <div id="stl_upper_container">
                                            <div id="stl_upper_viewer" style="width:300px; height:300px;"></div>
                                        </div>
                                        <input type="file" name="stl_upper" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.stl_lower') }} <i class="fas fa-arrow-down"></i></label>
                                        <div id="stl_lower_container">
                                            <div id="stl_lower_viewer" style="width:300px; height:300px;"></div>
                                        </div>
                                        <input type="file" name="stl_lower" class="form-control">
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary" id="submitBtn">{{ trans('messages.done') }}</button>
                            </div>

                        </div>


                    </div>
                    {{-- End STL SECTION --}}

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
            $('#submitBtn').prop('disabled', true).text('{{ trans('messages.submitting') }}...');
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
