@extends('second_lab.layouts.master')

@section('content')
<section class="section">
    <div class="section-header"><h1>Treatment Plans to Process</h1></div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                @forelse ($plans as $plan)
                    <div class="mb-3">
                        <p><strong>Scan ID:</strong> {{ $plan->scan_id }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($plan->status) }}</p>
                        <a href="{{ route('second_lab.treatment-plans.show', $plan->id) }}" class="btn btn-sm btn-primary">View</a>
                    </div>
                    <hr>
                @empty
                    <p>No plans assigned yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
