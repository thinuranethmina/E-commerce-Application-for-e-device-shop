<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\SeasonalBanner;
use App\Models\Setting;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();

        View::composer('*', function ($view) {

            $student = null;
            $settings = Setting::where('key', 'like', 'website.%')
                ->get()
                ->pluck('value', 'key');

            if (Auth::check()) {
                $phone =  Auth::user()->phone;
                $student = $phone ? User::where('phone', $phone)->where('role', 'student')->first() : null;
            }

            $cartProducts = Cart::where('session_id', Cookie::get('session_id'))->whereHas(
                'productVariation',
                function ($query) {
                    $query->where('stock', '>', '0');
                }
            )->get();

            $banners = Banner::where('status', 'active')->get();
            $categories = Category::where('status', 'active')->get();
            $accessories = SubCategory::where('status', 'active')->whereHas(
                'category',
                function ($query) {
                    $query->where('status', 'active')
                        ->where('name', 'like', '%accessories%');
                }
            )->limit(10)->get();
            $seasonal_banner = SeasonalBanner::first();

            $cartTotal = 0;

            foreach ($cartProducts as $cartProduct) {
                $cartTotal += $cartProduct->productVariation->price * $cartProduct->qty;
            }

            $view->with([
                'brands' => Brand::where('status', 'active')->get(),
                'cartProducts' => $cartProducts,
                'cartTotal' => $cartTotal,
                'banners' => $banners,
                'categories' => $categories,
                'accessories' => $accessories,
                'seasonal_banner' => $seasonal_banner,
            ]);

            $view->with([
                'username' => $student ? $student->first_name . ' ' . $student->last_name : 'Guest',
                'avatar' => $student && $student->avatar ? asset('assets/uploads/user/' . $student->avatar) : asset('assets/frontend/images/avatar/default.png'),
                'is_logged_in' => $student ? true : false,

                'site_name' => $settings['website.site_name'],
                'site_favicon' => asset('assets/global/images/favicon/' . $settings['website.site_favicon']),
                'site_light_logo' => asset('assets/global/images/logos/' . $settings['website.site_light_logo']),
                'site_dark_logo' => asset('assets/global/images/logos/' . $settings['website.site_dark_logo']),

                'meta_title' => $settings['website.meta_title'],
                'meta_keywords' => $settings['website.meta_keywords'],
                'meta_description' => $settings['website.meta_description'],

                'google_analytics' => $settings['website.google_analytics_code'],
            ]);
        });


        if (!Cookie::has('session_id')) {
            $session = Str::uuid();

            Log::info('Session_id =' . $session);

            Cookie::queue('session_id', $session, 60 * 24 * 30 * 6);
        }
    }
}
