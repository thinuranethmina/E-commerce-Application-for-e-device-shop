<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = ProductVariation::query();

        $query->whereHas('product', function ($q) {
            $q->where('status', 'active');
        });

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('price', 'LIKE', '%' . $search . '%')
                    ->orWhere('stock', 'LIKE', '%' . $search . '%');
            });
        }

        $items = $query->orderBy('stock', 'asc')->paginate(15);

        return view('backend.pages.stock.index', compact('items'));
    }
}
