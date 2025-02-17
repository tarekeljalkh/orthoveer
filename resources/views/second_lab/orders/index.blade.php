@extends('second_lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('second_lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.dhl_orders') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('second_lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.dhl_orders') }}</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('messages.dhl_orders') }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('second_lab.orders.create') }}" class="btn btn-success">{{ trans('messages.create_new_ticket') }} <i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="orders" class="display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Scan ID</th>
                                        <th>Doctor</th>
                                        <th>Street</th>
                                        <th>Suburb</th>
                                        <th>Postcode</th>
                                        <th>Country</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr onclick="window.location='{{ route('second_lab.orders.show', $order->id) }}';" style="cursor:pointer;">
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->scan_id }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->street }}</td>
                                            <td>{{ $order->suburb }}</td>
                                            <td>{{ $order->postcode }}</td>
                                            <td>{{ $order->country }}</td>
                                            <td>
                                                <div class="badge
                                                    {{ $order->status == 'pending' ? 'badge-warning' : '' }}
                                                    {{ $order->status == 'delivered' ? 'badge-success' : '' }}">
                                                    {{ $order->status }}
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
