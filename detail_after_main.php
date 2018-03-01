<?php
session_start();
include("functions.php");
chkSsid();
//1.GETでidを取得
$id = $_GET["id"];

//2.DB接続など
$pdo = db_con();

//3.SELECT * FROM content WHERE id=***; を取得（bindValueを使用！）
$stmt = $pdo->prepare("SELECT * FROM content WHERE id=:id");
$stmt->bindValue(":id",$id,PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  $row = $stmt->fetch();
}



?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>書籍詳細</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">	</head>

  <style>
    div{padding: 10px;font-size:16px;}
    .center{text-align:center}
    table {margin:0 auto;}
  </style>
</head>
<body>

<!-- Head[Start] -->
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="main_after.php">メイン</a>
            <a class="navbar-brand" href="new_account.php">新規作成</a>
            <a class="navbar-brand" href="login.php">ログイン</a>
            <a class="navbar-brand" href="logout.php">ログアウト</a>
        </div>
    </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
  <div class="container jumbotron center">
  <legend>詳細</legend>

    <table>
      <tr>
        <th>書籍名：</th>
        <td>『<?=$row["bookname"]?>』</td>
      </tr>
      <tr>
        <th>URL:</th>
        <td><a href="<?=$row["bookurl"]?>" target="_blank">
          <i class="fa fa-external-link" aria-hidden="true"></i></a>
        </td>
      </tr>
      <tr>
        <th>コメント：</th>
        <td><?=$row["detail"]?></td>
      </tr>
      <tr>
        <th>登録日時：</th>
        <td><?=$row["puttime"]?></td>
      </tr>

    </table>
</div>
<!-- Main[End] -->


</body>
</html>






