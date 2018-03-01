<?php
session_start();
//0.外部ファイル読み込み
include("functions.php");
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>新規ユーザー作成</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<!-- ログイン前メニュー -->
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="main.php">メイン</a>
            <a class="navbar-brand" href="index.php">記事作成</a>
            <a class="navbar-brand" href="new_account.php">ユーザー作成</a>
            <a class="navbar-brand" href="login.php">ログイン</a>
            <a class="navbar-brand" href="logout.php">ログアウト</a>
        </div>
    </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="insert_account.php">
  <div class="jumbotron">
   <fieldset>
    <legend>新規作成</legend>
     <label>ログインID：<input type="text" name="lid"></label><br>
     <label>パスワード：<input type="password" name="lpw"></label><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
