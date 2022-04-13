<?php

namespace App\Providers;

use App\AdvBlock;
use App\Category;
use App\Contents;
use App\Currencies;
use App\HPContactUS;
use App\Language;
use App\Partners;
use App\Post;
use App\ProductRequest;
use App\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Closure;
use Cookie;
use Config;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
        view()->composer('*', function ($view) {

            $user = Auth::user();
            $langauges = Language::get();
            $setting = Setting::first();

            $category = Category::orderby("id","asc")->get();

            $services_header = Contents::orderby('id','desc')->where("type","services")->get();
            $pages_top = Post::where("type","2")->get();

            $hp_contact = HPContactUS::first();
            $geturlphoto = $setting->public;

            $select_lan = Language::where('dir', '=', app()->getLocale())->first();
            if ($select_lan == null) {
                $select_lan = Language::where('select', '=', '1')->first();
            }
            $select_lan_choice = Language::where('select', '=', '1')->first();

            $count_header = count(Request::segments(1));
            if ($count_header == 0) {
                $data_results = file_get_contents(public_path() . '/languages/' . $select_lan->dir . '.json');
            }
            else {
                $secound_url = Request::segments(1)[0];
                if($secound_url == "dashboard" || $secound_url == "store"){
                    $data_results = file_get_contents(public_path() . '/languages/' . $select_lan->dir . '_dashboard.json');
                }
                else{
                    $data_results = file_get_contents(public_path() . '/languages/' . $select_lan->dir . '.json');
                }
            }
            $lang = json_decode($data_results);

            $path = url('/').$geturlphoto;

            $select_curr = Currencies::where('select', '=', 1)->first();
            if(Cookie::get('currency') != null){
                $curenc_cooki = Currencies::where('code', '=', Cookie::get('currency'))->first();
            }
            else{
                $curenc_cooki = Currencies::where('select', '=', 1)->first();
            }

            $currs = Currencies::get();

            $view
                ->with('get_url_photo', $geturlphoto)
                ->with('path', $path)
                ->with('user', $user)
                ->with('curenc_cooki', $curenc_cooki)
                ->with('currs', $currs)
                ->with('select_curr', $select_curr)
                ->with('lang', $lang)
                ->with('services_header', $services_header)
                ->with('category', $category)
                ->with('hp_contact', $hp_contact)
                ->with('pages_top', $pages_top)
                ->with('setting', $setting)
                ->with('select_lan_choice', $select_lan_choice)
                ->with('select_lan', $select_lan)
                ->with('langauges', $langauges);

        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
