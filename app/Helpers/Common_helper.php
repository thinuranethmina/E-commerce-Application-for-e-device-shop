<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


if (!function_exists('nice_file_name')) {
    function nice_file_name($file_title = "", $extension = "")
    {
        $unique_str = substr(md5(uniqid(rand(), true) . time()), 0, 11);
        return $unique_str . '-' . time() . '.' . $extension;
    }
}


if (!function_exists('slugify')) {
    function slugify($string)
    {
        $slug = preg_replace('/\s+/u', '-', $string);
        $slug = preg_replace('/-+/', '-', $slug);

        $slug = preg_replace('/[^\p{L}\p{N}-]+/u', '', $slug);

        $slug = trim($slug, '-');

        return $slug;
    }
}

if (!function_exists('slugify')) {
    function slugify($string)
    {
        $slug = preg_replace('/\s+/u', '-', $string);
        $slug = preg_replace('/-+/', '-', $slug);

        $slug = preg_replace('/[^\p{L}\p{N}-]+/u', '', $slug);

        $slug = trim($slug, '-');

        return $slug;
    }
}

if (!function_exists('random')) {
    /**
     * Generate a random string of specified length.
     *
     * @param int $length The length of the random string.
     * @param bool $lowercase Whether to convert the string to lowercase.
     * @return string The generated random string.
     */
    function random(int $length, bool $lowercase = false): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $lowercase ? strtolower($randomString) : $randomString;
    }
}



if (!function_exists('remove_file')) {
    function remove_file($url = null)
    {
        if (!$url) return;

        $url = str_replace('public/', '', $url);
        $url = public_path($url);

        $file_name = basename($url);

        if (is_file($url) && file_exists($url)) {
            unlink($url);

            $optimized_url = str_replace($file_name, 'optimized/' . $file_name, $url);
            if (is_file($optimized_url) && file_exists($optimized_url)) {
                unlink($optimized_url);
            }
        }
    }
}
