<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\City;

class CityController extends Controller
{
    public function index(){
        return view('dashboard/city.index');
    }

    public function add_edit(){
        return view('dashboard/city.add_edit');
    }

    function get_data(Request $request)
    {
        $columns = array(
            0 =>'id',
            1 =>'name',
            2 =>'language',
            3 =>'id',
        );

        $totalData = City::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $City =  City::
        Where('name', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy('id','desc')
            ->orderBy($order,$dir)
            ->get();

        if($search != null){
            $totalFiltered = City::
            Where('name', 'LIKE',"%{$search}%")
                ->count();
        }


        $data = array();
        if(!empty($City))
        {
            foreach ($City as $City)
            {
                $edit = route('dashboard_city.add_edit',['id' => $City->id]);
                $langage = $City->Language->name;
                $ava_lan = url(parent::PublicPa().$City->Language->avatar);

                $edit_title = parent::CurrentLangShow()->Edit;
                $delete_title = parent::CurrentLangShow()->Delete;
                $add_title = parent::CurrentLangShow()->Add_new_language;
                $has_lanageus = $City->City;
                $langages_reslut = '';
                if($has_lanageus->count() != 0){
                    foreach ($has_lanageus as $item2){
                        $t  = url(parent::PublicPa().$item2->Language->avatar);
                        $langages_reslut = $langages_reslut . "<img class='btn_edit_lan' data-id='{$item2->id}' style='margin: 0 5px;width: 40px;height: 25px;' src='{$t}' />";
                    }
                }

                $nestedData['id'] = $City->id;
                $nestedData['name'] = $City->name;
                $nestedData['language'] = "<img style='width: 40px;height: 25px;' src='{$ava_lan}' />" . $langages_reslut . "<a style='margin-left: 5px;' class='btn_add_lan btn btn-danger btn-sm' data-id='{$City->id}' title='$add_title' ><i class='color_wi fa fa-plus'></i></a>";
                $nestedData['options'] = "&emsp;<a class='btn btn-success btn-sm' href='{$edit}' title='$edit_title' ><span class='color_wi fa fa-edit'></span></a>
                                          <a class='btn_delete_current btn btn-danger btn-sm' data-id='{$City->id}' title='$delete_title' ><span class='color_wi fa fa-trash'></span></a>";
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
        $City = City::where('id' ,'=',$id)->first();
        if($City == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        return response()->json(['success'=>$City]);
    }

    function deleted(Request $request){
        $id = $request->id;
        if($id == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        $City = City::where('id' ,'=',$id)->first();
        if($City == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        $City->delete();
        return response()->json(['error' => __('language.msg.d')]);
    }

    public function post_data(Request $request){
        $edit = $request->id;
        $type = $request->type;
        $validation = Validator::make($request->all(), $this->rules($edit),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            if($edit != null){
                DB::transaction(function()
                {
                    $City = City::where('id' ,'=',Input::get('id'))->first();
                    $City->name = Input::get('name');
                    $City->update();
                    if( !$City )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=>__('language.msg.m'),'dashboard'=>'1','redirect' =>route('dashboard_city.index')]);
            }
            else{
                DB::transaction(function()
                {
                    $City = new City();
                    $City->name = Input::get('name');
                    $City->language_id = parent::GetIdLangEn()->id;
                    $City->user_id = parent::CurrentID();
                    $City->save();
                    if( !$City )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=> __('language.msg.s'),'dashboard'=>'1','redirect' =>route('dashboard_city.index')]);
            }
        }
    }

    private function rules($edit = null){
        $x= [
            'name' => 'required|min:3|max:191',
        ];
        if($edit != null){
            $x['id'] ='required|integer|min:1';
        }
        return $x;
    }

    private function languags(){
        if(app()->getLocale() == "ar"){
            return [
                'video.required' => 'حقل الفيديو مطلوب.',
                'video.regex' => 'حقل الفيديو غير صحيح .',
                'video.min' => 'حقل الفيديو مطلوب على الاقل 3 حقول .',
                'video.max' => 'حقل الفيديو مطلوب على الاكثر 191 حرف  .',
                'name.required' => 'حقل الاسم مطلوب.',
                'name.regex' => 'حقل الاسم غير صحيح .',
                'name.min' => 'حقل الاسم مطلوب على الاقل 3 حقول .',
                'name.max' => 'حقل الاسم مطلوب على الاكثر 191 حرف  .',
                'type.required' => 'حقل نوع التنصيف مطلوب.',
                'type.numeric' => 'حقل نوع التنصيف غير صحيح .',
                'type.in' => 'حقل نوع التنصيف غير صحيح .',
                'avatar.required' => 'حقل الصورة مطلوب.',
                'summary.required' => 'حقل الوصف مطلوب.',
                'dir.required' => 'حقل كود الغة مطلوب.',
                'keywords' => 'The keywords field is required.',
                'description ' => 'The description  field is required.',

            ];
        }
        else{
            return [];
        }
    }

}
