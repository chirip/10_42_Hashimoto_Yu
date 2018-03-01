<?php
session_start();
//0.外部ファイル読み込み
include("functions.php");
chkSsid();

//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM content");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
  queryError($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<p>';
    $view .= '<a href="detail_after_main.php?id='.$result["id"].'">';
    $view .= "『";
    $view .= h($result["bookname"]);
    $view .= "』";
    $view .= '</a>　';
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
<title>メイン(ログイン)</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<!-- ログイン後メニュー -->
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
        <div class="navbar-header">
            <?php if($_SESSION["kanri_flg"]=="0"){ ?>
            <a class="navbar-brand" href="main_after.php">メイン</a>
            <a class="navbar-brand" href="my_page.php">マイページ</a>
            <a class="navbar-brand" href="index.php">書籍登録</a>
            <a class="navbar-brand" href="logout.php">ログアウト</a>
            <?php } ?>

            <!-- 管理者用メニュー表示 -->
            <?php if($_SESSION["kanri_flg"]=="1"){ ?>
                <a class="navbar-brand" href="kanri_main.php">書籍管理</a>
                <a class="navbar-brand" href="kanri.php">ユーザー管理</a>
                <a class="navbar-brand" href="logout.php">ログアウト</a>
            <?php } ?>
        </div>
    </nav>
</header>

<!-- Head[End] -->
<div><?= $lid ?>さん、こんにちは</div>

<!-- Main[Start] -->
<div>
  <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
