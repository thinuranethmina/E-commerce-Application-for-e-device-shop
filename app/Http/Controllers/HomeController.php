<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Testimonial;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'Active')
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
            })->inRandomOrder()
            ->get();

        $testimonials = Testimonial::where('status', 'Active')->get();
        return view('frontend.pages.home.index', compact('products', 'testimonials'));
    }

    public function search(Request $request)
    {
        $request->merge([
            'search' => trim($request->search),
        ]);

        if (empty($request->search)) {
            return '';
        }

        $products = Product::where(function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })->where(function ($query) {
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
            ->where('status', 'Active')
            ->get();

        return view('frontend.components.search', compact('products'))->render();
    }

    public function contactSubmit(Request $request)
    {

        $Validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'message' => ['required', 'max:500', 'regex:/^[a-zA-Z0-9\s]+$/'],
            'honeypot_field' => 'nullable|string|max:0',
            'g-recaptcha-response' => ['required', new ReCaptcha()],
        ], [
            'name' => 'Name is required',
            'name.max' => 'Name must be less than 100 characters',
            'email' => 'Email is required',
            'email.email' => 'Email is not valid',
            'message' => 'Message is required',
            'message.max' => 'Message must be less than 500 characters',
            'message.regex' => 'Message must contain only letters and numbers',
            'g-recaptcha-response.required' => 'Google ReCaptcha is required',
        ]);

        if ($Validator->fails()) {
            return redirect()->back()->withInput()->with('error', $Validator->errors()->first());
        }

        if (!empty($request->honeypot_field)) {
            return redirect()->back()->with('error', 'Please try again later');
        }

        $data = [
            'title' => 'Contact Form Submission',
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'date' => date('Y-m-d')
        ];

        $content = view('email.admin.contact', $data)->render();

        $admin_subject = 'New Contact Form Submission';
        $admin_body = view('email.layout.base', ['content' => $content])->render();

        $content = view('email.client.contact', ['title' => 'Thank you for connecting with DigiMax.lk!',])->render();

        $client_subject = 'Thank You! Stay Connected with DigiMax.lk';
        $client_body = view('email.layout.base', ['content' => $content])->render();

        $emailRequest  = new Request([
            'admin_subject' => $admin_subject,
            'admin_body' => $admin_body,
            'client_subject' => $client_subject,
            'client_body' => $client_body,
            'email' => $request->email
        ]);

        $controller = new PHPMailController();

        if ($controller->sendMail($emailRequest)) {
            return redirect()->back()->with('success', 'Form submition successfully');
        } else {
            return redirect()->back()->with('error', 'Please try again later');
        }
    }
}
