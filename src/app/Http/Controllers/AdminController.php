<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function Ramsey\Uuid\v1;

class AdminController extends Controller
{
    public function isadmin(){
        $user = Auth::user();
        $role = $user->role;
        if($role !== "admin"){
            return abort(404);
        }
    }
    public function view_review(){
        $this->isadmin();
        $data = DB::select(DB::raw('SELECT reviews.*,users.username FROM reviews,users WHERE reviews.userid = users.id'));
        if($data){
            return view('admin.review',['data'=>$data]);
        } else {
            return abort(500);
        }
    }
    public function view_user(){
        $this->isadmin();
        $data = DB::select(DB::raw('SELECT * FROM users WHERE id > 0'));
        foreach($data as $dt){
            $id = $dt->id;
            $query = DB::select(DB::raw('SELECT COUNT(id) as counts FROM reviews WHERE userid = ?'), [$id]);
            if($query){
                $count = $query[0]->counts;
            } else {
                $count = 0;
            }
            $dt->counts = $count;
        }
        if($data){
            return view('admin.user',['data'=>$data]);
        } else {
            return abort(500);
        }
    }
    public function delete_user(Request $request){
        $user = Auth::user();
        $role = $user->role;
        if($role !== "admin"){
            return response()->json(["status"=>500,"message"=>"Error Security, Authenticate Failed!"]);
        }
        $id = $request->input('id');
        $password = $request->input('password');
        $user_pass = $user->password;
        if(Hash::check($password,$user_pass)){
            $delete = DB::delete(DB::raw("DELETE FROM users WHERE id = ?"), [$id]);
            if($delete){
                return response()->json(["status"=>200,"message"=>"Xóa Thành Công Người Dùng!"]);
            } else {
                return response()->json(["status"=>500,"message"=>"Có Lỗi Xảy Ra Vui Lòng Thử Lại Sau!"]);
            }
        } else {
            return response()->json(["status"=>500,"message"=>"Xóa Thất Bại Do Mật Khẩu Bạn Nhập Vào Không Đúng!"]);
        }
    }
}
