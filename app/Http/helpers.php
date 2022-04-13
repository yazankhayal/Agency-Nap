<?php
/**
 * Created by PhpStorm.
 * User: Napster
 * Date: 5/7/2020
 * Time: 11:08 PM
 */

function CurrentLangShow($lang_s)
{
    $select_lan = \App\Language::where('dir', '=', app()->getLocale())->first();
    $data_results = file_get_contents(public_path() . '/languages/' . $select_lan->dir . '.json');
    $lang = json_decode($data_results);
    foreach ($lang as $key => $value) {
        if ($key == $lang_s) {
            return $value;
        }
    }
}

if (!function_exists('pop_up')) {
    function pop_up()
    {
        $one = \Cookie::get('pop_up');
        return $one;
    }
}

if (!function_exists('Gallery')) {
    function Gallery()
    {
        $one = \App\Gallery::get();
        return $one;
    }
}

if (!function_exists('ul_link')) {
    function ul_link($link)
    {
        $one = route($link);
        return $one;
    }
}

if (!function_exists('dis')) {
    function dis()
    {
        $count = count(Request::segments(1));
        $dis = "disabled";
        if ($count == 4) {
            if (Request::segments(1)[3]) {
                $dis = "";
            }
        }
        return $dis;
    }
}

if (!function_exists('lang_name')) {
    function lang_name($lang)
    {
        $two = CurrentLangShow($lang);
        if ($two) {
            return $two;
        } else {
            return 'No_found_language : ' . $lang;
        }
    }
}

if (!function_exists('current_route')) {
    function current_route($x)
    {
        if (\Route::current()->getName() == $x) {
            return "active";
        } else {
            return "";
        }
    }
}

if (!function_exists('current_route_c')) {
    function current_route_c()
    {
        return \Route::current()->getName();
    }
}

if (!function_exists('category_check')) {
    function category_check($x)
    {
        $category = \App\Category::where("id",$x)->first();
        return $category;
    }
}

if (!function_exists('page_header')) {
    function page_header()
    {
        $category = \App\Post::where("type",3)->get();
        return $category;
    }
}

if (!function_exists('category')) {
    function category()
    {
        $category = \App\Category::get();
        return $category;
    }
}

if (!function_exists('scripts')) {
    function scripts()
    {
        $i = \App\ScriptsSetting::first();
        return $i;
    }
}

if (!function_exists('posts')) {
    function posts()
    {
        $i = \App\Post::where("type", "1")->where("featured", "1")->get();
        return $i;
    }
}


if (!function_exists('pages_footer')) {
    function pages_footer()
    {
        $i = \App\Post::where("type", "3")->where("featured", "1")->get();
        return $i;
    }
}
if (!function_exists('pages_footer1')) {
    function pages_footer1()
    {
        $i = \App\Post::where("type", "4")->where("featured", "1")->get();
        return $i;
    }
}
if (!function_exists('pages_footer2')) {
    function pages_footer2()
    {
        $i = \App\Post::where("type", "5")->where("featured", "1")->get();
        return $i;
    }
}

if (!function_exists('setting')) {
    function setting()
    {
        $setting = \App\Setting::first();
        return $setting;
    }
}

if (!function_exists('hp_contact')) {
    function hp_contact()
    {
        $setting = \App\HPContactUS::first();
        return $setting;
    }
}

if (!function_exists('path')) {
    function path()
    {
        $path = \App\Setting::first()->public;
        $ps = url('/') . $path;
        return $ps;
    }
}

if (!function_exists('get_url_photo')) {
    function get_url_photo()
    {
        $path = \App\Setting::first()->public;
        return $path;
    }
}

if (!function_exists('features_area')) {
    function features_area()
    {
        $path = \App\Contents::orderby('id', 'asc')->where("type", "features_area")->get();
        return $path;
    }
}
