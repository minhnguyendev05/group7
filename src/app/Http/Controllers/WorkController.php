<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // for time
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\WordController;

class WorkController extends Controller
{
    public function render_add() {
        if(Auth::check()){
            return view('work.add');
        }
        return redirect()->route('login');
    }
    public function add(Request $request) {
        $data = $request->all();
        $workname = $data['workname'];
        $timestart = $data['timestart'];
        $timeend = $data['timeend'];
        $mota = $data['mota'];
        $userid = Auth::id();
        $validator = Validator::make($request->all(), [
            'workname' => 'required|string|max:255',
            'timestart' => 'required|string|max:255',
            'timeend' => 'required|string|max:255',
            'mota' => 'required|string|max:2000', //confirmed
        ]);

        if ($validator->fails()) {
            return redirect()->route('add_work')
                        ->withErrors($validator)
                        ->withInput();
        }
        if(strtotime($timeend) - strtotime($timestart) < 0){
            return redirect()->back()->withErrors(['content' => 'Thời Gian Kết Thúc Không Thể Ở Trước Thời Gian Bắt Đầu!']);
        }
        $user = Auth::id();
        $db = DB::table('works')->select('*')->where('timestart','=',$timestart)->where('userid',$user);
        if($db){
            // not null array 0 object
            return redirect()->back()->withErrors(['content' => 'Thời Gian Bắt Đầu Trùng Lặp, Vui Lòng Kiếm Tra Lại!']);
        }
        // blacklist 
        $word = new WordController();
        $check = $word->check([$workname,$mota]);
        if($check === false){
           return redirect()->back()->withErrors(['content' => 'Nội Dung Của Bạn Chứa Từ Bị Cấm. Hãy Biết Điều Tuân Thủ Quy Tắc!']);
        }
        $work = Work::create([
            'workname' => $workname,
            'mota' => $mota,
            'timestart' => $timestart,
            'timeend' => $timeend,
            'userid' => $userid,
            'done' => 0,
        ]);
        session()->flash('success', 'Thêm Công Việc Thành Công!');
        return redirect()->route('add_work');
    }
    public function time_remaining(){
        
        $startDate = Carbon::parse('2024-12-13 10:00:00');  // Ngày bắt đầu
        $endDate = Carbon::parse('2024-12-14 15:30:00');    // Ngày kết thúc

        // Tính khoảng cách giữa hai thời điểm
        $diff = $startDate->diff($endDate);

        // Hiển thị khoảng cách dưới dạng các đơn vị khác nhau
        echo $diff->days . " ngày ";        // Số ngày
        echo $diff->h . " giờ ";           // Số giờ
        echo $diff->i . " phút ";          // Số phút
        echo $diff->s. " giây ";          // Giây

    }
    public function view(){
        $now = date("Y-m-d");
        $id = Auth::id();
        $db = DB::select(DB::raw('SELECT * FROM notes WHERE userid = ? AND (ghim = 1 OR ngay = ?)'),[$id,$now]);
        //$db = DB::table('notes')->select('*')->where('ngay',$now)->get();
        return view('work.calendar',['note'=>$db]);
    }
    public function get_work(Request $request){
        if(Auth::check()){
            $start = $request->query('start');
            $end = $request->query('end');
            $user = Auth::user();
            $id = $user->id;
            $works = DB::select(DB::raw("SELECT * FROM works WHERE userid = ? AND ((timestart >= ? AND timeend <= ?) OR (timestart >= ? AND timeend IS NULL))"),[$id,$start,$end,$start]);
            $array = [];
            foreach($works as $work){
                //dump($work);
                if($work->timeend === null){
                    array_push($array, array(
                        'title' => $work->workname,
                        'start' => date("Y-m-d",strtotime($work->timestart)),
                        'description' => $work->mota,
                        'id' => $work->id,
                        'status' => $work->done,
                    ));
                } elseif (explode(' ',$work->timestart)[1] == '00:00:00' && explode(' ',$work->timeend)[1] == '00:00:00'){
                    array_push($array, array(
                        'title' => $work->workname,
                        'start' => date("Y-m-d",strtotime($work->timestart)),
                        'end' => date("Y-m-d",strtotime($work->timeend)),
                        'description' => $work->mota,
                        'id' => $work->id,
                        'status' => $work->done,
                    ));
                } else {
                    array_push($array, array(
                        'title' => $work->workname,
                        'start' => $work->timestart,
                        'end' => $work->timeend,
                        'description' => $work->mota,
                        'id' => $work->id,
                        'status' => $work->done,
                    ));
                }    
            }
            return response()->json($array);
        } else {
            return abort(403);
        }
    }
    public function history(){
        if(Auth::check()){
            $user = Auth::user();
            $id = $user->id;
            $works = DB::select(DB::raw("SELECT * FROM works WHERE userid = ?"), [$id]);
            return view('work.history', ['works' => $works]);
        }
        return redirect()->route('login');
    }
    public function get_work_id($id){
        if(Auth::check()){
            $user = Auth::user();
            $userid = $user->id;
            $work = DB::select(DB::raw("SELECT * FROM works WHERE userid = ? AND id = ? LIMIT 1"), [$userid,$id]);
            return view('work.details', ['work' => $work]);
        }
        return redirect()->route('login');
    }
    public function update(Request $request) {
        $id = $request->input('id');
        $status = $request->input('status');
        if(Auth::check()){
            $user = Auth::user();
            $userid = $user->id;
            $update = DB::update(DB::raw("UPDATE works SET done = ? WHERE id = ? AND userid = ?"),[$status,$id,$userid]);
            if($update) {
                return response()->json(["status"=>200,"message"=>"Update Work Successfully!"]);
            } else {
                return response()->json(["status"=>500,"message"=>"Unknown Error Occurred!"]);
            }
        }
        return response()->json(["status"=>403,"message"=>"Error Missing Permission!"]);
    }
}
