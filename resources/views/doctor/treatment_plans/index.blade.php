@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Treatment Plans</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @if ($treatmentPlans->isEmpty())
                        <p>No treatment plans yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Scan ID</th>
                                        <th>Status</th>
                                        <th>Notes</th>
                                        <th>Files</th>
                                        <th>Created</th>
                                        <th>Action</th> {{-- Add this --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($treatmentPlans as $plan)
                                        <tr>
                                            <td>{{ $plan->id }}</td>
                                            <td>
                                                @if ($plan->scan)
                                                    <a href="{{ route('doctor.scans.show', $plan->scan->id) }}">
                                                        #{{ $plan->scan->id }}
                                                    </a>
                                                @else
                                                    <em>No scan</em>
                                                @endif
                                            </td>
                                            <td>{{ ucfirst($plan->status) }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($plan->notes, 50) }}</td>
                                            <td>
                                                @foreach (json_decode($plan->uploaded_files, true) ?? [] as $file)
                                                    <a href="{{ asset('storage/' . $file) }}" target="_blank">View</a><br>
                                                @endforeach
                                            </td>
                                            <td>{{ $plan->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                @if ($plan->status === 'review')
                                                    <form action="{{ route('doctor.treatment-plans.accept', $plan->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="btn btn-success btn-sm">Accept</button>
                                                    </form>

                                                    <form action="{{ route('doctor.treatment-plans.refuse', $plan->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Refuse this plan?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="btn btn-danger btn-sm">Refuse</button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">No actions</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
