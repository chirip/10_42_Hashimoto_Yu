<?php

session_start();
include("functions.php");
chkSsid();

//入力チェック(受信確認処理追加)
if(
  !isset($_POST["title"]) || $_POST["title"]=="" ||
  !isset($_POST["category"]) || $_POST["category"]=="" ||
  !isset($_POST["detail"]) || $_POST["detail"]==""
){
  exit('ParamError');
}

//1. POSTデータ取得
$title   = $_POST["title"];
$detail = $_POST["detail"];
$category = $_POST["category"];
$lid = $_SESSION["lid"];

//****************************************************
//Start:Fileアップロードチェック
//****************************************************
if (isset($_FILES["upfile"] ) && $_FILES["upfile"]["error"] ==0 ) {
  //情報取得
  $file_name = $_FILES["upfile"]["name"];         //"1.jpg"ファイル名取得
  $tmp_path  = $_FILES["upfile"]["tmp_name"]; //"/usr/www/tmp/1.jpg"アップロード先のTempフォルダ
  $file_dir_path = "upload/";  //画像ファイル保管先

  //***File名の変更***
  $extension = pathinfo($file_name, PATHINFO_EXTENSION); //拡張子取得(jpg, png, gif)
  $uniq_name = date("YmdHis"). "." . $extension;  //ユニークファイル名作成
  $file_name = $file_dir_path.$uniq_name; //ユニークファイル名とパス
 
  $img="";  //画像表示orError文字を保持する変数
  // FileUpload [--Start--]
  if ( is_uploaded_file( $tmp_path ) ) {
      if ( move_uploaded_file( $tmp_path, $file_name )){
          chmod( $file_name, 0644 );
      } else {
          exit("Error:アップロードできませんでした。"); //Error文字
      }
  }
  // FileUpload [--End--]
}else{
  exit("画像が送信されていません"); //Error文字
}
//****************************************************
//End:Fileアップロードチェック
//****************************************************


//2. DB接続します(エラー処理追加)
$pdo = db_con();

//３．データ登録SQL作成


$stmt = $pdo->prepare("INSERT INTO content(id, lid, time, title, detail, category, image) 
VALUES (NULL, :lid, sysdate(), :title, :detail, :category, :image )");
$stmt->bindValue(':title', $title,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid', $lid,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':category', $category, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':detail', $detail,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':image', $file_name,PDO::PARAM_STR);  //＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊画像＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊

$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  queryError($stmt);

}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");
  exit;
}
?>
