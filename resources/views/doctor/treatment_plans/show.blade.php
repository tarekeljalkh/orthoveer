@if ($plan->status === 'review')
    <div class="mt-4">
        <form action="{{ route('doctor.treatment-plans.accept', $plan->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button class="btn btn-success">Accept</button>
        </form>

        <form action="{{ route('doctor.treatment-plans.refuse', $plan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to refuse?');">
            @csrf
            @method('PATCH')
            <button class="btn btn-danger">Refuse</button>
        </form>
    </div>
@endif
