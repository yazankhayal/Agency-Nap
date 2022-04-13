<?php

namespace App\Http\Controllers;

use App\Category;
use App\Contents;
use App\Contact_page;
use App\ContactUS;
use App\Currencies;
use App\EmailSetting;
use App\Gallery;
use App\HomePageSetting;
use App\Language;
use App\Portfolio;
use App\ProductRequest;
use App\Products;
use App\HPContactUS;
use App\Newsletter;
use App\Partners;
use App\Post;
use App\ProductsTranslate;
use App\Testimonials;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mail;
use Cookie;

class HomepageController extends Controller
{

    public function index(Request $request)
    {
        $slider = Contents::orderby('id', 'desc')->where("type", "slider")->get();
        $services = Contents::orderby('id', 'desc')->where("type", "services")->get();
        $blog = Post::orderby('id', 'desc')->where("type", "1")->where("featured", "1")->get();
        $gallery = Gallery::orderby('id', 'desc')->get();
        $about = Contents::orderby('id', 'desc')->where("type", "about")->first();
        $special = Contents::orderby('id', 'desc')->where("type", "special")->first();
        $fact = Contents::orderby('id', 'desc')->where("type", "fact")->first();
        $how_work = Contents::orderby('id', 'desc')->where("type", "how_work")->first();
        $agency = Contents::orderby('id', 'desc')->where("type", "agency")->first();
        $fqa = Contents::orderby('id', 'desc')->where("type", "faq")->get();
        $featured = Portfolio::orderby('id', 'desc')->get();
        return view('index', compact('fqa', 'agency', 'slider', 'about', 'blog', 'gallery', 'special', 'fact', 'how_work', 'featured', 'services'));
    }

    public function about(Request $request)
    {
        $about = Contents::orderby('id', 'desc')->where("type", "about")->first();
        $special = Contents::orderby('id', 'desc')->where("type", "special")->first();
        $Testimonials = Testimonials::orderby('id', 'desc')->get();
        $agency = Contents::orderby('id', 'desc')->where("type", "agency")->first();
        $gallery = Gallery::orderby('id', 'desc')->get();
        return view('about', compact('about', 'special', 'Testimonials', 'agency', 'gallery'));
    }

    public function portfolio(Request $request)
    {
        $items = Portfolio::orderby("id", "desc")->paginate(6);
        return view('portfolio', compact('items'));
    }

    public function change_language($lang = 'en')
    {
        Session::put('local', $lang);
        //session()->push('local',$lang);
        return redirect()->back();
    }


    public function currency_change($id)
    {
        $item = Currencies::where("id", $id)->first();
        if ($item == null) {
            return redirect()->back();
        }
        Cookie::queue(cookie('currency', $item->code, $minute = 1440));
        return redirect()->back();
    }

    public function services(Request $request)
    {
        $items = new Products();

        if ($request->category_id != null) {
            $items = $items->where('category_id', 'like', "%" . $request->category_id . "%");
        }
        if ($request->type != null) {
            $items = $items->where('type', $request->type);
        }
        if ($request->bed_rooms != null) {
            $items = $items->where('bed_rooms', $request->bed_rooms);
        }
        if ($request->bath_rooms != null) {
            $items = $items->where('bath_rooms', $request->bath_rooms);
        }
        if ($request->car != null) {
            $items = $items->where('car', $request->car);
        }
        if ($request->sq != null) {
            $items = $items->where('sq', $request->sq);
        }
        if ($request->address != null) {
            $items = $items->where('address', $request->address);
        }
        if ($request->country != null) {
            $items = $items->where('country', $request->country);
        }
        if ($request->city != null) {
            $items = $items->where('city', $request->city);
        }

        $price_min = $request->price_min;
        if ($price_min != null) {
            $f_price_min = explode("-", $price_min)[0];
            $f_price_max = explode("-", $price_min)[1];
            $items = $items->whereBetween('price', [$f_price_min, $f_price_max]);
        }

        $features = $request->features;
        if($features != null){
            if(count($features) != 0){
                foreach ($features as $key => $value){
                    $items = $items->where('features', $value);
                }
            }
        }

        $items = $items->orderby('created_at', 'desc');
        $items = $items->paginate(6);

        $tags = array();
        if (app()->getLocale() == Language::where("select", "1")->first()->dir) {
            $tags1 = Products::get();
            if ($tags1->count() != 0) {
                foreach ($tags1 as $r2) {
                    $r = $r2->features;
                    if (count(explode(",", $r)) != 0) {
                        foreach (explode(",", $r) as $key => $value) {
                            if ($value) {
                                array_push($tags, $value);
                            }
                        }
                    }

                }
            }
        } else {
            $tags1 = ProductsTranslate::get();
            if ($tags1->count() != 0) {
                foreach ($tags1 as $r2) {
                    $r = $r2->features;
                    if (count(explode(",", $r)) != 0) {
                        foreach (explode(",", $r) as $key => $value) {
                            if ($value) {
                                array_push($tags, $value);
                            }
                        }
                    }

                }
            }
        }

        return view('services', compact('items', 'tags'));
    }

