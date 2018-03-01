<?php
session_start();
include("functions.php");
chkSsid();

//$_SESSION["lid"]の有無を判定（ログインの後か前か判定）
if(!isset($_SESSION["lid"]) || $_SESSION["lid"]=="" ){
  $a = "ゲスト";//ログイン前ならゲスト表記
}else{
  $a = $_SESSION["lid"];//ログイン後なら$_SESSION["lid"]を表記
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>記事登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    div{padding: 10px;font-size:16px;}
    input{width:800px;}

  </style>

</head>
<body>

<!-- Head[Start] -->
<!-- ログインメニュー -->
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

<!-- ログインの有無により表示する名前を変更 -->
<div><?=$a?>さん、こんにちは</div>

<!-- Main[Start] -->
<form method="post" action="insert.php"  enctype="multipart/form-data">
  <div class="jumbotron">
   <fieldset>
    <legend>記事登録</legend>
    <label>タイトル：<input type="text" name="title"></label><br>
    <span>カテゴリー：</span>
    <select name="category">
      <option value="cate1">cate1</option>
      <option value="cate2">cate2</option>
      <option value="cate3">cate3</option>
      <option value="other">other</option>
    </select><br>
    <!-- <label>カテゴリ：<input type="text" name="category"></label><br> -->
    <span>見出し画像：</span><input type="file" name="upfile"><br>
    内容：<br>
    <label><textArea name="detail" rows="40" cols="100"></textArea></label><br>
    <input type="submit" value="送信">
    </fieldset>
  </div>
</form>


<!-- Main[End] -->


</body>
</html>
