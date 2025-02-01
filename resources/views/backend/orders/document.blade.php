<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @page {
            size: A4;
            margin: 0;
            padding: 0;
        }

        body {
            width: 100%;
            font-family: Helvetica, Arial, sans-serif;
            font-size: 12px;
            margin: 0 !important;
            padding: 0 !important;
        }

        p {
            line-height: 20px !important;
        }

        .card {
            width: 100%;
            margin: 0 !important;
            padding: 0 !important;
            color: #2f2d2d;
        }

        .header {
            padding: 10px 0;
            background-color: #FF0001;
            color: #fff;
        }

        .header .title {
            margin-top: auto !important;
            margin-bottom: auto !important;
            font-size: 38px;
            line-height: 45px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .header .logo {
            margin: auto;
            width: auto;
            height: 40px;
            object-fit: contain;
            object-position: center center;
        }

        .content {
            padding: 0px 50px;
            border: none;
        }

        .table {
            width: 100%;
            border-spacing: 0 !important;
            border-collapse: collapse;
            border: none ! important;
            margin-top: 40px;
        }

        .table th,
        .table td {
            padding: 5px 8px;
            font-size: 12px;
            line-height: 15px;
            font-weight: 400;
            text-align: center;
        }

        table td {
            padding: 0 8px;
            font-size: 12px;
            line-height: 15px;
            font-weight: 400;
        }

        table td p {
            margin-top: 0 !important;
            margin-bottom: 2px !important;
        }

        .table tr td.border-bottom,
        .table tr.border-bottom {
            border-bottom: 1px solid #c5c5c5 !important;
        }

        .table tr th {
            background-color: #000;
            color: #fff
        }

        .table tr td {
            padding: 10px;
            background-color: #fff;
            color: #2f2d2d;
        }

        .footer {
            width: 100%;
            padding-bottom: 5px;
            font-size: 12px;
            line-height: 15px;
            text-align: center;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .footer .copy {
            margin-top: 5px !important;
            margin-bottom: 10px !important;
            color: #6c757d;
            text-transform: uppercase;
        }

        .footer table td {
            font-size: 12px;
            line-height: 15px;
            font-weight: 400;
            text-align: center;
        }

        .badge-success {
            font-size: 12px;
            line-height: 14px;
            padding: 3px 10px;
            border-radius: 5px;
            border: #086d08 solid 1px;
            background-color: #c3e6cb;
            color: #086d08;
        }

        .badge-danger {
            font-size: 12px;
            line-height: 14px;
            padding: 3px 10px;
            border-radius: 5px;
            border: #FF4646 solid 1px;
            color: #FF4646;
            background-color: #f8d7da;
        }

        .text-primary {
            color: #FF4646 !important;
        }

        .text-muted {
            color: #727272 !important;
        }

        .divider {
            margin-top: 0;
            margin-bottom: 5px;
            border: none;
            border-top: 1px solid #c5c5c5 !important;
        }
    </style>

</head>

<body>

    <div class="card">
        <div class="header">
            <div class="content">
                <table width="100%">
                    <tr>
                        <td align="left" valign="center" style="vertical-align: middle;">
                            <img class="logo"
                                src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/frontend/images/logo/invoice.png'))) }}">
                        </td>
                        <td align="right" style="vertical-align: middle;">
                            <h4 class="title">Invoice</h4>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="content">
            <table width="100%" style="margin-top: 20px;">
                <tr>
                    <td colspan="2" align="right">
                        <p class="text-primary">Invoice Date: {{ $order->created_at->format('Y-m-d') }}</p>
                        <p class="text-primary">Order ID: {{ $order->ref }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3 style="margin-top: 4px;">Invoice from:</h3>
                        <p style="margin-bottom: 0 !important;">DigiMax.lk</p>
                        <p style="margin-bottom: 0 !important;">No:11 Main Street, <br> Battaramulla, Sri Lanka</p>
                        <p style="margin-bottom: 0 !important;">www.digimax.lk</p>
                    </td>
                    <td align="right">
                        <h3 style="margin-top: 4px;">Invoice to:</h3>
                        <p style="margin-bottom: 0 !important;">{{ $order->customer_first_name }}
                            {{ $order->customer_last_name }}</p>
                        <p style="margin-bottom: 0 !important;">{{ $order->address }}</p>
                        <p style="margin-bottom: 0 !important;">{{ $order->phone }}</p>
                    </td>
                </tr>
            </table>

            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5px"><strong>#</strong></th>
                        <th><strong>Product</strong></th>
                        <th style="width: 100px"><strong>Unit Price</strong></th>
                        <th><strong>Qty</strong></th>
                        <th style="width: 100px"><strong>Total</strong></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($order->orderItems as $index => $order_item)
                        <tr class="border-bottom">
                            <td>
                                {{ $index + 1 }}
                            </td>
                            <td style="text-align: left !important;">{{ $order_item->productVariation->product->name }}
                                @if ($order_item->productVariation->values->count() > 0)
                                    (@foreach ($order_item->productVariation->values as $type)
                                        {{ $type->variationValue->variable }}
                                        @if (!$loop->last)
                                            |
                                        @endif
                                    @endforeach)
                                @endif
                            </td>
                            <td>LKR {{ number_format($order_item->price, 2) }}</td>
                            <td>{{ $order_item->qty }}</td>
                            <td style="text-align: right !important;">
                                LKR {{ number_format($order_item->price * $order_item->qty, 2) }}
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="4" style="text-align: right !important;"><strong>Sub Total</strong></td>
                        <td style="text-align: right !important;">LKR
                            {{ number_format($order->sub_total, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right !important;"><strong>Delivery Charge</strong></td>
                        <td style="text-align: right !important;">LKR
                            {{ number_format($order->delivery_fee, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <table width="100%">
                <tr>
                    <td align="left" style="padding: 0 !important;">
                        <h3>PAYMENT INFO</h3>
                    </td>
                    <td align="right" style="padding: 0 !important;">
                        <h3>TOTAL AMOUNT</h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right" style="padding: 0 !important;">
                        <hr class="divider">
                    </td>
                </tr>
                <tr>
                    <td align="left" style="padding: 0 !important;">
                        <p>Payment Method: <strong>{{ $order->payment->payment_method }}</strong></p>
                        <p>Payment Status: <strong>{{ $order->payment->payment_status }}</strong></p>
                    </td>
                    <td align="right" style="padding: 0 !important;">
                        <h1 class="text-primary" style="margin-top: 10px;">LKR {{ number_format($order->total, 2) }}
                        </h1>
                    </td>
                </tr>
            </table>

            <div style="margin-top: 30px; margin-bottom: 150px;">
                <hr class="divider">
                <p>Additional Note:</p>
            </div>

        </div>

        <div class="footer">
            <div style=" padding: 0 60px;">
                <p style="padding-bottom: 0 !important; line-height: 13px !important;"><strong>Thank you for
                        shopping with
                        us!</strong></p>
                <p style="padding-bottom: 0 !important; line-height: 13px !important;">
                    For any inquiries regarding this invoice, please contact our support team at
                    info@digimax.lk or <br> visit us at www.digimax.lk for more amazing deals!
                </p>
                <p class="copy">This is a system-generated invoice. No signature is required.</p>
            </div>
        </div>
    </div>

</body>

</html>
