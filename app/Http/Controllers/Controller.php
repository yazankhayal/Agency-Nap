<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Language;
use App\Setting;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function upladImage($request, $dir = 'user',$ids = null){
        $img = $request;
        $imageName = $ids.time().'.'.$img->getClientOriginalExtension();
        $direction = public_path('/upload/'.$dir.'/');
        $img->move($direction,$imageName);
        return $saveImge = 'upload/'.$dir.'/'.$imageName;
    }

    public function GetIdLangEn(){
        $select_lan = Language::where('select','=','1')->first();
        if($select_lan != null){
            return $select_lan;
        }
        else {
            return Language::where('select', '=', '1')->first();
        }
    }

    public function GetIdLangCurrent(){
        $select_lan = Language::where('select','=',1)->first();
        if($select_lan != null){
            return $select_lan;
        }
        else{
            return Language::where('select','=',1)->first();
        }
    }

    public function IP_Address(){
        return \Request::ip();
    }

    public function create_slug($x){
        return str_replace(' ', '-', $x);
    }

    public function create_slug_($x){
        return str_replace(' ', '_', $x);
    }

    public function create_keywords($x){
        return $x;
    }

    public function url_link (){
        return Setting::first()->public;
    }

    public function url_base_path (){
        return '/public/upload/';
    }

    public function RanomGmail($n){
        $domain ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $len = strlen($domain);
        $generated_string = "";
        for ($i = 0; $i < $n; $i++){
            $index = rand(0, $len - 1);
            $generated_string = $generated_string . $domain[$index];
        }
        return $generated_string;
    }

    public function RandomOrderId($n){
        $domain2 ="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz@#$&*";
        $domain ="0123456789";
        $len = strlen($domain);
        $generated_string = "";
        for ($i = 0; $i < $n; $i++){
            $index = rand(0, $len - 1);
            $generated_string = $generated_string . $domain[$index];
        }
        return $generated_string;
    }

    public function PublicPa(){
        return Setting::first()->public;
    }

    public function CurrentID(){
        return Auth::user()->id;
    }

    public function select_lang(){
        return  $select_lan_choice = Language::where('select', '=', '1')->first();
    }

    public function select_lan(){
        $select_lan = Language::where('dir', '=', app()->getLocale())->first();
        if ($select_lan == null) {
            $select_lan = Language::where('select', '=', '1')->first();
        }
        return $select_lan;
    }

    public function changeEnv($data = array()){
        if(count($data) > 0){

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach((array)$data as $key => $value){

                // Loop through .env-data
                foreach($env as $env_key => $env_value){

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if($entry[0] == $key){
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);

            return true;
        } else {
            return false;
        }
    }

    public function CurrentLangShow(){
        $select_lan = Language::where('dir', '=', app()->getLocale())->first();
        $data_results = file_get_contents(public_path() . '/languages/' . $select_lan->dir . '_dashboard.json');
        $lang = json_decode($data_results);
        return $lang;
    }

    public function CurrentLangHomeShow(){
        $select_lan = Language::where('dir', '=', app()->getLocale())->first();
        $data_results = file_get_contents(public_path() . '/languages/' . $select_lan->dir . '.json');
        $lang = json_decode($data_results);
        return $lang;
    }


    public function send_Email_template($name_templage,$to_name,$to_email,$text){

        $from_email = env('MAIL_USERNAME');

        $data = array('text' => $text);

        Mail::send(['html' => 'emails.text'], $data, function ($message) use ($to_name, $to_email, $from_email,$name_templage) {
            $message->to($to_email, $to_name)
                ->subject($name_templage);
            $message->from($from_email,$name_templage);
        });
    }

    public function login_mail($to_name,$to_email){

        $from_email = env('MAIL_USERNAME');

        $logo = setting()->avatar();
        $to_name_2 = lang_name('Welcome').' : ' . $to_name;

        $msg = lang_name('Login_Successfully').' : IP : '. $this->IP_Address();
        $data = array('name' => $to_name_2,'logo' => $logo,'msg' => $msg,'link'=>$this->IP_Address());

        Mail::send(['html' => 'emails.login'], $data, function ($message) use ($to_name, $to_email, $from_email) {
            $message->to($to_email, $to_name)
                ->subject(lang_name('Login_Successfully'));
            $message->from($from_email,lang_name('Login_Successfully'));
        });
    }

    public function order_mail($to_name,$to_email,$cart){

        $from_email = env('MAIL_USERNAME');

        $logo = setting()->avatar();
        $to_name_2 = lang_name('Welcome').' : ' . $to_name;

        $ids = "";
        if ($cart->count() != 0) {
            foreach ($cart as $car) {
                $change = Cart::where("id", $car->id)->first();
                if ($change != null) {
                    $c = $change->Products->name();
                    $li2 = $change->Products->route();
                    $id = "<li><a href='$li2'>$c</a></li>";
                    $ids = $id . $ids;
                }
            }
        }

        $msg = lang_name('msg_order').' : '. $ids;

        $data = array('name' => $to_name_2,'logo' => $logo,'msg' => $msg);

        Mail::send(['html' => 'emails.order'], $data, function ($message) use ($to_name, $to_email, $from_email) {
            $message->to($to_email, $to_name)
                ->subject(lang_name('Active_account'));
            $message->from($from_email,lang_name('Active_account'));
        });
    }

    public function active_account_mail($to_name,$to_email){

        $from_email = env('MAIL_USERNAME');

        $logo = setting()->avatar();
        $to_name_2 = lang_name('Welcome').' : ' . $to_name;

        $msg = lang_name('Active_account').' : IP : '. $this->IP_Address();

        $user = User::where("email",$to_email)->first();
        if($user){
            $user->active_code = $this->RandomOrderId(10);
            $user->update();
        }

        $link = route('active_account',['email'=>$user->email,'code'=>$user->active_code]);

        $data = array('name' => $to_name_2,'logo' => $logo,'msg' => $msg,'link'=>$link);

        Mail::send(['html' => 'emails.active'], $data, function ($message) use ($to_name, $to_email, $from_email) {
            $message->to($to_email, $to_name)
                ->subject(lang_name('Active_account'));
            $message->from($from_email,lang_name('Active_account'));
        });
    }

    public function register_mail($to_name,$to_email){

        $from_email = env('MAIL_USERNAME');

        $logo = setting()->avatar();
        $to_name_2 = lang_name('Welcome').' : ' . $to_name;

        $msg = lang_name('New_Account').' : IP : '. $this->IP_Address();
        $data = array('name' => $to_name_2,'logo' => $logo,'msg' => $msg,'link'=>$this->IP_Address());

        Mail::send(['html' => 'emails.register'], $data, function ($message) use ($to_name, $to_email, $from_email) {
            $message->to($to_email, $to_name)
                ->subject(lang_name('Register_Successfully'));
            $message->from($from_email,lang_name('Register_Successfully'));
        });
    }

    public function copoun_mail($to_name,$to_email,$copoun){

        $from_email = env('MAIL_USERNAME');

        $logo = setting()->avatar();
        $to_name_2 = lang_name('Welcome').' : ' . $to_name;

        $msg = lang_name('Copoun').' : '. $copoun;

        $data = array('name' => $to_name_2,'logo' => $logo,'msg' => $msg,'link'=>$copoun);

        Mail::send(['html' => 'emails.copoun'], $data, function ($message) use ($to_name, $to_email, $from_email) {
            $message->to($to_email, $to_name)
                ->subject(lang_name('Copoun'));
            $message->from($from_email,lang_name('Copoun'));
        });
    }

    public function register_mail_admin($to_name,$to_email){

        $from_email = env('MAIL_USERNAME');

        $logo = setting()->avatar();
        $to_name_2 = lang_name('Welcome').' : ' . $to_name;

        $msg = lang_name('New_Account').' : IP : '. $this->IP_Address();
        $data = array('name' => $to_name_2,'logo' => $logo,'msg' => $msg,'link'=>$this->IP_Address());

        Mail::send(['html' => 'emails.register'], $data, function ($message) use ($from_email) {
            $message->to($from_email, $from_email)
                ->subject(lang_name('Register_Successfully'));
            $message->from($from_email,lang_name('Register_Successfully'));
        });
    }

    public function get_day($x){
        return explode("-",$x)[2];
    }

    public function get_month($x){
        return explode("-",$x)[1];
    }

    public function get_year($x){
        return explode("-",$x)[0];
    }

}
