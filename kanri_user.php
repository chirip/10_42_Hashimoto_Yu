<?php
session_start();
//0.外部ファイル読み込み
include("functions.php");
chkSsid();

//$_SESSION["lid"]の有無を判定（ログインの後か前か判定）
if(!isset($_SESSION["lid"]) || $_SESSION["lid"]=="" ){
  $a = "ゲスト";//ログイン前ならゲスト表記
}else{
  $a = $_SESSION["lid"];//ログイン後なら$_SESSION["lid"]を表記
}

//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM user_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  error_db_info();
  
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .='<tr>';

    $view .='<td>';
    $view .='<a href="kanri_user_detail.php?user_id='.$result["user_id"].'">';
    $view .= $result["lid"];
    $view .='</a>';    
    $view .='</td>';

    $view .='<td>';
    $view .= $result["lpw"];
    $view .='</td>';

    $view .='<td>';
    $view .= $result["kanri_flg"];
    $view .='</td>';

    $view .='<td>';
    $view .= $result["life_flg"];
    $view .='</td>';

    $view .='<td>';
    $view .='<a href="kanri_delete.php?user_id='.$result["user_id"].'">';
    $view .='[削除]';
    $view .='</a>';
    $view .='</td>';
    
    $view .='</tr>';
    
  
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ユーザー表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
  div{padding: 10px;font-size:16px;}
  table{  width: 100%; margin:15px;}
  legend{margin-left: 10px;}
</style>
</head>
<body id="main">
<!-- Head[Start] -->
<!-- ログイン後メニュー -->
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
        <div class="navbar-header">
            <!-- 一般用メニュー表示 kanri_flg=0 -->
            <?php if($_SESSION["kanri_flg"]=="0"){ ?>
              <a class="navbar-brand" href="main.php">メイン</a>
            <a class="navbar-brand" href="kanri_main.php">自己記事一覧</a>
            <a class="navbar-brand" href="index.php">記事作成</a>
            <a class="navbar-brand" href="new_account.php">ユーザー作成</a>
            <a class="navbar-brand" href="login.php">ログイン</a>
            <a class="navbar-brand" href="logout.php">ログアウト</a>
            <?php } ?>

            <!-- 管理者用メニュー表示 kanri_flg=1 -->
            <?php if($_SESSION["kanri_flg"]=="1"){ ?>
              <a class="navbar-brand" href="main.php">メイン</a>
            <a class="navbar-brand" href="kanri_main.php">記事一覧</a>
            <a class="navbar-brand" href="kanri_user.php">ユーザー一覧</a>
            <a class="navbar-brand" href="index.php">記事作成</a>
            <a class="navbar-brand" href="new_account.php">ユーザー作成</a>
            <a class="navbar-brand" href="login.php">ログイン</a>
            <a class="navbar-brand" href="logout.php">ログアウト</a>
            <?php } ?>
        </div>
    </nav>
<header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div><?=$a?>さん、こんにちは</div>

<div>
  <div class="container jumbotron">
    <legend>ユーザー一覧</legend>
    <table>
      <tr>
      <th>ID</th>
      <th>PASS</th>
      <th>管理</th>
      <th>LIFE</th>
      <th>削除</th>
      </tr>
      <?=$view?>
    </table>
  </div>
</div>
<!-- Main[End] -->

</body>
</html>
