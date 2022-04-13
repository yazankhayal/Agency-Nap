<?php

namespace App\Http\Controllers\Dashboard;

use App\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller
{
    public function index(){
        return view('dashboard/payment_method.index');
    }

    public function get_data_by_id(Request $request){
        $items = PaymentMethod::first();
        return response()->json(['success'=>$items]);
    }

    public function post_data(Request $request){
        $PaymentMethod = PaymentMethod::first();
        $enable_debit_card_enable = $request->debit_card_enable;
        $paypal_enable = $request->paypal_enable;
        $hand_over_enable = $request->hand_over_enable;
        $validation = Validator::make($request->all(), $this->rules($PaymentMethod,$enable_debit_card_enable,
        $paypal_enable));
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            if($PaymentMethod == null){
                $PaymentMethod = new PaymentMethod();

                
                if($enable_debit_card_enable == "on"){
                    $PaymentMethod->debit_card_enable = true;
                    $PaymentMethod->app_key_id_debit_card = $request->app_key_id_debit_card;
                    $PaymentMethod->app_secret_debit_card = $request->app_secret_debit_card;
                    $PaymentMethod->debit_card_live = $request->debit_card_live;
                }
                else{
                    $PaymentMethod->debit_card_enable = false;
                }
                
                if($paypal_enable == "on"){
                    $PaymentMethod->paypal_enable = true;
                    $PaymentMethod->app_key_id_paypal = $request->app_key_id_paypal;
                    $PaymentMethod->app_secret_paypal = $request->app_secret_paypal;
                    $PaymentMethod->paypal_live = $request->paypal_live;
                    $env_update = [
                        'PAYPAL_SANDBOX_CLIENT_ID'   => Input::get('dir'),
                        'PAYPAL_SANDBOX_SECRET'   => Input::get('dir'),
                        'PAYPAL_MODE'   =>  $request->paypal_live,
                    ];
                    parent::changeEnv($env_update);
                }
                else{
                    $PaymentMethod->paypal_enable = false;
                }

                if($hand_over_enable == "on"){
                    $PaymentMethod->hand_over_enable = true;
                }
                else{
                    $PaymentMethod->hand_over_enable = false;
                }

                $PaymentMethod->user_id = parent::CurrentID();
                $PaymentMethod->save();
                return response()->json(['success'=> __('language.msg.s'),'same_page'=>'1','dashboard'=>'1']);
            }
            else{
                $PaymentMethod = PaymentMethod::first();
                
                if($enable_debit_card_enable == "on"){
                    $PaymentMethod->debit_card_enable = true;
                    $PaymentMethod->app_key_id_debit_card = $request->app_key_id_debit_card;
                    $PaymentMethod->app_secret_debit_card = $request->app_secret_debit_card;
                    $PaymentMethod->debit_card_live = $request->debit_card_live;
                }
                else{
                    $PaymentMethod->debit_card_enable = false;
                }
                
                if($paypal_enable == "on"){
                    $PaymentMethod->paypal_enable = true;
                    $PaymentMethod->app_key_id_paypal = $request->app_key_id_paypal;
                    $PaymentMethod->app_secret_paypal = $request->app_secret_paypal;
                    $PaymentMethod->paypal_live = $request->paypal_live;
                    $env_update = [
                        'PAYPAL_SANDBOX_CLIENT_ID'   => Input::get('dir'),
                        'PAYPAL_SANDBOX_SECRET'   => Input::get('dir'),
                        'PAYPAL_MODE'   =>  $request->paypal_live,
                    ];
                    parent::changeEnv($env_update);
                }
                else{
                    $PaymentMethod->paypal_enable = false;
                }

                if($hand_over_enable == "on"){
                    $PaymentMethod->hand_over_enable = true;
                }
                else{
                    $PaymentMethod->hand_over_enable = false;
                }
                $PaymentMethod->update();
                return response()->json(['success'=>__('language.msg.m'),'same_page'=>'1','dashboard'=>'1']);
            }
        }
    }

    private function rules($edit = null,$enable_debit_card_enable = null
    ,$paypal_enable = null){
        $x= [
            
        ];
        if($edit != null){
            $x['id'] ='required|integer|min:1';
        }

        if($enable_debit_card_enable == "on"){
            $x['app_key_id_debit_card'] ='required|string|min:1|max:191';
            $x['app_secret_debit_card'] ='required|string|min:1|max:191';
            $x['debit_card_live'] ='required|string|min:1|max:191';
        }

        if($paypal_enable == "on"){
            $x['app_key_id_paypal'] ='required|string|min:1|max:191';
            $x['app_secret_paypal'] ='required|string|min:1|max:191';
            $x['paypal_live'] ='required|string|min:1|max:191';
        }

        return $x;
    }
}
