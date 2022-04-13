<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Currencies;
use Session;
use Cookie;

class CurrencyController extends Controller
{
    public function index(){
        return view('dashboard/currency.index');
    }

    public function add_edit(){
        return view('dashboard/currency.add_edit');
    }

    function get_data(Request $request)
    {
        $columns = array(
            0 =>'id',
            1 =>'name',
            2 =>'code',
            4 =>'id',
        );

        $totalData = Currencies::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $posts =  Currencies::
        Where('name', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->orderBy('id','desc')
            ->get();

        if($search != null){
            $totalFiltered = Currencies::
            Where('name', 'LIKE',"%{$search}%")
                ->count();
        }


        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $ava = url(parent::PublicPa().$post->avatar);
                $edit = route('dashboard_currency.add_edit',['id' => $post->id]);

                $sele_r = parent::CurrentLangShow()->secondary;

                if($post->select == 1){
                    $sele_r = parent::CurrentLangShow()->Primary;
                }

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['code'] = $post->code;
                $nestedData['dir'] = $post->dir;
                $nestedData['select'] = '<div class="badge-primary badge">'. $sele_r .'</div>';
                $nestedData['options'] = "&emsp;<a class='btn btn-success btn-sm' href='{$edit}' title='تعديل' ><span class='color_wi fa fa-edit'></span></a>
                                          &emsp;<a class='btn_delete_current btn btn-danger btn-sm' data-id='{$post->id}' title='حذف' ><span class='color_wi fa fa-trash'></span></a>";
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($json_data);
    }

    function get_data_by_id(Request $request){
        $id = $request->id;
        if($id == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        $Currencies = Currencies::where('id' ,'=',$id)->first();
        if($Currencies == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        return response()->json(['success'=>$Currencies]);
    }

    function deleted(Request $request){
        $id = $request->id;
        if($id == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        $Currencies = Currencies::where('id' ,'=',$id)->first();
        if($Currencies == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        if($Currencies->code == 'usd'){
            return response()->json(['error'=> __('language.msg.dont')]);
        }
        $Currencies->delete();
        return response()->json(['success'=> __('language.msg.d')]);
    }

    public function post_data(Request $request){
        $edit = $request->id;
        $password = $request->password;
        $validation = Validator::make($request->all(), $this->rules($edit),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            if($edit != null){
                DB::transaction(function()
                {
                    $Currencies = Currencies::where('id' ,'=',Input::get('id'))->first();
                    $Currencies->name = Input::get('name');
                    $Currencies->code = Input::get('code');
                    if (Input::get('select') == "on") {
                        $Currencies->select = true;
                        Cookie::queue(cookie('currency', Input::get('code'), $minute = 1440));
                        $get_other = Currencies::where('select', '=', '1')->first();
                        $get_other->select = 0;
                        $get_other->update();
                        $env_update = [
                            'currency'=>Input::get('code'),
                        ];
                        parent::changeEnv($env_update);
                    } else {
                        $Currencies->select = false;
                    }
                    $Currencies->update();
                    if( !$Currencies )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=>__('language.msg.m'),'dashboard'=>'1','redirect' =>route('dashboard_currency.index')]);
            }
            else{
                DB::transaction(function()
                {
                    $Currencies = new Currencies();
                    $Currencies->name = Input::get('name');
                    $Currencies->code = Input::get('code');
                    if (Input::get('select') == "on") {
                        Cookie::queue(cookie('currency', Input::get('code'), $minute = 1440));
                        $Currencies->select = true;
                        $get_other = Currencies::where('select', '=', '1')->first();
                        $get_other->select = 0;
                        $get_other->update();
                        $env_update = [
                            'currency'   =>Input::get('code'),
                        ];
                        parent::changeEnv($env_update);
                    } else {
                        $Currencies->select = false;
                    }
                    $Currencies->save();
                    if( !$Currencies )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=> __('language.msg.s'),'dashboard'=>'1','redirect' =>route('dashboard_currency.index')]);
            }
        }
    }

    private function rules($edit = null,$pass = null){
        $x= [
            'name' => 'required|string',
            'code' => 'required|string',
        ];
        if($edit != null){
            $x['id'] ='required|integer|min:1';
        }
        return $x;
    }

    private function languags(){
        if(app()->getLocale() == "ar"){
            return [
                'name.required' => 'حقل الاسم مطلوب.',
                'code.required' => 'حقل الكود مطلوب.',
                'name.regex' => 'حقل الاسم غير صحيح .',
                'name.min' => 'حقل الاسم مطلوب على الاقل 3 حقول .',

            ];
        }
        else{
            return [];
        }
    }


}
