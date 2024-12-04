<?php
header("Cache-Control: private");
session_cache_limiter('none');
  $firstDate = $tgt_date[0];
  $tgt_date = json_encode($tgt_date);
  $tgt_dates = $tgt_date;
  $tgt_sumvalue = json_encode($tgt_sumvalue);
  $cate_data="";
  //戻りがオブジェクト型
  foreach($categories as $val){
      $cate_data .= "<option value='". $val->cate_num;
      $cate_data .= "'>". $val->cate_name. "</option>";
  }
  $store_data="";
  //戻りがオブジェクト型
  foreach($storetypes as $val){
      $store_data .= "<option value='". $val->store_num;
      $store_data .= "'>". $val->store_name. "</option>";
  }

  $actualresults=120000;
?>
<!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="shortcut icon" href="{{ asset('/money.png') }}">
    <title>MoneyWars</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger sticky-top mb-0" >
        <a class="navbar-brand" href="{{route('money.index')}}">MoneyWars</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-start" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="{{route('money.index')}}">集計グラフ</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#" data-toggle="modal" data-target="#dataCreate">新規作成</a>
            </li>
          </ul>
        </div>
    </nav>
    @if(session('message'))
    <div id="alert" class="alert alert-success">{{session('message')}}</div>
    @endif

    <div class="row form-container my-3">
      <div class="container d-flex justify-content-between align-items-center my-1">
          <!-- 左端の「前週」ボタン -->
          <div>
              <a href="{{route('money.preweek')}}?preweek=<?php echo $firstDate; ?>" 
                class="btn btn-outline-danger btn-lg" 
                style="padding: 20px 40px; font-size: 1.5rem;">
                  前週
              </a>
          </div>

          <!-- 中央の目標値と合計を横並びに -->
          <div class="d-flex justify-content-center align-items-center">
              <div class="text-center mx-3">
                  <label class="col-form-label" style="font-size: 1.5rem;">月間目標値</label>
                  <label class="col-form-label" style="font-size: 1.5rem;">
                      <mark><strong>100,000</strong></mark>
                  </label>
              </div>
              <div class="text-center mx-3">
                  <label class="col-form-label" style="font-size: 1.5rem;"><?php echo date('m'); ?>月合計</label>
                  <label class="col-form-label" style="font-size: 1.5rem;">
                      <mark><strong><?php echo number_format($actualresults) ?></strong></mark>
                  </label>
              </div>
          </div>

          <!-- 右端の「次週」ボタン -->
          <div>
              <a href="{{route('money.nextweek')}}?nextweek=<?php echo $firstDate; ?>" 
                class="btn btn-outline-danger btn-lg" 
                style="padding: 20px 40px; font-size: 1.5rem;">
                  次週
              </a>
          </div>
      </div>

      <!-- 下部のエラーメッセージ -->
      <div class="container d-flex justify-content-center my-0 text-center flex-wrap">
          <?php if(isset($actualresults) && intval($actualresults) > intval(80000)) :?>
              <div class="mx-3">
                  <label class="col-form-label"><strong style="color:red;font-size:20px;">予算 OVER</strong></label>
              </div>
          <?php endif; ?>
          <?php if(isset($amazoncount) && intval($amazoncount) > intval(50000)) :?>
              <div class="mx-3">
                  <label class="col-form-label"><strong style="color:red;font-size:20px;">Amazon OVER</strong></label>
              </div>
          <?php endif; ?>
      </div>
  </div>

    <div id="wrap">
        <div id="mini-calendar"></div>
    </div>
    <!-- ここに本文を記述します -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/js/jquery.minicalendar.js"></script>
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
      tgt_dates = <?php echo $tgt_dates; ?>;

      $(function(){
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
<div class="modal fade" id="dataCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">新規作成</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form method="post" action="{{route('money.store')}}" class="form-inline" enctype="multipart/form-data" autocomplete="off">
              @csrf
              <div class="modal-body">
                  <div class="row">
                      <div class="form-group mb-1" style="width:100%;">
                          <span class="col-3">日付</span>
                          <input type="text" class="datepicker datepicker-dropdown" id="tgt_date" name="tgt_date">
                      </div>
                      <br />
                      <div class="form-group mb-1" style="width:100%;">
                          <span class="col-3">種類</span>
                          <select name="tgt_item" id="tgt_item" class="browser-default custom-select">
                              <?php echo $cate_data; ?>
                          </select>
                      </div>
                      <div class="form-group mb-1" style="width:100%;">
                          <span class="col-3">項目名</span>
                          <input type="text" id="tgt_name" name="tgt_name" class="form-control">
                      </div>
                      <div class="form-group mb-1" style="width:100%;">
                          <span class="col-3">店舗種別</span>
                          <select name="tgt_storetype" id="tgt_storetype" class="browser-default custom-select">
                              <?php echo $store_data; ?>
                          </select>
                      </div>
                      <div class="form-group mb-1" style="width:100%;">
                          <span class="col-3">支出額</span>
                          <input type="text" id="tgt_payment" name="tgt_payment" class="form-control">
                      </div>
                  </div>
                  <div class="modal-footer text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-primary">保存</button>
                  </div>
              </div>
          </form>
      </div>
    </div>
  </div>
</div>