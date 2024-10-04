@extends('lab.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('lab.printfiles.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Edit Print File</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
            <div class="breadcrumb-item"><a href="{{ route('lab.printfiles.index') }}">All Print Files</a></div>
            <div class="breadcrumb-item"><a href="#">Edit Print File</a></div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('lab.printfiles.update', $printFile->id) }}" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4>Edit Print File</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12 col-12">
                                    <label>Current File</label>
                                    <p>
                                        <a href="{{ asset('storage/' . $printFile->file_path) }}" class="btn btn-link" target="_blank">Download Current File</a>
                                    </p>
                                </div>
                                <div class="form-group col-md-12 col-12">
                                    <label>Upload New Print File (ZIP)</label>
                                    <input type="file" name="file" class="form-control" id="file" accept=".zip">
                                    <small class="form-text text-muted">Leave blank if you don't want to replace the existing file.</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">{{ trans('messages.update') }}</button>
                        </div>
                    </form>

                    <!-- Delete Form -->
                    <form action="{{ route('lab.printfiles.destroy', $printFile->id) }}" method="post" style="margin-top: 10px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this file?');">{{ trans('messages.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
