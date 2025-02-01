<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageUploader;
use App\Models\Category;
use App\Services\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Category::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('slug', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $items = $query->orderBy('name', 'asc')->paginate(15);

        $categories = Category::all();
        return view('backend.pages.category.index', compact('items', 'categories'));
    }

    public function create()
    {
        $html = view('backend.pages.category.create')->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'status' => 'required|in:Active,Inactive',
            'icon' => 'required|regex:/<svg[\s\S]*?>[\s\S]*?<\/svg>/i',
            function ($attribute, $value, $fail) {
                if (!str_contains($value, '<svg')) {
                    $fail('The icon must contain an <svg> tag.');
                    return;
                }
            },
        ], [
            'icon.required' => 'The icon is required.',
            'icon.regex' => 'The icon must be a valid SVG.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
        }

        $slug = Str::slug($request->name);

        if (Category::where('slug', $slug)->exists()) {
            return response()->json(['success' => false, 'message' => 'Category name already exists.'], 200);
        }

        Category::create([
            'icon' => $request->icon,
            'slug' => $slug,
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'redirect' => route('admin.category.index'), 'message' => 'Category created successfully'], 200);
    }

    public function edit(string $id)
    {
        $item = Category::find($id);

        if (empty($item)) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 200);
        }

        $html = view('backend.pages.category.edit', compact('item'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'status' => 'required|in:Active,Inactive',
            'icon' => 'required|regex:/<svg[\s\S]*?>[\s\S]*?<\/svg>/i',
            function ($attribute, $value, $fail) {

                if (!preg_match('/<svg[\s\S]*?>[\s\S]*?<\/svg>/', $value)) {
                    $fail('The icon must contain valid SVG code.');
                    return;
                }

                libxml_use_internal_errors(true);
                $xml = simplexml_load_string($value);
                libxml_clear_errors();
                if ($xml === false) {
                    $fail('The icon must be a well-formed SVG.');
                }
            },
        ], [
            'icon.required' => 'The icon is required.',
            'icon.regex' => 'The icon must be a valid SVG.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
        }

        $query = Category::find($id);

        if (empty($query)) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 200);
        }

        $slug = Str::slug($request->name);

        if (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Category name already exists.'], 200);
        }

        $query->update([
            'slug' => $slug,
            'icon' => $request->icon,
            'name' => $request->name,
            'status' => $request->status,
        ]);


        return response()->json(['success' => true, 'redirect' => route('admin.category.index'), 'message' => 'Category updated successfully'], 200);
    }
    public function destroy(string $id)
    {
        $item = Category::find($id);

        if (empty($item)) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 200);
        }

        $item->delete();

        return response()->json(['success' => true, 'redirect' => route('admin.category.index'), 'message' => 'Category deleted successfully'], 200);
    }
}
