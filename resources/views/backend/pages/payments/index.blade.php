@extends('backend.app')
@section('page', 'Orders')
@section('content')
    <div class="row">
        @includeFirst(['backend.components.breadcrumb'])

        <div class="col-12 overview">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card bg-pink">
                        <div class="card-body">
                            <h5 class="card-title text-white">Received Payments</h5>
                            <p class="card-text text-white">
                                LKR {{ number_format($payments->where('payment_status', 'Paid')->sum('order.total'), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-orange">
                        <div class="card-body">
                            <h5 class="card-title text-white">Pending Payments</h5>
                            <p class="card-text text-white">
                                LKR
                                {{ number_format($payments->where('payment_status', 'Pending')->sum('order.total'), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-purple">
                        <div class="card-body">
                            <h5 class="card-title text-white">Cancelled Payments</h5>
                            <p class="card-text text-white">
                                LKR
                                {{ number_format($payments->where('payment_status', 'Cancelled')->sum('order.total'), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-blue">
                        <div class="card-body">
                            <h5 class="card-title text-white">Refunded Payments</h5>
                            <p class="card-text text-white">
                                LKR
                                {{ number_format($payments->where('payment_status', 'Refunded')->sum('order.total'), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <form id="searchForm" action="" method="GET">
                    <div class="card-header">
                        <div class="row pb-3">

                            <div class="col-12 d-inline-flex align-items-center justify-content-between flex-wrap gap-3">

                                <div class="d-flex gap-2 order-0">
                                    <!--Filter-->
                                    <div>
                                        <button class="btn btn-outline-success" id="filterToggle" type="button">
                                            @if (request()->all())
                                                Clear Filter
                                            @else
                                                <i class="fi fi-rr-filter"></i>Filter
                                            @endif
                                        </button>
                                    </div>
                                    <!-- Search -->
                                    <div class="search-filter">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search" name="search"
                                                placeholder="Search here" value="{{ request('search') }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="input-group-text">
                                                    <i class="fi fi-rr-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div id="filter"
                                    class="d-flex flex-grow-1 align-items-center justify-content-center gap-3 flex-wrap {{ request()->all() ? '' : 'd-none' }} order-2">

                                    <div class="d-flex align-items-center gap-2">
                                        <input type="date" class="form-control" name="from_date"
                                            value="{{ request('from_date') }}">
                                        <span>to</span>
                                        <input type="date" class="form-control" name="to_date"
                                            value="{{ request('to_date') }}">
                                    </div>

                                    <div>
                                        <select class="form-select" name="order_status">
                                            <option value="">Select Order Status</option>
                                            <option value="Pending"
                                                {{ request('order_status') == 'Pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="Confirmed"
                                                {{ request('order_status') == 'Confirmed' ? 'selected' : '' }}>Confirmed
                                            <option value="Delivered"
                                                {{ request('order_status') == 'Delivered' ? 'selected' : '' }}>Delivered
                                            </option>
                                            <option value="Cancelled"
                                                {{ request('order_status') == 'Cancelled' ? 'selected' : '' }}>Cancelled
                                            </option>
                                            <option value="Returned"
                                                {{ request('order_status') == 'Returned' ? 'selected' : '' }}>Returned
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <select class="form-select" name="payment_status">
                                            <option value="">Select Payment Status</option>
                                            <option value="Pending"
                                                {{ request('payment_status') == 'Pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="Paid"
                                                {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>Paid
                                            </option>
                                            <option value="Failed"
                                                {{ request('payment_status') == 'Failed' ? 'selected' : '' }}>Failed
                                            </option>
                                            <option value="Refunded"
                                                {{ request('payment_status') == 'Refunded' ? 'selected' : '' }}>Refunded
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <select class="form-select" name="payment_method">
                                            <option value="">Select Payment Mode</option>
                                            <option value="Card"
                                                {{ request('payment_method') == 'Card' ? 'selected' : '' }}>Card</option>
                                            <option value="Bank Transfer"
                                                {{ request('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank
                                                Transfer</option>
                                        </select>
                                    </div>

                                </div>


                                <div class="d-flex align-items-center gap-2 order-1">
                                    <!-- Export -->
                                    <div class="dropdown">
                                        <a class="btn btn-outline-success dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                class="fi fi-rr-download"></i>Export EXCEL
                                        </a>

                                        <ul class="dropdown-menu">
                                            <li>
                                                <input type="radio" id="CSV" value="csv" name="export_type"
                                                    class="d-none">
                                                <label class="py-2 px-3 w-100" for="CSV">
                                                    CSV
                                                </label>
                                            </li>
                                            <li>
                                                <input type="radio" id="XLS" value="xls" name="export_type"
                                                    class="d-none">
                                                <label class="py-2 px-3 w-100" for="XLS">
                                                    XLS
                                                </label>
                                            </li>
                                            <li>
                                                <input type="radio" id="XLSX" value="xlsx" name="export_type"
                                                    class="d-none">
                                                <label class="py-2 px-3 w-100" for="XLSX">
                                                    XLSX
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
                <div class="card-body px-0">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive mb-3 overflow-y-hidden">
                                    <table class="table table-bordered table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 30px;">#</th>
                                                <th style="min-width: 200px;">Ref</th>
                                                <th style="min-width: 200px;">Name</th>
                                                <th style="min-width: 30px;">Payment Method</th>
                                                <th style="min-width: 100px;">Amount</th>
                                                <th style="min-width: 100px;">Payment Status</th>
                                                <th style="min-width: 100px;">Created At</th>
                                                <th class="text-center" style="min-width: 200px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $index => $item)
                                                <tr>
                                                    <td>{{ $items->firstItem() + $index }}</td>
                                                    <td>
                                                        {{ $item->order->ref }}
                                                    </td>
                                                    <td>
                                                        {{ $item->order->customer_first_name . ' ' . $item->order->customer_last_name }}
                                                    </td>
                                                    <td>
                                                        {{ $item->payment_method }}
                                                    </td>
                                                    <td>
                                                        LKR {{ number_format($item->order->total, 2) }}
                                                    </td>
                                                    <td>
                                                        @switch($item->payment_status)
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

                                                        <div class="tag {{ $statusColor }}">
                                                            {{ $item->payment_status }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </td>
                                                    <td>
                                                        <div class="actions">
                                                            <a target="_blank"
                                                                href="{{ route('admin.orders.edit', $item->order->id) }}"
                                                                type="button" class="edit-btn action-btn">
                                                                <i class="fi fi-rr-edit"></i>
                                                            </a>
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
                <div class="card-footer">
                    <div class="col-xl-12 d-flex justify-content-end mt-3">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[type="radio"]').forEach((radio) => {
            radio.addEventListener('change', (e) => {

                // alert(e.target.value)

                var form = document.querySelector('#searchForm');

                var formData = new FormData(form);

                switch (radio.value) {
                    case 'csv':
                        var type = 'csv';
                        break;
                    case 'xls':
                        var type = 'xls';
                        break;
                    case 'xlsx':
                        var type = 'xlsx';
                        break;
                    default:
                        showToast('Please select a valid file type');
                }

                fetch(`{{ route('admin.payments.export') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: formData,
                    })
                    .then(response => response.blob())
                    .then(blob => {
                        var downloadUrl = window.URL.createObjectURL(blob);
                        var link = document.createElement('a');
                        link.href = downloadUrl;
                        link.download = `payments.${type}`;
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                        window.URL.revokeObjectURL(downloadUrl);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            })
        })
    </script>
@endsection
