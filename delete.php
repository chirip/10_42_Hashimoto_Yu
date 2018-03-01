<?php
session_start();
include("functions.php");
chkSsid();

//1.POSTでParamを取得
$id = $_GET["id"];

//2.DB接続など
$pdo = db_con();

//3.UPDATEcontent SET ....; で更新(bindValue)
//　基本的にinsert.phpの処理の流れです。
$stmt = $pdo->prepare("DELETE FROM content WHERE id=:id");
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  header("Location: my_page.php");
  exit;
}

?>
