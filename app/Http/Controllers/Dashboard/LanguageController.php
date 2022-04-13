<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\CategoryTranslate;
use App\Contents;
use App\ContentsTranslate;
use App\Post;
use App\PostTranslate;
use App\Products;
use App\ProductsTranslate;
use App\Setting;
use App\SettingTranslate;
use App\Testimonials;
use App\TestimonialsTranslate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Language;
use File;
use Config;

class LanguageController extends Controller
{
    public function index()
    {
        return view('dashboard/language.index');
    }

    public function add_edit()
    {
        return view('dashboard/language.add_edit');
    }

    public function lang($id = null)
    {
        if ($id == null) {
            return redirect()->route('dashboard_language.index');
        }
        $lang_item = Language::where("id", $id)->first();
        if ($lang_item == null) {
            return redirect()->route('dashboard_language.index');
        }
        $data = $lang_item->dir . ".json";
        $data_results = file_get_contents(public_path() . '/languages/' . $data);
        $lang_first = json_decode($data_results);

        $data2 = $lang_item->dir . "_dashboard.json";
        $data_results2 = file_get_contents(public_path() . '/languages/' . $data2);
        $lang2 = json_decode($data_results2);

        return view('dashboard/language.lang', compact('lang_first','lang2', 'lang_item'));
    }

    public function lang_post(Request $request)
    {
        if($request->type_dashboard_or_site == 1){
            if ($request->id == null) {
                return response()->json(['error' => __('language.msg.e')]);
            }
            $lang_item = Language::where("id", $request->id)->first();
            if ($lang_item == null) {
                return response()->json(['error' => __('language.msg.e')]);
            }

            $data_one = $lang_item->dir . ".json";

            $input = $request->all();
            if (file_exists(public_path() . '/languages/' . $data_one)) {
                unlink(public_path() . '/languages/' . $data_one);
            }

            unset($input['_token']);
            unset($input['id']);
            unset($input['type_dashboard_or_site']);
            //old
            $mydata = json_encode($input);
            file_put_contents(public_path() . '/languages/' . $data_one, $mydata);

            return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_language.lang',['id'=>Input::get('id')])]);

        }
        else{
            if ($request->id == null) {
                return response()->json(['error' => __('language.msg.e')]);
            }
            $lang_item = Language::where("id", $request->id)->first();
            if ($lang_item == null) {
                return response()->json(['error' => __('language.msg.e')]);
            }

            $data_one = $lang_item->dir . "_dashboard.json";

            $input = $request->all();
            if (file_exists(public_path() . '/languages/' . $data_one)) {
                unlink(public_path() . '/languages/' . $data_one);
            }

            unset($input['_token']);
            unset($input['id']);
            unset($input['type_dashboard_or_site']);
            //old
            $mydata = json_encode($input);
            file_put_contents(public_path() . '/languages/' . $data_one, $mydata);

            return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_language.lang',['id'=>Input::get('id')])]);

        }
    }

    function get_data(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'dir',
            3 => 'select',
            4 => 'id',
        );

