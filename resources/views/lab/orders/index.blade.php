@extends('lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Orders</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('lab.dashboard') }}">Dashboard</a></div>
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
                                <table id="example" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Doctor Name</th>
                                            <th>STL UPPER</th>
                                            <th>STL LOWER</th>
                                            <th>PDF</th>
                                            <th>Due Date</th>
                                            <th>Notes</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr onclick="window.location='{{ route('lab.orders.show', $order->id) }}';"
                                                style="cursor:pointer;">
                                                <td>Dr. {{ $order->doctor->last_name }}, {{ $order->doctor->first_name }}</td>
                                                <td><a href="#" class="btn btn-secondary">test {{ $order->stl_upper }}</a></td>
                                                <td>{{ $order->stl_lower }}</td>
                                                <td>{{ $order->pdf }}</td>
                                                <td>{{ $order->due_date->format('d/m/Y') }}</td>
                                                <td>{{ $order->notes }}</td>
                                                <td>
                                                    <div class="badge
                                                    {{ $order->status == 'pending' ? 'badge-warning' : '' }}
                                                    {{ $order->status == 'in_progress' ? 'badge-info' : '' }}
                                                    {{ $order->status == 'completed' ? 'badge-success' : '' }}
                                                    {{ $order->status == 'cancelled' ? 'badge-danger' : '' }}">
                                                    {{ $order->status }}
                                                </div>
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
        new DataTable('#example', {
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    </script>
@endpush
