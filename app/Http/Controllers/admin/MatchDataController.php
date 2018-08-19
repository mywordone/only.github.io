<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Excel;
use Storage;

class MatchDataController extends Controller
{
	//比赛数据显示页面
	public function index(Request $res){
		$match_id = 0;
		$player_id = 0;
		$matchdatas = null;
		$matchinfos = DB::table('matchinfo as c')
			->leftjoin('player as a','c.playerA_id','=','a.id')
			->leftjoin('player as b','c.playerB_id','=','b.id')
			->select('a.name as playerAname','b.name as playerBname','c.id',
                'c.match_name','c.match_phase','c.match_item','c.playerA_id','c.playerB_id')
			->get();
		if($res->method() === 'POST'){
			$match_id = $res->input('matchname');
			$player_id = $res->input('playername');
			$playername = DB::table('player')->where('id',$player_id)->pluck('name')[0];
			// dd($playername);
			$matchdatas = DB::select('select a.*,b.name from matchdata as a,round as b where 
				a.match_id = :mid and a.player_id = :pid and a.round_id = b.id and a.status = 0' ,['mid' => $match_id,'pid' => $player_id]);
			
		}
		return view('admin.matchdata.index',compact('matchinfos','matchdatas',
				'match_id','player_id'));
	}

	// public function getData(Request $res){
		
	// }
    //比赛数据批量上传
    public function import(Request $res){

    	if($res->method() === 'GET' ){
    		//获取比赛信息
    		$matchinfos = DB::table('matchinfo')
			->leftjoin('player as a','matchinfo.playerA_id','=','a.id')
			->leftjoin('player as b','matchinfo.playerB_id','=','b.id')
			->select('a.name as playerAname','b.name as playerBname','matchinfo.id','matchinfo.match_name','matchinfo.match_phase','matchinfo.match_item','matchinfo.playerA_id','matchinfo.playerB_id')
			->get();
    		//显示批量上传页面
    		return view('admin.matchdata.import',compact('matchinfos'));
    	}else{
    		//获取提交数据并保存到数据库
    		$post = $res->input();
    		//判断表单内容是否正确
    		
    		// load方法基于项目根路径作为根目录，需要对中文进行了转码，否则会提示文件不存在。
    		$filePath = '.' . $post['excelpath'];
		    Excel::load($filePath, function($reader) use ($post) {
		        // $data = $reader->all();
		        $data = $reader -> getSheet(0) -> toArray();
		        // 写入数据表
		        $arr = [];
		        foreach ($data as $key => $value) {
		        	// 跳过表头
		        	if($key == 0 || $key == 1){
		        		continue;
		        	}
		        	$arr[] = [
		        		'player_id' =>  $post['playername'],
		        		'match_id'  =>  $post['matchname'],
		        		'round_id'	=>	(int) $value[0],// 局数
		        		'getscore'	=>	(int) $value[1],//总得
		        		'losescore'	=>	(int) $value[2],//总失
		        		'take_send'	=>	$value[3],//接发轮次
		        		'patnum'	=>	$value[4],//拍数
		        		'methods'	=>	$value[5],//手段
		        		'get_lose'	=>	$value[6],//得失分
		        	]; 
		        }
                //设置原有数据为不可用
                DB::table('matchdata')->where(['player_id' => $post['playername'],
                'match_id' => $post['matchname']])->update(['status' => 1]);
		        //插入数据库
		        if(DB::table('matchdata')->insert($arr)){
		        	$response = 0;
		        	$this->manageExceldata($arr,$post);
		        }else{
		        	$response = 1;
		        }
		        echo $response;
		    });
    	}

    }

    //导出模板
    public function export(){//导出数据

    	// 定义一个变量
    	$cellData = ['局数','总得','总失','发接轮次','拍数','手段','得失分'];
        // 调用excel类创建一个excel文件
        Excel::create('比赛数据上传模板',function($excel) use ($cellData){
        	// 创建一个工作表
            $excel->sheet('比赛数据', function($sheet) use ($cellData){
            	// 将数据写入到行里
            	$sheet->setAllBorders('thin'); //设置边框
                //设置字体
            	$sheet->setFontFamily('Calibri'); 
                $sheet->setFontSize(15); 
                $sheet->setFontBold(true); 
                //设置背景
            	$sheet->cell('A2:G2', function($cells){ 
                	$cells->setBackground('#FF7F00');
           		}); 
           		$sheet->setWidth([// 设置多个列宽
                	'A' => 8, 
                	'B' => 8,
                	'C' => 8, 
                	'D' => 8, 
                	'E' => 8, 
                	'F' => 8, 
                	'G' => 8, 
           		]); 
            	$sheet->mergeCells('A1:G1');//合并

            	$sheet->row(1,['数据标题']);
                $sheet->row(2,$cellData);

            });// 导出文件
        })->export('xls');
	}

	//文件上传保存方法
    public function uploader(Request $request){
    	// 开始做文件上传
    	if($request -> file('file') -> isValid() && $request -> hasFile('file')){
    		// 上传处理
    		// 对文件进行重新命名，防止重复
    		$filename = sha1(time() . rand(100000,999999)) . '.' . $request -> file('file') -> getClientOriginalExtension();
    		// dd($filename);
    		$result = Storage::disk('public') -> put($filename,file_get_contents($request -> file('file') -> path()));
    		// dd($result);
    		// 返回信息
    		if($result){
    			//成功
    			$response = ['code' => 0,'msg' => '上传成功！','filepath' => '/storage/' . $filename];
    		}else{
    			//失败
    			$response = ['code' => 1,'msg' => $request -> file('file') -> getErrorMessage()];
    		}
    	}else{
    		// 返回值
    		$response = ['code' => 2,'msg' => '非法上传文件！'];
    	}
    	// 输出结果
    	return response() -> json($response);
    }

    //比赛数据添加
    public function add(Request $res){
    	//获取比赛信息
		$matchinfos = DB::table('matchinfo')
		->leftjoin('player as a','matchinfo.playerA_id','=','a.id')
		->leftjoin('player as b','matchinfo.playerB_id','=','b.id')
		->select('a.name as playerAname','b.name as playerBname','matchinfo.id','matchinfo.match_name','matchinfo.match_phase','matchinfo.match_item','matchinfo.playerA_id','matchinfo.playerB_id')
		->get();
		//获取局数
		$rounds = DB::table('round')->select('id','name')->get();
    	if($res->method() == 'GET'){
    		return view('admin.matchdata.add',compact('matchinfos','rounds'));
    	}else{
    		$data = $res->except('_token');
    		// dd($data);
    		$res = DB::table('matchdata')->insert($data);
    		if($res){
    			$info = '添加成功';
    			return view('admin.matchdata.add',compact('matchinfos','rounds','info'));
    		}else{
    			$info = '添加失败';
    			return view('admin.matchdata.add',compact('matchinfos','rounds','info'));
    		}
    	}
    }

    //比赛数据修改
    public function edit(Request $res){
    	if($res->method() == 'GET'){
    		//获取局数
    		$rounds = DB::table('round')->select('id','name')->get();
    		//获取选中记录信息
    		$data = DB::table('matchdata')->where('id',$res->input('id'))->first();
    		return view('admin.matchdata.edit',compact('rounds','data'));
    	}else{
    		$data = $res->except('_token','id');
    		DB::table('matchdata')->where('id',$res->input('id'))->update($data);
    		exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
    	}
    }

    //删除比赛数据
    public function delete(Request $res){
    	$id = $res->input('id');
    	$result = DB::table('matchdata')->where('id',$id)->update(['status' => '1']);
    	if($result){
    		exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
    	}else{
    		exit(json_encode(array('code'=>1,'msg'=>'删除失败')));
    	}
    }

    //处理上传数据
    public function manageExceldata($arr, $post){
  		$rounds = [];
    	foreach ($arr as $key => $value) {
    		if($value['round_id'] == 1){
    			$rounds['round1'][] = $value['get_lose'];
    			continue;
    		}
    		if($value['round_id'] == 2){
    			$rounds['round2'][] = $value['get_lose'];
    			continue;
    		}
    		if($value['round_id'] == 3){
    			$rounds['round3'][] = $value['get_lose'];
    			continue;
    		}
    		if($value['round_id'] == 4){
    			$rounds['round4'][] = $value['get_lose'];
    			continue;
    		}
    		if($value['round_id'] == 5){
    			$rounds['round5'][] = $value['get_lose'];
    			continue;
    		}
    		if($value['round_id'] == 6){
    			$rounds['round6'][] = $value['get_lose'];
    			continue;
    		}
    		if($value['round_id'] == 7){
    			$rounds['round7'][] = $value['get_lose'];
    			continue;
    		}
    	}
         $totalScore = [];
        //设置该场比赛成绩作废
        DB::table('score')->where('match_id',$post['matchname'])->update(['status' => 1]);
        //获取上传数据对应的运动员
        // dd($post);
        $match = DB::table('matchinfo')->where(['id' => $post['matchname'],'playerA_id' => $post['playername']])->get();
        //判断是否是A运动员的成绩
        if($match->first()){
            //是这场比赛运动员A的比赛成绩 插入数据表
            $totalScore = $this->getTotalScore($rounds);
        }else{
            //是这场比赛运动员B的比赛成绩 成绩取反 插入数据表
            $totalScore = $this->getTotalScore($rounds,1);
        }
        //获取总比分信息
    	$data['match_id'] = $post['matchname'];
    	$data['bigscore'] = $totalScore['big'];
        $data['smallscore'] = implode(' ', $totalScore['small']);
    	DB::table('score')->insert($data);
    }

    //计算比分
    private function getTotalScore($arr,$flag = 0){
    	$scoreinfos = [];
    	foreach ($arr as $key => $value) {
    		$scoreinfos[] = $this->getSmallScore($value,$flag);
    	}
        // echo $flag;
        // dd($scoreinfos);
    	$yCount = 0;
    	$nCount = 0;
    	$smallScore = [];
    	foreach ($scoreinfos as $key => $value) {
    		$value[1] == 'y' ? $yCount++ : $nCount++;
    		$smallScore[] = $value[0];
    	}
        if($flag == 1){
            $totalScore['big'] = $nCount.':'.$yCount;
        }else{
            $totalScore['big'] = $yCount.':'.$nCount;
        }
    	
    	$totalScore['small'] = $smallScore;
    	return $totalScore;
    }

    //获取小比分信息
    private function getSmallScore($arr, $flag = 0){
    	$getCount = 0;
    	$loseCount = 0;
    	$arr = array_count_values($arr);
        if($flag == 1){
            $smlScore[] = $arr['失'].'-'.$arr['得'];
        }else{
            $smlScore[] = $arr['得'].'-'.$arr['失'];
        }
    	if($arr['得'] > $arr['失']){
    		$smlScore[] = 'y';
    	}else{
    		$smlScore[] = 'n';
    	}

    	return $smlScore;
    }

}
