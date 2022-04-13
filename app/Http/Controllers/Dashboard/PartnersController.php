<?php

namespace App\Http\Controllers\Dashboard;

use App\Partners;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnersController extends Controller
{
    public function index(){
        return view('dashboard/partners.index');
    }

    public function file_deleted(Request $request){
        $filename =  $request->get('filename');
        $path = base_path(parent::url_base_path().'partners/'.$filename);
        if (file_exists($path)) {
            unlink($path);
        }
        $save = Partners::where('avatar','=',$filename)->first();
        if($save == null){
            return response()->json(['error'=> 'Has Error']);
        }
        $save->delete();
        return $filename;
    }

    public function file_deleted_by_id($id = null){
        $save = Partners::where('id','=',$id)->first();
        if($save == null){
            return response()->json(['error'=> 'Has Error']);
        }
        $filename = $save->avatar;
        $path = base_path(parent::url_base_path().'partners/'.$save->avatar);
        if (file_exists($path)) {
            unlink($path);
        }
        $save->delete();
        return response()->json(['success'=>'Done delete photo']);
    }

    public function attachments(Request $request){
        $item = Partners::get();
        return response()->json(['data'=>$item]);
    }

    public function express_mail_file(Request $request){
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $url = base_path(parent::url_base_path().'partners/');
        $image->move($url,$imageName);

        $save = new Partners();
        $save->avatar = $imageName;
        $save->save();

        return response()->json(['data'=>$imageName]);
    }
}
