<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class WordController extends Controller
{
    public function __construct()
    {
        
    }
    public function check($w){
         // blacklist 
         $blacklist = [
            'địt', 'fuck', 'lồn', 'pê-đê', 'cặc', 'đụ', 'dâm', 'chịch', 'vãi', 'buồi', 'mẹ', 'con mẹ',
            'đĩ', 'chơi gái', 'bậy', 'chửi bậy', 'lưỡi tục', 'điếm', 'đụng đít', 'sờ soạng',
            'thối', 'tởm', 'ngáo đá', 'xạo', 'lừa đảo','nứng', 'nghe đéo', 'đéo', 'tự sướng', 'gâu', 'bóc phốt', 'vô dụng', 'thân xác', 'con chó', 'ngu',
            'dau bo', 'đầu bò', 'nửa mùa', 'khoái', 'gái gọi', 'thằng chó', 'bế tắc', 'giẻ rách',
            'khốn khổ', 'thịt', 'chó đẻ', 'mất dạy', 'nhục', 'hèn', 'lol', 'lon','ccm',
            'cu', 'trẻ trâu', 'ngáo ngơ', 'gạ tình', 'trốn thoát', 'sống hèn', 'bẩn thỉu', 'sờ mó',
            'xạo lồn', 'lố bịch', 'đổ đốn', 'lòng tham', 'ngu', 'cac', 'lừa','chơi gái','cl','co cl','cocl',
            'cak', 'hư hỏng', 'dm', 'dcm', 'cdm', 'cmm', 'đm', 'đcm', 'cc','vcl','vkl','cmn','deo me', 'cmm','chó','bao phòng',
            'choi gai','gai goi','bao phong','xuyen dem','memaybeo','mmb','con memaybeo','chos','choa','dit','chich','buoi','db'
        ];
        if(is_array($w)){
            $raw = implode(" ",$w);
        } else {
            $raw = $w;
        }
        foreach ($blacklist as $word) {
            if (stripos($raw, $word) !== false) {
                $user = User::where('id',Auth::id())->first();
                $vipham = $user->vipham + 1;
                if($vipham >= 5){
                    $user->update(["status"=> 0,"vipham"=> $vipham]);
                } else {
                    $user->update(["vipham" => $vipham]);
                }
                return false;
            }
        }
        return true;
    }
}
