@extends('lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.new_scan') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.new_scan') }}</a></div>
            </div>
        </div>

        <div class="section-body">
            <form action="{{ route('lab.scans.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- Doctor Section --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ trans('messages.doctor') }}:</h4>
                                <div class="card-header-action">
                                    <select class="form-control select2" name="doctor_id" id="doctorSelect">
                                        <option value="0" disabled selected>{{ trans('messages.select_existing_doctor') }}...</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" data-first-name="{{ $doctor->first_name }}" data-last-name="{{ $doctor->last_name }}" data-email="{{ $doctor->email }}">
                                                {{ $doctor->last_name }}, {{ $doctor->first_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <a href="#" id="clearDoctorForm" class="btn btn-success" style="pointer-events: none; opacity: 0.5;">
                                        {{ trans('messages.clear') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.first_name') }}</label>
                                        <input name="doctor_first_name" type="text" class="form-control" required="">
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.last_name') }}</label>
                                        <input name="doctor_last_name" type="text" class="form-control" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ trans('messages.email') }}</label>
                                        <input name="doctor_email" type="text" class="form-control" required="">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Doctor Section --}}

                    {{-- Patient Section --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ trans('messages.patient') }}:</h4>
                                <div class="card-header-action">
                                    <select class="form-control select2" name="patient_id" id="patientSelect">
                                        <option value="0" disabled selected>{{ trans('messages.select_existing_patient') }}...</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}" data-first-name="{{ $patient->first_name }}" data-last-name="{{ $patient->last_name }}" data-dob="{{ $patient->dob->format('Y-m-d') }}" data-gender="{{ $patient->gender }}">
                                                {{ $patient->last_name }}, {{ $patient->first_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <a href="#" id="clearPatientForm" class="btn btn-success" style="pointer-events: none; opacity: 0.5;">
                                        {{ trans('messages.clear') }}
                                    </a>
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
                                                <input type="radio" name="patient_gender" value="male" class="selectgroup-input" checked="">
                                                <span class="selectgroup-button">{{ trans('messages.male') }}</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="patient_gender" value="female" class="selectgroup-input">
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
                                        <input type="date" name="due_date" class="form-control" value="{{ now()->toDateString() }}" min="{{ now()->toDateString() }}">
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
                                        <div class="form-group col-12" id="previewContainer"></div>
                                        <input type="file" name="pdf[]" id="pdfInput" class="form-control" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Order Section --}}

                        {{-- STL Sections --}}
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
                        {{-- End STL Sections --}}
                    </div>
            </form>
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
                newContainer.style.width = '300px';
                newContainer.style.height = '300px';
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
            // Initialize STL viewers for file inputs
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

            // Handle patient selection
            $('#patientSelect').on('select2:select', function(e) {
                $('#clearPatientForm').css({'pointer-events': 'auto', 'opacity': '1'});

                var data = e.params.data;
                var patientfirstName = $(data.element).data('first-name');
                var patientlastName = $(data.element).data('last-name');
                var patientdob = $(data.element).data('dob');
                var patientgender = $(data.element).data('gender');

                // Fill the form fields
                $('input[name="patient_first_name"]').val(patientfirstName);
                $('input[name="patient_last_name"]').val(patientlastName);
                $('input[name="patient_dob"]').val(patientdob);

                // Set gender radio button
                $(`input[name="patient_gender"][value="${patientgender}"]`).prop('checked', true);
            });

            // Reset patient form when clear button is clicked
            $('#clearPatientForm').click(function(e) {
                e.preventDefault();

                // Clear the Select2 selection
                $('#patientSelect').val(0).trigger('change');

                // Reset form fields
                $('input[name="patient_first_name"], input[name="patient_last_name"], input[name="patient_dob"]').val('');
                $('input[name="patient_gender"][value="male"]').prop('checked', true);

                // Disable clear button again
                $(this).css({'pointer-events': 'none', 'opacity': '0.5'});
            });

            // Handle doctor selection
            $('#doctorSelect').on('select2:select', function(e) {
                $('#clearDoctorForm').css({'pointer-events': 'auto', 'opacity': '1'});

                var data = e.params.data;
                var doctorfirstName = $(data.element).data('first-name');
                var doctorlastName = $(data.element).data('last-name');
                var doctoremail = $(data.element).data('email');

                // Fill the form fields
                $('input[name="doctor_first_name"]').val(doctorfirstName);
                $('input[name="doctor_last_name"]').val(doctorlastName);
                $('input[name="doctor_email"]').val(doctoremail);
            });

            // Reset doctor form when clear button is clicked
            $('#clearDoctorForm').click(function(e) {
                e.preventDefault();

                // Clear the Select2 selection
                $('#doctorSelect').val(0).trigger('change');

                // Reset form fields
                $('input[name="doctor_first_name"], input[name="doctor_last_name"], input[name="doctor_email"]').val('');

                // Disable clear button again
                $(this).css({'pointer-events': 'none', 'opacity': '0.5'});
            });

            // Form submission event
            $('form').on('submit', function() {
                $('#submitBtn').prop('disabled', true).text('{{ trans('messages.submitting') }}...');
            });

            // Preview files before submitting
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
        });
    </script>
@endpush
