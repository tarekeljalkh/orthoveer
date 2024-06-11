@extends('second_lab.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('second_lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ trans('messages.dhl_order') }}</h1>
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
                        <h4>{{ trans('messages.dhl_order') }}: {{ $order->scan_id }}</h4>
                    </div>
                    <div class="card-body">
                        <h2>Order Details</h2>
                        <div><strong>Order ID:</strong> {{ $order->scan_id }}</div>
                        <div><strong>Date:</strong> {{ $order->created_at->format('Y-m-d') }}</div>
                        <div><strong>To Name:</strong> ORTHOVEER</div>
                        <div><strong>Destination Street:</strong> 17 rue du petit Albi</div>
                        <div><strong>Destination City:</strong> Cergy</div>
                        <div><strong>Destination Postcode:</strong> 95800</div>
                        <div><strong>Destination State:</strong> Bloc C2 Porte 203</div>
                        <div><strong>Destination Country:</strong> France</div>
                        <div><strong>Destination Email:</strong> orthoveer@gmail.com</div>
                        <div><strong>Destination Phone:</strong> 0745556967</div>
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
