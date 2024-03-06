@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Orders</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Orders</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Orders</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="orders" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Patient Name</th>
                                            <th>Scan Date</th>
                                            <th>Due Date</th>
                                            <th>Procedure</th>
                                            <th>Order Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->patient->last_name }}, {{ $order->patient->first_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order->scan_date)->format('d/m/Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order->due_date)->format('d/m/Y') }}</td>
                                                <td>{{ $order->procedure }}</td>
                                                @if ($order->status == 'pending')
                                                    <td>
                                                        <div class="badge badge-info">Pending</div>
                                                    </td>
                                                @elseif ($order->status == 'in_progress')
                                                    <td>
                                                        <div class="badge badge-primary">In Progress</div>
                                                    </td>
                                                @elseif ($order->status == 'completed')
                                                    <td>
                                                        <div class="badge badge-success">Completed</div>
                                                    </td>
                                                @elseif ($order->status == 'canceled')
                                                    <td>
                                                        <div class="badge badge-danger">Canceled</div>
                                                    </td>
                                                @endif

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
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    </script>
@endpush
