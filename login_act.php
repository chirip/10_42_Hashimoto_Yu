<?php
session_start();

//0.外部ファイル読み込み
include("functions.php");

//1.  DB接続します
$pdo = db_con();

//2. データ登録SQL作成
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];

$stmt = $pdo->prepare("SELECT * FROM user_table WHERE lid=:lid AND lpw=:lpw AND life_flg=0");
$stmt->bindValue(':lid', $lid);
$stmt->bindValue(':lpw', $lpw);
$res = $stmt->execute();


//3. SQL実行時にエラーがある場合
if($res==false){
    queryError($stmt);
}

//4. 抽出データ数を取得
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()
$val = $stmt->fetch(); //1レコードだけ取得する方法

//5. 該当レコードがあればSESSIONに値を代入
if( $val["user_id"] != "" ){
  $_SESSION["chk_ssid"]  = session_id();
  $_SESSION["kanri_flg"] = $val['kanri_flg'];
  $_SESSION["lid"]      = $val['lid'];
  header("Location: index.php");
}else{
  //logout処理を経由して全画面へ
  header("Location: login.php");
}

exit();
?>

