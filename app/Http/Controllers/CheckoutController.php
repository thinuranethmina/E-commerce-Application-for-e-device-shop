<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Setting;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;

class CheckoutController extends Controller
{
    public function index()
    {

        $settings = Setting::where('key', 'like', 'payment.%')
            ->get()
            ->pluck('value', 'key');

        do {
            $ref = 'DMX-' . date('Ymd') . '-' . substr(str_shuffle('0123456789'), 0, 5);
        } while (Order::where('ref', $ref)->exists());

        return view('frontend.pages.checkout.index', compact('settings', 'ref'));
    }
    public function quickBuy($slug, $id)
    {

        $productVariation = ProductVariation::where('id', $id)->where('stock', '>', '0')->whereHas(
            'product',
            function ($query) {
                $query->where('status', 'Active')->where(function ($query) {
                    $query->whereHas('brand', function ($brandQuery) {
                        $brandQuery->where('status', 'Active');
                    })
                        ->orWhereNull('brand_id');
                })->whereHas('subCategory', function ($query) {
                    $query->where('status', 'Active')
                        ->whereHas('category', function ($query) {
                            $query->where('status', 'Active');
                        });
                });
            }
        )->firstOrFail();

        $settings = Setting::where('key', 'like', 'payment.%')
            ->get()
            ->pluck('value', 'key');

        do {
            $ref = 'DMX-' . date('Ymd') . '-' . substr(str_shuffle('0123456789'), 0, 5);
        } while (Order::where('ref', $ref)->exists());

        return view('frontend.pages.checkout.quick-buy', compact('settings', 'ref', 'productVariation'));
    }
    public function returnIndex($order_ref)
    {

        $settings = Setting::where('key', 'like', 'payment.%')
            ->get()
            ->pluck('value', 'key');

        do {
            $ref = 'DMX-' . date('Ymd') . '-' . Str::random(5);
        } while (Order::where('ref', $ref)->exists());

        $order = Order::where('ref', $order_ref)->whereNotIn('deliver_status', ['Delivered', 'Cancelled'])->first();

        if ($order) {
            $html = view('frontend.components.checkout-thanks', compact('order'))->render();
        }

        return view('frontend.pages.checkout.index', compact('settings', 'ref', 'html'));
    }

