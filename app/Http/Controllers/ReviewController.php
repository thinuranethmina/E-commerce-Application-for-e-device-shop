<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        Log::info($request->all());

        $vaidator = Validator::make(
            $request->all(),
            [
                'product_id' => 'required|exists:products,id',
                'name' => [
                    'required',
                    'string',
                    'max:50',
                    'regex:/^[a-zA-Z\s]+$/u',
                ],
                'email' => 'required|string|email|max:100|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'comment' => 'required|string|max:500|min:10|not_regex:/http(s)?:\/\//i',
                'rating' => 'required|integer|between:1,5',
            ],
            [
                'product_id.required' => 'Product ID is required',
                'product_id.exists' => 'Product ID does not exist',
                'name.required' => 'Name is required',
                'name.regex' => 'Name can only contain letters and spaces',
                'email.required' => 'Email is required',
                'email.regex' => 'Please enter a valid email address',
                'comment.required' => 'Comment is required',
                'comment.min' => 'Comment must be at least 10 characters',
                'comment.not_regex' => 'Links are not allowed in the comment',
                'rating.required' => 'Rating is required',
                'rating.between' => 'Rating must be between 1 and 5',
            ]
        );

        if ($vaidator->fails()) {
            return response()->json(['success' => false, 'message' => $vaidator->errors()->first()], 200);
        }

        if ($request->has('save_details')) {
            session([
                'name' => $request->name,
                'email' => $request->email
            ]);
        } else {
            session()->forget(['name', 'email']);
        }

        Review::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'status' => 'Inactive',
        ]);

        return response()->json(['success' => true, 'message' => 'Review submitted successfully. Your review will be approved by the admin.'], 200);
    }
}
