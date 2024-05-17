@extends('lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.orders') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.orders') }}</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('messages.orders') }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('lab.orders.create') }}" class="btn btn-success">{{ trans('messages.create_new') }} <i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="orders" class="display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>DHL TRACKING NUMBER</th>
                                        <th>Origin</th>
                                        <th>destination</th>
                                        <th>Scans</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr onclick="window.location='{{ route('lab.orders.show', $order->id) }}';"
                                        style="cursor:pointer;">
                                        <td>{{ $order->id }}</td>
                                            <td>{{ $order->dhl_tracking_number }}</td>
                                            <td>{{ $order->origin }}</td>
                                            <td>{{ $order->destination }}</td>
                                            <td>
                                                @foreach ($order->scans as $scan)
                                                    {{ $scan }}
                                                @endforeach
                                            </td>
                                            <td>
                                                <div
                                                    class="badge
                                                        {{ $order->status == 'pending' ? 'badge-warning' : '' }}
                                                        {{ $order->status == 'resubmitted' ? 'badge-info' : '' }}
                                                        {{ $order->status == 'completed' ? 'badge-success' : '' }}
                                                        {{ $order->status == 'rejected' ? 'badge-danger' : '' }}">
                                                    {{ $order->status ?? 'No status' }}
                                                </div>
                                            </td>
                                            <td>{{ $order->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    </script>
@endpush
