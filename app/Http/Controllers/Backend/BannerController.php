<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Banner::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $items = $query->orderBy('id', 'desc')->paginate(15);

        $banners = Banner::all();
        return view('backend.pages.banner.index', compact('items', 'banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $html = view('backend.pages.banner.create')->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'title' => 'required|string|max:255|unique:banners,title',
            'url' => 'required|url',
            'type' => 'required|in:hero,bottom_bar,home_sidebar,shop_sidebar',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
        }

        $data = [];

        $data['image'] = "uploads/banner/" . nice_file_name($request->title, $request->image->extension());

        FileUploader::upload($request->image, $data['image'], 2000, 2000, 150, 50);

        Banner::create([
            'image' => $data['image'],
            'url' => $request->url,
            'title' => $request->title,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'redirect' => route('admin.banner.index'), 'message' => 'Banner created successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Banner::find($id);

        if (empty($item)) {
            return response()->json(['success' => false, 'message' => 'Banner not found'], 200);
        }

        $html = view('backend.pages.banner.show', compact('item'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Banner::find($id);

        if (empty($item)) {
            return response()->json(['success' => false, 'message' => 'Banner not found'], 200);
        }

        $html = view('backend.pages.banner.edit', compact('item'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $query = Banner::find($id);

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'title' => 'required|string|max:255|unique:banners,title,' . $id,
            'url' => 'required|url',
            'type' => 'required|in:hero,bottom_bar,home_sidebar,shop_sidebar',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
        }

        if (!$query) {
            return response()->json(['success' => false, 'message' => 'Banner not found'], 200);
        }

        $data = [];

        if ($request->hasFile('image')) {
            $data['image'] = "uploads/banner/" . nice_file_name($request->title, $request->image->extension());
            FileUploader::upload($request->image, $data['image'], 2000, 2000, 150, 50);
            remove_file($query->image);
        }

        $query->update([
            'url' => $request->url,
            'image' => $data['image'] ?? $query->image,
            'title' => $request->title,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'redirect' => route('admin.banner.index'), 'message' => 'Banner updated successfully'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $query = Banner::find($id);

        if (!$query) {
            return response()->json(['success' => false, 'message' => 'Banner not found'], 200);
        }

        remove_file($query->image);
        $query->delete();
        return response()->json(['success' => true, 'redirect' => route('admin.banner.index'), 'message' => 'Banner deleted successfully'], 200);
    }
}
