@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ __('messages.edit_invoice') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('messages.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">
                    <a href="{{ route('admin.invoices.index') }}">{{ __('messages.invoice') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('messages.edit_invoice') }}</div>
            </div>
        </div>

        <div class="section-body">
            <form action="{{ route('admin.invoices.update', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    {{-- Invoice Details --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('messages.invoice_details') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label for="user_id">{{ __('messages.created_by_user') }} <span class="text-danger">*</span></label>
                                        <select name="user_id" class="form-control select2" required>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ $invoice->user_id == $user->id ? 'selected' : '' }}>
                                                    {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="doctor_id">{{ __('messages.doctors') }} <span class="text-danger">*</span></label>
                                        <select id="doctor_id" name="doctor_id" class="form-control select2" required>
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}" {{ $invoice->doctor_id == $doctor->id ? 'selected' : '' }}>
                                                    {{ $doctor->first_name }} {{ $doctor->last_name }} ({{ $doctor->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>{{ __('messages.invoice_date') }}</label>
                                        <input type="date" name="invoice_date" class="form-control"
                                            value="{{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') : '' }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>{{ __('messages.due_date') }}</label>
                                        <input type="date" name="due_date" class="form-control"
                                            value="{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') : '' }}">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>{{ __('messages.total_amount') }} <span class="text-danger">*</span></label>
                                        <input type="text" step="0.01" name="total_amount" id="totalDisplay"
                                            class="form-control" value="{{ number_format($invoice->total_amount, 2, '.', '') }}" readonly required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="status">{{ __('messages.status') }}</label>
                                        <select name="status" class="form-control">
                                            <option value="unpaid" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>
                                                {{ __('messages.unpaid') }}</option>
                                            <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>
                                                {{ __('messages.paid') }}</option>
                                            <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>
                                                {{ __('messages.cancelled') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.payment_method') }}</label>
                                    <input type="text" name="payment_method" class="form-control" value="{{ $invoice->payment_method }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.notes') }}</label>
                                    <textarea name="notes" class="form-control" rows="3">{{ $invoice->notes }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.upload_invoice_pdf') }}</label>
                                    <input type="file" name="pdf_path" class="form-control">
                                    @if ($invoice->pdf_path)
                                        <small class="d-block mt-1">
                                            <a href="{{ asset($invoice->pdf_path) }}" target="_blank">View Existing PDF</a>
                                        </small>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="scans">{{ __('messages.attach_scans') }}</label>
                                    <select name="scans[]" id="scans" class="form-control select2" multiple>
                                        @foreach ($scans as $scan)
                                            <option value="{{ $scan->id }}" {{ $invoice->scans->contains($scan->id) ? 'selected' : '' }}>
                                                Scan #{{ $scan->id }} - {{ $scan->created_at->format('d/m/Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">{{ __('messages.update_invoice') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
function calculateTotal() {
    const doctorId = $('#doctor_id').val();
    const scans = $('#scans').val();

    console.log('Doctor ID:', doctorId);
    console.log('Selected scans:', scans);

    if (doctorId && scans && scans.length) {
        $.ajax({
            url: '{{ route('admin.invoices.calculateTotal') }}',
            data: { doctor_id: doctorId, scans: scans },
            success: function(response) {
                if (response.total !== undefined) {
                    $('#totalDisplay').val(parseFloat(response.total).toFixed(2));
                } else {
                    $('#totalDisplay').val('0.00');
                }
            },
            error: function() {
                $('#totalDisplay').val('0.00');
            }
        });
    } else {
        $('#totalDisplay').val('0.00');
    }
}

$(document).ready(function() {

    // Bind change event on doctor and scans selects
    $('#doctor_id, #scans').on('change', calculateTotal);

    // Calculate total on page load
    calculateTotal();
});
</script>
@endpush
