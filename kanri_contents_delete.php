<?php
session_start();
//0.外部ファイル読み込み
include("functions.php");
chkSsid();
//index.php（登録フォームの画面ソースコードを全コピーして、このファイルをまるっと上書き保存）

$id = $_GET["id"];
// echo $id; //確認用

//1.  DB接続します
$pdo = db_con();

  
  //２．データ登録SQL作成
  $stmt = $pdo->prepare("DELETE FROM content WHERE id=:id");
  $stmt ->bindValue(":id", $id, PDO::PARAM_INT);//第3引数は数字なら_INT　文字ならTEXT
  $status = $stmt->execute();
  
  //３．データ表示
  $view="";
  if($status==false){
    //execute（SQL実行時にエラーがある場合）
    error_db_info();
    
  }else{

    header("Location: kanri_main.php");//  header("Location: select.php"); 「:」のあとは＿スペースが必須！
    exit;   //おまじない 
  }
?>