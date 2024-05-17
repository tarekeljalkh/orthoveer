@extends('lab.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Create New Order</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('lab.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('lab.orders.index') }}">Orders</a></div>
            <div class="breadcrumb-item">Create New Order</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('lab.orders.store') }}" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h4>Create New Order</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12 col-12">
                                    <label for="scans">Select Scans:</label>
                                    <select class="form-control select2" name="scans[]" id="scans" multiple>
                                        @foreach ($completedScans as $scan)
                                        <option value="{{ $scan->id }}">{{ $scan->name }} - {{ $scan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label for="origin">Origin:</label>
                                    <input type="text" class="form-control" id="origin" name="origin" required>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="destination">Destination:</label>
                                    <input type="text" class="form-control" id="destination" name="destination" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12 col-12">
                                    <label for="tracking_number">DHL Tracking Number:</label>
                                    <input type="text" class="form-control" id="tracking_number" name="tracking_number" required>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Place Order</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const origin = document.getElementById('origin').value;
            const destination = document.getElementById('destination').value;

            fetch('{{ route("dhl.shipping-rates") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ origin, destination })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('tracking_number').value = data.tracking_number; // Assuming DHL API returns a tracking number
                    form.submit(); // Submit the form once we have the tracking number
                } else {
                    console.error('Failed to fetch shipping rates: ', data.message);
                }
            })
            .catch(error => console.error('Error fetching shipping rates:', error));
        });
    });
    </script>


@endsection
