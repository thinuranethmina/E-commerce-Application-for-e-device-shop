<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SystemSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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
    public function show(Request $request)
    {
        $settings = Setting::where('key', 'like', 'website.%')
            ->get()
            ->pluck('value', 'key');

        return view('backend.pages.settings.system', compact('settings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'site_name' => 'required',
                'meta_title' => 'required',
                'meta_keywords' => 'required',
                'meta_description' => 'required',
                'site_light_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|dimensions:min_width=100,min_height=50,max_width=2000,max_height=2000',
                'site_dark_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|dimensions:min_width=100,min_height=50,max_width=2000,max_height=2000',
                'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,webp|dimensions:min_width=16,min_height=16,max_width=100,max_height=100',
            ],
            [
                'site_name.required' => 'Please enter website name.',
                'meta_title.required' => 'Please enter website title.',
                'meta_keywords.required' => 'Please enter website keywords.',
                'meta_description.required' => 'Please enter website description.',

                'site_logo.image' => 'Please upload a valid image for the logo.',
                'site_logo.mimes' => 'Please upload an image in jpeg, png, webp, or jpg format for the logo.',
                'site_logo.dimensions' => 'Logo image dimensions must be between 100x100 and 1024x1024.',

                'site_favicon.image' => 'Please upload a valid image for the favicon.',
                'site_favicon.mimes' => 'Please upload a favicon in jpeg, png, webp, or jpg format.',
                'site_favicon.dimensions' => 'Favicon dimensions must be between 16x16 and 32x32.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $uploadPaths = [
            'site_light_logo' => 'assets/global/images/logos/',
            'site_dark_logo' => 'assets/global/images/logos/',
            'site_favicon' => 'assets/global/images/favicon/',
        ];

        foreach ($uploadPaths as $field => $path) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);

                if (!file_exists(public_path($path))) {
                    mkdir(public_path($path), 0755, true);
                }

                $prevFile = Setting::where('key', 'website.' . $field)->value('value');
                if ($prevFile && file_exists(public_path("$path/{$prevFile}"))) {
                    unlink(public_path("$path/{$prevFile}"));
                }

                $fileName = Str::random(16) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($path), $fileName);
                Setting::updateOrCreate(['key' => 'website.' . $field], ['value' => $fileName]);
            }
        }

        $data = $request->except(['site_light_logo', 'site_dark_logo', 'site_favicon']);
        foreach ($data as $field => $value) {
            Setting::updateOrCreate(['key' => "website.{$field}"], ['value' => $value]);
        }

        return response()->json(['success' => true, 'redirect' => route('admin.system_settings'), 'message' => "System Settings Update Success"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
