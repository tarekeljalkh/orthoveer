<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Invoice &mdash; Stisla</title>
    <style>
        /* General styles */
        body {
            font-family: 'Helvetica', sans-serif;
            background-color: #ffffff;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Layout styles */
        .container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        .invoice-title {
            text-align: left;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #555;
        }

        .invoice-number {
            float: right;
            font-size: 18px;
            font-weight: normal;
            color: #555;
        }

        .address,
        .payment-method {
            font-size: 12px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 16px;
            color: #e67e22;
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .section-lead {
            font-size: 12px;
            color: #777;
            margin-bottom: 15px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 12px;
            text-align: left;
        }

        .table th {
            background-color: #f9f9f9;
            color: #555;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .invoice-detail-item {
            margin-top: 10px;
            padding: 5px 0;
            font-size: 12px;
            color: #333;
        }

        hr {
            border: 0;
            border-top: 1px solid #eee;
            margin: 20px 0;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .no-print {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="invoice-title">
            Invoice
            <div class="invoice-number">Order #12345</div>
        </div>
        <hr>
        <div class="row clearfix">
            <div class="col-md-6">
                <div class="address">
                    <strong>Billed To:</strong><br>
                    Ujang Maman<br>
                    1234 Main<br>
                    Apt. 4B<br>
                    Bogor Barat, Indonesia
                </div>
            </div>
            <div class="col-md-6 text-right">
                <div class="address">
                    <strong>Shipped To:</strong><br>
                    Muhamad Nauval Azhar<br>
                    1234 Main<br>
                    Apt. 4B<br>
                    Bogor Barat, Indonesia
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-6">
                <div class="payment-method">
                    <strong>Payment Method:</strong><br>
                    Visa ending **** 4242<br>
                    ujang@maman.com
                </div>
            </div>
            <div class="col-md-6 text-right">
                <div class="address">
                    <strong>Order Date:</strong><br>
                    September 19, 2018<br><br>
                </div>
            </div>
        </div>

        <div class="section-title">Order Summary</div>
        <p class="section-lead">All items here cannot be deleted.</p>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-right">Totals</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Mouse Wireless</td>
                    <td class="text-center">$10.99</td>
                    <td class="text-center">1</td>
                    <td class="text-right">$10.99</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Keyboard Wireless</td>
                    <td class="text-center">$20.00</td>
                    <td class="text-center">3</td>
                    <td class="text-right">$60.00</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Headphone Blitz TDR-3000</td>
                    <td class="text-center">$600.00</td>
                    <td class="text-center">1</td>
                    <td class="text-right">$600.00</td>
                </tr>
            </tbody>
        </table>

        <div class="row clearfix">
            <div class="col-lg-8">
                <!-- Additional content if needed -->
            </div>
            <div class="col-lg-4 text-right">
                <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Subtotal</div>
                    <div class="invoice-detail-value">$670.99</div>
                </div>
                <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Shipping</div>
                    <div class="invoice-detail-value">$15</div>
                </div>
                <hr>
                <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Total</div>
                    <div class="invoice-detail-value invoice-detail-value-lg">$685.99</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
