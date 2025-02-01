<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('backend.auth.login');
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            // 'password' => [
            //     'required',
            //     'string',
            //     'min:8',
            //     'regex:/[a-z]/',
            //     'regex:/[A-Z]/',
            //     'regex:/[0-9]/',
            //     'regex:/[@$!%*?&#]/',
            // ],
            'honeypot_field' => 'nullable|string|max:0',
            // 'g-recaptcha-response' => ['required', new ReCaptcha()],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
        }

        if ($request->honeypot_field) {
            Log::warning('Bot detected during login attempt.', ['ip' => $request->ip()]);
            return response()->json(['success' => false, 'message' => 'Bot detected. Access denied.'], 200);
        }

        $email = $request->email;
        $attemptsKey = 'login_attempts_' . $email;
        $attempts = Cache::get($attemptsKey, 0);

        if ($attempts >= 5) {
            return response()->json([
                'success' => false,
                'message' => 'Too many failed login attempts. Please try again later.',
            ], 429);
        }

        if (Auth::attempt(['email' => $email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                return response()->json(['success' => false, 'message' => 'Access denied. Admins only.'], 200);
            }

            if ($user->status !== 'Active') {
                return response()->json(['success' => false, 'message' => 'Account is not active.'], 200);
            }

            Cache::forget($attemptsKey);

            return response()->json([
                'success' => true,
                'message' => 'Login successful.',
                'redirect' => 'admin',
            ], 200);
        }

        Cache::put($attemptsKey, $attempts + 1, now()->addMinutes(15));

        Log::warning('Failed login attempt.', ['email' => $email, 'ip' => $request->ip()]);

        return response()->json(['success' => false, 'message' => 'Invalid credentials.'], 200);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
