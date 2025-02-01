@extends('backend.app')
@section('page', 'Edit Order')
@section('content')
    @include('backend.components.breadcrumb')
    <div class="row top-row">

        <div class="col-12">
            @csrf
            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-lg-12">

                                <div class="d-flex justify-content-between gap-2 flex-wrap mb-3">
                                    <h4 class="header-title">Order Details</h4>

                                    <div class="d-flex gap-2">
                                        <p>
                                            Payment Status:
                                            @switch($item->payment->payment_status)
                                                @case('Paid')
                                                    @php $statusColor = 'tag-green'; @endphp
                                                @break

                                                @case('Pending')
                                                    @php $statusColor = 'tag-yellow'; @endphp
                                                @break

                                                @case('Failed')
                                                    @php $statusColor = 'tag-red'; @endphp
                                                @break

                                                @case('Returned')
                                                    @php $statusColor = 'tag-orange'; @endphp
                                                @break

                                                @default
                                                    @php $statusColor = 'tag-black'; @endphp
                                            @endswitch
                                            <span class="tag {{ $statusColor }}">
                                                {{ $item->payment->payment_status }}</span>
                                        </p>
                                        <p>
                                            Deliver Status:
                                            @switch($item->deliver_status)
                                                @case('Confirmed')
                                                    @php $statusColor = 'tag-green'; @endphp
                                                @break

                                                @case('Pending')
                                                    @php $statusColor = 'tag-yellow'; @endphp
                                                @break

                                                @case('Cancelled ')
                                                    @php $statusColor = 'tag-red'; @endphp
                                                @break

                                                @case('Delivered')
                                                    @php $statusColor = 'tag-orange'; @endphp
                                                @break

                                                @case('Returned')
                                                    @php $statusColor = 'tag-black'; @endphp
                                                @break

                                                @default
                                                    @php $statusColor = 'tag-black'; @endphp
                                            @endswitch
                                            <span class="tag {{ $statusColor }}">
                                                {{ $item->deliver_status }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-3 mb-4">
                                    <a href="{{ route('admin.orders.pdf', ['id' => $item->id, 'purpose' => 'view']) }}"
                                        target="_blank" type="button" class="btn btn-primary px-2 py-1">
                                        <i class="fi fi-rr-print"></i> Print PDF</a>

                                    <a href="{{ route('admin.orders.pdf', ['id' => $item->id, 'purpose' => 'download']) }}"
                                        type="button" class="btn btn-primary px-2 py-1"><i class="fi fi-rr-download"></i>
                                        Download
                                        PDF</a>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <div class="table-responsive mb-3 overflow-y-hidden">
                                            <table class="table table-bordered table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="min-width: 30px;">#</th>
                                                        <th style="min-width: 200px;">Product</th>
                                                        <th style="min-width: 200px;">Qty</th>
                                                        <th style="min-width: 30px;">Price</th>
                                                        <th style="min-width: 100px;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($item->orderItems as $index => $order_item)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $order_item->productVariation->product->name }}
                                                                @if ($order_item->productVariation->values->count() > 0)
                                                                    (@foreach ($order_item->productVariation->values as $type)
                                                                        {{ $type->variationValue->variable }}
                                                                        @if (!$loop->last)
                                                                            |
                                                                        @endif
                                                                    @endforeach)
                                                                @endif
                                                            </td>
                                                            <td>{{ $order_item->qty }}</td>
                                                            <td>{{ number_format($order_item->price, 2) }}</td>
                                                            <td style="text-align: right !important;">
                                                                {{ number_format($order_item->price * $order_item->qty, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="3" class="text-right">Sub Total</td>
                                                        <td style="text-align: right !important;">LKR</td>
                                                        <td style="text-align: right !important;">
                                                            {{ number_format($item->sub_total, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right">Delivery Charge</td>
                                                        <td style="text-align: right !important;">LKR</td>
                                                        <td style="text-align: right !important;">
                                                            {{ number_format($item->delivery_fee, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right">Total</td>
                                                        <td style="text-align: right !important;">LKR</td>
                                                        <td style="text-align: right !important;">
                                                            {{ number_format($item->total, 2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-12 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label" for="site_name">Order ID</label>
                                            <input type="text" name="site_name" id="site_name" class="form-control"
                                                value="{{ $item->ref }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-12 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label" for="site_name">Payment Method</label>
                                            <input type="text" name="site_name" id="site_name" class="form-control"
                                                value="{{ $item->payment->payment_method }}" disabled>
                                        </div>
                                    </div>

                                    @if ($item->payment->payment_status == 'Paid')
                                        <div class="col-12 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="date">{{ $item->payment->payment_method == 'Card' ? 'Card' : 'Admin Approved At' }}</label>
                                                <input type="text" name="date" id="date" class="form-control"
                                                    value="{{ $item->payment->updated_at->format('Y-m-d h:i A') }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="note">Note</label>
                                            <textarea class="form-control" name="note" rows="5" disabled>{{ $item->note }}</textarea>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-lg-12">

                                <h4 class="mb-3 header-title">Customer Details</h4>

                                <div class="form-group">
                                    <label class="form-label" for="customer_name">Customer name</label>
                                    <input type="text" name="customer_name" id="customer_name" class="form-control"
                                        value="{{ $item->customer_name }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        value="{{ $item->phone }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        value="{{ $item->email }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="5" disabled>{{ $item->address }}</textarea>
                                </div>

                                @if ($item->payment->payment_method == 'Card')
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="site_name">Payment Response</label>
                                            <textarea class="form-control" rows="8" disabled>{{ $item->payment->response }}</textarea>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
