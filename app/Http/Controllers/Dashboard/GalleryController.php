<?php

namespace App\Http\Controllers\Dashboard;

use App\Gallery;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index(){
        return view('dashboard/gallery.index');
    }

    public function file_deleted(Request $request){
        $filename =  $request->get('filename');
        $path = base_path(parent::url_base_path().'gallery/'.$filename);
        if (file_exists($path)) {
            unlink($path);
        }
        $save = Gallery::where('avatar','=',$filename)->first();
        if($save == null){
            return response()->json(['error'=> 'Has Error']);
        }
        $save->delete();
        return $filename;
    }

    public function file_deleted_by_id($id = null){
        $save = Gallery::where('id','=',$id)->first();
        if($save == null){
            return response()->json(['error'=> 'Has Error']);
        }
        $filename = $save->avatar;
        $path = base_path(parent::url_base_path().'gallery/'.$save->avatar);
        if (file_exists($path)) {
            unlink($path);
        }
        $save->delete();
        return response()->json(['success'=>'Done delete photo']);
    }

    public function attachments(Request $request){
        $item = Gallery::orderby('id','desc')->get();
        return response()->json(['data'=>$item]);
    }

    public function express_mail_file(Request $request){
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $url = base_path(parent::url_base_path().'gallery/');
        $image->move($url,$imageName);

        $save = new Gallery();
        $save->avatar = $imageName;
        $save->save();

        return response()->json(['data'=>$imageName]);
    }
}
