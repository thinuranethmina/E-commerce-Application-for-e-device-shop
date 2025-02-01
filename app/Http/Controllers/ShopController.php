<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationValue;
use App\Models\Review;
use App\Models\SubCategory;
use App\Models\Variation;
use App\Models\VariationValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    public function index()
    {
        $orderBy = request()->get('order_by', 'DESC');
        $rows = request()->get('rows', 16);

        $title = null;

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
            });

        if (request()->has('category')) {
            $products->whereHas(
                'subCategory',
                function ($query) {
                    $query->where('category_id', request('category'));
                }
            );
            $title = strtoupper(Category::findOrFail(request('category'))->name);
        }

        if (request()->has('subcategory_id')) {
            $products->where('sub_category_id', request('subcategory_id'));
            if (request('subcategory_id')) {
                $title = strtoupper(SubCategory::findOrFail(request('subcategory_id'))->name);
            }
        }

        if (request()->has('brand')) {
            $products->whereIn('brand_id', request('brand'));
            if (is_array(request('brand')) && count(request('brand')) == 1) {
                $title = strtoupper(Brand::findOrFail(request('brand')[0])->name);
            }
        }

        if (request()->has('variation')) {
            $variations = request('variation');

            $products->whereHas('variations.values', function ($query) use ($variations) {
                $query->whereIn('variation_value_id', $variations);
            });
        }

        $minRange = request()->get('min_range', 0);
        $products->whereHas('variations', function ($query) use ($minRange) {
            $query->where('price', '>=', $minRange);
        });

        if (request()->has('max_range')) {
            $maxRange = request()->get('max_range');
            $products->whereHas('variations', function ($query) use ($maxRange) {
                $query->where('price', '<=', $maxRange);
            });
        }

        $products->orderBy('created_at', $orderBy);

        $allProducts = $products->count();

        $products = $products->paginate($rows);

        $categories = Category::where('status', 'Active')->get();
        $brands = Brand::where('status', 'Active')->get();
        $variations = Variation::all();


        return view('frontend.pages.shop.index', compact('products', 'categories', 'brands', 'variations', 'title', 'allProducts'));
    }

    public function detail($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $reviews = Review::where('product_id', $product->id)
            ->where('status', 'Active')
            ->orderBy('id', 'desc');

        $related_products = Product::whereIn('sub_category_id', SubCategory::where('category_id', $product->subCategory->category_id)->pluck('id'))->get();

        return view('frontend.pages.shop.detail', compact('product', 'reviews', 'related_products'));
    }

    public function fetchOptions(Request $request)
    {
        $product_id = $request->product_id;
        $variation_id = $request->variation_id;
        $value_id = $request->value_id;

        $product = Product::findOrFail($product_id);

        $productVariations = $product->variations->pluck('id')->toArray();

        $selectedVariations = ProductVariationValue::where('variation_value_id', $value_id)
            ->whereIn('product_variation_id', $productVariations)
            ->pluck('product_variation_id')
            ->toArray();

        $dependentVariations = ProductVariationValue::whereIn('product_variation_id', $selectedVariations)
            ->distinct()
            ->pluck('variation_value_id')
            ->toArray();

        $data = [];
        foreach ($dependentVariations as $dependentVariation) {
            $data[] = [
                'variable' => VariationValues::where('id', $dependentVariation)->first()->variationName->id,
                'value' => $dependentVariation,
            ];
        }

        $query = ProductVariation::where('product_id', $product_id);

        $dependentVariations2 = ProductVariationValue::whereIn('product_variation_id', $selectedVariations)
            ->distinct()
            ->pluck('id')
            ->toArray();

        foreach ($request->all() as $key => $value) {
            if (!is_null($value) && $key !== 'product_id' && $key !== 'variation_id' && $key !== 'value_id' && $key !== 'qty' && $key !== '_token') {
                $query->whereHas('values', function ($q) use ($key, $value, $dependentVariations2) {
                    $q->where('variation_value_id', $value)->whereIn('id', $dependentVariations2);
                });
            }
        }

        $price = $query->first()->price ?? 0;
        $productVariationId = $query->first()->id ?? 0;

        Log::info($data);

        $resp = [
            "stock" => $query->first()->stock ?? -1,
            "resultset" => $data,
            "productVariationId" => $productVariationId,
            "price" => $price,
        ];

        return $resp;
    }

    public function priceUpdate(Request $request)
    {
        Log::info($request->all());

        $nullValues = [];
        foreach ($request->all() as $key => $value) {
            if (is_null($value)) {
                $nullValues[$key] = $value;
            }
        }

        if (!empty($nullValues)) {
            Log::warning('The following keys have null values:', $nullValues);

            return response()->json([
                'success' => false,
                'message' => 'The field "' . array_key_first($nullValues) . '" is null.',
                'null_keys' => array_keys($nullValues),
            ], 422);
        }

        $productVariations = Product::findOrFail($request->product_id)->variations->pluck('id');

        $selectedVariations = [];
        foreach ($request->all() as $key => $value) {
            $variation_name = Variation::where('name', $key)->first();

            if (!$variation_name) {
                continue;
            }

            $variationValues = VariationValues::where('id', $value)->where('variation_id', $variation_name->id)->first();

            if (!$variationValues) {
                continue;
            }

            $selectedVariations = ProductVariationValue::where('variation_value_id', $value)->whereIn('product_variation_id', $productVariations)->get();
        }

        return response()->json(['success' => true, 'message' => 'Request data is valid'], 200);
    }
}
