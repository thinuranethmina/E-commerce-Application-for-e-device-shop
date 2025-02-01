@extends('backend.app')
@section('content')
    <div class="row top-row dashboard">
        <div class="col-12 mb-3">
            @include('backend.components.greeting')
            <h4 class="username text-capitalize">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h4>
        </div>
        <div class="col-12 overview">
            <h4 class="section-title">Overview</h4>
            <div class="row">
                <div class="col-xl-3">
                    <div class="card bg-pink">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Products</h5>
                            <p class="card-text text-white">{{ $products->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-orange">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Orders</h5>
                            <p class="card-text text-white">{{ $orders->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <h5 class="card-title text-dark">Deliver Pending Orders</h5>
                            <p class="card-text text-dark">{{ $orders->where('deliver_status', 'Pending')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-success">
                        <div class="card-body">
                            <h5 class="card-title text-white">Confirmed Orders</h5>
                            <p class="card-text text-white">{{ $orders->where('deliver_status', 'Confirmed')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <h5 class="card-title text-white">Delivered Orders</h5>
                            <p class="card-text text-white">{{ $orders->where('deliver_status', 'Delivered')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card" style="background-color: brown">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Products Reviews</h5>
                            <p class="card-text text-white">{{ $reviews->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-purple">
                        <div class="card-body">
                            <h5 class="card-title text-white">Low Stock Products</h5>
                            <p class="card-text text-white">{{ $lowStockProducts->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-dark">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Received Payments</h5>
                            <p class="card-text text-white">
                                LKR {{ number_format($payments->where('payment_status', 'Paid')->sum('order.total'), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
