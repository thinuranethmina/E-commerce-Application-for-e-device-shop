<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = SubCategory::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('slug', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        $items = $query->orderBy('name', 'asc')->paginate(15);

        $subCategories = SubCategory::all();
        return view('backend.pages.subcategory.index', compact('items', 'subCategories'));
    }

    public function create()
    {
        $categories = Category::where('status', 'Active')->get();

        $html = view('backend.pages.subcategory.create', compact('categories'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:sub_categories,name',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
        }

        $slug = Str::slug($request->name);

        if (SubCategory::where('slug', $slug)->exists()) {
            return response()->json(['success' => false, 'message' => 'Sub Category name already exists.'], 200);
        }

        SubCategory::create([
            'category_id' => $request->category,
            'slug' => $slug,
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'redirect' => route('admin.sub-category.index'), 'message' => 'Sub Category created successfully'], 200);
    }

    public function edit(string $id)
    {
        $item = SubCategory::find($id);

        $categories = Category::where('status', 'Active')->get();

        if (empty($item)) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 200);
        }

        $html = view('backend.pages.subcategory.edit', compact('item', 'categories'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:sub_categories,name,' . $id,
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
        }

        $item = SubCategory::find($id);

        if (empty($item)) {
            return response()->json(['success' => false, 'message' => 'Sub Category not found'], 200);
        }

        $slug = Str::slug($request->name);

        if (SubCategory::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Sub Category name already exists.'], 200);
        }

        $item->update([
            'category_id' => $request->category,
            'slug' => $slug,
            'name' => $request->name,
            'status' => $request->status,
        ]);


        return response()->json(['success' => true, 'redirect' => route('admin.sub-category.index'), 'message' => 'Sub Category updated successfully'], 200);
    }
    public function destroy(string $id)
    {
        $item = SubCategory::find($id);

        if (empty($item)) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 200);
        }

        $item->delete();

        return response()->json(['success' => true, 'redirect' => route('admin.category.index'), 'message' => 'Category deleted successfully'], 200);
    }
}
