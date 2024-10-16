@extends('lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lab.printfiles.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Add New Print File</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ route('lab.printfiles.index') }}">All Print Files</a></div>
                <div class="breadcrumb-item"><a href="#">Add new Print File</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('lab.printfiles.store') }}" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4>Add new Print File</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Hidden field to store scan_id -->
                                    <input type="hidden" name="scan_id" value="{{ $scan_id }}">

                                    <div class="form-group col-md-12 col-12">
                                        <label>Upload Print File</label>
                                        <input type="file" name="file" class="form-control" id="file" accept=".zip" required>
                                        <div class="invalid-feedback">
                                            Please upload a valid ZIP file.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">{{ trans('messages.add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
