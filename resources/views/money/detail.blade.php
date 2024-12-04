<?php
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger sticky-top mb-5" >
        <a class="navbar-brand" href="{{route('money.index')}}">MoneyWars</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-start" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="{{route('money.index')}}">集計グラフ</a>
            </li>
            {{-- <li class="nav-item active">
              <a class="nav-link" href="#" data-toggle="modal" data-target="#dataCreate">新規作成</a>
            </li> --}}
          </ul>
        </div>
    </nav>
    @if(session('message'))
      <div id="alert" class="alert alert-success">{{session('message')}}</div>
    @endif
    <div class="mx-auto col-12" style="text-align:center;margin-top:85px;">
        <div class="table-responsive-sm text-nowrap">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">日付</th>
                        <th class="text-center">カテゴリ</th>
                        <th class="text-center">項目名</th>
                        <th class="text-center">店舗種別</th>
                        <th class="text-center">支出額</th>
                        <th class="text-center">編集</th>
                        <th class="text-center">削除</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($results) && !empty($results)){
                      foreach($results as $result){
                          echo '<tr>';
                          echo '<td>'.$result->id.'</td>';
                          echo '<td>'.date('Y-m-d',strtotime($result->tgt_date)).'</td>';
                          echo '<td>'.$result->tgt_itemName.'</td>';
                          echo '<td class="text-center">'.$result->tgt_name.'</td>';
                          echo '<td class="text-center">'.$result->tgt_storetype.'</td>';
                          echo '<td class="text-center">'.$result->tgt_payment.'</td>';
                          echo '<td class="text-center">';
                          echo '<button type="button" class="btn btn-primary" data-toggle="modal" onclick="row_updatedata(this)" data-id="'.$result->id.'"data-target="#dataUpdate" data-tgt_date="'.date('Y-m-d',strtotime($result->tgt_date)).'" data-tgt_item="'.$result->tgt_item.'" data-tgt_storetype="'.$result->tgt_storetype.'" data-tgt_payment="'.$result->tgt_payment.'" data-tgt_name="'.$result->tgt_name.'">';
                          echo '編集';
                          echo '</button>';
                          echo '</td>';
                          echo '<td class="text-center">';
                            echo '<button type="button" class="btn btn-danger" data-toggle="modal" onclick="row_deletedata(this)" data-id="'.$result->id.'"data-target="#dataDelete" data-tgt_date="'.date('Y-m-d',strtotime($result->tgt_date)).'" data-tgt_item="'.$result->tgt_item.'" data-tgt_storetype="'.$result->tgt_storetype.'" data-tgt_payment="'.$result->tgt_payment.'" data-tgt_name="'.$result->tgt_name.'">';
                          echo '削除';
                          echo '</button>';
                          echo '</td>';
                          echo '</tr>';
                      }
                    }else{
                      echo "データなし";
                    }
                    ?>
                </tbody>
            </table>
          <div class="d-flex justify-content-center mt-5">
              {{-- {!! $results->links() !!} --}}
          </div>
      </div>

    <!-- ここに本文を記述します -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.ja.min.js"></script>
    <script type="text/javascript">
      $(function(){
        setTimeout(function () {
            //保存後に画面がリダイレクトされることを利用している
            $('#alert').fadeOut(3000);
        }, 3000);

      });

    function row_updatedata(data) {
        let id = data.dataset.id;//id
        let tgt_date =data.dataset.tgt_date;//支出日
        let tgt_item = data.dataset.tgt_item;//アイテム番号
        let tgt_storetype = data.dataset.tgt_storetype;//店舗種別
        let tgt_payment = data.dataset.tgt_payment;//支出額
        let tgt_name = data.dataset.tgt_name;//項目名
        $('#updateId').val(id);
        var modal = $(this);
        $('#dataUpdate').on('show.bs.modal', function(e) {
            var modal = $(this);
            modal.find('#uid').val(id);
            modal.find('#utgt_date').val(tgt_date);
            modal.find('#utgt_item').val(tgt_item);
            modal.find('#utgt_storetype').val(tgt_storetype);
            modal.find('#utgt_payment').val(tgt_payment);
            modal.find('#utgt_name').val(tgt_name);
        });
    }
    function row_deletedata(data) {
        let id = data.dataset.id;//id
        let tgt_date =data.dataset.tgt_date;//支出日
        let tgt_item = data.dataset.tgt_item;//アイテム番号
        let tgt_storetype = data.dataset.tgt_storetype;//店舗種別
        let tgt_payment = data.dataset.tgt_payment;//支出額
        let tgt_name = data.dataset.tgt_name;//項目名
        $('#dataDelete').on('show.bs.modal', function(e) {
            var modal = $(this);
            modal.find('#did').val(id);
            modal.find('#dtgt_date').val(tgt_date);
            modal.find('#dtgt_item').val(tgt_item);
            modal.find('#dtgt_storetype').val(tgt_storetype);
            modal.find('#dtgt_payment').val(tgt_payment);
            modal.find('#dtgt_name').val(tgt_name);
        });
    }
    </script>
  </body>
