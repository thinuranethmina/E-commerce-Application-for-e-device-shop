<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Review::whereHas('product', function ($q) {
            $q->where('status', 'Active');
        });

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->where('email', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('rating') && !empty($request->rating)) {
            $query->where('rating', '=', $request->rating);
        }

        $items = $query->orderBy('id', 'desc')->paginate(15);

        $reviews = Review::all();
        return view('backend.pages.review.index', compact('items', 'reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Review::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Review not found'], 200);
        }

        $html = view('backend.pages.review.show', compact('item'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Review::find($id);
        $products = Product::all();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Review not found'], 200);
        }

        $html = view('backend.pages.review.edit', compact('item', 'products'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $query = Review::find($id);

        if (!$query) {
            return response()->json(['success' => false, 'message' => 'Review not found'], 200);
        }

        $vaidator = Validator::make(
            $request->all(),
            [
                'product_id' => 'required|exists:products,id',
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:100',
                'comment' => 'required|string|max:500',
                'rating' => 'required|string|in:1,2,3,4,5',
                'status' => 'required|string|in:Active,Inactive',
            ],
            [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'comment.required' => 'Comment is required',
                'rating.required' => 'Rating is required',
                'status.required' => 'Status is required',
            ]
        );

        if ($vaidator->fails()) {
            return response()->json(['success' => false, 'message' => $vaidator->errors()->first()], 200);
        }

        $query->update([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'redirect' => route('admin.review.index'), 'message' => 'Review updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $query = Review::find($id);

        if (!$query) {
            return response()->json(['success' => false, 'message' => 'Review not found'], 200);
        }

        $query->delete();
        return response()->json(['success' => true, 'redirect' => route('admin.review.index'), 'message' => 'Review deleted successfully'], 200);
    }
}
