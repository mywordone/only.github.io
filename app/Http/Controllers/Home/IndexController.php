<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class IndexController extends Controller
{
    //
    public function index()
    {
        $game_name = DB::table('message')->select('game_name')->distinct()->get();
        $city = DB::table('message')->select('city')->distinct()->get();
        $user_a = DB::table('message')
                    ->leftJoin('user as ua','ua.id','=','message.user_a')
                    ->select('ua.id','ua.user_name')->distinct()->get();
        $user_b = DB::table('message')
                    ->leftJoin('user as ub','ub.id','=','message.user_b')
                    ->select('ub.id','ub.user_name')->distinct()->get();
        $play = DB::table('user')->select('play')->distinct()->get();
        $game_stage = DB::table('message')->select('game_stage')->distinct()->get();
        $game_project = DB::table('message')->select('game_project')->distinct()->get();
        $user = DB::table('user')->select('id','user_name')->get();
        return view('home.index.index',compact('game_name','city','user_a','user_b','play','game_stage','game_project','user'));
    }
    //搜索条件数据
    public function data(Request $request)
    {
        $data = DB::table('message')
                ->join('user as ua','ua.id','=','message.user_a')
                ->join('user as ub','ub.id','=','message.user_b')
                ->leftJoin('count_score as count','count.mess_id','=','message.id')
                ->select('message.*','ua.user_name as user_a','ub.user_name as user_b','count.big','count.small')
                ->get();
        $response = [
            'code'=> 0,
            'msg'=> "",
            'count'=> 1000,
            'data'=> $data
        ];
        if (empty($request->all()['key'])){
            return response()->json($response);
        }else{
            $data = $request->all()['key'];
            $arr = [];
            foreach ($data as $k => $v){
                if (empty($v)){
                    $arr;
                }else{
                    $arr[$k] = $v ;
                }
            }
            $data = DB::table('message')
                    ->join('user as ua','ua.id','=','message.user_a')
                    ->join('user as ub','ub.id','=','message.user_b')
                    ->leftJoin('count_score as count','count.mess_id','=','message.id')
                    ->select('message.*','ua.user_name as user_a','ua.*','ub.user_name as user_b','ub.*','count.big','count.small')
                    ->where($arr)
                    ->get();
//            dd($data);//array()
            $response = [
                'code'=> 0,
                'msg'=> "",
                'count'=> 1000,
                'data'=> $data
            ];
            return response()->json($response);
        }
    }
    
    //视图渲染数据
    public function viewl(Request $request)
    {
        $id = $request->id;
        $aid = DB::table('message')->where('id',$id)->value('user_a');
        $bid = DB::table('message')->where('id',$id)->value('user_b');
        $aname = DB::table('user')->where('id',$aid)->value('user_name');
        $bname = DB::table('user')->where('id',$bid)->value('user_name');
//        dd($aid,$bid);
        //A运动员比赛数据
        $adata = DB::table('game_data')->where([
            'mess_id'=>$id,
            'user_id'=>$aid
        ])->get();
        //B运动员比赛数据
        $bdata = DB::table('game_data')->where([
            'mess_id'=>$id,
            'user_id'=>$bid
        ])->get();
        $ascore = $this->getResult1($adata);//A运动员比赛各板数得分次数
        $bscore = $this->getResult1($bdata);//B运动员比赛各板数得分次数

//        dd($ascore,$bscore);
        $anum = $this->getResult2($adata);
        $bnum = $this->getResult2($bdata);
//        dd($anum,$bnum);
        $i = 0;
        $adf = [];
        $asf = [];
        $bdf = [];
        $bsf = [];
        $astr = '';
        foreach ($anum as $item) {
            $astr = $item;
            if($i % 2 == 0){
                $adf[] = $item;
            }
            if ($i % 2 != 0){
                $asf[] = $item;
            }
            $i++;
        }
        $s = 0;
        $bstr = '';
        foreach ($bnum as $item) {
            $bstr = $item;
            if($s % 2 == 0){
                $bdf[] = $item;
            }
            if ($s % 2 != 0){
                $bsf[] = $item;
            }
            $s++;
        }
        array_pop($bdf);
        array_pop($adf);
        $adf = implode(',',$adf);//A运动员比赛各板数得分
        $asf = implode(',',$asf);//A运动员比赛各板数失分
        $bdf = implode(',',$bdf);//B运动员比赛各板数得分
        $bsf = implode(',',$bsf);//B运动员比赛各板数失分
//        dd($astr,$bstr);//A运动员比赛各板数得分率，B运动员比赛各板数得分率
        return view('home.index.list',compact('aname','bname','ascore','bscore','adf','asf','bdf','bsf','astr','bstr',''));
    }
    //取出运动员比赛详细分数
    public function getResult1($data){
        //定义变量
        $fqd = 0;
        $fqs = 0;
        $zsd = 0;
        $zss = 0;
        $fsd = 0;
        $fss = 0;
        $csd = 0;
        $css = 0;
        $kzd = 0;
        $kzs = 0;
        $fqdd = 0;
        $fqds = 0;
        $jqdd = 0;
        $jqds = 0;
        $zhdd = 0;
        $zhds = 0;
        $xcdd = 0;
        $xcds = 0;
        $fqdres = ['发球','第三板'];
        $jqdres = ['接发球','第四板'];
        $zhdres = ['第六板','第五板'];
        foreach ($data as $item)
        {
            if ($item->tool == '发球'){
                $item->get_lose == '得' ? $fqd++ : $fqs++;
            }
            if ($item->tool == '正手'){
                $item->get_lose == '得' ? $zsd++ : $zss++;
            }
            if ($item->tool == '反手'){
                $item->get_lose == '得' ? $fsd++ : $fss++;
            }
            if ($item->tool == '侧身'){
                $item->get_lose == '得' ? $csd++ : $css++ ;
            }
            if ($item->tool == '控制'){
                $item->get_lose == '得' ? $kzd++ : $kzs++;
            }
            if (in_array($item->bat_number,$fqdres)){
                $item->get_lose == '得' ? $fqdd++ : $fqds++;
            }
            if (in_array($item->bat_number,$jqdres)){
                $item->get_lose == '得' ? $jqdd++ : $jqds++;
            }
            if (in_array($item->bat_number,$zhdres)){
                $item->get_lose == '得' ? $zhdd++ : $zhds++;
            }
            if ($item->bat_number == '相持' && $item->get_lose == '得'){
                $item->get_lose == '得' ? $xcdd++ : $xcds++;
            }
        }

        if (($fqd+$fqs) == 0){
            $fqbl = 0;
        }else{
            $fqbl = $fqd/($fqd+$fqs)*100;//发球得分比例
        }
        if(($zsd+$zss)==0){
            $zsbl = 0;
        }else{
            $zsbl = $zsd/($zsd+$zss)*100;//正手得分比例
        }
        if(($fsd+$fss)==0){
            $fsbl = 0;
        }else{
            $fsbl = $fsd/($fsd+$fss)*100;//反手得分比例
        }
        if (($csd+$css)==0){
            $csbl = 0;
        }else{
            $csbl = $csd/($csd+$css)*100;//侧身得分比例
        }
        if (($kzd+$kzs)==0){
            $kzbl = 0;
        }else{
            $kzbl = $kzd/($kzd+$kzs)*100;//控制得分比例
        }
        if(($fqdd+$fqds)==0){
            $fqdbl = 0;
        }else{
            $fqdbl = $fqdd/($fqdd+$fqds)*100;//发抢段得分比例
        }
        if(($jqdd+$jqds)==0){
            $jqdbl = 0;
        }else{
            $jqdbl = $jqdd/($jqdd+$jqds)*100;//接抢段得分比例
        }
        if(($zhdd+$zhds)==0){
            $zhdbl = 0;
        }else{
            $zhdbl = $zhdd/($zhdd+$zhds)*100;//转换段得分比例
        }
        if(($xcdd+$xcds)==0){
            $xcdbl = 0;
        }else{
            $xcdbl = $xcdd/($xcdd+$xcds)*100;//相持得分比例
        }
        $strbl1 = $fqbl .','. $zsbl .','. $fsbl .','. $csbl .','. $kzbl;
        $strbl2 = $fqdbl .','. $jqdbl .','. $zhdbl .','. $xcdbl;
        $score['fqd'] = $fqd;//发球得分
        $score['fqs'] = $fqs;//发球失分
        $score['zsd'] = $zsd;//正手得分
        $score['zss'] = $zss;//正手失分
        $score['fsd'] = $fsd;//反手得分
        $score['fss'] = $fss;//反手失分
        $score['csd'] = $csd;//侧身得分
        $score['css'] = $css;//侧身失分
        $score['kzd'] = $kzd;//控制得分
        $score['kzs'] = $kzs;//控制失分
        $score['fqdd'] = $fqdd;//发抢段得分
        $score['fqds'] = $fqds;//发抢断失分
        $score['jqdd'] = $jqdd;//接抢段得分
        $score['jqds'] = $jqds;//接抢段失分
        $score['zhdd'] = $zhdd;//转换段得分
        $score['zhds'] = $zhds;//转换段失分
        $score['xcdd'] = $xcdd;//相持得分
        $score['xcds'] = $xcds;//相持失分
        $score['strbl1'] = $strbl1;
        $score['strbl2'] = $strbl2;
        return $score;
    }
    //取出各运动员各板分数和比例
    public function getResult2($data)
    {
        //
        $numd1 = 0;
        $nums1 = 0;
        $numd2 = 0;
        $nums2 = 0;
        $numd3 = 0;
        $nums3 = 0;
        $numd4 = 0;
        $nums4 = 0;
        $numd5 = 0;
        $nums5 = 0;
        $numd6 = 0;
        $nums6 = 0;
        $numd7 = 0;
        $nums7 = 0;
        foreach ($data as $datum) {
            if ($datum->bat_number == '发球'){
                $datum->get_lose == '得' ? $numd1++ : $nums1++;
            }elseif ($datum->bat_number == '接发球'){
                $datum->get_lose == '得' ? $numd2++ : $nums2++;
            }elseif ($datum->bat_number == '第三板'){
                $datum->get_lose == '得' ? $numd3++ : $nums3++;
            }elseif ($datum->bat_number == '第四板'){
                $datum->get_lose == '得' ? $numd4++ : $nums4++;
            }elseif ($datum->bat_number == '第五板'){
                $datum->get_lose == '得' ? $numd5++ : $nums5++;
            }elseif ($datum->bat_number == '第六板'){
                $datum->get_lose == '得' ? $numd6++ : $nums6++;
            }else {
                $datum->get_lose == '得' ? $numd7++ : $nums7++;
            }
        }

        if (($numd1 + $nums1) != 0){
            $str1 = $numd1/($numd1 + $nums1)*100;
        }else{
            $str1 = 0;
        }
        if(($numd2 + $nums2) != 0){
            $str2 = $numd2/($numd2 + $nums2)*100;
        }else{
            $str2 = 0;
        }
        if(($numd3 + $nums3) != 0){
            $str3 = $numd3/($numd3 + $nums3)*100;
        }else{
            $str3 = 0;
        }
        if(($numd4 + $nums4) != 0){
            $str4 = $numd4/($numd4 + $nums4)*100;
        }else{
            $str4 = 0;
        }
        if(($numd5 + $nums5) != 0){
            $str5 = $numd5/($numd5 + $nums5)*100;
        }else{
            $str5 = 0;
        }
        if(($numd6 + $nums6) != 0){
            $str6 = $numd6/($numd6 + $nums6)*100;
        }else{
            $str6 = 0;
        }
        if(($numd7 + $nums7) != 0){
            $str7 = $numd7/($numd7 + $nums7)*100;
        }else{
            $str7 = 0;
        }
        $str = $str1. ',' . $str2. ',' . $str3. ',' . $str4. ',' . $str5 . ','. $str6 . ','.$str7;
        $num['numd1'] = $numd1;
        $num['nums1'] = $nums1;
        $num['numd2'] = $numd2;
        $num['nums2'] = $nums2;
        $num['numd3'] = $numd3;
        $num['nums3'] = $nums3;
        $num['numd4'] = $numd4;
        $num['nums4'] = $nums4;
        $num['numd5'] = $numd5;
        $num['nums5'] = $nums5;
        $num['numd6'] = $numd6;
        $num['nums6'] = $nums6;
        $num['numd7'] = $numd7;
        $num['nums7'] = $nums7;
        $num['str']   = $str;
        return $num;
    }
    //

}












