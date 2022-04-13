<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\City;
use App\bath_roomss;
use App\Products;
use App\ProductsReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sizes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProductsController extends Controller
{
    public function index()
    {
        return view('dashboard/products.index');
    }

    public function add_edit($id = null)
    {
        $category_id1 = Category::get();
        return view('dashboard/products.add_edit', compact('category_id1'));
    }

    function get_data(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'language',
            3 => 'avatar',
            4 => 'id',
        );

        $totalData = Products::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $products = Products::
        Where('name', 'LIKE', "%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->orderBy($order, $dir)
            ->get();

        if ($search != null) {
            $totalFiltered = Products::
            Where('name', 'LIKE', "%{$search}%")
                ->count();
        }


        $data = array();
        if (!empty($products)) {
            foreach ($products as $post) {
                $ava = url(parent::PublicPa() . $post->avatar);
                $edit = route('dashboard_products.add_edit', ['id' => $post->id]);
                $maker = route('dashboard_products.gallery', ['id' => $post->id]);

                $langage = $post->Language->name;
                $ava_lan = url(parent::PublicPa() . $post->Language->avatar);

                $ba_sc2 = __("language.products_gallery");

                $gallery = "<a class='btn btn-dark btn-sm' href='{$maker}' title='$ba_sc2' ><span class='bath_rooms_wi fa fa-picture-o'></span></a>";
                $rating = "<a class='btn btn-primary btn_rating btn-sm' data-id='{$post->id}' title='Rating' ><span class='bath_rooms_wi fa fa-star'></span></a>";
                $copy = "<a class='btn btn-warning btn_copy btn-sm' data-id='{$post->id}' title='Copy' ><span class='bath_rooms_wi fa fa-copy'></span></a>";

                $edit_title = parent::CurrentLangShow()->Edit;
                $delete_title = parent::CurrentLangShow()->Delete;
                $add_title = parent::CurrentLangShow()->Add_new_language;
                $has_lanageus = $post->Products;
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
                $nestedData['options'] = "&emsp;<a class='btn btn-success btn-sm' href='{$edit}' title='$edit_title' ><span class='bath_rooms_wi fa fa-edit'></span></a>
                                            $copy  <a class='btn_delete_current btn btn-danger btn-sm' data-id='{$post->id}' title='$delete_title' ><span class='bath_rooms_wi fa fa-trash'></span></a>";
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
        $Post = Products::where('id', '=', $id)->first();
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
        $Post = Products::where('id', '=', $id)->first();
        if ($Post == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $Post->delete();
        return response()->json(['error' => __('language.msg.d')]);
    }

    function copy(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $Post = Products::where('id', '=', $id)->first();
        if ($Post == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $newTask = $Post->replicate();
        $newTask->save();
        return response()->json(['success' => __('language.msg.m')]);
    }

    public function post_data(Request $request)
    {
        $edit = $request->id;
        $icon = $request->icon;
        $validation = Validator::make($request->all(), $this->rules($edit), $this->languags());
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            if ($edit != null) {
                $Post = Products::where('id', '=', Input::get('id'))->first();
                
                $Post->name = Input::get('name');
                $Post->sub_name = Input::get('sub_name');
                $Post->summary = Input::get('summary');
                
                $Post->category_id = Input::get('category_id');
                
                $Post->files = $request->old_images . ',' . $request->images;
                
                if (Input::hasFile('avatar')) {
                    //Remove Old
                    if ($Post->avatar != 'posts/no.png') {
                        if (file_exists(public_path($Post->avatar))) {
                            unlink(public_path($Post->avatar));
                        }
                    }
                    //Save avatar
                    $Post->avatar = parent::upladImage(Input::file('avatar'), 'products','1');
                }
                if (Input::hasFile('avatar1')) {
                    //Remove Old
                    if ($Post->avatar1 != 'posts/no.png') {
                        if (file_exists(public_path($Post->avatar1))) {
                            unlink(public_path($Post->avatar1));
                        }
                    }
                    //Save avatar1
                    $Post->avatar1 = parent::upladImage(Input::file('avatar1'), 'products','2');
                }
                
                $Post->from_date = Input::get('from_date');
                $Post->to_date = Input::get('to_date');
                $Post->price = Input::get('price');

                $Post->type = Input::get('type');
                $Post->bed_rooms = Input::get('bed_rooms');
                $Post->bath_rooms = Input::get('bath_rooms');
                $Post->car = Input::get('car');
                $Post->sq = Input::get('sq');
                $Post->address = Input::get('address');
                $Post->provide = Input::get('provide');
                $Post->city = Input::get('city');
                $Post->country =Input::get('country');
                $Post->post_code = Input::get('post_code');

                $Post->area = Input::get('area');
                $Post->video = Input::get('video');

                $str_zi = "";
                $names = $request->names;
                if($names != null ){
                    if(count($names) != 0){
                        $i22 = 0;
                        foreach($names as $key =>$value){
                            $str_zi = $value.','.$str_zi;
                            $i22 = $i22 + 1;
                        }
                    }
                }
                $Post->features = $str_zi;

                $Post->update();
                $id_rotue = $Post->id;
                return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_products.index')]);
            } else {
                $Post = new Products();
                $Post->name = Input::get('name');
                $Post->files = $request->images;
                $Post->sub_name = Input::get('sub_name');
                $Post->summary = Input::get('summary');
                $Post->price = Input::get('price');
                $Post->category_id = Input::get('category_id');

                $Post->language_id = parent::GetIdLangEn()->id;
                $image_copy = parent::upladImage(Input::file('avatar'), 'products','1');
                $Post->avatar = $image_copy;
                $Post->avatar1 = parent::upladImage(Input::file('avatar1'), 'products','2');

                $Post->from_date = Input::get('from_date');
                $Post->to_date = Input::get('to_date');

                $Post->type = Input::get('type');
                $Post->bed_rooms = Input::get('bed_rooms');
                $Post->bath_rooms = Input::get('bath_rooms');
                $Post->car = Input::get('car');
                $Post->sq = Input::get('sq');
                $Post->address = Input::get('address');
                $Post->provide = Input::get('provide');
                $Post->city = Input::get('city');
                $Post->country =Input::get('country');
                $Post->post_code = Input::get('post_code');

                $Post->area = Input::get('area');
                $Post->video = Input::get('video');

                $str_zi = "";
                $names = $request->names;
                if($names != null ){
                    if(count($names) != 0){
                        $i22 = 0;
                        foreach($names as $key =>$value){
                            $str_zi = $value.','.$str_zi;
                            $i22 = $i22 + 1;
                        }
                    }
                }
                $Post->features = $str_zi;

                $Post->save();
                $id_rotue = $Post->id;
                return response()->json(['success' => __('language.msg.s'), 'dashboard' => '1', 'redirect' => route('dashboard_products.index')]);
            }
        }
    }

    private function rules($edit = null)
    {
        $x = [
            'name' => 'required|min:3|max:191',
            'sub_name' => 'required|min:3|max:191',
            'summary' => 'required|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required|numeric|min:1',
            'avatar' => 'required|mimes:png,jpg,jpeg,jpeg,PNG,JPG,JPEG',
            'avatar1' => 'required',
        ];
        if ($edit != null) {
            $x['id'] = 'required|integer|min:1';
            $x['avatar'] = 'nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
            $x['avatar1'] = 'nullable';
        }
        return $x;
    }

    private function languags()
    {
        if (app()->getLocale() == "ar") {
            return [
                'keywords' => 'The keywords field is required.',
                'description ' => 'The description  field is required.',
                'sub_name.required' => 'حقل الاسم الثانوي مطلوب.',
                'sub_name.regex' => 'حقل الاسم الثانوي غير صحيح .',
                'sub_name.min' => 'حقل الاسم الثانوي مطلوب على الاقل 3 حقول .',
                'sub_name.max' => 'حقل الاسم الثانوي مطلوب على الاكثر 191 حرف  .',
                'price.max' => 'حقل الاسم الثانوي مطلوب على الاكثر 191 حرف  .',
                'paragraph.required' => 'حقل المختصر مطلوب.',
                'name.required' => 'حقل الاسم مطلوب.',
                'category_id.required' => 'حقل التنصيف مطلوب.',
                'category_id.numeric' => 'حقل التنصيف غير صحيح .',
                'name.regex' => 'حقل الاسم غير صحيح .',
                'name.min' => 'حقل الاسم مطلوب على الاقل 3 حقول .',
                'name.max' => 'حقل الاسم مطلوب على الاكثر 191 حرف  .',
                'summary.required' => 'حقل الوصف مطلوب.',
                'summary.min' => 'حقل الوصف مطلوب على الاقل 3 حقول .',
                'summary_bunner.required' => 'حقل الوصف البانر مطلوب.',
                'summary_bunner.min' => 'حقل الوصف البانر مطلوب على الاقل 3 حقول .',
                'category_id.required' => 'حقل الاقسام مطلوب.',
                'category_id.regex' => 'حقل الاقسام غير صحيح .',
                'category_id.min' => 'حقل الاقسام مطلوب على الاقل 31 .',
                'price.required' => 'حقل السعر مطلوب.',
                'price.regex' => 'حقل السعر غير صحيح .',
                'price.min' => 'حقل السعر مطلوب على الاقل 1 .',
                'avatar.required' => 'حقل الصورة مطلوب.',
                'avatar.mimes' => 'حقل الصورة غير صحيح .',
                'bunner.required' => 'حقل صورة البانر مطلوب.',
                'bunner.mimes' => 'حقل صورة البانر غير صحيح .',
            ];
        } else {
            return [];
        }
    }
    
    public function uploadjquery(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('upload/gallery_products'), $imageName);
        return response()->json(['data' => $imageName]);
    }

    public function deleteuploadjquery(Request $request)
    {
        $filename = $request->get('filename');
        $path = public_path() . '/upload/gallery_products/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }

    public function related_products(Request $request)
    {
        $edit = $request->products_id;
        $validation = Validator::make($request->all(), $this->rules22());
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $Post = Products::where('id', '=', $edit)->first();
            if ($Post == null) {
                return response()->json(['error' => 'Has Error']);
            } else {
                $old = $Post->related_products;
                $Post->related_products = $old . $request->related_products;
                $Post->update();
                return response()->json(['success' => __('language.msg.m')]);
            }
        }
    }

    private function rules22($edit = null)
    {
        $x = [
            'related_products' => 'required|string|min:1',
            'products_id' => 'required|numeric',
        ];
        return $x;
    }

    public function get_pro($x)
    {
        $Post = Products::where('id', '=', $x)->first();
        if ($Post == null) {
            return null;
        } else {
            return $Post->related_products;
        }
    }

    function get_related_products(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'language',
            3 => 'avatar',
            4 => 'id',
        );

        $id = $request->id;
        $related_products = $this->get_pro($id);

        $totalData = Products::where("id", "!=", $id)->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $products = Products::
        where("id", "!=", $id)
            ->offset($start)
            ->limit($limit)
            ->orderBy('related_products', 'desc')
            ->orderBy($order, $dir)
            ->get();

        if ($search != null) {
            $totalFiltered = Products::
            where("id", "!=", $id)
                ->count();
        }


        $data = array();
        if (!empty($products)) {
            foreach ($products as $post) {

                $ava = url(parent::PublicPa() . $post->avatar);

                $featured = '';
                $featured_lable = '';

                if ($related_products != null) {
                    $count = explode(",", $related_products);
                    if (count($count) != 0) {
                        foreach ($count as $key => $value) {
                            if ($value) {
                                if ($value == $post->id) {
                                    $featured = 'checked';
                                }
                            }
                        }
                    }
                }

                $nestedData['options'] = '<label class="custom-switch">
                                            <input type="checkbox" data-id=' . $post->id . ' name="custom-switch-checkbox"
                                             class="btn_featured custom-switch-input" ' . $featured . '>
                                              <span class="custom-switch-indicator"></span> <span class="custom-switch-description">' . $featured_lable . '</span>
                                              </label>';

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['avatar'] = "<img style='width: 50px;height: 50px;' src='{$ava}' class='img-circle img_data_tables'>";
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


}
