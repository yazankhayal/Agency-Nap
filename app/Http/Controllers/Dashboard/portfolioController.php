<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\CategoryPortfolio;
use App\City;
use App\Portfolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class portfolioController extends Controller
{
    public function index()
    {
        return view('dashboard/portfolio.index');
    }

    public function add_edit($id = null)
    {
        $category_portfolio_id1 = CategoryPortfolio::get();
        return view('dashboard/portfolio.add_edit', compact('category_portfolio_id1'));
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

        $totalData = Portfolio::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $Portfolio = Portfolio::
        Where('name', 'LIKE', "%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->orderBy($order, $dir)
            ->get();

        if ($search != null) {
            $totalFiltered = Portfolio::
            Where('name', 'LIKE', "%{$search}%")
                ->count();
        }


        $data = array();
        if (!empty($Portfolio)) {
            foreach ($Portfolio as $post) {
                $ava = url(parent::PublicPa() . $post->avatar);
                $edit = route('dashboard_portfolio.add_edit', ['id' => $post->id]);
                $langage = $post->Language->name;
                $ava_lan = url(parent::PublicPa() . $post->Language->avatar);

                $edit_title = parent::CurrentLangShow()->Edit;
                $delete_title = parent::CurrentLangShow()->Delete;
                $add_title = parent::CurrentLangShow()->Add_new_language;

                $has_lanageus = $post->PortfolioTranslate;
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
                                           <a class='btn_delete_current btn btn-danger btn-sm' data-id='{$post->id}' title='$delete_title' ><span class='color_wi fa fa-trash'></span></a>";
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
        $Post = Portfolio::where('id', '=', $id)->first();
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
        $Post = Portfolio::where('id', '=', $id)->first();
        if ($Post == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $Post->delete();
        return response()->json(['error' => __('language.msg.d')]);
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
                $Post = Portfolio::where('id', '=', Input::get('id'))->first();
                $Post->name = Input::get('name');
                $Post->sub_name = Input::get('sub_name');
                $Post->category_portfolio_id = Input::get('category_portfolio_id');
                if (Input::hasFile('avatar')) {
                    //Remove Old
                    if ($Post->avatar != 'posts/no.png') {
                        if (file_exists(public_path($Post->avatar))) {
                            unlink(public_path($Post->avatar));
                        }
                    }
                    //Save avatar
                    $Post->avatar = parent::upladImage(Input::file('avatar'), 'portfolio');
                }
                $Post->update();
                $id_rotue = $Post->id;
                return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_portfolio.index')]);
            } else {
                $Post = new Portfolio();
                $Post->name = Input::get('name');
                $Post->sub_name = Input::get('sub_name');
                $Post->category_portfolio_id = Input::get('category_portfolio_id');
                $Post->language_id = parent::GetIdLangEn()->id;
                $image_copy = parent::upladImage(Input::file('avatar'), 'portfolio');
                $Post->avatar = $image_copy;
                $Post->save();
                $id_rotue = $Post->id;
                return response()->json(['success' => __('language.msg.s'), 'dashboard' => '1', 'redirect' => route('dashboard_portfolio.index')]);
            }
        }
    }

    private function rules($edit = null)
    {
        $x = [
            'name' => 'required|min:3|max:191',
            'sub_name' => 'required|min:3|max:191',
            'category_portfolio_id' => 'required|numeric|min:1',
            'avatar' => 'required|mimes:png,jpg,jpeg,jpeg,PNG,JPG,JPEG',
        ];
        if ($edit != null) {
            $x['id'] = 'required|integer|min:1';
            $x['avatar'] = 'nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
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
                'category_portfolio_id.required' => 'حقل التنصيف مطلوب.',
                'category_portfolio_id.numeric' => 'حقل التنصيف غير صحيح .',
                'name.regex' => 'حقل الاسم غير صحيح .',
                'name.min' => 'حقل الاسم مطلوب على الاقل 3 حقول .',
                'name.max' => 'حقل الاسم مطلوب على الاكثر 191 حرف  .',
                'summary.required' => 'حقل الوصف مطلوب.',
                'summary.min' => 'حقل الوصف مطلوب على الاقل 3 حقول .',
                'summary_bunner.required' => 'حقل الوصف البانر مطلوب.',
                'summary_bunner.min' => 'حقل الوصف البانر مطلوب على الاقل 3 حقول .',
                'category_portfolio_id.required' => 'حقل الاقسام مطلوب.',
                'category_portfolio_id.regex' => 'حقل الاقسام غير صحيح .',
                'category_portfolio_id.min' => 'حقل الاقسام مطلوب على الاقل 31 .',
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
        $image->move(public_path('upload/gallery_portfolio'), $imageName);
        return response()->json(['data' => $imageName]);
    }

    public function deleteuploadjquery(Request $request)
    {
        $filename = $request->get('filename');
        $path = public_path() . '/upload/gallery_portfolio/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }

    public function related_portfolio(Request $request)
    {
        $edit = $request->Portfolio_id;
        $validation = Validator::make($request->all(), $this->rules22());
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $Post = Portfolio::where('id', '=', $edit)->first();
            if ($Post == null) {
                return response()->json(['error' => 'Has Error']);
            } else {
                $old = $Post->related_portfolio;
                $Post->related_portfolio = $old . $request->related_portfolio;
                $Post->update();
                return response()->json(['success' => __('language.msg.m')]);
            }
        }
    }

    private function rules22($edit = null)
    {
        $x = [
            'related_portfolio' => 'required|string|min:1',
            'Portfolio_id' => 'required|numeric',
        ];
        return $x;
    }

    public function get_pro($x)
    {
        $Post = Portfolio::where('id', '=', $x)->first();
        if ($Post == null) {
            return null;
        } else {
            return $Post->related_portfolio;
        }
    }

    function get_related_portfolio(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'language',
            3 => 'avatar',
            4 => 'id',
        );

        $id = $request->id;
        $related_portfolio = $this->get_pro($id);

        $totalData = Portfolio::where("id", "!=", $id)->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $Portfolio = Portfolio::
        where("id", "!=", $id)
            ->offset($start)
            ->limit($limit)
            ->orderBy('related_portfolio', 'desc')
            ->orderBy($order, $dir)
            ->get();

        if ($search != null) {
            $totalFiltered = Portfolio::
            where("id", "!=", $id)
                ->count();
        }


        $data = array();
        if (!empty($Portfolio)) {
            foreach ($Portfolio as $post) {

                $ava = url(parent::PublicPa() . $post->avatar);

                $featured = '';
                $featured_lable = '';

                if ($related_portfolio != null) {
                    $count = explode(",", $related_portfolio);
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
