<?php
session_start();
//0.外部ファイル読み込み
include("functions.php");
chkSsid();
//index.php（登録フォームの画面ソースコードを全コピーして、このファイルをまるっと上書き保存）

$user_id = $_GET["user_id"];
// echo $id; //確認用

//1.  DB接続します
$pdo = db_con();

  
  //２．データ登録SQL作成
  $stmt = $pdo->prepare("DELETE FROM user_table WHERE user_id=:user_id");
  $stmt ->bindValue(":user_id", $user_id, PDO::PARAM_INT);//第3引数は数字なら_INT　文字ならTEXT
  $status = $stmt->execute();
  
  //３．データ表示
  $view="";
  if($status==false){
    //execute（SQL実行時にエラーがある場合）
    error_db_info();
    
  }else{
    //Selectデータの数だけ自動でループしてくれる
    // while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    //   $view .='<p>';
    //   $view .='<a href="detail.php?id='.$result["id"].'">';
    //   $view .= $result["name"]."[".$result["indate"]."]";
    //   $view .='</a>';
    //   $view .='</p>';
    header("Location: kanri_user.php");//  header("Location: select.php"); 「:」のあとは＿スペースが必須！
    exit;   //おまじない 
  }
?>