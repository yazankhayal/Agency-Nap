<?php

namespace App\Http\Controllers\Dashboard;

use App\Cart;
use App\ProductRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class RequestProductsController extends Controller
{
    public function index(){
        return view('dashboard/request_products.index');
    }

    function get_data(Request $request)
    {
        $columns = array(
            0 =>'id',
            1 =>'name',
            2 =>'address',
            3 =>'phone',
            4 =>'id',
        );

        $totalData = ProductRequest::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $posts =  ProductRequest::
        Where('f_name', 'LIKE',"%{$search}%")
            ->orWhere('l_name', 'like',"%{$search}%")
            ->orWhere('address', 'like',"%{$search}%")
            ->orWhere('phone', 'like',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy('id','desc')
            ->orderBy($order,$dir)
            ->get();

        if($search != null){
            $totalFiltered = ProductRequest::
            Where('f_name', 'LIKE',"%{$search}%")
                ->orWhere('l_name', 'like',"%{$search}%")
                ->orWhere('address', 'like',"%{$search}%")
                ->orWhere('phone', 'like',"%{$search}%")
                ->count();
        }


        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $s = "<a class='btn btn-warning btn_edit_current btn-sm' data-id='{$post->id}' title='edit' ><span class='color_wi fa fa-edit'></span></a>";

                $ty = $post->send;
                $st_1 = '<span class="badge badge-primary">'.parent::CurrentLangShow()->New.'</span>';
                if($ty == 2){
                    $st_1 = '<span class="badge badge-warning">'.parent::CurrentLangShow()->Processing.'</span>';
                }
                else if($ty == 3){
                    $st_1 = '<span class="badge badge-primary">'.parent::CurrentLangShow()->Completed.'</span>';
                }
                else if($ty == 4){
                    $st_1 = '<span class="badge badge-dark">'.parent::CurrentLangShow()->On_Hold.'</span>';
                }
                else if($ty == 5){
                    $st_1 = '<span class="badge badge-primary">'.parent::CurrentLangShow()->Pending.'</span>';
                }
                else if($ty == 6){
                    $st_1 = '<span class="badge badge-danger">'.parent::CurrentLangShow()->Canceled.'</span>';
                }
                else if($ty == 7){
                    $st_1 = '<span class="badge badge-info">'.parent::CurrentLangShow()->Completed.'</span>';
                }

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->f_name .' '. $post->l_name;
                $nestedData['type'] = $st_1;
                $nestedData['address'] = $post->address;
                $nestedData['phone'] = $post->phone;
                $nestedData['options'] = "<a class='btn btn-success btn_eye btn-sm' data-id='{$post->id}' title='عرض' ><span class='color_wi fa fa-eye'></span></a>
                    $s
                    <a class='btn_delete_current btn btn-danger btn-sm' data-id='{$post->id}' title='حذف' ><span class='color_wi fa fa-trash'></span></a>";
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

    function details(Request $request){
        $id = $request->id;
        if($id == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        $ProductRequest = ProductRequest::with('Lists')->where('id' ,'=',$id)->first();
        if($ProductRequest == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        return response()->json(['success'=>$ProductRequest]);
    }

    function deleted(Request $request){
        $id = $request->id;
        if($id == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        $ProductRequest = ProductRequest::where('id' ,'=',$id)->first();
        if($ProductRequest == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        $list = Cart::where("user",$id)->get();
        if($list->count() != 0){
            foreach ($list as $l){
                $remove = Cart::where('id' ,'=',$l->id)->first();
                if($remove == null){
                    return response()->json(['error'=> __('language.msg.e')]);
                }
                $remove->delete();
            }
        }
        $ProductRequest->delete();
        return response()->json(['error' => __('language.msg.d')]);
    }

    function read(Request $request){
        $id = $request->id;
        if($id == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        $ProductRequest = ProductRequest::where('id' ,'=',$id)->first();
        if($ProductRequest == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        $ProductRequest->read = 1;
        $ProductRequest->update();
        return response()->json(['success'=> __('language.msg.m')]);
    }


    public function edit(Request $request){
        $edit = $request->id;
        $typ = $request->type;
        $validation = Validator::make($request->all(), $this->rules2($typ));
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            $Post = ProductRequest::where('id' ,'=',Input::get('id'))->first();
            $Post->send = Input::get('type');
            $Post->update();
            return response()->json(['success'=>__('language.msg.m'),'dashboard'=>'1','close'=>'1']);
        }
    }

    private function rules2($type = null){
        $x= [
            'type' => 'required|string',
            'id' => 'required|integer|min:1',
        ];
        return $x;
    }


}
