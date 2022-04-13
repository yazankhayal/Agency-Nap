<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Contents;

class AboutListController extends Controller
{
    public function index()
    {
        return view('dashboard/about_list.index');
    }

    public function add_edit()
    {
        return view('dashboard/about_list.add_edit');
    }

    function get_data(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'avatar',
            3 => 'language',
            4 => 'id',
        );

        $totalData = Contents::where("type", 'features_area')->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $about_list = Contents::
        Where('name', 'LIKE', "%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->where("type", 'features_area')
            ->orderBy($order, $dir)
            ->get();

        if ($search != null) {
            $totalFiltered = Contents::
            Where('name', 'LIKE', "%{$search}%")
                ->where("type", 'features_area')
                ->count();
        }


        $data = array();
        if (!empty($about_list)) {
            foreach ($about_list as $post) {
                $edit = route('dashboard_about_list.add_edit', ['id' => $post->id]);
                $langage = $post->Language->name;
                $ava_lan = url(parent::PublicPa() . $post->Language->avatar);
                $ava = url(parent::PublicPa() . $post->avatar1);

                $edit_title = parent::CurrentLangShow()->Edit;
                $delete_title = parent::CurrentLangShow()->Delete;
                $add_title = parent::CurrentLangShow()->Add_new_language;

                $has_lanageus = $post->ContentsLists;
                $langages_reslut = '';
                if ($has_lanageus->count() != 0) {
                    foreach ($has_lanageus as $item2) {
                        $t = url(parent::PublicPa() . $item2->Language->avatar);
                        $langages_reslut = $langages_reslut . "<img class='btn_edit_lan' data-id='{$item2->id}' style='margin: 0 5px;width: 40px;height: 25px;' src='{$t}' />";
                    }
                }

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['avatar'] = "<img style='width: 50px;height: 50px;' src='{$ava}' class='img-circle img_data_tables'>";
                $nestedData['language'] = "<img style='width: 40px;height: 25px;' src='{$ava_lan}' />" . $langages_reslut;
                $nestedData['options'] = "&emsp;<a class='btn btn-success btn-sm' href='{$edit}' title='$edit_title' ><span class='color_wi fa fa-edit'></span></a>
                                          &emsp;<a class='btn_delete_current btn btn-danger btn-sm' data-id='{$post->id}' title='$delete_title' ><span class='color_wi fa fa-trash'></span></a>";
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    function get_data_by_id(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $Post = Contents::where('id', '=', $id)->first();
        if ($Post == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        return response()->json(['success' => $Post]);
    }

    function deleted(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $Post = Contents::where('id', '=', $id)->first();
        if ($Post == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $Post->delete();
        return response()->json(['error' => __('language.msg.d')]);
    }

    public function post_data(Request $request)
    {
        $edit = $request->id;
        $validation = Validator::make($request->all(), $this->rules($edit), $this->languags());
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            if ($edit != null) {
                $Post = Contents::where('id', '=', Input::get('id'))->first();
                $Post->name = Input::get('name');
                $Post->sub_name = Input::get('sub_name');
                $Post->link = Input::get('link');
                if (Input::hasFile('avatar1')) {
                    //Remove Old
                    if ($Post->avatar1 != 'features_area/no.png') {
                        if (file_exists(public_path($Post->avatar1))) {
                            unlink(public_path($Post->avatar1));
                        }
                    }
                    //Save avatar
                    $Post->avatar1 = parent::upladImage(Input::file('avatar1'), 'features_area');
                }
                $Post->update();
                return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_about_list.index')]);
            } else {
                $Post = new Contents();
                $Post->name = Input::get('name');
                $Post->sub_name = Input::get('sub_name');
                $Post->type = 'features_area';
                $Post->avatar1 = parent::upladImage(Input::file('avatar1'), 'features_area');
                $Post->language_id = parent::GetIdLangEn()->id;
                $Post->user_id = parent::CurrentID();
                $Post->save();
                return response()->json(['success' => __('language.msg.s'), 'dashboard' => '1', 'redirect' => route('dashboard_about_list.index')]);
            }
        }
    }

    private function rules($edit = null)
    {
        $x = [
            'name' => 'required|min:3|max:191|regex:/^[ا-يa-zA-Z0-9]/',
            'sub_name' => 'required|min:3|max:191|regex:/^[ا-يa-zA-Z0-9]/',
            'avatar1' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
        ];
        if ($edit != null) {
            $x['id'] = 'required|integer|min:1';
            $x['avatar1'] = 'nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
        }
        return $x;
    }

    private function languags()
    {
        if (app()->getLocale() == "ar") {
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
                'type_post.required' => 'حقل نوع المقالة مطلوب.',
                'type_post.numeric' => 'حقل نوع المقالة غير صحيح .',
                'type_post.in' => 'حقل نوع المقالة غير صحيح .',

                'avatar1.required' => 'حقل الصورة مطلوب.',
                'summary.required' => 'حقل الوصف مطلوب.',
                'dir.required' => 'حقل كود الغة مطلوب.',

            ];
        } else {
            return [];
        }
    }


}
