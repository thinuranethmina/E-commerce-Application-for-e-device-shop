<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageUploader;
use App\Models\Brand;
use App\Services\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Brand::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $items = $query->orderBy('name', 'asc')->paginate(15);

        $brands = Brand::all();
        return view('backend.pages.brand.index', compact('items', 'brands'));
    }

    public function create()
    {
        $html = view('backend.pages.brand.create')->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,webp',
            'name' => 'required|string|max:255|unique:categories,name',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
        }

        $data = [];

        $data['image'] = "uploads/brand/" . nice_file_name($request->title, $request->image->extension());
        FileUploader::upload($request->image, $data['image'], 1000, 1000, 50, 50);

        Brand::create([
            'icon' => $data['image'],
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'redirect' => route('admin.brand.index'), 'message' => 'Brand created successfully'], 200);
    }

    public function edit(string $id)
    {
        $item = Brand::find($id);

        if (empty($item)) {
            return response()->json(['success' => false, 'message' => 'Brand not found'], 200);
        }

        $html = view('backend.pages.brand.edit', compact('item'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
        }

        $query = Brand::find($id);

        if (empty($query)) {
            return response()->json(['success' => false, 'message' => 'Brand not found'], 200);
        }

        $data = [];

        if ($request->hasFile('image')) {
            $data['image'] = "uploads/category/" . nice_file_name($request->title, $request->image->extension());
            FileUploader::upload($request->image, $data['image'], 1000, 1000, 150, 50);
            remove_file($query->image);
        }

        $query->update([
            'icon' => $data['image'] ?? $query->image,
            'name' => $request->name,
            'status' => $request->status,
        ]);


        return response()->json(['success' => true, 'redirect' => route('admin.brand.index'), 'message' => 'Brand updated successfully'], 200);
    }
    public function destroy(string $id)
    {
        $item = Brand::find($id);

        if (empty($item)) {
            return response()->json(['success' => false, 'message' => 'Brand not found'], 200);
        }

        $item->delete();

        return response()->json(['success' => true, 'redirect' => route('admin.brand.index'), 'message' => 'Brand deleted successfully'], 200);
    }
}