    public function product($id = null, $name = null, Request $request)
    {
        $item = Products::where([
            'id' => $id,
            'name' => $name
        ])->first();
        if ($item == null) {
            return redirect()->to('/');
        } else {
            $related = $item->related_products;
            return view('product', compact('item', 'related'));
        }
    }

    public function quick_view_ajax(Request $request)
    {
        $id = $request->id;
        $item = Products::where("id", $id)->first();
        if ($id == null) {
            return redirect()->to('/');
        }
        if ($item == null) {
            return redirect()->to('/');
        } else {
            if ($request->ajax()) {
                return view('data/product.quick', compact('item'));
            }
            $route = $item->route();
            return redirect()->to($route);
        }
    }

    public function blog(Request $request)
    {
        $items = Post::orderby('created_at', 'desc')->where("type", 1);
        if ($request->q != null) {
            $items = $items->where('name', 'like', "%" . $request->q . "%");
        }
        if ($request->tags != null) {
            $items = $items->where('tags', 'like', "%" . $request->tags . "%");
        }
        $items = $items->paginate(6);
        if ($request->ajax()) {
            return view('data/blog', compact('items'));
        }
        $tags = Post::orderby('created_at', 'desc')->select("tags")->get();
        $related = Post::orderby('created_at', 'desc')->take(3)->get();
        $partners = Partners::orderby('id', 'desc')->get();
        $gallery = Gallery::orderby('id', 'desc')->get();
        return view('blog', compact('items', 'tags', 'related', 'partners', 'gallery'));
    }

    public function post($id = null, $name = null)
    {
        $item = Post::where([
            'id' => $id,
            'name' => $name
        ])->first();
        if ($item == null) {
            return redirect()->to('/');
        } else {
            $partners = Partners::orderby('id', 'desc')->get();
            $gallery = Gallery::orderby('id', 'desc')->get();
            return view('post', compact('item', 'partners', 'gallery'));
        }
    }

    public function service($id = null, $name = null)
    {
        $item = Contents::where([
            'id' => $id,
            'name' => $name
        ])->first();
        if ($item == null) {
            return redirect()->to('/');
        } else {
            $faqs = Contents::orderby('id', 'desc')->where("type", "faqs")->get();
            return view('service', compact('item', 'faqs'));
        }
    }

