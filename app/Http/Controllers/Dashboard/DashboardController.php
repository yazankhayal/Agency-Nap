<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\ContactUS;
use App\Copuon;
use App\Language;
use App\Newsletter;
use App\Post;
use App\Products;
use App\User;
use App\UserCopoun;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Currencies;
use App\CurrencyConversions;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $c_1 = Products::count();
        $c_2 = Category::count();
        $c_3 = User::where("role", 3)->count();
        $c_4 = Post::where("type", 1)->count();
        $currens = Currencies::get();
        return view('dashboard.index', compact('currens', 'c_1', 'c_2', 'c_3', 'c_4'));
    }

    public function currency()
    {
        $currens = Currencies::get();
        return view('dashboard.currency', compact('currens'));
    }

    public function send_email()
    {
        return view('dashboard.send_email');
    }

    public function send_email_send(Request $request)
    {
        $email_cout = count(explode(",",$request->email));
        $validation = Validator::make($request->all(), $this->rules($email_cout));
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {

            
            if ($request->newsletter == "on") {
                if(Newsletter::count() != 0){
                    foreach(Newsletter::get() as $item){
                        
                        parent::send_Email_template($request->name_temp,$item->email,$item->email,$request->summary);
                    }
                }
            }

            if ($request->contact_us == "on") {
                if(ContactUS::count() != 0){
                    foreach(ContactUS::get() as $item){
                       
                        parent::send_Email_template($request->name_temp,$item->f_name,$item->email,$request->summary);
                    }
                }
            }

if(count(explode(",",$request->email)) != 0){
                foreach (explode(",",$request->email) as $item){
                    
                    parent::send_Email_template($request->name_temp, $item, $item, $request->summary);
                }
            }

            return response()->json(['success' => parent::CurrentLangShow()->Send_Email, 'dashboard' => '1']);
        }
    }


    private function rules($edit = null)
    {
        $x = [
            'name' => 'required|string|min:1',
            'name_temp' => 'required|string|min:1',
            'email' => 'required|email|string|min:1',
            'summary' => 'required|string|min:1',
        ];
        if ($edit >= 2) {
            $x['email'] = 'required|string|min:1';
            $x['name'] = 'nullable|string|min:1';
        }
        return $x;
    }

    public function currency_conversions(Request $request)
    {
        $currecy = $request->currency_id;
        $price = $request->price;
        $sum = array_combine($currecy, $price);
        foreach ($sum as $key => $value) {
            if (empty($value)) {
                return response()->json(['error' => 'Please fill the price']);
            } else {
                $edit = CurrencyConversions::where('currencies_id', $key)->first();
                if ($edit == null) {
                    $save = new CurrencyConversions();
                    $save->price = $value;
                    $save->currencies_id = $key;
                    $save->save();
                } else {
                    $edit->price = $value;
                    $edit->save();
                }
            }
        }
        if (empty($sum)) {
            return response()->json(['error' => 'Please fill the price']);
        }
        $role = route('dashboard_admin.currency');
        return response()->json(['success' => __('language.msg.s'), 'dashboard' => '1', 'redirect' => $role]);
    }

    public function languages()
    {
        return response()->json(['data' => Language::get()]);
    }

    public function languages_exption_em()
    {
        return response()->json(['data' => Language::where('select', '!=', '1')->get()]);
    }

    public function newsletter()
    {
        return response()->json([Newsletter::get()]);
    }

}
