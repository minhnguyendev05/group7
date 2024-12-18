<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // for time

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
        $work = Work::create([
            'workname' => $workname,
            'mota' => $mota,
            'timestart' => $timestart,
            'timeend' => $timeend,
            'userid' => $userid,
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
        return view('work.calendar');
    }
    public function get_work(Request $request){
        if(Auth::check()){
            $start = $request->query('start');
            $end = $request->query('end');
            $user = Auth::user();
            $id = $user->id;
            $works = DB::select(DB::raw("SELECT * FROM works WHERE (timestart >= ? AND timeend <= ?) OR (timestart >= ? AND timeend IS NULL)"),[$start,$end,$start]);
            $array = [];
            foreach($works as $work){
                //dump($work);
                if($work->timeend === null){
                    array_push($array, array(
                        'title' => $work->workname,
                        'start' => date("Y-m-d",strtotime($work->timestart)),
                        'description' => $work->mota,
                    ));
                } elseif (explode(' ',$work->timestart)[1] == '00:00:00' && explode(' ',$work->timeend)[1] == '00:00:00'){
                    array_push($array, array(
                        'title' => $work->workname,
                        'start' => date("Y-m-d",strtotime($work->timestart)),
                        'end' => date("Y-m-d",strtotime($work->timeend)),
                        'description' => $work->mota,
                    ));
                } else {
                    array_push($array, array(
                        'title' => $work->workname,
                        'start' => $work->timestart,
                        'end' => $work->timeend,
                        'description' => $work->mota,
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
}
