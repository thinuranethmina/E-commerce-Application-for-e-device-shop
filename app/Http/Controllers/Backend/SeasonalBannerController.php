<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SeasonalBanner;
use App\Services\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeasonalBannerController extends Controller
{
    public function show()
    {
        $banner = SeasonalBanner::first();
        return view('backend.pages.seasonal_banner.index', compact('banner'));
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
            'label1' => 'required|string|max:255',
            'label2' => 'required|string|max:255',
            'label3' => 'required|string|max:255',
            'url' => 'required|url',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $banner = SeasonalBanner::first();

        $data = [];

        if ($request->hasFile('image')) {
            $data['image'] = "uploads/seasonal_banner/" . nice_file_name($request->title, $request->image->extension());
            FileUploader::upload($request->image, $data['image'], 2000, 2000, 150, 50);
            remove_file($banner->image);
        }

        $banner->update(
            [
                'image' => $data['image'] ?? $banner->image,
                'label1' => $request->label1,
                'label2' => $request->label2,
                'label3' => $request->label3,
                'url' => $request->url,
                'status' => $request->status
            ]
        );

        return redirect()->back()->with('success', 'Seasonal Banner updated successfully');
    }
}
