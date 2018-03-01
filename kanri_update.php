<!-- //1.POSTでParamを取得


//2.DB接続など


//3.UPDATE gs_user_table SET ....; で更新(bindValue)
//　基本的にinsert.phpの処理の流れです。 -->


<?php
include("functions.php");

//入力チェック(受信確認処理追加)
if(
  !isset($_POST["user_id"]) || $_POST["user_id"]=="" ||    
  !isset($_POST["lid"]) || $_POST["lid"]=="" ||
  !isset($_POST["lpw"]) || $_POST["lpw"]=="" ||
  !isset($_POST["kanri_flg"]) || $_POST["kanri_flg"]=="" ||
  !isset($_POST["life_flg"]) || $_POST["life_flg"]==""
){
  exit('ParamError');
}

//1. POSTデータ取得
$user_id     = $_POST["user_id"];
$lid  = $_POST["lid"];
$lpw = $_POST["lpw"];
$kanri_flg = $_POST["kanri_flg"];
$life_flg = $_POST["life_flg"];


//2. DB接続します(エラー処理追加)
$pdo = db_con();



//３．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE user_table SET lid=:lid, lpw=:lpw, life_flg=:life_flg, kanri_flg=:kanri_flg WHERE user_id=:user_id");
$stmt->bindValue(':user_id', $user_id,PDO::PARAM_INT);
$stmt->bindValue(':lid', $lid,PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw,PDO::PARAM_STR);
$stmt->bindValue(':life_flg', $life_flg,PDO::PARAM_INT);
$stmt->bindValue(':kanri_flg', $kanri_flg,PDO::PARAM_INT);

$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  error_db_info();
  
}else{
  //５．index.phpへリダイレクト
  header("Location: kanri_user.php");//  header("Location: select.php"); 「:」のあとは＿スペースが必須！
  
  exit;
}
?>