        $totalData = Language::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $posts = Language::
        Where('name', 'LIKE', "%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->orderBy($order, $dir)
            ->get();

        if ($search != null) {
            $totalFiltered = Language::
            Where('name', 'LIKE', "%{$search}%")
                ->count();
        }


        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $ava = url(parent::PublicPa() . $post->avatar);
                $edit = route('dashboard_language.add_edit', ['id' => $post->id]);
                $lang = route('dashboard_language.lang', ['id' => $post->id]);

                $sele_r = parent::CurrentLangShow()->secondary;

                if($post->select == 1){
                    $sele_r = parent::CurrentLangShow()->Primary;
                }

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['avatar'] = "<img style='width: 70px;height: 50px;' src='{$ava}' class='img-circle img_data_tables'>";
                $nestedData['dir'] = $post->dir;
                $nestedData['select'] = '<div class="badge-primary badge">' . $sele_r . '</div>';
                $nestedData['options'] = "&emsp;<a class='btn btn-success btn-sm' href='{$edit}' title='Edit' ><span class='color_wi fa fa-edit'></span></a>
                        &emsp;<a class='btn btn-warning btn-sm' href='{$lang}' title='Lang' ><span class='color_wi fa fa-folder'></span></a>
                                          &emsp;<a class='btn_delete_current btn btn-danger btn-sm' data-id='{$post->id}' title='حذف' ><span class='color_wi fa fa-trash'></span></a>";
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
        $Language = Language::where('id', '=', $id)->first();
        if ($Language == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        return response()->json(['success' => $Language]);
    }

    function deleted(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $Language = Language::where('id', '=', $id)->first();
        if ($Language == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        if ($Language->select == 1) {
            return response()->json(['error' => __('language.msg.dont')]);
        }
        $Language->delete();
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
                DB::transaction(function () {
                    $Language = Language::where('id', '=', Input::get('id'))->first();
                    $Language->name = Input::get('name');
                    $Language->dir = strtolower(Input::get('dir'));
                    if (Input::get('select') == "on") {
                        $Language->select = true;
                        Session::put('local', strtolower(Input::get('dir')));
                        app()->setLocale(strtolower(Input::get('dir')));
                        $get_other = Language::where('select', '=', '1')->first();
                        $get_other->select = 0;
                        $get_other->update();
                        $env_update = [
                            'APP_LOCAL'   =>strtolower(Input::get('dir')),
                            'APP_NAME'   =>parent::create_slug_(Input::get('name')),
                        ];
                        parent::changeEnv($env_update);
                    } else {
                        $Language->select = false;
                    }
                    if (Input::hasFile('avatar')) {
                        //Remove Old
                        if ($Language->avatar != 'no.png') {
                            if (file_exists(public_path($Language->avatar))) {
                                unlink(public_path($Language->avatar));
                            }
                        }
                        //Save avatar
                        $Language->avatar = parent::upladImage(Input::file('avatar'), 'language');
                    }
                    $Language->update();

                    if (Input::get('select') == "on") {
                        $this->ChangeSetting(Input::get('id'));
                        $this->ChangeTestimonials(Input::get('id'));
                        $this->ChangeProducts(Input::get('id'));
                        $this->ChangePost(Input::get('id'));
                        $this->ChangeCategory(Input::get('id'));
                        $this->ChangeContents(Input::get('id'));
                    }
                    if (Input::get('dir') != Language::where('select', '=', '1')->first()->dir) {
                        //Old one
                        $data_one = "en.json";
                        $data_results_one = file_get_contents(public_path() . '/languages/' . $data_one);
                        //old
                        file_put_contents(public_path() . '/languages/' . Input::get('dir') . ".json", $data_results_one);

                        //Old one
                        $data_one2 = "en_dashboard.json";
                        $data_results_one2 = file_get_contents(public_path() . '/languages/' . $data_one2);
                        //old
                        file_put_contents(public_path() . '/languages/' . Input::get('dir') . "_dashboard.json", $data_results_one2);
                    }
                    if (!$Language) {
                        return response()->json(['error' => __('language.msg.e')]);
                    }
                });
                return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_language.index')]);
            } else {
                $Language = new Language();
                $Language->name = Input::get('name');
                $Language->dir = strtolower(Input::get('dir'));
                if (Input::get('select') == "on") {
                    $Language->select = true;
                    app()->setLocale(strtolower(Input::get('dir')));
                    $this->ChangeSetting(Input::get('id'));
                    $this->ChangeTestimonials(Input::get('id'));
                    $this->ChangeProducts(Input::get('id'));
                    $this->ChangePost(Input::get('id'));
                    $this->ChangeCategory(Input::get('id'));
                    $this->ChangeContents(Input::get('id'));
                    $env_update = [
                        'APP_LOCAL'   => strtolower(Input::get('dir')),
                        'APP_NAME'   =>parent::create_slug_(Input::get('name')),
                    ];
                    parent::changeEnv($env_update);
                } else {
                    $Language->select = false;

                }
                $Language->avatar = parent::upladImage(Input::file('avatar'), 'language');
                $Language->save();

                if (Input::get('dir') != Language::where('select', '=', '1')->first()->dir) {
                    //Old one
                    $data_one = "en.json";
                    $data_results_one = file_get_contents(public_path() . '/languages/' . $data_one);
                    //old
                    file_put_contents(public_path() . '/languages/' . Input::get('dir') . ".json", $data_results_one);

                    //Old one
                    $data_one2 = "en_dashboard.json";
                    $data_results_one2 = file_get_contents(public_path() . '/languages/' . $data_one2);
                    //old
                    file_put_contents(public_path() . '/languages/' . Input::get('dir') . "_dashboard.json", $data_results_one2);
                }

                return response()->json(['success' => __('language.msg.s'), 'dashboard' => '1', 'redirect' => route('dashboard_language.index')]);
            }
        }
    }

    private function rules($edit = null, $pass = null)
    {
        $x = [
            'name' => 'required|min:1|max:191|regex:/^[ا-يa-zA-Z0-9]/',
            'dir' => 'required|string|regex:/^[a-z]+$/u|',
            'select' => 'nullable',
            'avatar' => 'required|mimes:png,jpg,jpeg',
        ];
        if ($edit != null) {
            $x['id'] = 'required|integer|min:1';
            $x['avatar'] = 'nullable|mimes:png,jpg,jpeg';
        }
        return $x;
    }

