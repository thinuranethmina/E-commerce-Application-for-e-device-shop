<?php

namespace App\Http\Controllers\Backend;

use App\Exports\PaymentsExport;
use App\Http\Controllers\Controller;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = OrderPayment::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('response', 'LIKE', '%' . $search . '%');
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
            $query->whereHas('order', function ($q) use ($request) {
                $q->where('deliver_status', $request->order_status);
            });
        }

        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $query->where('payment_method', $request->payment_method);
        }

        $items = $query->orderBy('id', 'desc')->paginate(15);

        $payments = OrderPayment::all();
        return view('backend.pages.payments.index', compact('items', 'payments'));
    }
    public function export(Request $request)
    {
        $searchBy = null;

        $search = $request->input('search');

        $query = OrderPayment::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('response', 'LIKE', '%' . $search . '%');
            });
            $searchBy = 'Search By: ' . $search;
        }

        if ($request->has('from_date') && !empty($request->from_date)) {
            $query->where('created_at', '>=', $request->from_date);
            $searchBy = ' From Date: ' . $request->from_date;
        }

        if ($request->has('to_date') && !empty($request->to_date)) {
            $query->where('created_at', '<=', $request->to_date);
            $searchBy = ' To Date: ' . $request->to_date;
        }

        if ($request->has('payment_status') && !empty($request->payment_status)) {
            $query->where('payment_status', $request->payment_status);
            $searchBy = ' Payment Status: ' . $request->payment_status;
        }

        if ($request->has('order_status') && !empty($request->order_status)) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->where('deliver_status', $request->order_status);
            });
            $searchBy = ' Order Status: ' . $request->order_status;
        }

        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $query->where('payment_method', $request->payment_method);
            $searchBy = ' Payment Method: ' . $request->payment_method;
        }

        $type = $request->input('export_type') ?? 'xlsx';
        if (!($type == 'xlsx' || $type == 'csv' || $type == 'xls')) {
            $type == 'xlsx';
        }

        return Excel::download(new PaymentsExport($query->get(), $searchBy), 'payments.' . $type);
    }
}
