<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationValue;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product_variation_id = $request->product_id;
        $qty = $request->qty;

        if (!$product_variation_id) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 200);
        }

        $product_variation = ProductVariation::find($product_variation_id);

        if (!$product_variation) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 200);
        }

        if ($product_variation->stock <= 0) {
            return response()->json(['success' => false, 'message' => 'Product Out of Stock'], 200);
        }

        // check this prodcut stock
        if ($product_variation->stock < $qty) {
            return response()->json(['success' => false, 'message' => 'Product out of stock'], 200);
        }

        $product = $product_variation->product->where('status', 'Active')
            ->where(function ($query) {
                $query->whereHas('brand', function ($brandQuery) {
                    $brandQuery->where('status', 'Active');
                })
                    ->orWhereNull('brand_id');
            })
            ->whereHas('subCategory', function ($query) {
                $query->where('status', 'Active')
                    ->whereHas('category', function ($query) {
                        $query->where('status', 'Active');
                    });
            })
            ->first();

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 200);
        }

        $sessionId = Cookie::get('session_id');

        if (!$sessionId) {
            return response()->json(['success' => false, 'message' => 'Session not found'], 200);
        }

        $variation = $product_variation;

        if (!$variation) {
            return response()->json(['success' => false, 'message' => 'Product variation not found'], 200);
        }

        $cart = Cart::where('product_variation_id', $variation->id)
            ->where('session_id', $sessionId)
            ->first();

        if ($cart) {
            if ($cart->qty >= $cart->productVariation->stock) {
                return response()->json(['success' => false, 'message' => 'Product out of stock'], 200);
            } else {
                $cart->update(['qty' => $cart->qty + $qty]);
            }
        } else {
            Cart::create([
                'session_id' => $sessionId,
                'product_variation_id' => $variation->id,
                'qty' => $qty,
            ]);
        }

        $cartProducts = Cart::where('session_id', $sessionId)->whereHas(
            'productVariation',
            function ($query) {
                $query->where('stock', '>', '0');
            }
        )->get();

        $html = '';
        $total_price = 0;
        $total = $cartProducts->count();

        foreach ($cartProducts as $cartProduct) {
            $total_price += $cartProduct->productVariation->price * $cartProduct->qty;
            $html .= view('frontend.components.product-card-checkout', ['cart_product' => $cartProduct])->render();
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'html' => $html,
            'total' => $total,
            'total_price' => 'Rs ' . number_format($total_price, 2)
        ], 200);
    }

    public function changeQty($id, $qty)
    {
        $cart = Cart::where('id', $id)->where('session_id', Cookie::get('session_id'))->firstOrFail();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        $product = ProductVariation::where('id', $cart->product_variation_id)->first();

        if ($product->stock < $qty) {
            return response()->json(['success' => false, 'message' => 'Product out of stock'], 200);
        }

        $cart->update(['qty' => $qty]);

        return response()->json(['success' => true, 'message' => 'Quantity updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function remove(string $id)
    {
        Log::info("Removing cart item");
        Cart::find($id)->delete();

        $cart_items = Cart::where('session_id', Cookie::get('session_id'))
            ->whereHas('productVariation', function ($query) {
                $query->where('stock', '>', '0')
                    ->whereHas('product', function ($query) {
                        $query->where('status', 'Active')
                            ->where(function ($query) {
                                $query->whereHas('brand', function ($brandQuery) {
                                    $brandQuery->where('status', 'Active');
                                })
                                    ->orWhereNull('brand_id');
                            })
                            ->whereHas('subCategory', function ($query) {
                                $query->where('status', 'Active')
                                    ->whereHas('category', function ($query) {
                                        $query->where('status', 'Active');
                                    });
                            });
                    });
            })
            ->get();

        $total = 0;

        foreach ($cart_items as $cart_item) {
            $total += $cart_item->productVariation->price * $cart_item->qty;
        }

        $item_count = $cart_items->count();

        $settings = Setting::where('key', 'like', 'payment.%')
            ->get()
            ->pluck('value', 'key');

        $delivery_fee = $settings['payment.delivery_fee'] ?? 0;

        $grand_total = $total > 0 ? ($delivery_fee + $total) : 0;

        return response()->json(['success' => true, 'total' => $total, 'grand_total' => $grand_total,  'item_count' => $item_count ?? 0,  'message' => 'Product deleted successfully'], 200);
    }
}
