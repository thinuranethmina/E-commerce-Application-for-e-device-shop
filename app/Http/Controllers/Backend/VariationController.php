<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Variation;
use App\Models\VariationValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VariationController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Variation::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });
        }

        $items = $query->orderBy('name', 'asc')->paginate(15);

        $variations = Variation::all();
        return view('backend.pages.variation.index', compact('items', 'variations'));
    }

    public function create()
    {
        $html = view('backend.pages.variation.create')->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    public function variationValues(string $id)
    {

        $item = Variation::find($id);

        if (empty($item)) {
            return response()->json(['success' => false, 'message' => 'Variation not found'], 200);
        }

        $html = view('backend.pages.variation.select-values', compact('item'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:variations,name',
            'values' => 'required|array',
            'values.*' => 'required|string|max:255',
            'colors.*' => 'required|max:255'
        ], [
            'name.unique' => 'Variation name already exists',
            'values.required' => 'Variation values are required',
            'values.*.required' => 'Fill all variation values',
            'colors.*.required' => 'Fill all colors'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
        }

        $variation = Variation::create([
            'name' => $request->name,
        ]);

        $values = array_filter($request->values);
        $colors = array_filter($request->colors);

        if (count($values) !== count($colors)) {
            return response()->json(['errors' => ['values' => 'Values and colors must have the same count.']], 422);
        }

        $data = array_map(function ($value, $color) use ($variation) {
            return [
                'variations_id' => $variation->id,
                'variable' => $value,
                'color' => $color,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $values, $colors);

        DB::table('variation_details')->insert($data);

        return response()->json(['success' => true, 'redirect' => route('admin.variation.index'), 'message' => 'Variation created successfully'], 200);
    }

    public function edit(string $id)
    {
        $item = Variation::find($id);

        if (empty($item)) {
            return response()->json(['success' => false, 'message' => 'Brand not found'], 200);
        }

        $html = view('backend.pages.variation.edit', compact('item'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:variations,name,' . $id,
            'values' => 'required|array',
            'values.*' => 'required|string|max:255',
            'colors.*' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
        }

        $query = Variation::find($id);

        if (empty($query)) {
            return response()->json(['success' => false, 'message' => 'Variation not found'], 200);
        }

        $query->update([
            'name' => $request->name,
        ]);

        foreach ($request->values as $key => $value) {
            $variationValue = VariationValues::where('variations_id', $query->id)
                ->where('variable', $value)
                ->first();

            Log::info($variationValue);
            if ($variationValue) {
                $variationValue->update([
                    'color' => $request->colors[$key],
                ]);
            } else {
                Log::info($request->colors[$key]);
                VariationValues::create([
                    'variations_id' => $query->id,
                    'variable' => $value,
                    'color' => $request->colors[$key],
                ]);
            }
        }

        return response()->json(['success' => true, 'redirect' => route('admin.variation.index'), 'message' => 'Variation updated successfully'], 200);
    }
    public function destroy(string $id) {}
}
