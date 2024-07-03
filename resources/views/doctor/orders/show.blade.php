@extends('doctor.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ trans('messages.show_scan') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
            <div class="breadcrumb-item"><a href="#">{{ trans('messages.order') }}: {{ $order->id }}</a></div>
        </div>
    </div>

    <div class="section-body">
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
                                <input name="patient_first_name" type="text" class="form-control" value="{{ $order->patient->first_name }}" disabled>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>{{ trans('messages.last_name') }}</label>
                                <input name="patient_last_name" type="text" class="form-control" value="{{ $order->patient->last_name }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>{{ trans('messages.date_of_birth') }}</label>
                                <input name="patient_dob" type="text" class="form-control" value="{{ $order->patient->dob->format('d/m/y') }}" disabled>
                            </div>
                            <div class="form-group col-md-5 col-12">
                                <label class="form-label">{{ trans('messages.gender') }}</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="patient_gender" value="male" class="selectgroup-input" @if($order->patient->gender == 'male') checked @endif disabled>
                                        <span class="selectgroup-button">{{ trans('messages.male') }}</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="patient_gender" value="female" class="selectgroup-input" @if($order->patient->gender == 'female') checked @endif disabled>
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
                                <input type="date" name="due_date" class="form-control" value="{{ $order->due_date instanceof \DateTime ? $order->due_date->format('Y-m-d') : \Carbon\Carbon::parse($order->due_date)->format('Y-m-d') }}" disabled>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>{{ trans('messages.type') }}</label>
                                <select class="form-control select2" id="typeOfWorkSelect" name="typeofwork_id" disabled>
                                    @foreach ($typeofWorks as $typeofWork)
                                    <option value="{{ $typeofWork->id }}" @if($order->typeofwork_id == $typeofWork->id) selected @endif>{{ $typeofWork->name }}</option>
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
                                        <div class="activity-detail">
                                            <div class="mb-2">
                                                <span class="text-job text-primary">{{ $status->updatedBy->role ?? 'User' }}, {{ $status->updatedBy->last_name }}, {{ $status->updatedBy->first_name }},
                                                </span>
                                                <span class="bullet"></span>
                                                <span class="text-job text-info">{{ $status->created_at->format('d/m/Y') }}</span>
                                            </div>
                                            <p><span style="font-weight: bold">{{ trans('messages.status') }}:</span> {{ $status->status }}</p>
                                            <p><span style="font-weight: bold">{{ trans('messages.note') }}:</span> {{ $status->note }}</p>
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
                </div>
            </div>
            {{-- End Note Section --}}

            {{-- Image Section --}}
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ trans('messages.upload_image_or_pdf') }}:</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <div class="form-group col-12">
                                    <div class="form-group col-12" id="previewContainer" style="display: flex; align-items: center; flex-wrap: nowrap; overflow-x: auto; gap: 20px;">
                                        @php
                                            $filePaths = $order->pdf ? json_decode($order->pdf, true) : [];
                                        @endphp
                                        @if (!empty($filePaths))
                                            @foreach ($filePaths as $filePath)
                                                @if (pathinfo($filePath, PATHINFO_EXTENSION) === 'pdf')
                                                    <a href="{{ asset($filePath) }}" download style="flex-shrink: 0; display: inline-flex; align-items: center;">
                                                        View PDF
                                                    </a>
                                                @else
                                                    <a href="{{ asset($filePath) }}" download style="flex-shrink: 0; display: inline-flex; align-items: center;">
                                                        <img src="{{ asset($filePath) }}" alt="Uploaded Image" style="height: 40px; width: auto;">
                                                    </a>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
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
                                <label>{{ trans('messages.stl_upper') }} <i class="fas fa-arrow-up"></i></label>
                                <div id="stl_upper" style="width:300px; height:300px; margin:0 auto;{{ !$order->stl_upper ? ' display:none;' : '' }}">
                                </div>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label>{{ trans('messages.stl_lower') }} <i class="fas fa-arrow-down"></i></label>
                                <div id="stl_lower" style="width:300px; height:300px; margin:0 auto;{{ !$order->stl_lower ? ' display:none;' : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End STL Section --}}
        </div>
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
    });
</script>
@endpush
