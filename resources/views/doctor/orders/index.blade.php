@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.orders') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('doctor.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.orders') }}</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('messages.all_orders') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="orders" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('messages.patient_name') }}</th>
                                            <th>{{ trans('messages.scan_date') }}</th>
                                            <th>{{ trans('messages.due_date') }}</th>
                                            <th>{{ trans('messages.status') }}</th>
                                            <th>{{ trans('messages.note') }}</th>
                                            <th>{{ trans('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->patient->last_name }}, {{ $order->patient->first_name }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($order->scan_date)->format('d/m/Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order->due_date)->format('d/m/Y') }}</td>
                                                <td>

                                                    @isset($order->latestStatus)
                                                        <div
                                                            class="badge
                                                                {{ $order->latestStatus->status == 'pending' ? 'badge-primary' : '' }}
                                                                {{ $order->latestStatus->status == 'resubmitted' ? 'badge-warning' : '' }}
                                                                {{ $order->latestStatus->status == 'delivered' ? 'badge-info' : '' }}
                                                                {{ $order->latestStatus->status == 'completed' ? 'badge-success' : '' }}
                                                                {{ $order->latestStatus->status == 'rejected' ? 'badge-danger' : '' }}">
                                                            {{ $order->latestStatus->status }}
                                                        </div>
                                                    @endisset
                                                </td>
                                                <td>
                                                    @isset($order->latestStatus)
                                                        {{ $order->latestStatus->note }}
                                                    @endisset
                                                </td>
                                                <td>
                                                    <a href="{{ route('doctor.orders.edit', $order->id) }}"
                                                        class="btn btn-primary">{{ trans('messages.edit') }}</a>
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
        new DataTable('#orders', {
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