    private function languags()
    {
        if (app()->getLocale() == "ar") {
            return [
                'keywords' => 'The keywords field is required.',
                'description ' => 'The description  field is required.',
                'name.required' => 'حقل الاسم مطلوب.',
                'name.regex' => 'حقل الاسم غير صحيح .',
                'name.min' => 'حقل الاسم مطلوب على الاقل 1 حقول .',
                'name.max' => 'حقل الاسم مطلوب على الاكثر 191 حرف  .',
                'avatar.required' => 'حقل صورة الغة مطلوب.',
                'dir.required' => 'حقل كود الغة مطلوب.',
            ];
        } else {
            return [];
        }
    }

    public function ChangeProducts($x)
    {

        //Get lang not select
        $lang = Language::where("select", "0")->get();

        //Get Products
        $lists = Products::get();
        if ($lists->count() != 0) {
            foreach ($lists as $item) {
                $change = Products::find($item->id);
                $change->language_id = $x;
                $change->update();
            }
        }
        //Get Products Translate
        $other = ProductsTranslate::get();
        if ($other->count() != 0) {
            $other_count = 0;
            foreach ($other as $item) {
                $change = ProductsTranslate::find($item->id);

                if ($lang->count() != 0) {
                    foreach ($lang as $lang2) {
                        $change->language_id = $lang2->id;
                        $change->update();
                    }
                }

            }
        }

    }

    public function ChangeSetting($x)
    {

        //Get lang not select
        $lang = Language::where("select", "0")->get();

        //Get Post
        $lists = Setting::first();
        $lists->language_id = $x;
        $lists->update();

        //Get Post Translate
        $other = SettingTranslate::get();
        if ($other->count() != 0) {
            $other_count = 0;
            foreach ($other as $item) {
                $change = PostTranslate::find($item->id);
                if($change != null){
                    if ($lang->count() != 0) {
                        foreach ($lang as $lang2) {
                            $change->language_id = $lang2->id;
                            $change->update();
                        }
                    }
                }
            }
        }

    }

    public function ChangePost($x)
    {

        //Get lang not select
        $lang = Language::where("select", "0")->get();

        //Get Post
        $lists = Post::get();
        if ($lists->count() != 0) {
            foreach ($lists as $item) {
                $change = Post::find($item->id);
                $change->language_id = $x;
                $change->update();
            }
        }
        //Get Post Translate
        $other = PostTranslate::get();
        if ($other->count() != 0) {
            $other_count = 0;
            foreach ($other as $item) {
                $change = PostTranslate::find($item->id);
                if ($lang->count() != 0) {
                    foreach ($lang as $lang2) {
                        $change->language_id = $lang2->id;
                        $change->update();
                    }
                }
            }
        }

    }


    public function ChangeTestimonials($x)
    {

        //Get lang not select
        $lang = Language::where("select", "0")->get();

        //Get Post
        $lists = Testimonials::get();
        if ($lists->count() != 0) {
            foreach ($lists as $item) {
                $change = Testimonials::find($item->id);
                $change->language_id = $x;
                $change->update();
            }
        }
        //Get Post Translate
        $other = TestimonialsTranslate::get();
        if ($other->count() != 0) {
            $other_count = 0;
            foreach ($other as $item) {
                $change = TestimonialsTranslate::find($item->id);
                if ($lang->count() != 0) {
                    foreach ($lang as $lang2) {
                        $change->language_id = $lang2->id;
                        $change->update();
                    }
                }
            }
        }

    }

    public function ChangeCategory($x)
    {

        //Get lang not select
        $lang = Language::where("select", "0")->get();

        //Get Category
        $lists = Category::get();
        if ($lists->count() != 0) {
            foreach ($lists as $item) {
                $change = Category::find($item->id);
                $change->language_id = $x;
                $change->update();
            }
        }
        //Get CategoryTranslate
        $other = CategoryTranslate::get();
        if ($other->count() != 0) {
            $other_count = 0;
            foreach ($other as $item) {
                $change = CategoryTranslate::find($item->id);
                if ($lang->count() != 0) {
                    foreach ($lang as $lang2) {
                        $change->language_id = $lang2->id;
                        $change->update();
                    }
                }
            }
        }

    }

    public function ChangeContents($x)
    {

        //Get lang not select
        $lang = Language::where("select", "0")->get();

        //Get Contents
        $lists = Contents::get();
        if ($lists->count() != 0) {
            foreach ($lists as $item) {
                $change = Contents::find($item->id);
                $change->language_id = $x;
                $change->update();
            }
        }


        //Get ContentsTranslate
        $other = ContentsTranslate::get();
        if ($other->count() != 0) {
            $other_count = 0;
            foreach ($other as $item) {
                $change = ContentsTranslate::find($item->id);

                if ($lang->count() != 0) {
                    foreach ($lang as $lang2) {
                        $change->language_id = $lang2->id;
                        $change->update();
                    }
                }

            }
        }


    }


}
