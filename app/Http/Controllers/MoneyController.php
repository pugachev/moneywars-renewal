<?php

namespace App\Http\Controllers;

use App\Models\Spending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MoneyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tgt_date = array();
        $tgt_sumvalue = array();
        
        //spendingsテーブルから当月・一週間分(日曜日開始)のデータを取得
        //今日日付の曜日番号取得
        $w = date("w",strtotime(date('Y-m-d')));
        //今週最初日付の取得
        $start_day = date('Y-m-d', strtotime("-{$w} day", strtotime(date('Y-m-d'))));
        //今週最後の日付取得
        $w = 6- $w;
        $end_day = date('Y-m-d', strtotime("+{$w} day", strtotime(date('Y-m-d'))));

        if(is_array($tgt_date) && empty($tgt_date)){
            $targetDate = $start_day;
            for($i=0;$i<7;$i++){
                array_push($tgt_date,date("Y-m-d",strtotime("+{$i} day",strtotime($targetDate))));
            }
        }

        //指定週間のデータ取得
        $results=Spending::groupBy('tgt_date')
        ->select('tgt_date',DB::raw('sum(tgt_payment) as sumvalue'))
        ->whereBetween('tgt_date',[$start_day,$end_day])
        ->get();

        foreach ($results as $result) {
            array_push($tgt_sumvalue,$result['sumvalue']);
        }

        // dd($tgt_sumvalue);

        //指定月間の合計値の取得
        $tmpactualresults=Spending::select(DB::raw('sum(tgt_payment) as sumvalue'))
        ->where('tgt_date','like','%'.date('Y-m').'%')
        ->get();

        foreach($tmpactualresults as $val){
            $actualresults = $val['sumvalue'];
        }

        //データ不足箇所を0詰め
        for($i=count($tgt_sumvalue);$i<7;$i++){
            array_push($tgt_sumvalue,0);
        }

        //カテゴリ一覧
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