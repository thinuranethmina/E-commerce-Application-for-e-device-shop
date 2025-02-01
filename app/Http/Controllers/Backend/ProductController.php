<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductVariation;
use App\Models\ProductVariationValue;
use App\Models\Variation;
use App\Services\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Product::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas(
                'subCategory',
                function ($q) use ($request) {
                    $q->where('category_id', $request->category);
                }
            );
        }

        if ($request->has('brand') && !empty($request->brand)) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $items = $query->orderBy('name', 'asc')->paginate(15);

        $products = Product::all();
        $categories = Category::where('status', 'Active')->get();
        $brands = Brand::where('status', 'Active')->get();
        return view('backend.pages.product.index', compact('items', 'products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        $variations = Variation::all();

        return view('backend.pages.product.create', compact('brands', 'categories', 'variations'));
    }

    public function variationRow($index)
    {
        $variations = Variation::all();

        $index2 = time();

        $html = view('backend.pages.product.variation-row', compact('variations', 'index', 'index2'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    public function variationContent()
    {
        $variations = Variation::all();

        $index = time();

        $html = view('backend.pages.product.variation-content', compact('variations', 'index'))->render();

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
                'slug' => 'required|string|max:255|unique:products,slug',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'warranty_period' => 'nullable|string|max:255',
                'warranty_info' => 'nullable|string|max:1000',
                'brand_id' => 'nullable|exists:brands,id',
                'sub_category_id' => 'required|exists:sub_categories,id',
                'is_featured' => 'required|in:0,1',
                'price' => 'required_unless:has_variations,1|min:0',
                'stock' => 'required_unless:has_variations,1|min:0',
                'status' => 'required|string|in:Active,Inactive',
                'gallery.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            ],
            [
                'slug.required' => 'The product slug is required.',
                'slug.unique' => 'The slug must be unique. This slug is already in use.',
                'thumbnail.required' => 'The product thumbnail is required.',
                'thumbnail.image' => 'The thumbnail must be a valid image.',
                'thumbnail.mimes' => 'The thumbnail must be a file of type: jpeg, png, jpg, webp.',
                'thumbnail.max' => 'The thumbnail size must not exceed 2MB.',
                'name.required' => 'The product name is required.',
                'description.required' => 'The product description is required.',
                'base_price.required' => 'The base price is required.',
                'base_price.numeric' => 'The base price must be a numeric value.',
                'base_price.min' => 'The base price must be at least 0.',
                'warranty.required' => 'The warranty information is required.',
                'brand_id.required' => 'A valid brand ID is required.',
                'brand_id.exists' => 'The selected brand does not exist.',
                'sub_category_id.required' => 'A valid sub-category ID is required.',
                'sub_category_id.exists' => 'The selected sub-category does not exist.',
                'is_featured.required' => 'Please specify if the product is featured.',
                'is_featured.in' => 'Invalid value for the featured field.',
                'status.required' => 'The product status is required.',
                'status.in' => 'The status must be either Active or Inactive.',
                'gallery.*.required' => 'The gallery image is required.',
                'gallery.*.image' => 'The gallery image must be a valid image.',
                'gallery.*.mimes' => 'The gallery image must be a file of type: jpeg, png, jpg, webp.',
                'gallery.*.max' => 'The gallery image size must not exceed 2MB.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        if (isset($request->has_variations) && $request->has_variations == 1) {

            $validator2 = Validator::make($request->all(), [
                'product_variation.*' => 'required|min:1',
                'product_variation.*.price' => 'required|numeric|min:0',
                'product_variation.*.stock' => 'required|numeric|min:0',
                'product_variation' => 'required|array|min:1',
                'product_variation' => 'required|array',
                'product_variation.*.variationName.*' => 'required',
                'product_variation.*.variationValue.*' => 'required',
            ], [
                'product_variation.*.price.required' => 'The price is required.',
                'product_variation.*.price.*.numeric' => 'Each price must be a numeric value.',
                'product_variation.*.price.*.min' => 'Each price must be at least 0.',
                'product_variation.*.stock.required' => 'The stock is required.',
                'product_variation.*.stock.*.integer' => 'Each stock value must be an integer.',
                'product_variation.*.stock.*.min' => 'Each stock value must be at least 0.',
                'product_variation.*.variationName.*.required' => 'The variation name is required.',
                'product_variation.*.variationName.*.exists' => 'The selected variation name does not exist.',
                'product_variation.*.variationValue.*.required' => 'The variation value is required.',
                'product_variation.*.variationValue.*.exists' => 'The selected variation value does not exist.',
            ]);

            if ($validator2->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }
        }

        $imagePath = null;
        if ($request->hasFile('thumbnail')) {
            $imagePath = "uploads/products/thumbnail/" . nice_file_name($request->name, $request->thumbnail->extension());
            FileUploader::upload($request->thumbnail, $imagePath, 300, 500, 150, 50);
        }

        $product = Product::create([
            'slug' => Str::slug($request->slug),
            'thumbnail' => $imagePath,
            'name' => $request->name,
            'description' => $request->description,
            'warranty_period' => $request->warranty_period,
            'warranty_info' => $request->warranty_info,
            'brand_id' => $request->brand_id ?? null,
            'sub_category_id' => $request->sub_category_id,
            'is_featured' => $request->is_featured,
            'status' => $request->status,
        ]);

        if (isset($request->has_variations) && $request->has_variations == 1) {

            foreach ($request->product_variation as $key => $value) {
                $variationQuery = ProductVariation::create([
                    'product_id' => $product->id,
                    'price' => $value['price'],
                    'stock' => $value['stock'],
                ]);

                foreach ($value['variationName'] as $key2 => $value2) {
                    ProductVariationValue::create([
                        'product_variation_id' => $variationQuery->id,
                        'variation_name_id' => $value2,
                        'variation_value_id' => $value['variationValue'][$key2],
                    ]);
                }
            }
        } else {
            ProductVariation::create([
                'product_id' => $product->id,
                'price' => $request->price,
                'stock' => $request->stock,
            ]);
        }

        if ($request->has('gallery')) {
            foreach ($request->file('gallery') as $galleryImage) {
                $imagePath = "uploads/products/gallery/" . nice_file_name($request->name, $galleryImage->extension());
                FileUploader::upload($galleryImage, $imagePath, 300, 500, 150, 50);

                ProductGallery::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                ]);
            }
        }

        return response()->json(['success' => true, 'redirect' => route('admin.products.index'), 'message' => 'Product created successfully.'], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        $variations = Variation::all();
        $categories = Category::where('status', 'Active')->get();
        $brands = Brand::where('status', 'Active')->get();

        return view('backend.pages.product.show', compact('product', 'variations', 'categories', 'brands'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $variations = Variation::all();
        $categories = Category::where('status', 'Active')->get();
        $brands = Brand::where('status', 'Active')->get();

        return view('backend.pages.product.edit', compact('product', 'variations', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::info($request->all());

        $query = Product::find($id);

        $validator = Validator::make(
            $request->all(),
            [
                'slug' => 'required|string|max:255|unique:products,slug,' . $query->id,
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'warranty_period' => 'nullable|string|max:255',
                'warranty_info' => 'nullable|string|max:1000',
                'brand_id' => 'nullable|exists:brands,id',
                'sub_category_id' => 'required|exists:sub_categories,id',
                'is_featured' => 'required|in:0,1',
                'price' => 'required_unless:has_variations,1|min:0',
                'stock' => 'required_unless:has_variations,1|min:0',
                'status' => 'required|string|in:Active,Inactive',
                'gallery.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            ],
            [
                'slug.required' => 'The product slug is required.',
                'slug.unique' => 'The slug must be unique. This slug is already in use.',
                'thumbnail.image' => 'The thumbnail must be a valid image.',
                'thumbnail.mimes' => 'The thumbnail must be a file of type: jpeg, png, jpg, webp.',
                'thumbnail.max' => 'The thumbnail size must not exceed 2MB.',
                'name.required' => 'The product name is required.',
                'description.required' => 'The product description is required.',
                'base_price.required' => 'The base price is required.',
                'base_price.numeric' => 'The base price must be a numeric value.',
                'base_price.min' => 'The base price must be at least 0.',
                'warranty.required' => 'The warranty information is required.',
                'brand_id.required' => 'A valid brand ID is required.',
                'brand_id.exists' => 'The selected brand does not exist.',
                'sub_category_id.required' => 'A valid sub-category ID is required.',
                'sub_category_id.exists' => 'The selected sub-category does not exist.',
                'is_featured.required' => 'Please specify if the product is featured.',
                'is_featured.in' => 'Invalid value for the featured field.',
                'status.required' => 'The product status is required.',
                'status.in' => 'The status must be either Active or Inactive.',
                'product_variation.*.price.required' => 'The price is required.',
                'product_variation.*.price.*.numeric' => 'Each price must be a numeric value.',
                'product_variation.*.price.*.min' => 'Each price must be at least 0.',
                'product_variation.*.stock.required' => 'The stock is required.',
                'product_variation.*.stock.*.integer' => 'Each stock value must be an integer.',
                'product_variation.*.stock.*.min' => 'Each stock value must be at least 0.',
                'product_variation.*.variationName.*.required' => 'The variation name is required.',
                'product_variation.*.variationName.*.exists' => 'The selected variation name does not exist.',
                'product_variation.*.variationValue.*.required' => 'The variation value is required.',
                'product_variation.*.variationValue.*.exists' => 'The selected variation value does not exist.',
                'gallery.*.required' => 'The gallery image is required.',
                'gallery.*.image' => 'The gallery image must be a valid image.',
                'gallery.*.mimes' => 'The gallery image must be a file of type: jpeg, png, webp.',
                'gallery.*.max' => 'The gallery image size must not exceed 2MB.',
            ]
        );

        if (!$query) {
            return response()->json(['success' => false, 'message' =>  'Product not found'], 200);
        }

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        if (isset($request->has_variations) && $request->has_variations == 1) {
            $validator2 = Validator::make($request->all(), [
                'product_variation' => 'required',
                'product_variation.*' => 'required|min:1',
                'product_variation.*.price' => 'required|numeric|min:0',
                'product_variation.*.stock' => 'required|numeric|min:0',
                'product_variation.*.variationName.*' => 'exists:variations,id',
                'product_variation.*.variationValue.*' => 'exists:variation_values,id',
                'product_variation.*.name.*' => 'required',
            ], [
                'product_variation.*.price.required' => 'The price is required.',
                'product_variation.*.price.numeric' => 'The price must be a numeric value.',
                'product_variation.*.price.min' => 'The price must be at least 0.',
                'product_variation.*.stock.required' => 'The stock is required.',
                'product_variation.*.stock.numeric' => 'The stock must be a numeric value.',
                'product_variation.*.stock.min' => 'The stock must be at least 0.',
                'product_variation.*.variationName.*.required' => 'The variation name is required.',
                'product_variation.*.variationName.*.exists' => 'The selected variation name does not exist.',
                'product_variation.*.variationValue.*.required' => 'The variation value is required.',
                'product_variation.*.variationValue.*.exists' => 'The selected variation value does not exist.',
                'product_variation.*.name.*.required' => 'The variation name is required.',
            ]);

            if ($validator2->fails()) {
                return response()->json(['success' => false, 'message' => $validator2->errors()->first()], 422);
            }
        }

        $imagePath = null;
        if ($request->hasFile('thumbnail')) {
            $imagePath = "uploads/products/thumbnail/" . nice_file_name($request->name, $request->thumbnail->extension());
            FileUploader::upload($request->thumbnail, $imagePath, 300, 500, 150, 50);
            remove_file($query->thumbnail);
        }

        $query->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'thumbnail' => $imagePath ?? $query->thumbnail,
            'description' => $request->description,
            'warranty_period' => $request->warranty_period,
            'warranty_info' => $request->warranty_info,
            'brand_id' => $request->brand_id,
            'sub_category_id' => $request->sub_category_id,
            'is_featured' => $request->is_featured,
            'status' => $request->status,
        ]);

        if (isset($request->has_variations) && $request->has_variations == 1) {

            $selectedProductVariation = [];

            foreach ($request->product_variation as $key => $value) {

                $selectedProductVariation[] = $key;

                $variationQuery = ProductVariation::find($key);
                if ($variationQuery) {
                    $variationQuery->update([
                        'price' => $value['price'],
                        'stock' => $value['stock'],
                    ]);

                    $selectedVariationValues = [];

                    foreach ($value['variationName'] as $key2 => $value2) {
                        $productVariation = ProductVariationValue::where('id', $key2)->where('product_variation_id', $key)->first();

                        if ($productVariation) {
                            $selectedVariationValues[] = $productVariation->id;
                            $productVariation->update([
                                'variation_value_id' => $value['variationValue'][$key2],
                            ]);
                        } else {
                            $variationValue = ProductVariationValue::create([
                                'product_variation_id' => $key,
                                'variation_value_id' => $value['variationValue'][$key2],
                            ]);
                            $selectedVariationValues[] = $variationValue->id;
                        }
                    }

                    ProductVariationValue::where('product_variation_id', $key)->whereNotIn('id', $selectedVariationValues)->delete();
                } else {
                    $variationQuery = ProductVariation::create([
                        'product_id' => $query->id,
                        'price' => $value['price'],
                        'stock' => $value['stock'],
                    ]);

                    $selectedProductVariation[] = $variationQuery->id;

                    foreach ($value['variationName'] as $key2 => $value2) {
                        ProductVariationValue::create([
                            'product_variation_id' => $variationQuery->id,
                            'variation_name_id' => $value2,
                            'variation_value_id' => $value['variationValue'][$key2],
                        ]);
                    }
                }
            }

            ProductVariation::where('product_id', $query->id)->whereNotIn('id', $selectedProductVariation)->delete();
        } else {
            $query->variations[0]->update([
                'price' => $request->price,
                'stock' => $request->stock,
            ]);
            $query->variations->skip(1)->each(function ($variation) {
                foreach ($variation->values as $value) {
                    $value->delete();
                }
                $variation->delete();
            });
            $query->variations[0]->values()->delete();
        }

        if ($request->has('length')) {
            for ($i = 0; $i < $request->input('length'); $i++) {
                if ($request->has('image' . $i)) {

                    if ($request->input('imageStatus' . $i) == 'newset') {
                        $screenShot = $request->file('image' . $i);

                        if ($screenShot->isValid()) {

                            $imagePath = "uploads/products/gallery/" . nice_file_name($request->name, $screenShot->extension());
                            FileUploader::upload($screenShot, $imagePath, 300, 500, 150, 50);

                            ProductGallery::create([
                                'product_id' => $query->id,
                                'image' => $imagePath,
                            ]);
                        }
                    } elseif ($request->input('imageStatus' . $i) == 'deleted') {
                        $imageName = $request->input('image' . $i);
                        $screenShot = ProductGallery::where('image',  $imageName)->first();

                        if ($screenShot) {

                            remove_file($screenShot->image);

                            $screenShot->delete();
                        }
                    }
                }
            }
        }

        return response()->json(['success' => true, 'redirects' => route('admin.products.index'), 'message' => 'Product updated successfully.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $query = Product::find($id);

        if ($query) {
            $query->delete();
            return response()->json(['success' => true, 'redirect' => route('admin.products.index'), 'message' => 'Product deleted successfully.'], 200);
        }

        return response()->json(['success' => false, 'message' => 'Product not found.'], 200);
    }
}
