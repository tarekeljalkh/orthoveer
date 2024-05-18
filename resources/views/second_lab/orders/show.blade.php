@extends('second_lab.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('second_lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ trans('orders') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('second_lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ trans('order') }}: {{ $order->id }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ trans('order') }}: {{ $order->id }}</h4>
                    </div>
                    <div class="card-body">
                        <h2>Order Details</h2>
                        <div><strong>Order ID:</strong> {{ $order->id }}</div>
                        <div><strong>Date:</strong> {{ $order->date ? $order->date->format('Y-m-d') : 'Date not set' }}</div>
                        <div><strong>To Name:</strong> {{ $order->to_name }}</div>
                        <div><strong>Destination Street:</strong> {{ $order->destination_street }}</div>
                        <div><strong>Destination City:</strong> {{ $order->destination_city }}</div>
                        <div><strong>Destination Postcode:</strong> {{ $order->destination_postcode }}</div>
                        <div><strong>Destination State:</strong> {{ $order->destination_state }}</div>
                        <div><strong>Destination Country:</strong> {{ $order->destination_country }}</div>
                        <div><strong>Destination Email:</strong> {{ $order->destination_email }}</div>
                        <div><strong>Destination Phone:</strong> {{ $order->destination_phone }}</div>
                        <div><strong>Item Name:</strong> {{ $order->item_name }}</div>
                        <div><strong>Item Price:</strong> {{ $order->item_price }}</div>
                        <div><strong>Weight:</strong> {{ $order->weight }}</div>
                        <div><strong>Shipping Method:</strong> {{ $order->shipping_method }}</div>
                        <div><strong>Reference:</strong> {{ $order->reference }}</div>
                        <div><strong>SKU:</strong> {{ $order->sku }}</div>
                        <div><strong>Quantity:</strong> {{ $order->qty }}</div>
                        <div><strong>Company:</strong> {{ $order->company }}</div>
                        <div><strong>Carrier:</strong> {{ $order->carrier }}</div>
                        <div><strong>Carrier Product Code:</strong> {{ $order->carrier_product_code }}</div>
                        <div><strong>Status:</strong> {{ $order->status }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
