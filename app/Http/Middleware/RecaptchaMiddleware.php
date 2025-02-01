<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use ReCaptcha\ReCaptcha;

class RecaptchaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $recaptcha = new ReCaptcha(env('RECAPTCHA_SECRET_KEY'));

        $response = $recaptcha->verify(
            $request->input('g-recaptcha-response'),
            $request->ip(),
            ['action' => 'login']
        );

        if (!$response->isSuccess()) {
            return redirect()->back()->withErrors([
                'g-recaptcha-response' => 'The reCAPTCHA was not verified.',
            ]);
        }

        return $next($request);
    }
}
