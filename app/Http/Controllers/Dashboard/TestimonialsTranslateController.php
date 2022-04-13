<?php

namespace App\Http\Controllers\Dashboard;

use App\TestimonialsTranslate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class TestimonialsTranslateController extends Controller
{

    function get_data_by_id(Request $request)
    {
        $id = $request->id;
        $language_id = $request->language_id;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $SubScriptions = TestimonialsTranslate::
        where('testimonials_id', '=', $id)
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
                $PostTranslate = TestimonialsTranslate::where('id', '=', Input::get('id'))->first();
                $PostTranslate->name = Input::get('name');
                $PostTranslate->bio = Input::get('bio');
                $PostTranslate->summary = Input::get('summary');
                $PostTranslate->language_id = Input::get('language_id');
                $PostTranslate->testimonials_id = Input::get('testimonials_id');
                $PostTranslate->update();
                return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_testimonials.index')]);
            } else {
                $check = TestimonialsTranslate::
                where('testimonials_id', '=', Input::get('testimonials_id'))
                    ->where('language_id', '=', Input::get('language_id'))
                    ->first();
                if ($check != null) {
                    return response()->json(['error' => __('language.msg.already')]);
                }
                $PostTranslate = new TestimonialsTranslate();
                $PostTranslate->name = Input::get('name');
                $PostTranslate->bio = Input::get('bio');
                $PostTranslate->summary = Input::get('summary');
                $PostTranslate->language_id = Input::get('language_id');
                $PostTranslate->testimonials_id = Input::get('testimonials_id');
                $PostTranslate->save();
                return response()->json(['success' => __('language.msg.s'), 'dashboard' => '1', 'redirect' => route('dashboard_testimonials.index')]);
            }
        }
    }

    private function rules($edit = null, $pass = null)
    {
        $x = [
            'name' => 'required|min:3|max:191|regex:/^[ا-يa-zA-Z0-9]/',
            'testimonials_id' => 'required|numeric|min:1',
            'bio' => 'required|min:3|max:191|regex:/^[ا-يa-zA-Z0-9]/',
            'summary' => 'required|string',
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
                'bio.required' => 'حقل bio مطلوب.',
                'bio.regex' => 'حقل bio غير صحيح .',
                'bio.min' => 'حقل bio مطلوب على الاقل 3 حقول .',
                'bio.max' => 'حقل bio مطلوب على الاكثر 191 حرف  .',

            ];
        } else {
            return [];
        }
    }


}