    public function store(Request $request)
    {

        $vaidator = Validator::make($request->all(), [
            'payment_method' => 'required|in:card,bank',
            'ref' => 'required|unique:orders,ref',
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'required|min:10',
            'email' => 'nullable|email',
            'note' => 'nullable|string|max:255',
            'g-recaptcha-response' => ['required', new ReCaptcha()],
        ], [
            'payment-method.required' => 'Payment method is required',
            'address.required' => 'Address is required',
            'phone.required' => 'Phone is required',
            'email.email' => 'Email is invalid',
            'note.required' => 'Note is required',
        ]);

        if ($vaidator->fails()) {
            return response()->json(['success' => false, 'message' => $vaidator->errors()->first()], 200);
        }

        $cart_items = Cart::where('session_id', Cookie::get('session_id'))->whereHas(
            'productVariation',
            function ($query) {
                $query->where('stock', '>', '0');
            }
        )->get();

        $total = 0;

        foreach ($cart_items as $cart_item) {
            if ($cart_item->productVariation->product->status == 'Active') {
                $price = $cart_item->productVariation->price;
                $qty = $cart_item->qty;
                $total += $price * $qty;

                if ($cart_item->qty > $cart_item->productVariation->stock) {
                    return response()->json(['success' => false, 'message' => $cart_item->productVariation->product->name . " stock not enough"], 200);
                }
            }
        }

        $settings = Setting::where('key', 'like', 'payment.%')
            ->get()
            ->pluck('value', 'key');

        $delivery_fee = $settings['payment.delivery_fee'] ?? 0;

        $order = Order::create([
            'ref' => $request->ref,
            'session_id' => Cookie::get('session_id'),
            'customer_name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'note' => $request->note,
            'sub_total' => $total,
            'delivery_fee' => $delivery_fee,
            'total' => $total + $delivery_fee,
            'deliver_status' => 'Pending',
        ]);

        foreach ($cart_items as $cart_item) {
            if ($cart_item->productVariation->product->status == 'Active') {
                if ($cart_item->qty <= $cart_item->productVariation->stock) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_variation_id' => $cart_item->product_variation_id,
                        'price' => $cart_item->productVariation->price,
                        'qty' => $cart_item->qty,
                    ]);
                }
            }
        }

        $total += $delivery_fee;

        $total = 100;

        OrderPayment::create([
            'order_id' => $order->id,
            'payment_status' => 'Pending',
            'payment_method' => $request->payment_method == 'card' ? 'Card' : 'Bank Transfer',
        ]);

        $hash = strtoupper(
            md5(
                $settings['payment.payhere_merchant_id'] .
                    $request->ref .
                    number_format($total, 2, '.', '') .
                    "LKR" .
                    strtoupper(md5($settings['payment.payhere_secret_key']))
            )
        );

        $html = '';
        if ($request->payment_method == 'bank') {
            $html = view('frontend.components.checkout-thanks', compact('order'))->render();
            Cart::where('session_id', Cookie::get('session_id'))->delete();
        }

        return response()->json(['success' => true, 'message' => 'Order placed successfully', 'hash' => $hash, 'total' => number_format($total, 2, '.', ''), 'app_url' => env('APP_URL'), 'html' => $html], 200);
    }
    public function quickStore(Request $request)
    {

        $vaidator = Validator::make($request->all(), [
            'payment_method' => 'required|in:card,bank',
            'ref' => 'required|unique:orders,ref',
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'required|min:10',
            'email' => 'nullable|email',
            'note' => 'nullable|string|max:255',
            'productVariationId' => 'required:exists:product_variations,id,stock>0,product.status=Active,product.sub_category.status=Active,product.sub_category.category.status=Active,product.brand.status=Active',
            'product_quantity' => 'required|min:1',
            'g-recaptcha-response' => ['required', new ReCaptcha()],
        ], [
            'payment-method.required' => 'Payment method is required',
            'address.required' => 'Address is required',
            'phone.required' => 'Phone is required',
            'email.email' => 'Email is invalid',
            'note.required' => 'Note is required',
            'productVariationId.required' => 'Product is required',
            'productVariationId.exists' => 'Product not found',
            'productVariationId.stock' => 'Product stock not enough',
            'productVariationId.product.status' => 'Product not found',
            'productVariationId.product.sub_category.status' => 'Product not found',
            'productVariationId.product.sub_category.category.status' => 'Product not found',
            'productVariationId.product.brand.status' => 'Product not found',
            'product_quantity.required' => 'Product quantity is required',
            'product_quantity.min' => 'Product quantity must be at least 1',
        ]);

        if ($vaidator->fails()) {
            return response()->json(['success' => false, 'message' => $vaidator->errors()->first()], 200);
        }

        $item = ProductVariation::where('id', $request->productVariationId)->where('stock', '>', '0')
            ->whereHas(
                'product',
                function ($query) {
                    $query->where('status', 'Active')->where(function ($query) {
                        $query->whereHas('brand', function ($brandQuery) {
                            $brandQuery->where('status', 'Active');
                        })
                            ->orWhereNull('brand_id');
                    })->whereHas('subCategory', function ($query) {
                        $query->where('status', 'Active')
                            ->whereHas('category', function ($query) {
                                $query->where('status', 'Active');
                            });
                    });
                }
            )->first();


        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 200);
        }

        $total = 0;

        if ($item->product->status == 'Active') {
            $price = $item->price;
            $qty = $request->product_quantity ?? 1;
            $total = $price * $qty;

            if ($qty > $item->stock) {
                return response()->json(['success' => false, 'message' => "Stock not enough"], 200);
            }
        }

        $settings = Setting::where('key', 'like', 'payment.%')
            ->get()
            ->pluck('value', 'key');

        $delivery_fee = $settings['payment.delivery_fee'] ?? 0;

        $order = Order::create([
            'ref' => $request->ref,
            'session_id' => 'none',
            'customer_name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'note' => $request->note,
            'sub_total' => $total,
            'delivery_fee' => $delivery_fee,
            'total' => $total + $delivery_fee,
            'deliver_status' => 'Pending',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_variation_id' => $request->productVariationId,
            'price' => $item->price,
            'qty' => $qty,
        ]);

        $total += $delivery_fee;

        $total = 100;

        OrderPayment::create([
            'order_id' => $order->id,
            'payment_status' => 'Pending',
            'payment_method' => $request->payment_method == 'card' ? 'Card' : 'Bank Transfer',
        ]);

        $hash = strtoupper(
            md5(
                $settings['payment.payhere_merchant_id'] .
                    $request->ref .
                    number_format($total, 2, '.', '') .
                    "LKR" .
                    strtoupper(md5($settings['payment.payhere_secret_key']))
            )
        );

        $html = '';
        if ($request->payment_method == 'bank') {
            $html = view('frontend.components.checkout-thanks', compact('order'))->render();
        }

        return response()->json(['success' => true, 'message' => 'Order placed successfully', 'hash' => $hash, 'total' => number_format($total, 2, '.', ''), 'app_url' =>  env('APP_URL'), 'html' => $html], 200);
    }

    public function notify(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'payment_id' => 'required',
        ]);

        if ($validator->fails()) {
            Log::info($validator->errors()->first());
        }

        $response = json_encode($request->all());

        $order = Order::where('ref', $request->input('order_id'))->first();

        if (!$order) {
            return false;
        }

        $status = 'Pending';

        if ($request->input('status_code') == 2) {
            $status = 'Paid';
            Cart::where('session_id', $order->session_id)->delete();

            if ($order->email) {

                $data = [
                    'title' => 'Payment Received - Thank You!',
                    'message' => "We have received your payment for Order #" . $order->ref . ". Your order is now being processed. <br> <br> Thank you for shopping with us!",
                    'name' => $order->customer_first_name . ' ' . $order->customer_last_name
                ];

                $client_subject =  'Payment Received - Thank You! - #' . $order->ref;

                $content = view('email.client.order', $data)->render();

                $client_body = view('email.layout.base', ['content' => $content])->render();

                $emailRequest  = new Request([
                    'client_subject' => $client_subject,
                    'client_body' => $client_body,
                    'email' => $order->email
                ]);

                if ($order->payment->payment_status != 'Paid' && $request->payment_status == 'Paid') {
                    $emailRequest->merge([
                        'client_attachment' => $this->generatePdfInvoice($order->id),
                    ]);
                }

                PHPMailController::sendMail($emailRequest);
            }
        } else if ($request->input('status_code') == 0 || $request->input('status_code') == -3) {
            $status = 'Pending';
            Cart::where('session_id', $order->session_id)->delete();
        } else {
            $status = 'Failed';
        }

        $order->payment->update([
            'payment_status' => $status ?? 'Failed',
            'transaction_id' => $request->payment_id,
            'response' => $response,
        ]);

        return true;
    }


    public function generatePdfInvoice($id)
    {
        $order = Order::findOrFail($id);
        $html = view('backend.orders.document', compact('order'))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();


        $directoryPath = storage_path('app/public/invoices');
        $filePath = $directoryPath . "/{$order->ref}.pdf";

        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        file_put_contents($filePath, $dompdf->output());

        return $filePath;
    }
}
