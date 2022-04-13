<?php

namespace App\Http\Controllers\Dashboard;

use App\Contents;
use App\ContentsTranslate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SliderTranslateController extends Controller
{

    function get_data_by_id(Request $request)
    {
        $id = $request->id;
        $language_id = $request->language_id;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $SubScriptions = ContentsTranslate::
        where('hp_contents_id', '=', $id)
            ->where('language_id', '=', $language_id)
            ->first();
        if ($SubScriptions == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        return response()->json(['success' => $SubScriptions]);
    }

    public function post_data(Request $request)
    {
        $edit = $request->id;
        $password = $request->password;
        $validation = Validator::make($request->all(), $this->rules($edit), $this->languags());
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            if ($edit != null) {
                $PostTranslate = ContentsTranslate::where('id', '=', Input::get('id'))->first();
                $PostTranslate->summary = Input::get('summary');
                $PostTranslate->sub_name = Input::get('sub_name');
                $PostTranslate->name = Input::get('name');
                $PostTranslate->language_id = Input::get('language_id');
                $PostTranslate->hp_contents_id = Input::get('hp_contents_id');
                $PostTranslate->update();
                return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_slider.index')]);
            } else {
                $check = ContentsTranslate::
                where('hp_contents_id', '=', Input::get('hp_contents_id'))
                    ->where('language_id', '=', Input::get('language_id'))
                    ->first();
                if ($check != null) {
                    return response()->json(['error' => __('language.msg.already')]);
                }
                DB::transaction(function () {
                    $PostTranslate = new ContentsTranslate();
                    $PostTranslate->sub_name = Input::get('sub_name');
                    $PostTranslate->name = Input::get('name');
                    $PostTranslate->summary = Input::get('summary');
                    $PostTranslate->language_id = Input::get('language_id');
                    $PostTranslate->hp_contents_id = Input::get('hp_contents_id');
                    $PostTranslate->save();
                    if (!$PostTranslate) {
                        return response()->json(['error' => __('language.msg.e')]);
                    }
                });
                return response()->json(['success' => __('language.msg.s'), 'dashboard' => '1', 'redirect' => route('dashboard_slider.index')]);
            }
        }
    }

    private function rules($edit = null, $pass = null)
    {
        $x = [
            'name' => 'required|min:3|max:191|regex:/^[ا-يa-zA-Z0-9]/',
            'sub_name' => 'required|min:3|max:191|regex:/^[ا-يa-zA-Z0-9]/',
            'summary' => 'required|min:2',
            'hp_contents_id' => 'required|numeric|min:1',
            'language_id' => 'required|numeric|min:1',
        ];
        if ($edit != null) {
            $x['id'] = 'required|integer|min:1';
        }
        return $x;
    }

    private function languags()
    {
        if (app()->getLocale() == "ar") {
            return [
                'name.required' => 'حقل الاسم مطلوب.',
                'name.regex' => 'حقل الاسم غير صحيح .',
                'name.min' => 'حقل الاسم مطلوب على الاقل 3 حقول .',
                'name.max' => 'حقل الاسم مطلوب على الاكثر 191 حرف  .',
                'summary.required' => 'حقل الوصف مطلوب.',
                'dir.required' => 'حقل كود الغة مطلوب.',

            ];
        } else {
            return [];
        }
    }


}
