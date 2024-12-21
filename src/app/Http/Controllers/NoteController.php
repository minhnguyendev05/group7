<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Note;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function view(){
        $userid = Auth::id();
        $note = DB::select(DB::raw("SELECT * FROM notes WHERE userid = ? ORDER BY ghim DESC"),[$userid]);
        foreach($note as $nt){
            $nt->content = substr($nt->content,0, 10)."...";
            $nt->ngay = date("d/m/Y",strtotime($nt->ngay));
        }
        return view('note.view',['notes'=>$note]);
    }
    public function add(Request $request){
        if(Auth::check()){
            $userid = Auth::id();
            $all = $request->all();
            $notename = $all['notename'];
            $ngay = $all['ngay'];
            $content = $all['content'];
            $validator = Validator::make($all, [
                'notename' => 'required|string|max:255',
                'ngay' => 'required|string|max:20',
                'content' => 'required|string|max:1000',
            ]);
            if ($validator->fails()) {
                return response()->json(["status"=>500,"message"=> $validator->errors()->all()]);
            }
            $word = new WordController();
            $check = $word->check([$notename,$content]);
            if($check === false){
                return response()->json(["status"=>500,"message"=>"Nội Dung Của Bạn Chứa Từ Bị Cấm. Hãy Biết Điều Tuân Thủ Quy Tắc!"]);
            }
            $note = Note::create([
                'notename' => $notename,
                'ngay' => $ngay,
                'userid' => $userid,
                'content' => $content,
                'ghim' => 0,
            ]);
            if($note){
                return response()->json(["status"=>200,"message"=>"Thêm Ghi Chú Thành Công!"]);
            } else {
                return response()->json(["status"=>500,"message"=>"Thêm Ghi Chú Thất Bại!"]);
            }
        } else {
            return abort(403);
        }
    }
    public function get_note(){
        if(Auth::check()){
            $userid = Auth::id();
            $note = DB::select(DB::raw("SELECT * FROM notes WHERE userid = ? ORDER BY ghim DESC"),[$userid]);
            $data = "";
            foreach($note as $nt){
                $nt->content = substr($nt->content,0, 10)."...";
                $nt->ngay = date("d/m/Y",strtotime($nt->ngay));
                if($nt->ghim === 1){
                    $type = 0;
                    $txt = "Bỏ Ghim";
                } else {
                    $type = 1;
                    $txt = "Ghim";
                }
                $data .= '<div class="flex flex-wrap flex-evenly text-white padding-10 margin-10">
                        <div class="name-time border-right">'.$nt->notename.'</div>
                        <div class="name-time border-right">'.$nt->content.'</div>
                        <div class="name-time border-right">'.$nt->ngay.'</div>
                        <a class="name-time border-right link text-white" onclick="ghim('.$nt->id.','.$type.')">'.$txt.'</a>
                    </div>';
            }
            if($note){
                return response()->json(["status"=>200,"message"=>$data]);
            } else {
                return response()->json(["status"=>500,"message"=>"Unknown Error Occurred!"]);
            }
            
        } else {
            return abort(403);
        }
    }
    public function bind_note(Request $request){
        if(Auth::check()){
            $userid = Auth::id();
            $id = $request->input('id');
            $type = intval($request->input('type'));
            $up = DB::update(DB::raw("UPDATE notes SET ghim = 0 WHERE userid = ? AND id > 0"),[$userid]);
            if($type === 0){
                return response()->json(["status"=>200,"message"=>"Bỏ Ghim Ghi Chú Thành Công!"]);
            }
            $date = DB::update(DB::raw("UPDATE notes SET ghim = ? WHERE userid = ? AND id = ?"),[$type,$userid,$id]);
            if($date){
                return response()->json(["status"=>200,"message"=>"Ghim Ghi Chú Thành Công!"]);
            } else {
                return response()->json(["status"=>500,"message"=>"Ghim Ghi Chú Thất Bại!"]);
            }
            
        } else {
            return abort(403);
        }
    }
    public function review(){
        return view('note.review');
    }
    public function add_review(Request $request){
        $stars = $request->input('stars');
        $content = $request->input('content');
        $validator = Validator::make($request->all(),[
            "stars" => "required|integer|max:5",
            "content" => "required|string|max:1000",
        ]);
        if($validator->fails()){
            return redirect()->route('view_review')->with('data','false')->with('error',implode(',',$validator->errors()->all()));
        }
        $word = new WordController();
        $check = $word->check([$content]);
        if($check === false){
            return redirect()->route('view_review')->with('error',"Nội Dung Của Bạn Chứa Từ Bị Cấm. Hãy Biết Điều Tuân Thủ Quy Tắc!")->with('data','false');
        }
        $userid = Auth::id();
        $review = Review::create([
            "rate" => $stars,
            "content" => $content,
            "userid" => $userid,
        ]);
        if($review){
            return redirect()->route('view_review')->with('success','Gửi Đánh Giá Thành Công!')
            ->with('data','true');
        } else {
            return redirect()->route('view_review')->with('error','Thêm Đánh Giá Thất Bại!')->with('data','false');
        }
    }

}