    public function newsletter(Request $request)
    {
        $email = $request->email;
        $validation = Validator::make($request->all(), $this->newsletter_rules($email), $this->lnewsletter_anguags());
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $save = new Newsletter();
            $save->email = $email;
            $save->save();
            return response()->json(['success' => parent::CurrentLangHomeShow()->send_newsletter, 'dashboard' => '0']);
        }
    }

    private function newsletter_rules($edit)
    {
        $x = [
            'email' => 'required|string|email|unique:newsletter,email,' . $edit,
        ];
        return $x;
    }

    private function lnewsletter_anguags()
    {
        if (app()->getLocale() == "ar") {
            return [
                'email.required' => 'حقل الايميل مطلوب.',
                'email.taken' => 'البريد الإلكتروني تم أخذه.',
                'email.email' => 'حقل الايميل غير صحيح .',
            ];
        } else {
            return [];
        }
    }

    public function contact_us()
    {
        $hp_contact_us = HPContactUS::first();
        $Contact_page = Contact_page::first();
        $address = Contents::orderby('id', 'desc')->where("type", "address")->get();
        $partners = Partners::orderby('id', 'desc')->get();
        $gallery = Gallery::orderby('id', 'desc')->get();
        return view('contact_us', compact('hp_contact_us', 'Contact_page', 'partners', 'gallery', 'address'));
    }

    public function verify(Request $request)
    {
        $email = $request->email;
        $code = $request->code;
        if ($email == null || $code == null) {
            return view('verify')->with('warning', 'Already Verify your account');
        } else {
            return view('verify')->with('error', 'No found your account');
        }
    }

    public function contact_post(Request $request)
    {
        $validation = Validator::make($request->all(), $this->contact_post_rules(), $this->contact_post_rules_languags());
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $save = new ContactUS();
            $save->email = $request->email;
            $save->phone = $request->phone;
            $save->f_name = $request->f_name;
            $save->l_name = $request->l_name;
            $save->summary = $request->summary;
            $save->save();
            return response()->json(['success' => parent::CurrentLangHomeShow()->send_contact, 'dashboard' => '0']);
        }
    }

    private function contact_post_rules()
    {
        $x = [
            'email' => 'required|string|email',
            'f_name' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'l_name' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'summary' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'phone' => 'required|numeric',
        ];
        return $x;
    }

    private function contact_post_rules_languags()
    {
        if (app()->getLocale() == "ar") {
            return [
                'call_back.required' => 'حقل تاريخ التواصل مطلوب.',
                'call_back.regex' => 'حقل تاريخ التواصل غير صحيح .',

                'f_name.required' => 'حقل الاسم الاول مطلوب.',
                'f_name.regex' => 'حقل الاسم الاول غير صحيح .',
                'f_name.min' => 'حقل الاسم الاول مطلوب على الاقل 3 حقول .',

                'l_name.required' => 'حقل الاسم الثاني مطلوب.',
                'l_name.regex' => 'حقل الاسم الثاني غير صحيح .',
                'l_name.min' => 'حقل الاسم الثاني مطلوب على الاقل 3 حقول .',

                'summary.required' => 'حقل الوصف مطلوب.',
                'summary.regex' => 'حقل الوصف غير صحيح .',
                'summary.min' => 'حقل الوصف مطلوب على الاقل 3 حقول .',

                'phone.required' => 'حقل الهاتف مطلوب.',
                'phone.numeric' => 'حقل الهاتف غير صحيح .',

                'email.required' => 'حقل البريد الالكتروني مطلوب.',
                'email.regex' => 'حقل البريد الالكتروني غير صحيح .',
                'email.email' => 'حقل البريد الالكتروني مطلوب على الاقل 3 حقول .',

            ];
        } else {
            return [];
        }
    }

    public function request_product(Request $request)
    {
        $item = Products::where('id', '=', $request->products_id)->first();
        if ($item == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $validation = Validator::make($request->all(), $this->reques_rules());
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $save = new ProductRequest();
            $save->email = $request->email;
            $save->phone = $request->phone;
            $save->f_name = $request->f_name;
            $save->l_name = $request->l_name;
            $save->summary = $request->summary;
            $save->products_id = $request->products_id;
            $save->save();

            return response()->json(['success' => parent::CurrentLangHomeShow()->send_request, 'dashboard' => '0']);
        }
    }

    private function reques_rules()
    {
        $x = [
            'email' => 'required|string|email',
            'f_name' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'l_name' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'summary' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'phone' => 'required|numeric',
            'products_id' => 'required|numeric',
        ];
        return $x;
    }

    private function req_languags()
    {
        if (app()->getLocale() == "ar") {
            return [
                'products_id.required' => 'حقل المنتج مطلوب.',
                'products_id.numeric' => 'حقل المنتج غير صحيح .',

                'calendar.required' => 'حقل التاريخ مطلوب.',
                'child.required' => 'حقل الاطفال مطلوب.',
                'child.numeric' => 'حقل الاطفال يجب ان يكون رقم .',
                'adult.required' => 'حقل الكبار مطلوب.',
                'adult.numeric' => 'حقل الكبار يجب ان يكون رقم .',
                'infant.required' => 'حقل الرضع مطلوب.',
                'infant.numeric' => 'حقل الرضع يجب ان يكون رقم .',

                'f_name.required' => 'حقل الاسم الاول مطلوب.',
                'f_name.regex' => 'حقل الاسم الاول غير صحيح .',
                'f_name.min' => 'حقل الاسم الاول مطلوب على الاقل 3 حقول .',

                'l_name.required' => 'حقل الاسم الثاني مطلوب.',
                'l_name.regex' => 'حقل الاسم الثاني غير صحيح .',
                'l_name.min' => 'حقل الاسم الثاني مطلوب على الاقل 3 حقول .',

                'summary.required' => 'حقل الوصف مطلوب.',
                'summary.regex' => 'حقل الوصف غير صحيح .',
                'summary.min' => 'حقل الوصف مطلوب على الاقل 3 حقول .',

                'phone.required' => 'حقل الهاتف مطلوب.',
                'phone.numeric' => 'حقل الهاتف غير صحيح .',

                'email.required' => 'حقل البريد الالكتروني مطلوب.',
                'email.regex' => 'حقل البريد الالكتروني غير صحيح .',
                'email.email' => 'حقل البريد الالكتروني مطلوب على الاقل 3 حقول .',

            ];
        } else {
            return [];
        }
    }

}
