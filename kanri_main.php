<?php
session_start();
//0.外部ファイル読み込み
include("functions.php");
chkSsid();
//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM content ORDER BY time DESC");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
  queryError($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<p>';
    $view .= '<a href="detail_after.php?id='.$result["id"].'">';
    $view .= "『";
    $view .= h($result["title"]);
    $view .= "』";
    $view .= '</a>　';

    $view .='<a href="kanri_contents_delete.php?id='.$result["id"].'">';
    $view .='[削除]';
    $view .='</a>';
    $view .= '</p>';

  }
}
$lid = $_SESSION["lid"];

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>メイン</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
  div{padding: 10px;font-size:16px;}
</style>
</head>
<body id="main">
<!-- Head[Start] -->
<!-- ログイン前メニュー -->
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
<div><?= $lid ?>さん、こんにちは</div>

<!-- Main[Start] -->
<div>
  <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
