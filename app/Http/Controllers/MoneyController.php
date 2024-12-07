<?php

namespace App\Http\Controllers;

use App\Models\Spending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class MoneyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        // 初期データ（必要に応じて変更可能）
        $tgtdate = $request->query('tgtdate', Carbon::now()->format('Y-m-d'));

        return view('money.index', compact('tgtdate'));

    }


    public function getJsonData(Request $request){

        // $tgtdate = $tgtdate ?? Carbon::now()->format('Y-m-d');
        $tgtdate = $request->input('tgtdate', Carbon::now()->format('Y-m-d'));
        // Log::info('getJsonData(1) '.$year.'-'.$month);
        $year = Carbon::parse($tgtdate)->year;
        $month = Carbon::parse($tgtdate)->month;
        $data = [
            'year' => $year,
            'month' => $month,
            'event' => [
                ['day' => '1', 'title' => 'イベント1', 'type' => 'blue'],
                ['day' => '2', 'title' => 'イベント2', 'type' => 'red'],
                ['day' => '3', 'title' => 'イベント3', 'type' => 'green'],
                ['day' => '3', 'title' => 'イベント4'],
                ['day' => '5', 'title' => 'イベント5', 'type' => 'blue'],
                ['day' => '5', 'title' => 'イベント6', 'type' => 'red'],
                ['day' => '7', 'title' => 'イベント7'],
                ['day' => '8', 'title' => 'イベント8', 'type' => 'blue'],
                ['day' => '8', 'title' => 'イベント9'],
                ['day' => '10', 'title' => 'イベント10'],
                ['day' => '10', 'title' => 'イベント11'],
                ['day' => '12', 'title' => 'イベント12', 'type' => 'green'],
                ['day' => '14', 'title' => 'イベント13'],
                ['day' => '14', 'title' => 'イベント14', 'type' => 'red'],
                ['day' => '15', 'title' => 'イベント15', 'type' => 'blue'],
                ['day' => '17', 'title' => 'イベント16'],
                ['day' => '19', 'title' => 'イベント17', 'type' => 'blue'],
                ['day' => '21', 'title' => 'イベント18'],
                ['day' => '24', 'title' => 'イベント19', 'type' => 'red'],
                ['day' => '24', 'title' => 'イベント20'],
                ['day' => '26', 'title' => 'イベント21', 'type' => 'green'],
                ['day' => '28', 'title' => 'イベント22', 'type' => 'blue'],
                ['day' => '28', 'title' => 'イベント23'],
                ['day' => '28', 'title' => 'イベント24', 'type' => 'green'],
                ['day' => '29', 'title' => 'イベント25', 'type' => 'red'],
                ['day' => '29', 'title' => 'イベント26'],
            ],
            'holiday' => ['3', '4', '5'],
        ];
        Log::info('getJsonData(2) '.$year.'-'.$month);
        // JSONデータを返却
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('money.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd('store '.$request->tgt_date);
        $spending=new Spending();
        $spending->tgt_date=date('Y-m-d',strtotime($request->tgt_date));
        $spending->tgt_item=$request->tgt_item;
        $spending->tgt_name=$request->tgt_name;
        $spending->tgt_storetype=$request->tgt_storetype;
        $spending->tgt_payment=$request->tgt_payment;
        $spending->save();

        return redirect()->to('money')->with('message', 'データを保存しました');
    }

    /**
     * Display the specified resource.
     */
    public function show($message)
    {
        // $results= Spending::where('tgt_date','=',$_GET['tgt_date'])->get();
        $results = Spending::select([
            'spendings.id as id',
            'spendings.tgt_date as tgt_date',
            'spendings.tgt_item as tgt_item',
            'c.cate_name as tgt_itemName',
            'spendings.tgt_name as tgt_name',
            'spendings.tgt_payment as tgt_payment',
            'spendings.tgt_storetype as tgt_storetype',
          ])
          ->join('categories as c','c.cate_num','=','spendings.tgt_item')
          ->where('spendings.tgt_date','=',$_GET['tgt_date'])
          ->get();

        // dd($results);

        $categories = DB::table('categories')
        ->select('cate_num','cate_name')
        ->orderBy('cate_num','asc')
        ->get();
        //店舗種類一覧
        $storetypes = DB::table('storetypes')
        ->select('store_num','store_name')
        ->orderBy('store_num','asc')
        ->get();
        return view('money.detail',compact('results','categories','storetypes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // $spending = Spending::find($request->id);
        // $spending->tgt_date=date('Y-m-d',strtotime($request->tgt_date));
        // $spending->tgt_item=$request->tgt_item;
        // $spending->tgt_payment=$request->tgt_payment;
        // $spending->tgt_name=$request->tgt_name;
        // $spending->save();
        // return redirect()->to('money')->with('message', 'データを修正しました');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->utgt_date);
        $spending = Spending::find($request->uid);
        $spending->tgt_date=date('Y-m-d',strtotime($request->utgt_date));
        $spending->tgt_item=$request->utgt_item;
        $spending->tgt_storetype=$request->utgt_storetype;
        $spending->tgt_payment=$request->utgt_payment;
        $spending->tgt_name=$request->utgt_name;
        $spending->save();
        return redirect()->to('money')->with('message', 'データを修正しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $spending = Spending::find($request->did);
        $spending->delete();
        return redirect()->to('money')->with('message', 'データを削除しました');
    }

    public function preweek(Request $request){

        $start_day = date("Y-m-d",strtotime("-7 day",strtotime($request->preweek)));
        $tgt_date = array();
        $tgt_sumvalue = array();
        $tmp = array();

        $end_day = date('Y-m-d', strtotime("+6 day", strtotime($start_day)));

        if(is_array($tgt_date) && empty($tgt_date)){
            $targetDate = $start_day;
            for($i=0;$i<7;$i++){
                array_push($tgt_date,date("Y-m-d",strtotime("+{$i} day",strtotime($targetDate))));
            }
        }

        if(is_array($tgt_date)){
            $targetDate = $start_day;
            for($i=0;$i<7;$i++){
                $tmp[date("Y-m-d",strtotime("+{$i} day",strtotime($targetDate)))]=0;
            }
        }
        
        //指定週間のデータ取得
        $results=Spending::groupBy('tgt_date')
        ->select('tgt_date',DB::raw('sum(tgt_payment) as sumvalue'))
        ->whereBetween('tgt_date',[$start_day,$end_day])
        ->get();

        foreach($tmp as $key => $val){
            foreach ($results as $result) {
                if($result['tgt_date']==$key){
                    $tmp[$key] = $result['sumvalue'];
                }
            }
        }

        foreach($tmp as $val){
            array_push($tgt_sumvalue,$val);
        }
    
        //指定月間の合計値の取得
        $tmpactualresults=Spending::select(DB::raw('sum(tgt_payment) as sumvalue'))
        ->where('tgt_date','like','%'.date('Y-m').'%')
        ->get();

        foreach($tmpactualresults as $val){
            $actualresults = $val['sumvalue'];
        }

        $categories = DB::table('categories')
        ->select('cate_num','cate_name')
        ->orderBy('cate_num','asc')
        ->get();
        //店舗種類一覧
        $storetypes = DB::table('storetypes')
        ->select('store_num','store_name')
        ->orderBy('store_num','asc')
        ->get();
        //Amazon使用回数
        $first_date = date("Y-m-01");
        $last_date = date("Y-m-t");
        $amazoncount=Spending::select(DB::raw('sum(tgt_payment) as amazoncnt'))
        ->where('tgt_storetype','=',11)
        ->whereBetween('tgt_date',[$first_date,$last_date])
        ->get();
        // dd($amazoncount->toSql(),$amazoncount->getBindings());
        // dd($amazoncount[0]['amazoncnt']);
        $amazoncount = $amazoncount[0]['amazoncnt'];
        return view('money.index',compact('tgt_date','tgt_sumvalue','categories','storetypes','actualresults','amazoncount'));
    }

    public function nextweek(Request $request){

        $start_day = date("Y-m-d",strtotime("+7 day",strtotime($request->nextweek)));
        $tgt_date = array();
        $tgt_sumvalue = array();
        $tmp = array();

        $end_day = date('Y-m-d', strtotime("+6 day", strtotime($start_day)));

        //1週間分の日付を揃える
        if(is_array($tgt_date) && empty($tgt_date)){
            $targetDate = $start_day;
            for($i=0;$i<7;$i++){
                array_push($tgt_date,date("Y-m-d",strtotime("+{$i} day",strtotime($targetDate))));
            }
        }
        //1週間分のデータで空の場合は0をセットする
        if(is_array($tgt_date)){
            $targetDate = $start_day;
            for($i=0;$i<7;$i++){
                $tmp[date("Y-m-d",strtotime("+{$i} day",strtotime($targetDate)))]=0;
            }
        }
        
        //指定週間のデータ取得
        $results=Spending::groupBy('tgt_date')
        ->select('tgt_date',DB::raw('sum(tgt_payment) as sumvalue'))
        ->whereBetween('tgt_date',[$start_day,$end_day])
        ->get();

        //用意した1週間分の日付にその日付の合計値を格納する
        foreach($tmp as $key => $val){
            foreach ($results as $result) {
                if($result['tgt_date']==$key){
                    $tmp[$key] = $result['sumvalue'];
                }
            }
        }

        //処理が冗長な気がする？$tmpで良いのではないかしら？
        foreach($tmp as $val){
            array_push($tgt_sumvalue,$val);
        }
    
        //指定月間の合計値の取得
        $tmpactualresults=Spending::select(DB::raw('sum(tgt_payment) as sumvalue'))
        ->where('tgt_date','like','%'.date('Y-m').'%')
        ->get();

        foreach($tmpactualresults as $val){
            $actualresults = $val['sumvalue'];
        }

        $categories = DB::table('categories')
        ->select('cate_num','cate_name')
        ->orderBy('cate_num','asc')
        ->get();
        //店舗種類一覧
        $storetypes = DB::table('storetypes')
        ->select('store_num','store_name')
        ->orderBy('store_num','asc')
        ->get();
        //Amazon使用回数
        $first_date = date("Y-m-01");
        $last_date = date("Y-m-t");
        $amazoncount=Spending::select(DB::raw('sum(tgt_payment) as amazoncnt'))
        ->where('tgt_storetype','=',11)
        ->whereBetween('tgt_date',[$first_date,$last_date])
        ->get();
        // dd($amazoncount->toSql(),$amazoncount->getBindings());
        // dd($amazoncount[0]['amazoncnt']);
        $amazoncount = $amazoncount[0]['amazoncnt'];
        return view('money.index',compact('tgt_date','tgt_sumvalue','categories','storetypes','actualresults','amazoncount'));

    }
}