<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $lowStockProducts = Product::where('status', 'Active')
            ->whereHas('variations', function ($query) {
                $query->where('stock', '<=', 5);
            })
            ->get();
        $products = Product::where('status', 'Active')->get();
        $orders = Order::all();
        $reviews = Review::where('status', 'Active')->get();
        $payments = OrderPayment::all();

        return view('backend.pages.dashboard', compact('lowStockProducts', 'products', 'orders', 'reviews', 'payments'));
    }
}
