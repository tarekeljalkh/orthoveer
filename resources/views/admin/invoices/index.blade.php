@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.invoices') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('admin.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.invoices') }}</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('messages.invoices') }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.invoices.create') }}" class="btn btn-success">
                                    {{ trans('messages.create_new') }} <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="invoices" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('messages.id') }}</th>
                                            <th>{{ trans('messages.invoice_number') }}</th>
                                            <th>{{ trans('messages.user') }}</th>
                                            <th>{{ trans('messages.total_amount') }}</th>
                                            <th>{{ trans('messages.status') }}</th>
                                            <th>{{ trans('messages.invoice_date') }}</th>
                                            <th>{{ trans('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td>{{ $invoice->id }}</td>
                                                <td>{{ $invoice->invoice_number }}</td>
                                                <td>{{ $invoice->user->first_name }} {{ $invoice->user->last_name }}</td>
                                                <td>{{ number_format($invoice->total_amount, 2) }}</td>
                                                <td>
                                                    @if ($invoice->status === 'paid')
                                                        <div class="badge badge-success">{{ trans('messages.paid') }}</div>
                                                    @else
                                                        <div class="badge badge-danger">{{ trans('messages.unpaid') }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $invoice->invoice_date ? $invoice->invoice_date->format('d/m/Y') : '-' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.invoices.edit', $invoice->id) }}"
                                                        class="btn btn-primary">
                                                        {{ trans('messages.edit') }}
                                                    </a>
                                                    <a href="{{ route('admin.invoices.show', $invoice->id) }}"
                                                        class="btn btn-info">
                                                        {{ trans('messages.show') }}
                                                    </a>
                                                    <a href="{{ route('admin.invoices.download', $invoice->id) }}"
                                                        class="btn btn-success">
                                                        {{ trans('messages.download_pdf') }}
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        new DataTable('#invoices', {
            layout: {
                topStart: {
                    buttons: [
                        'excel',
                        'pdf',
                        'print',
                    ]
                }
            },
            select: true
        });
    </script>
@endpush
