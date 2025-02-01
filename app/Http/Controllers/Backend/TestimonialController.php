<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Testimonial::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('rating') && !empty($request->rating)) {
            $query->where('rating', '=', $request->rating);
        }

        $items = $query->orderBy('name', 'asc')->paginate(15);

        $testimonials = Testimonial::all();
        return view('backend.pages.testimonial.index', compact('items', 'testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $html = view('backend.pages.testimonial.create')->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'comment' => 'required|string|max:500',
                'rating' => 'required|string|in:1,2,3,4,5',
                'status' => 'required|string|in:Active,Inactive',
            ],
            [
                'name.required' => 'Name is required',
                'location.required' => 'Location is required',
                'comment.required' => 'Comment is required',
                'rating.required' => 'Rating is required',
                'status.required' => 'Status is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = "uploads/testimonial/user/" . nice_file_name($request->name, $request->image->extension());
            FileUploader::upload($request->image, $imagePath, 300, 500, 150, 50);
        }

        $data = [
            'image' => $imagePath,
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
            'status' => $request->input('status'),
        ];

        Testimonial::create($data);

        return response()->json(['success' => true, 'redirect' => route('admin.testimonial.index'), 'message' => 'Testimonial created successfully'], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Testimonial::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Testimonial not found'], 200);
        }

        $html = view('backend.pages.testimonial.show', compact('item'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Testimonial::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Testimonial not found'], 200);
        }

        $html = view('backend.pages.testimonial.edit', compact('item'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $query = Testimonial::find($id);

        if (!$query) {
            return response()->json(['success' => false, 'message' => 'Testimonial not found'], 200);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'name' => 'required|string|max:50',
                'location' => 'required|string|max:50',
                'comment' => 'required|string|max:500',
                'rating' => 'required|string|in:1,2,3,4,5',
                'status' => 'required|string|in:Active,Inactive',
            ],
            [
                'image.image' => 'The uploaded file must be an image',
                'image.mimes' => 'The image must be in JPEG, PNG, or JPG format',
                'image.max' => 'The image size must not exceed 2MB',
                'name.required' => 'Name is required',
                'location.required' => 'Location is required',
                'comment.required' => 'Comment is required',
                'rating.required' => 'Rating is required',
                'status.required' => 'Status is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 200);
        }

        $imagePath = $query->image;
        if ($request->hasFile('image')) {
            $imagePath = "uploads/testimonial/user/" . nice_file_name($request->name, $request->image->extension());
            FileUploader::upload($request->file('image'), $imagePath, 300, 500, 150, 50);
            if ($query->image) {
                remove_file($query->image);
            }
        }

        $query->update([
            'image' => $imagePath,
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
            'status' => $request->input('status'),
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route('admin.testimonial.index'),
            'message' => 'Testimonial updated successfully',
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $query = Testimonial::find($id);

        if (!$query) {
            return response()->json(['success' => false, 'message' => 'Testimonial not found'], 200);
        }

        remove_file($query->image);
        $query->delete();
        return response()->json(['success' => true, 'redirect' => route('admin.testimonial.index'), 'message' => 'Testimonial deleted successfully'], 200);
    }
}
