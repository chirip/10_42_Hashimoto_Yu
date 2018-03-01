<?php
include("functions.php");
//1.POSTでParamを取得
$id     = $_POST["id"];
$title   = $_POST["title"];
$image  = $_POST["image"];
$detail = $_POST["detail"];

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



//2.DB接続など
$pdo = db_con();

//3.UPDATEcontent SET ....; で更新(bindValue)
//　基本的にinsert.phpの処理の流れです。
$stmt = $pdo->prepare("UPDATE content 
SET image=:image, title=:title, detail=:detail WHERE id=:id");
$stmt->bindValue(':title', $title,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':image', $image,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':detail', $detail, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id', $id,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  header("Location: kanri_main.php");
  exit;
}

?>


