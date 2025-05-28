@extends('doctor.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>New Treatment Plan</h1>
    </div>

    <div class="section-body">
        <form action="{{ route('doctor.treatment-plans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card">
                <div class="card-body">

                    <div class="form-group">
                        <label>Select Scan <span class="text-danger">*</span></label>
                        <select name="scan_id" class="form-control select2" required>
                            <option value="" disabled selected>Select a Scan</option>
                            @foreach ($scans as $scan)
                                <option value="{{ $scan->id }}">
                                    Scan #{{ $scan->id }} — {{ $scan->created_at->format('Y-m-d') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Upload Files (STL, Images, PDF)</label>
                        <input type="file" name="files[]" class="form-control" multiple required>
                    </div>

                </div>

                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>
    </div>
</section>
@endsection
