@extends('doctor.layouts.master')

@section('content')
<section class="section">
    <div class="section-header"><h1>Review Treatment Plan</h1></div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <p><strong>Scan ID:</strong> {{ $plan->scan_id }}</p>
                <p><strong>Status:</strong> {{ ucfirst($plan->status) }}</p>
                <p><strong>Notes:</strong> {{ $plan->notes ?? 'N/A' }}</p>

                <hr>
                <p><strong>Uploaded Files:</strong></p>
                <ul>
                    @foreach (json_decode($plan->uploaded_files, true) ?? [] as $file)
                        <li><a href="{{ asset('storage/' . $file) }}" target="_blank">View File</a></li>
                    @endforeach
                </ul>

                @if ($plan->external_stl_link)
                    <hr>
                    <p><strong>External Lab STL Link:</strong></p>
                    <a href="{{ $plan->external_stl_link }}" target="_blank">{{ $plan->external_stl_link }}</a>
                @endif
            </div>

            @if ($plan->status === 'review')
            <div class="card-footer text-right">
                <form action="{{ route('doctor.treatment-plans.approve', $plan->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    <button class="btn btn-success">Approve</button>
                </form>
                <form action="{{ route('doctor.treatment-plans.reject', $plan->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    <button class="btn btn-danger">Reject</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
