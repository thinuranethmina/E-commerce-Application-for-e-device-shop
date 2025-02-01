<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function show()
    {
        $settings = Setting::where('key', 'like', 'payment.%')
            ->get()
            ->pluck('value', 'key');

        return view('backend.pages.settings.payment', compact('settings'));
    }
    public function paymentGatewayUpdate(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'payhere_merchant_id' => 'required',
                'payhere_secret_key' => 'required',
                'refund_policy' => 'required|max:255',
            ],
            [
                'payhere_merchant_id.required' => 'Please enter PayHere Merchant ID.',
                'payhere_secret_key.required' => 'Please enter PayHere Secret Key.',
                'refund_policy.required' => 'Please enter refund policy.',
                'refund_policy.max' => 'Please enter a valid refund policy.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $settings = [
            'payhere_merchant_id',
            'payhere_secret_key',
            'refund_policy',
        ];

        foreach ($settings as $setting) {
            Setting::where('key', "payment.{$setting}")->update(['value' => $request->{$setting}]);
        }

        return redirect()->back()->with('success', 'Payment gateway settings updated successfully.');
    }

    public function offlinePaymentUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'bank_name' => 'required',
                'bank_info' => 'required',
            ],
            [
                'bank_name.required' => 'Please enter bank name.',
                'bank_info.required' => 'Please enter bank information.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        Setting::where('key', 'payment.bank_name')->update(['value' => $request->bank_name]);
        Setting::where('key', 'payment.bank_info')->update(['value' => $request->bank_info]);

        return redirect()->back()->with('success', 'Offline payment settings updated successfully.');
    }
    public function deliveryFeeUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'delivery_fee' => 'required',
            ],
            [
                'delivery_fee.required' => 'Please enter delivery fee.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        Setting::where('key', 'payment.delivery_fee')->update(['value' => $request->delivery_fee]);

        return redirect()->back()->with('success', 'Delivery fee updated successfully.');
    }
}
