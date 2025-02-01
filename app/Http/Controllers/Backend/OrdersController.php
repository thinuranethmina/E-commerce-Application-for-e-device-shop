<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PHPMailController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\alert;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Order::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->has('from_date') && !empty($request->from_date)) {
            $query->where('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && !empty($request->to_date)) {
            $query->where('created_at', '<=', $request->to_date);
        }

        if ($request->has('payment_status') && !empty($request->payment_status)) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('order_status') && !empty($request->order_status)) {
            $query->where('deliver_status', $request->order_status);
        }

        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $query->whereHas('payment', function ($q) use ($request) {
                $q->where('payment_method', $request->payment_method);
            });
        }


        $items = $query->orderBy('id', 'desc')->paginate(15);

        $orders = Order::all();
        return view('backend.pages.orders.index', compact('items', 'orders'));
    }

    public function show(string $id)
    {
        $item = Order::findOrFail($id);

        return view('backend.pages.orders.show', compact('item'));
    }

    public function edit(string $id)
    {
        $item = Order::findOrFail($id);

        return view('backend.pages.orders.edit', compact('item'));
    }
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        if (empty($order)) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 200);
        }

        $validator = Validator::make($request->all(), [
            'delivery_status' => 'required|string|in:Pending,Confirmed,Delivered,Cancelled,Returned',
            'payment_status' => 'required|string|in:Pending,Paid,Cancelled,Failed,Refunded',
            'customer_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
        }

        if ($request->email) {
            $data = [];
            if ($request->delivery_status == 'Delivered' && $order->deliver_status != 'Delivered') {

                $data = [
                    'title' => 'Order Delivered - Enjoy Your Purchase!',
                    'message' => 'Your order #' . $order->ref . ' has been successfully delivered. We hope you love your purchase!',
                    'name' => $request->customer_name
                ];

                $client_subject = 'Order Delivered - Enjoy Your Purchase! - #' . $order->ref;
            } else if ($request->delivery_status == 'Confirmed' && $order->deliver_status != 'Confirmed') {

                $data = [
                    'title' => 'Order Confirmed - Processing Now!',
                    'message' => "Your order #" . $order->ref . " has been confirmed and is now being processed. You will receive further updates once it's shipped.",
                    'name' => $request->customer_name

                ];

                $client_subject =  'Order Confirmed - Processing Now! - #' . $order->ref;
            } else if ($request->delivery_status == 'Cancelled' && $order->deliver_status != 'Cancelled') {

                $data = [
                    'title' => 'Order Cancelled - Update on Your Request',
                    'message' => "Your order #" . $order->ref . " has been cancelled as per your request. If you need further assistance, please contact our support team.",
                    'name' => $request->customer_name
                ];

                $client_subject =  'Order Canceled - Update on Your Request - #' . $order->ref;
            }

            if (($order->deliver_status != 'Delivered' && $request->delivery_status == 'Delivered') ||
                ($order->deliver_status != 'Confirmed' && $request->delivery_status == 'Confirmed') ||
                ($order->deliver_status != 'Cancelled' && $request->delivery_status == 'Cancelled')
            ) {

                $content = view('email.client.order', $data)->render();

                $client_body = view('email.layout.base', ['content' => $content])->render();

                $emailRequest  = new Request([
                    'client_subject' => $client_subject,
                    'client_body' => $client_body,
                    'email' => $request->email
                ]);

                if ($order->deliver_status != 'Confirmed' && $request->delivery_status == 'Confirmed') {
                    $emailRequest->merge([
                        'client_attachment' => $this->generatePdfInvoice($order->id),
                    ]);
                }

                PHPMailController::sendMail($emailRequest);
            }


            if ($order->payment->payment_status != 'Paid' && $request->payment_status == 'Paid') {

                $data = [
                    'title' => 'Payment Received - Thank You!',
                    'message' => "We have received your payment for Order #" . $order->ref . ". Your order is now being processed. <br> <br> Thank you for shopping with us!",
                    'name' => $request->customer_name
                ];

                $client_subject =  'Payment Received - Thank You! - #' . $order->ref;
            } else if ($order->payment->payment_status != 'Cancelled' && $request->payment_status == 'Cancelled') {

                $data = [
                    'title' => 'Payment Cancelled - Order Update',
                    'message' => "Your payment for Order #" . $order->ref . " has been canceled. If this was unintentional, please try again or contact us for assistance.",
                    'name' => $request->customer_name
                ];

                $client_subject =  'Order Canceled - Update on Your Request - #' . $order->ref;
            } else if ($order->payment->payment_status != 'Refunded' && $request->payment_status == 'Refunded') {

                $data = [
                    'title' => ' Refund Processed - Order #' . $order->ref,
                    'message' => "Your refund for Order #" . $order->ref . " has been processed successfully. The amount will be credited to your account within 14 business days.",
                    'name' => $request->customer_name
                ];

                $client_subject =  ' Refund Processed - Order #' . $order->ref;
            }

            if (($order->payment->payment_status != 'Paid' && $request->payment_status == 'Paid') ||
                ($order->payment->payment_status != 'Cancelled' && $request->payment_status == 'Cancelled') ||
                ($order->payment->payment_status != 'Refunded' && $request->payment_status == 'Refunded')
            ) {

                $content = view('email.client.order', $data)->render();

                $client_body = view('email.layout.base', ['content' => $content])->render();

                $emailRequest  = new Request([
                    'client_subject' => $client_subject,
                    'client_body' => $client_body,
                    'email' => $request->email
                ]);

                if ($order->payment->payment_status != 'Paid' && $request->payment_status == 'Paid') {
                    $emailRequest->merge([
                        'client_attachment' => $this->generatePdfInvoice($order->id),
                    ]);
                }

                PHPMailController::sendMail($emailRequest);
            }
        }

        if (
            ($request->delivery_status == 'Confirmed' && ($order->deliver_status == 'Pending' || $order->deliver_status == 'Cancelled' || $order->deliver_status == 'Returned'))
            ||
            ($request->delivery_status == 'Delivered' && ($order->deliver_status == 'Pending' || $order->deliver_status == 'Cancelled' || $order->deliver_status == 'Returned'))
        ) {
            $operation = 'Decrement';

            foreach ($order->orderItems as $item) {
                $item->productVariation()->decrement('stock', (int) $item->qty);
            }
        }

        if (
            ($request->delivery_status == 'Pending' || $request->delivery_status == 'Cancelled' || $request->delivery_status == 'Returned')
            &&
            ($order->deliver_status == 'Confirmed' || $order->deliver_status == 'Delivered')
        ) {

            foreach ($order->orderItems as $item) {
                $item->productVariation()->increment('stock', (int) $item->qty);
            }
        }

        $order->update([
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'deliver_status' => $request->delivery_status,
        ]);

        $order->payment()->update([
            'payment_status' => $request->payment_status,
        ]);

        return response()->json(['success' => true, 'redirect' => route('admin.orders.index'), 'message' => 'Order updated successfully'], 200);
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

    public function pdfInvoice($id, $purpose)
    {
        $order = Order::findOrFail($id);

        if (!($purpose == 'view' || $purpose == 'download')) {
            abort(404);
        }

        $html = view('backend.orders.document', compact('order'))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('http_backend', 'curl');
        $options->set('curl_options', [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        if ($purpose == 'download') {
            return response($dompdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $order->ref . '.pdf"');
        } else if ($purpose == 'view') {
            return response($dompdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="document.pdf"');
        }
    }

    public function destroy(string $id)
    {
        $item = Order::find($id);

        if (empty($item)) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 200);
        }

        $item->delete();

        return response()->json(['success' => true, 'redirect' => route('admin.orders.index'), 'message' => 'Order deleted successfully'], 200);
    }
}
