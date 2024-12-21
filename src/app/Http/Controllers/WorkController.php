<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // for time
use Illuminate\Support\Facades\Validator;

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
        // blacklist 
        $blacklist = [
            'địt', 'fuck', 'lồn', 'pê-đê', 'cặc', 'đụ', 'dâm', 'chịch', 'vãi', 'buồi', 'mẹ', 'con mẹ',
            'đĩ', 'chơi gái', 'bậy', 'chửi bậy', 'lưỡi tục', 'điếm', 'đụng đít', 'sờ soạng',
            'khốn nạn', 'thối', 'tởm', 'ngáo đá', 'tào lao', 'xạo', 'lươn lẹo', 'lừa đảo',
            'nứng', 'nghe đéo', 'đéo', 'tự sướng', 'gâu', 'bóc phốt', 'vô dụng', 'thân xác', 'con chó', 'ngu',
            'quái', 'đầu bò', 'nửa mùa', 'khoái', 'gái gọi', 'thằng chó', 'bế tắc', 'giẻ rách',
            'khốn khổ', 'thịt', 'chó đẻ', 'mất dạy', 'nhục', 'hèn', 'kền kền', 'bệnh hoạn',
            'hả hê', 'trẻ trâu', 'ngáo ngơ', 'gạ tình', 'trốn thoát', 'sống hèn', 'bẩn thỉu', 'sờ mó',
            'xạo lồn', 'lố bịch', 'đổ đốn', 'lòng tham', 'ngu', 'ăn cắp', 'lừa',
            'cak', 'hư hỏng', 'dm', 'dcm', 'cdm', 'cmm', 'đm', 'đcm', 'cc','vcl','vkl','cmn','deo me', 'cmm','chó','bao phòng'
        ];
        foreach ($blacklist as $word) {
            if (stripos($workname, $word) !== false || stripos($mota, $word) !== false) {
                $user = User::where('id',Auth::id())->first();
                $vipham = $user->vipham + 1;
                if($vipham >= 5){
                    $user->update(["status"=> 0,"vipham"=> $vipham]);
                } else {
                    $user->update(["vipham" => $vipham]);
                }
                return redirect()->back()->withErrors(['content' => 'Nội dung của bạn chứa từ bị cấm. Hãy biết điều tuân thủ quy tắc!']);
            }
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
        return view('work.calendar');
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
