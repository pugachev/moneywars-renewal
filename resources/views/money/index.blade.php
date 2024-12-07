<?php
header("Cache-Control: private");
session_cache_limiter('none');
  // $firstDate = $tgt_date[0];
  // $tgt_date = json_encode($tgt_date);
  // $tgt_dates = $tgt_date;
  // $tgt_sumvalue = json_encode($tgt_sumvalue);
  // $cate_data="";
  // //戻りがオブジェクト型
  // foreach($categories as $val){
  //     $cate_data .= "<option value='". $val->cate_num;
  //     $cate_data .= "'>". $val->cate_name. "</option>";
  // }
  // $store_data="";
  // //戻りがオブジェクト型
  // foreach($storetypes as $val){
  //     $store_data .= "<option value='". $val->store_num;
  //     $store_data .= "'>". $val->store_name. "</option>";
  // }

  $actualresults=120000;
?>
<!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="shortcut icon" href="{{ asset('/money.png') }}">
    <title>MoneyWars</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger sticky-top mb-0">
        <a class="navbar-brand" href="{{route('money.index')}}">MoneyWars</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- 左側のナビゲーション -->
            <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item active d-flex align-items-center">
                    <span><a class="nav-link" href="#" data-toggle="modal" data-target="#dataCreate" style="color: #ffffff;font-weight: bold;">新規</a></span>
                    <!-- 月間目標値を新規作成の隣に配置 -->
                    <span class="ml-3 navbar-text" style="color: #ffffff;font-weight: bold;">月間目標 : 100000円</span>
                    <!-- 月間実測値を月間目標値の隣に配置 -->
                    <span class="ml-3 navbar-text" style="color: #ffffff;font-weight: bold;">月間実測 : <mark><strong><?php echo number_format($actualresults) ?></strong></mark>円</span>
                    <span class="ml-3 navbar-text" style="color: #000000;font-weight: bold;"><a id="prevMonth" class="btn btn-light btn-sm" style="color: black;">前月</a></sapn>
                    <span class="ml-3 navbar-text" style="color: #000000;font-weight: bold;"><a id="nextMonthLink" class="btn btn-light btn-sm" style="color: black;">翌月</a></sapn>
                </li>
            </ul>
        </div>
    </nav>
    @if(session('message'))
    <div id="alert" class="alert alert-success">{{session('message')}}</div>
    @endif

    <div id="wrap" class="mt-5 mb-5">
        <div id="mini-calendar"></div>
    </div>
    <!-- ここに本文を記述します -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('js/jquery.minicalendar.js') }}"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
      .form-container {
        display: flex;
        flex-direction: column; /* 縦方向に並べる */
        gap: 5px; /* フォーム間の余白を設定 */
      }
    </style>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.ja.min.js"></script>
    <script type="text/javascript">

      $(function(){

        // インスタンス生成
        var calendarInstance =  $('#miniCalendar').miniCalendar({ api: true });

        // 前月ボタンイベント
        $('#prevMonth').click(function() {
            const currentDate = new Date(calendarInstance.year, calendarInstance.month - 1, 1);
            const prevMonthDate = new Date(currentDate.setMonth(currentDate.getMonth() - 1));
            const formattedDate = `${prevMonthDate.getFullYear()}-${(prevMonthDate.getMonth() + 1).toString().padStart(2, '0')}-01`;
            const dispDate = `${prevMonthDate.getFullYear()}年${(prevMonthDate.getMonth() + 1).toString().padStart(2, '0')}月`;
            $('.calendar-year-month').text(dispDate);
            calendarInstance.loadData(formattedDate); // 前月データを取得
        });


        $('#nextMonth').click(function() {
            var currentMonth = new Date(self.year, self.month - 1, 1);
            var nextMonth = new Date(currentMonth.setMonth(currentMonth.getMonth() + 1));
            self.loadData(`${nextMonth.getFullYear()}-${(nextMonth.getMonth() + 1).toString().padStart(2, '0')}-01`);
        });
        // const BASE_URL = $('meta[name="base-url"]').attr('content');


        // const prevMonthDate = "{{ \Carbon\Carbon::now()->startOfMonth()->subMonth()->format('Y-m-d') }}";
        // // document.getElementById('prevMonthLink').href = `${BASE_URL}/money/json?tgtdate=${prevMonthDate}`;
        // document.getElementById('prevMonthLink').href = `${BASE_URL}/money/json?tgtdate=${prevMonthDate}`;

        // const nextMonthDate = "{{ \Carbon\Carbon::now()->startOfMonth()->addMonth()->format('Y-m-d') }}";
        // document.getElementById('nextMonthLink').href = `${BASE_URL}/money/json?tgtdate=${nextMonthDate}`;

        setTimeout(function () {
            //保存後に画面がリダイレクトされることを利用している
            $('#alert').fadeOut(3000);
        }, 3000);


        $('.datepicker.datepicker-dropdown').datepicker({
            language:'ja', // 日本語化
            format: 'yyyy-mm-dd', // 日付表示をyyyy/mm/ddにフォーマット
            beforeShow: function(input, inst){
                setTimeout(function(){
                    $('#tgt_date')
                        .css(
                            'z-index',
                            String(parseInt($(input).parents('.modal').css('z-index'),10) + 1)
                        );
                },0);
            }
        });

        $('#mini-calendar').miniCalendar();

      });
    </script>
    <stylesheet
  </body>
</html>
