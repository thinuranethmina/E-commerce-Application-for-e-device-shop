<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class FileUploader
{
    public static function upload($uploaded_file, $upload_to, $width = null, $height = null, $optimized_width = 250, $optimized_height = null)
    {
        if (!$uploaded_file) {
            return null;
        }

        $upload_path = $upload_to;
        $upload_to = public_path($upload_to);

        if (is_dir($upload_to)) {
            $file_name = time() . '-' . random(3) . '.' . $uploaded_file->extension();
            $upload_path = $upload_path . '/' . $file_name;
        } else {
            $uploaded_path_arr = explode('/', $upload_to);
            $file_name = end($uploaded_path_arr);
            $upload_to = str_replace('/' . $file_name, "", $upload_to);

            if (!is_dir($upload_to)) {
                File::makeDirectory($upload_to, 0770, true);
            }
        }

        if ($width == null && $height == null) {
            $uploaded_file->move($upload_path, $file_name);
        } else {

            //Image optimization
            Image::make($uploaded_file->path())
                ->orientate()
                ->resize($width, $height, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })
                ->save($upload_to . '/' . $file_name);

            //Ultra Image optimization
            if ($optimized_width && $optimized_height) {
                $optimized_path = $upload_to . '/optimized';

                if (!is_dir($optimized_path)) {
                    File::makeDirectory($optimized_path, 0770, true);
                }

                Image::make($uploaded_file->path())
                    ->orientate()
                    ->resize($optimized_width, $optimized_height, function ($constraint) {
                        $constraint->upsize();
                        $constraint->aspectRatio();
                    })
                    ->save($optimized_path . '/' . $file_name);
            }
        }

        return $upload_path;
    }
}
