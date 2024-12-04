<!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="shortcut icon" href="{{ asset('/money.png') }}">
    <title>タイトル</title>
  </head>
  <body>
    <nav class="navbar navbar-dark bg-dark">
        <a href="#" class="navbar-brand">Navbar</a>
        <button class="navbar-toggler" type="button"
            data-toggle="collapse"
            data-target="#navmenu1"
            aria-controls="navmenu1"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse m-3" id="navmenu1">
            <div class="navbar-nav">
            <a class="nav-item nav-link" href="#">Menu#1</a>
            <a class="nav-item nav-link" href="#">Menu#2</a>
            <a class="nav-item nav-link" href="#">Menu#3</a>
            </div>
        </div>
    </nav>
    <div class="mx-auto mt-5" style="width:40%;">
        <form>
            <div class="form-group">
            <label for="tgtitem">項目</label>
            <select class="form-control" id="tgtitem" style="width:25%;">
                <option value="0">食費</option>
                <option value="1">日用品</option>
                <option value="2">外食費</option>
                <option value="3">医療費</option>
                <option value="4">公共料金</option>
            </select>
            </div>
            <div class="form-group">
                <label for="tgtdate">日付</label>
                <input type="text" class="form-control" id="tgtdate" style="width:10%;">
            </div>
            <div class="form-group">
                <label for="tgtexpensive">出費額</label>
                <input type="text" class="form-control" id="tgtexpensive" style="width:25%;">
            </div>
        </form>
    </div>
    <!-- ここに本文を記述します -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../bootstrap-datepicker/css/bootstrap-datepicker.min.css">
    <script type="text/javascript" src="../bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="../bootstrap-datepicker/locales/bootstrap-datepicker.ja.min.js"></script>
    <script>
        $('#tgtdate').datepicker({
            format: 'yyyy/mm/dd'
        });
    </script>
  </body>
</html>