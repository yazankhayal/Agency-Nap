<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Contents;
use App\HomePageSetting;
use App\Language;
use App\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Currencies;
use App\CurrencyConversions;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class EditHomePageController extends Controller
{
    function get_data(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'avatar',
            3 => 'id',
        );

        $totalData = Products::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $products = Products::
        offset($start)
            ->limit($limit)
            ->orderBy('featured', 'desc')
            ->orderBy($order, $dir)
            ->get();

        if ($search != null) {
            $totalFiltered = \Products::count();
        }


        $data = array();
        if (!empty($products)) {
            foreach ($products as $post) {
                $ava = url(parent::PublicPa() . $post->avatar);

                $featured = '';
                $featured_lable = '';
                if ($post->featured == 1) {
                    $featured = 'checked';
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

    //Deal function
    public function deal()
    {
        return view('dashboard/home_page.deal');
    }

    function deal_featured(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $user = Products::where('id', '=', $id)->first();
        if ($user == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        if ($user->featured == 1) {
            $user->featured = 0;
            $user->update();
            return response()->json(['error' => __('table.r-choice')]);
        } else {
            $user->featured = 1;
            $user->update();
            return response()->json(['success' => __('table.choice')]);
        }
    }

    //last_products function
    public function last_products()
    {
        return view('dashboard/home_page.last_products');
    }

    function deal_trending(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $user = Products::where('id', '=', $id)->first();
        if ($user == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        if ($user->trending == 1) {
            $user->trending = 0;
            $user->update();
            return response()->json(['error' => __('table.r-choice')]);
        } else {
            $user->trending = 1;
            $user->update();
            return response()->json(['success' => __('table.choice')]);
        }
    }

    function get_data_last_products(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'avatar',
            3 => 'id',
        );

        $totalData = Products::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $products = Products::
        offset($start)
            ->limit($limit)
            ->orderBy('trending', 'desc')
            ->orderBy($order, $dir)
            ->get();

        if ($search != null) {
            $totalFiltered = \Products::count();
        }


        $data = array();
        if (!empty($products)) {
            foreach ($products as $post) {
                $ava = url(parent::PublicPa() . $post->avatar);

                $featured = '';
                $featured_lable = '';
                if ($post->trending == 1) {
                    $featured = 'checked';
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

    //our_products_1 function
    public function our_products_1()
    {
        $category_id = Category::get();
        return view('dashboard/home_page.our_products_1', compact('category_id'));
    }

    public function our_products_2()
    {
        $category_id = Category::get();
        return view('dashboard/home_page.our_products_2', compact('category_id'));
    }

    public function our_products_3()
    {
        $category_id = Category::get();
        return view('dashboard/home_page.our_products_3', compact('category_id'));
    }

    public function our_trending_products_4()
    {
        $category_id = Category::get();
        return view('dashboard/home_page.our_trending_products_4', compact('category_id'));
    }
    public function our_trending_products_5()
    {
        $category_id = Category::get();
        return view('dashboard/home_page.our_trending_products_5', compact('category_id'));
    }
    public function our_trending_products_6()
    {
        $category_id = Category::get();
        return view('dashboard/home_page.our_trending_products_6', compact('category_id'));
    }

    function get_products(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'avatar',
            3 => 'id',
        );

        $type = $request->type;

        $totalData = Products::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $products = Products::offset($start)
            ->limit($limit)
            ->where(function ($q) use ($type) {
                $q->orderBy($type, 'desc');
            })
            ->orderBy($order, $dir)
            ->get();

        if ($search != null) {
            $totalFiltered = \Products::count();
        }


        $data = array();
        if (!empty($products)) {
            foreach ($products as $post) {
                $ava = url(parent::PublicPa() . $post->avatar);


                $featured = '';
                $featured_lable = '';
                if ($type == "f1") {
                    if ($post->f1 == 1) {
                        $featured = 'checked';
                    }
                }
                else if ($type == "f2") {
                    if ($post->f2 == 1) {
                        $featured = 'checked';
                    }
                }
                else if ($type == "f3") {
                    if ($post->f3 == 1) {
                        $featured = 'checked';
                    }
                }
                else if ($type == "f4") {
                    if ($post->f4 == 1) {
                        $featured = 'checked';
                    }
                }
                else if ($type == "f5") {
                    if ($post->f5 == 1) {
                        $featured = 'checked';
                    }
                }
                else if ($type == "f6") {
                    if ($post->f6 == 1) {
                        $featured = 'checked';
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

    public function save_cat(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $user = Category::where('id', '=', $id)->first();
        if ($user == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        if ($type == 1) {
            $remove = Category::where("id","!=",$id)->where('featured1', '=', "1")->first();
            if($remove){
                $remove->featured1 = 0;
                $remove->update();
            }
            $user->featured1 = 1;
            $user->update();
            return response()->json(['success' => __('table.choice')]);
        }
        else if($type == 2){
            $remove = Category::where("id","!=",$id)->where('featured2', '=', "1")->first();
            if($remove){
                $remove->featured2 = 0;
                $remove->update();
            }
            $user->featured2 = 1;
            $user->update();
            return response()->json(['success' => __('table.choice')]);
        }
        else if($type == 3){
            $remove = Category::where("id","!=",$id)->where('featured3', '=', "1")->first();
            if($remove){
                $remove->featured3 = 0;
                $remove->update();
            }
            $user->featured3 = 1;
            $user->update();
            return response()->json(['success' => __('table.choice')]);
        }
        else if($type == 4){
            $remove = Category::where("id","!=",$id)->where('featured4', '=', "1")->first();
            if($remove){
                $remove->featured4 = 0;
                $remove->update();
            }
            $user->featured4 = 1;
            $user->update();
            return response()->json(['success' => __('table.choice')]);
        }
        else if($type == 5){
            $remove = Category::where("id","!=",$id)->where('featured5', '=', "1")->first();
            if($remove){
                $remove->featured5 = 0;
                $remove->update();
            }
            $user->featured5 = 1;
            $user->update();
            return response()->json(['success' => __('table.choice')]);
        }
        else if($type == 6){
            $remove = Category::where("id","!=",$id)->where('featured6', '=', "1")->first();
            if($remove){
                $remove->featured6 = 0;
                $remove->update();
            }
            $user->featured6 = 1;
            $user->update();
            return response()->json(['success' => __('table.choice')]);
        }
    }

    function save_pro(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $user = Products::where('id', '=', $id)->first();
        if ($user == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        if ($type == 1) {
            if ($user->f1 == 1) {
                $user->f1 = 0;
                $user->update();
                return response()->json(['error' => __('table.r-choice')]);
            } else {
                $user->f1 = 1;
                $user->update();
                return response()->json(['success' => __('table.choice')]);
            }
        }
        else if($type == 2){
            if ($user->f2 == 1) {
                $user->f2 = 0;
                $user->update();
                return response()->json(['error' => __('table.r-choice')]);
            } else {
                $user->f2 = 1;
                $user->update();
                return response()->json(['success' => __('table.choice')]);
            }
        }
        else if($type == 3){
            if ($user->f3 == 1) {
                $user->f3 = 0;
                $user->update();
                return response()->json(['error' => __('table.r-choice')]);
            } else {
                $user->f3 = 1;
                $user->update();
                return response()->json(['success' => __('table.choice')]);
            }
        }
        else if($type == 4){
            if ($user->f4 == 1) {
                $user->f4 = 0;
                $user->update();
                return response()->json(['error' => __('table.r-choice')]);
            } else {
                $user->f4 = 1;
                $user->update();
                return response()->json(['success' => __('table.choice')]);
            }
        }
        else if($type == 5){
            if ($user->f5 == 1) {
                $user->f5 = 0;
                $user->update();
                return response()->json(['error' => __('table.r-choice')]);
            } else {
                $user->f5 = 1;
                $user->update();
                return response()->json(['success' => __('table.choice')]);
            }
        }
        else if($type == 6){
            if ($user->f6 == 1) {
                $user->f6 = 0;
                $user->update();
                return response()->json(['error' => __('table.r-choice')]);
            } else {
                $user->f6 = 1;
                $user->update();
                return response()->json(['success' => __('table.choice')]);
            }
        }
    }

    public function hot_tags(){
        $category_id = Category::get();
        return view('dashboard/home_page.hot_tags', compact('category_id'));
    }

    public function get_data_hot_tags_by_id(Request $request){
        $items = Contents::where('type','=',"hot_tags")->first();
        return response()->json(['success'=>$items]);
    }

    public function post_hot_tags(Request $request){
        $id = $request->id;
        $type = $request->type;
        if($id == null){
            return response()->json(['error' => parent::CurrentLangHomeShow()->Error_Happen]);
        }
        $item = Category::where("id",$id)->first();
        if($item == null){
            return response()->json(['error' => parent::CurrentLangHomeShow()->Error_Happen]);
        }
        if($type == "true"){
            $item->hot_tags = 1;
        }
        else{
            $item->hot_tags = 0;
        }
        $item->update();
        return response()->json(['success'=> __('language.msg.s'),'same_page'=>'1','dashboard'=>'1']);
    }

    private function rulespost_hot_tags($edit = null){
        $x= [
            'category_id' => 'required',
        ];
        if($edit != null){
            $x['id'] ='required|integer|min:1';
        }
        return $x;
    }

    public function sort(){
        return view('dashboard/home_page.sort');
    }

    public function get_data_sort_by_id(Request $request){
        $items = HomePageSetting::first();
        return response()->json(['success'=>$items]);
    }

    public function post_sort(Request $request){
        $HomePageSetting = HomePageSetting::first();
        $validation = Validator::make($request->all(), $this->rules_sort($HomePageSetting));
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            if($HomePageSetting == null){
                $HomePageSetting = new HomePageSetting();
                $HomePageSetting->sec_sort_1 = Input::get('sec_sort_1');
                if(Input::get('sec_enable_1') == "on"){
                    $HomePageSetting->sec_enable_1 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_1 = 0;
                }

                $HomePageSetting->sec_sort_2 = Input::get('sec_sort_2');
                if(Input::get('sec_enable_2') == "on"){
                    $HomePageSetting->sec_enable_2 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_2 = 0;
                }

                $HomePageSetting->sec_sort_3 = Input::get('sec_sort_3');
                if(Input::get('sec_enable_3') == "on"){
                    $HomePageSetting->sec_enable_3 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_3 = 0;
                }

                $HomePageSetting->sec_sort_4 = Input::get('sec_sort_4');
                if(Input::get('sec_enable_4') == "on"){
                    $HomePageSetting->sec_enable_4 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_4 = 0;
                }

                $HomePageSetting->sec_sort_5 = Input::get('sec_sort_5');
                if(Input::get('sec_enable_5') == "on"){
                    $HomePageSetting->sec_enable_5 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_5 = 0;
                }

                $HomePageSetting->sec_sort_6 = Input::get('sec_sort_6');
                if(Input::get('sec_enable_6') == "on"){
                    $HomePageSetting->sec_enable_6 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_6 = 0;
                }

                $HomePageSetting->sec_sort_7 = Input::get('sec_sort_7');
                if(Input::get('sec_enable_7') == "on"){
                    $HomePageSetting->sec_enable_7 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_7 = 0;
                }

                $HomePageSetting->sec_sort_8 = Input::get('sec_sort_8');
                if(Input::get('sec_enable_8') == "on"){
                    $HomePageSetting->sec_enable_8 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_8 = 0;
                }

                $HomePageSetting->sec_sort_9 = Input::get('sec_sort_9');
                if(Input::get('sec_enable_9') == "on"){
                    $HomePageSetting->sec_enable_9 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_9 = 0;
                }
                $HomePageSetting->sec_sort_10 = Input::get('sec_sort_10');
                if(Input::get('sec_enable_10') == "on"){
                    $HomePageSetting->sec_enable_10 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_10 = 0;
                }
                /*$HomePageSetting->sec_sort_10 = Input::get('sec_sort_10');
                $HomePageSetting->sec_sort_10 = Input::get('sec_sort_10');

                $HomePageSetting->sec_sort_11 = Input::get('sec_sort_11');
                $HomePageSetting->sec_enable_11 = Input::get('sec_enable_11');

                $HomePageSetting->sec_sort_12 = Input::get('sec_sort_12');
                $HomePageSetting->sec_enable_12 = Input::get('sec_enable_12');*/

                $HomePageSetting->save();
                return response()->json(['success'=> __('language.msg.s'),'same_page'=>'1','dashboard'=>'1']);
            }
            else{
                $HomePageSetting = HomePageSetting::first();
                $HomePageSetting->sec_sort_1 = Input::get('sec_sort_1');
                if(Input::get('sec_enable_1') == "on"){
                    $HomePageSetting->sec_enable_1 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_1 = 0;
                }

                $HomePageSetting->sec_sort_2 = Input::get('sec_sort_2');
                if(Input::get('sec_enable_2') == "on"){
                    $HomePageSetting->sec_enable_2 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_2 = 0;
                }

                $HomePageSetting->sec_sort_3 = Input::get('sec_sort_3');
                if(Input::get('sec_enable_3') == "on"){
                    $HomePageSetting->sec_enable_3 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_3 = 0;
                }

                $HomePageSetting->sec_sort_4 = Input::get('sec_sort_4');
                if(Input::get('sec_enable_4') == "on"){
                    $HomePageSetting->sec_enable_4 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_4 = 0;
                }

                $HomePageSetting->sec_sort_5 = Input::get('sec_sort_5');
                if(Input::get('sec_enable_5') == "on"){
                    $HomePageSetting->sec_enable_5 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_5 = 0;
                }

                $HomePageSetting->sec_sort_6 = Input::get('sec_sort_6');
                if(Input::get('sec_enable_6') == "on"){
                    $HomePageSetting->sec_enable_6 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_6 = 0;
                }

                $HomePageSetting->sec_sort_7 = Input::get('sec_sort_7');
                if(Input::get('sec_enable_7') == "on"){
                    $HomePageSetting->sec_enable_7 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_7 = 0;
                }

                $HomePageSetting->sec_sort_8 = Input::get('sec_sort_8');
                if(Input::get('sec_enable_8') == "on"){
                    $HomePageSetting->sec_enable_8 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_8 = 0;
                }

                $HomePageSetting->sec_sort_9 = Input::get('sec_sort_9');
                if(Input::get('sec_enable_9') == "on"){
                    $HomePageSetting->sec_enable_9 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_9 = 0;
                }
                $HomePageSetting->sec_sort_10 = Input::get('sec_sort_10');
                if(Input::get('sec_enable_10') == "on"){
                    $HomePageSetting->sec_enable_10 = 1;
                }
                else{
                    $HomePageSetting->sec_enable_10 = 0;
                }
                /*$HomePageSetting->sec_sort_10 = Input::get('sec_sort_10');
                $HomePageSetting->sec_sort_10 = Input::get('sec_sort_10');

                $HomePageSetting->sec_sort_11 = Input::get('sec_sort_11');
                $HomePageSetting->sec_enable_11 = Input::get('sec_enable_11');

                $HomePageSetting->sec_sort_12 = Input::get('sec_sort_12');
                $HomePageSetting->sec_enable_12 = Input::get('sec_enable_12');*/
                $HomePageSetting->update();
                return response()->json(['success'=>__('language.msg.m'),'same_page'=>'1','dashboard'=>'1']);
            }
        }
    }

    private function rules_sort($edit = null){
        $x= [
            'sec_sort_1' => 'required|min:1|numeric',
            'sec_enable_1' => 'nullable',
            'sec_sort_2' => 'required|min:1|numeric',
            'sec_enable_2' => 'nullable',
            'sec_sort_3' => 'required|min:1|numeric',
            'sec_enable_3' => 'nullable',
            'sec_sort_4' => 'required|min:1|numeric',
            'sec_enable_4' => 'nullable',
            'sec_sort_5' => 'required|min:1|numeric',
            'sec_enable_5' => 'nullable',
            'sec_sort_6' => 'required|min:1|numeric',
            'sec_enable_6' => 'nullable',
            'sec_sort_7' => 'required|min:1|numeric',
            'sec_enable_7' => 'nullable',
            'sec_sort_8' => 'required|min:1|numeric',
            'sec_enable_8' => 'nullable',
            'sec_sort_9' => 'required|min:1|numeric',
            'sec_enable_9' => 'nullable',
            //'sec_sort_10' => 'required|min:1|numeric',
            //'sec_enable_10' => 'nullable',
            // 'sec_sort_11' => 'required|min:1|numeric',
            //'sec_enable_11' => 'nullable',
            //'sec_sort_12' => 'required|min:1|numeric',
            //'sec_enable_12' => 'nullable',
        ];
        if($edit != null){
            $x['id'] ='required|integer|min:1';
        }
        return $x;
    }

    public function header_1(){
        $category_id1 = Category::get();
        $brand_id = Brand::get();
        return view('dashboard/home_page.header_1',compact('category_id1', 'brand_id'));
    }

    public function header_2(){
        $category_id1 = Category::get();
        $brand_id = Brand::get();
        return view('dashboard/home_page.header_2',compact('category_id1', 'brand_id'));
    }

    public function header_3(){
        $category_id1 = Category::get();
        $brand_id = Brand::get();
        return view('dashboard/home_page.header_3',compact('category_id1', 'brand_id'));
    }

    public function header_4(){
        $category_id1 = Category::get();
        $brand_id = Brand::get();
        return view('dashboard/home_page.header_4',compact('category_id1', 'brand_id'));
    }

    public function get_data_header_by_id(Request $request){
        $items = Contents::where('type','=','header_1')->first();
        return response()->json(['success'=>$items]);
    }

    public function get_data_header2_by_id(Request $request){
        $items = Contents::where('type','=','header_2')->first();
        return response()->json(['success'=>$items]);
    }

    public function get_data_header3_by_id(Request $request){
        $items = Contents::where('type','=','header_3')->first();
        return response()->json(['success'=>$items]);
    }

    public function get_data_header4_by_id(Request $request){
        $items = Contents::where('type','=','header_4')->first();
        return response()->json(['success'=>$items]);
    }

    public function post_header(Request $request)
    {
        $id = $request->id;
        $validation = Validator::make($request->all(), $this->rules22($id));
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {

            $type = "header_1";
            if($request->type == 1){
                $type = "header_1";
            }
            else if($request->type == 2){
                $type = "header_2";
            }
            else if($request->type == 3){
                $type = "header_3";
            }
            else{
                $type = "header_4";
            }

            $about = Contents::where('type','=',$type)->first();
            if($about == null){
                $about = new Contents();
                $about->type = $type;
                $about->name = $request->name;
                $about->link = $request->link;
                $about->video = $request->video;

                //Save category
                $category_1 = $request->category_1;
                $str_cat_1 = "";
                if ($category_1 != null) {
                    $count_cat_1 = $category_1;
                    if (count($count_cat_1) != 0) {
                        foreach ($count_cat_1 as $key => $value) {
                            $str_cat_1 = $value . "," . $str_cat_1;
                        }
                    }
                }
                $about->summary = $str_cat_1;

                //Save brand_id
                $brand_id = $request->brand_id;
                $str_bra = "";
                if ($brand_id != null) {
                    $count_cat_2 = $brand_id;
                    if (count($count_cat_2) != 0) {
                        foreach ($count_cat_2 as $key => $value) {
                            $str_bra = $value . "," . $str_bra;
                        }
                    }
                }
                $about->sub_summary = $str_bra;

                $about->avatar1 = parent::upladImage(Input::file('avatar1'),'header_1','1');
                $about->avatar2 = parent::upladImage(Input::file('avatar2'),'header_1','2');

                $about->language_id = parent::GetIdLangEn()->id;
                $about->user_id = parent::CurrentID();
                $about->save();
                return response()->json(['success'=>__('language.msg.s'),'same_page'=>'1','dashboard'=>'1']);
            }
            else{

                $about->link = $request->link;
                $about->name = $request->name;
                $about->video = $request->video;

                //Save category
                $category_1 = $request->category_1;
                $str_cat_1 = "";
                if ($category_1 != null) {
                    $count_cat_1 = $category_1;
                    if (count($count_cat_1) != 0) {
                        foreach ($count_cat_1 as $key => $value) {
                            $str_cat_1 = $value . "," . $str_cat_1;
                        }
                    }
                }
                $about->summary = $str_cat_1;

                //Save brand_id
                $brand_id = $request->brand_id;
                $str_bra = "";
                if ($brand_id != null) {
                    $count_cat_2 = $brand_id;
                    if (count($count_cat_2) != 0) {
                        foreach ($count_cat_2 as $key => $value) {
                            $str_bra = $value . "," . $str_bra;
                        }
                    }
                }
                $about->sub_summary = $str_bra;

                if(Input::hasFile('avatar1')){
                    //Remove Old
                    if($about->avatar1 != 'upload/header_1/no.png'){
                        if(file_exists(public_path($about->avatar1))){
                            unlink(public_path($about->avatar1));
                        }
                    }
                    //Save avatar1
                    $about->avatar1 = parent::upladImage(Input::file('header_1'),'about','1');
                }

                if(Input::hasFile('avatar2')){
                    //Remove Old
                    if($about->avatar2 != 'upload/header_1/no.png'){
                        if(file_exists(public_path($about->avatar2))){
                            unlink(public_path($about->avatar2));
                        }
                    }
                    //Save avatar2
                    $about->avatar2 = parent::upladImage(Input::file('avatar2'),'about','2');
                }
                $about->update();
                return response()->json(['success'=>__('language.msg.m'),'same_page'=>'1','dashboard'=>'1']);
            }

        }
    }

    private function rules22($edit = null)
    {
        $x = [
            'name' => 'required|string',
            'link' => 'required|string',
            'video' => 'required|string',
            'category_1' => 'required',
            'brand_id' => 'required',
            'avatar1' => 'required|mimes:png,jpg,jpeg,jpeg,PNG,JPG,JPEG',
            'avatar2' => 'required|mimes:png,jpg,jpeg,jpeg,PNG,JPG,JPEG',
        ];
        if($edit != null){
            $x['id'] ='required|integer|min:1';
            $x['avatar1'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
            $x['avatar2'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
        }
        return $x;
    }


}
