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

class AboutListTranslateController extends Controller
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
                $PostTranslate->name = Input::get('name');
                $PostTranslate->sub_name = Input::get('sub_name');
                $PostTranslate->language_id = Input::get('language_id');
                $PostTranslate->hp_contents_id = Input::get('hp_contents_id');
                $PostTranslate->update();
                return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_about_list.index')]);
            } else {
                $check = ContentsTranslate::
                where('hp_contents_id', '=', Input::get('hp_contents_id'))
                    ->where('language_id', '=', Input::get('language_id'))
                    ->first();
                if ($check != null) {
                    return response()->json(['error' => __('language.msg.already')]);
                }
                $PostTranslate = new ContentsTranslate();
                $PostTranslate->name = Input::get('name');
                $PostTranslate->sub_name = Input::get('sub_name');
                $PostTranslate->language_id = Input::get('language_id');
                $PostTranslate->hp_contents_id = Input::get('hp_contents_id');
                $PostTranslate->save();
                return response()->json(['success' => __('language.msg.s'), 'dashboard' => '1', 'redirect' => route('dashboard_about_list.index')]);
            }
        }
    }

    private function rules($edit = null, $pass = null)
    {
        $x = [
            'name' => 'required|min:3|max:191|regex:/^[??-??a-zA-Z0-9]/',
            'hp_contents_id' => 'required|numeric|min:1',
            'sub_name' => 'required|min:3|max:191|regex:/^[??-??a-zA-Z0-9]/',
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
                'name.required' => '?????? ?????????? ??????????.',
                'name.regex' => '?????? ?????????? ?????? ???????? .',
                'name.min' => '?????? ?????????? ?????????? ?????? ?????????? 3 ???????? .',
                'name.max' => '?????? ?????????? ?????????? ?????? ???????????? 191 ??????  .',
                'sub_name.required' => '?????? ?????????? ??????????.',
                'dir.required' => '?????? ?????? ???????? ??????????.',

            ];
        } else {
            return [];
        }
    }


}
