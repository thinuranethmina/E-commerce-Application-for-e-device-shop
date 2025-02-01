<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function show()
    {
        $settings = Setting::where('key', 'like', 'notification.%')
            ->get()
            ->pluck('value', 'key');

        return view('backend.pages.settings.notification', compact('settings'));
    }

    public function emailUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email_sender_name' => 'required|string',
                'email_sender_address' => 'required|string|email',
                'email_smtp_server' => 'required|string',
                'email_smtp_port' => 'required|integer',
                'email_smtp_username' => 'required|string',
                'email_smtp_password' => 'required|string',
                'email_encryption' => 'required|string|in:ssl,tls',
            ],
            [
                'email_sender_name.required' => 'Sender name is required.',
                'email_sender_address.required' => 'Sender address is required.',
                'email_sender_address.email' => 'Please provide a valid email address.',
                'email_smtp_server.required' => 'SMTP server is required.',
                'email_smtp_port.required' => 'SMTP port is required.',
                'email_smtp_port.integer' => 'SMTP port must be a valid number.',
                'email_smtp_username.required' => 'SMTP username is required.',
                'email_smtp_password.required' => 'SMTP password is required.',
                'email_encryption.required' => 'Encryption type is required.',
                'email_encryption.in' => 'Encryption type must be either ssl or tls.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'email_') === 0) {
                Setting::updateOrInsert(
                    ['key' => 'notification.' . $key],
                    ['value' => $value]
                );
            }
        }

        return redirect()->back()->with('success', 'Email settings updated successfully.');
    }
}
