@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('messages.invoice') }} #{{ $invoice->invoice_number }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.dashboard') }}</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.invoices.index') }}">{{ __('messages.invoices') }}</a></div>
            <div class="breadcrumb-item active">{{ __('messages.view_invoice') }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">

            {{-- Creator Info --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h4>{{ __('messages.created_by_user') }}</h4></div>
                    <div class="card-body">
                        <p><strong>{{ __('messages.user') }}:</strong> {{ $invoice->user?->first_name }} {{ $invoice->user?->last_name }} ({{ $invoice->user?->email }})</p>
                    </div>
                </div>
            </div>

            {{-- Doctor Info --}}
            @if ($invoice->doctor)
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h4>{{ __('messages.doctor') }}</h4></div>
                    <div class="card-body">
                        <p>{{ $invoice->doctor->first_name }} {{ $invoice->doctor->last_name }} ({{ $invoice->doctor->email }})</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Invoice Details --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h4>{{ __('messages.invoice_details') }}</h4></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>{{ __('messages.invoice_number') }}:</strong> {{ $invoice->invoice_number }}</p>
                                <p><strong>{{ __('messages.total_amount') }}:</strong> {{ number_format($invoice->total_amount, 2) }}</p>
                                <p><strong>{{ __('messages.status') }}:</strong>
                                    @switch($invoice->status)
                                        @case('paid')
                                            <span class="badge badge-success">{{ __('messages.paid') }}</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge badge-warning">{{ __('messages.cancelled') }}</span>
                                            @break
                                        @default
                                            <span class="badge badge-danger">{{ __('messages.unpaid') }}</span>
                                    @endswitch
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>{{ __('messages.invoice_date') }}:</strong> {{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') : '-' }}</p>
                                <p><strong>{{ __('messages.due_date') }}:</strong> {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') : '-' }}</p>
                                <p><strong>{{ __('messages.payment_method') }}:</strong> {{ $invoice->payment_method ?? '-' }}</p>
                            </div>
                        </div>

                        @if ($invoice->notes)
                            <div class="mt-3">
                                <p><strong>{{ __('messages.notes') }}:</strong></p>
                                <p>{{ $invoice->notes }}</p>
                            </div>
                        @endif

                        @if ($invoice->pdf_path)
                            <div class="mt-3">
                                <p><strong>{{ __('messages.invoice_pdf') }}:</strong></p>
                                <a href="{{ asset($invoice->pdf_path) }}" target="_blank" class="btn btn-outline-primary">
                                    {{ __('messages.view_pdf') }}
                                </a>
                            </div>
                        @endif

                        {{-- Download PDF Button --}}
                        <div class="mt-3">
                            <a href="{{ route('admin.invoices.download', $invoice) }}" class="btn btn-success">
                                {{ __('messages.download_invoice_pdf') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Attached Scans --}}
            @if ($invoice->scans && $invoice->scans->count())
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><h4>{{ __('messages.attached_scans') }}</h4></div>
                        <div class="card-body">
                            <ul>
                                @foreach($invoice->scans as $scan)
                                    <li>
                                        Scan #{{ $scan->id }} —
                                        {{ $scan->created_at->format('d/m/Y') }}
                                        @if ($scan->file)
                                            – <a href="{{ asset($scan->file) }}" target="_blank">{{ __('messages.view_file') }}</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>
@endsection
