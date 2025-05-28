@extends('second_lab.layouts.master')

@section('content')
<section class="section">
    <div class="section-header"><h1>Submit Final STL Link</h1></div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <p><strong>Notes from Doctor:</strong> {{ $plan->notes }}</p>

                <p><strong>Uploaded Files:</strong></p>
                <ul>
                    @foreach (json_decode($plan->uploaded_files, true) ?? [] as $file)
                        <li><a href="{{ asset('storage/' . $file) }}" target="_blank">View File</a></li>
                    @endforeach
                </ul>

                <form action="{{ route('second_lab.treatment-plans.submit-link', $plan->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Final STL Web Link</label>
                        <input type="url" name="external_stl_link" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Submit Link to Doctor</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