</html>
<!-- 編集モーダルダイアログ -->
<div class="modal fade" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">編集</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form method="post" action="{{route('money.update')}}" class="form-inline" enctype="multipart/form-data" autocomplete="off">
              @csrf
              @method('patch')
              <div class="modal-body">
                  <div class="row">
                      <div class="form-group mb-1" style="width:100%;">
                          <span class="col-3">日付</span>
                          <input type="text" class="datepicker datepicker-dropdown" id="utgt_date" name="utgt_date">
                      </div>
                      <br />
                      <div class="form-group mb-1" style="width:100%;">
                          <span class="col-3">種類</span>
                          <select name="utgt_item" id="utgt_item" class="browser-default custom-select">
                              <?php echo $cate_data; ?>
                          </select>
                      </div>
                      <div class="form-group mb-1" style="width:100%;">
                        <span class="col-3">項目名</span>
                        <input type="text" id="utgt_name" name="utgt_name" class="form-control">
                      </div>
                      <div class="form-group mb-1" style="width:100%;">
                          <span class="col-3">店舗種別</span>
                          <select name="utgt_storetype" id="utgt_storetype" class="browser-default custom-select">
                              <?php echo $store_data; ?>
                          </select>
                      </div>
                      <div class="form-group mb-1" style="width:100%;">
                          <span class="col-3">支出額</span>
                          <input type="text" id="utgt_payment" name="utgt_payment" class="form-control">
                      </div>
                  </div>
                  <input type="hidden" name="uid" id="uid">
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
<!-- 削除モーダルダイアログ -->
<div class="modal fade" id="dataDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">削除</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('money.destroy')}}" class="form-inline" enctype="multipart/form-data" autocomplete="off">
                @csrf
                {{-- @method('delete') --}}
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group mb-1" style="width:100%;">
                            <span class="col-3">日付</span>
                            <input type="text" class="datepicker datepicker-dropdown" disabled="disabled" id="dtgt_date" name="dtgt_date">
                        </div>
                        <br />
                        <div class="form-group mb-1" style="width:100%;">
                            <span class="col-3">種類</span>
                            <select name="dtgt_item" id="dtgt_item" disabled="disabled" class="browser-default custom-select">
                                <?php echo $cate_data; ?>
                            </select>
                        </div>
                        <div class="form-group mb-1" style="width:100%;">
                            <span class="col-3">項目名</span>
                            <input type="text" id="dtgt_name" name="dtgt_name" disabled="disabled" class="form-control">
                         </div>
                         <div class="form-group mb-1" style="width:100%;">
                            <span class="col-3">店舗種別</span>
                            <select name="dtgt_storetype" id="dtgt_storetype" class="browser-default custom-select">
                                <?php echo $store_data; ?>
                            </select>
                        </div>
                        <div class="form-group mb-1" style="width:100%;">
                            <span class="col-3">支出額</span>
                            <input type="text" id="dtgt_payment" name="dtgt_payment" disabled="disabled" class="form-control">
                        </div>
                    </div>
                    <input type="hidden" name="did" id="did">
                    <div class="modal-footer text-right">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                      <button type="submit" class="btn btn-danger">削除</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>