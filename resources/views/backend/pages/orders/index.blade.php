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
                            <h5 class="card-title text-white">Total Orders</h5>
                            <p class="card-text text-white">{{ $orders->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-orange">
                        <div class="card-body">
                            <h5 class="card-title text-white">Pending Orders</h5>
                            <p class="card-text text-white">{{ $orders->where('deliver_status', 'Pending')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-purple">
                        <div class="card-body">
                            <h5 class="card-title text-white">Delivered Orders</h5>
                            <p class="card-text text-white">{{ $orders->where('deliver_status', 'Delivered')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-blue">
                        <div class="card-body">
                            <h5 class="card-title text-white">Cancelled Orders</h5>
                            <p class="card-text text-white">{{ $orders->where('deliver_status', 'Cancelled')->count() }}</p>
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
                                                <th style="min-width: 30px;">Phone</th>
                                                <th style="min-width: 100px;">Payment Status</th>
                                                <th style="min-width: 100px;">Status</th>
                                                <th style="min-width: 100px;">Created At</th>
                                                <th class="text-center" style="min-width: 200px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $index => $item)
                                                <tr>
                                                    <td>{{ $items->firstItem() + $index }}</td>
                                                    <td>
                                                        {{ $item->ref }}
                                                    </td>
                                                    <td>
                                                        {{ $item->customer_name }}
                                                    </td>
                                                    <td>
                                                        {{ $item->phone }}
                                                    </td>
                                                    <td>
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

                                                        <div class="tag {{ $statusColor }}">
                                                            {{ $item->payment->payment_status }}
                                                        </div>
                                                    </td>
                                                    <td>
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

                                                        <div class="tag {{ $statusColor }}">
                                                            {{ $item->deliver_status }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </td>
                                                    <td>
                                                        <div class="actions">
                                                            <a href="{{ route('admin.orders.show', $item->id) }}"
                                                                class="view-btn action-btn">
                                                                <i class="fi fi-rr-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.orders.edit', $item->id) }}"
                                                                type="button" class="edit-btn action-btn">
                                                                <i class="fi fi-rr-edit"></i>
                                                            </a>
                                                            <button onclick="deleteItem({{ $item->id }},'orders')"
                                                                class="delete-btn action-btn">
                                                                <i class="fi fi-rr-trash"></i>
                                                            </button>
                                                            <a type="button" target="_blank"
                                                                href="{{ route('admin.orders.pdf', ['id' => $item->id, 'purpose' => 'view']) }}"
                                                                class="view-btn action-btn">
                                                                <i class="fi fi-rr-document"></i>
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

@endsection
