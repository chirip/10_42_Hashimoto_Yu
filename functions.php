<?php
/** 共通で使うものを別ファイルにしておきましょう。*/

//DB接続関数（PDO）
function db_con(){
  $dbname='blog';
  try {
    $pdo = new PDO('mysql:dbname='.$dbname.';charset=utf8;host=localhost','root','');
  } catch (PDOException $e) {
    exit('DbConnectError:'.$e->getMessage());
  }
  return $pdo;
}

//SQL処理エラー
function queryError($stmt){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}

/**
* XSS
* @Param:  $str(string) 表示する文字列
* @Return: (string)     サニタイジングした文字列
*/
function h($str){
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

//session check
function chkSsid(){
  if( !isset($_SESSION["chk_ssid"]) ||
      $_SESSION["chk_ssid"] != session_id()
    ){
      exit("ログインし直してください"); 
    }else{
      session_regenerate_id(true); $_SESSION["chk_ssid"] = session_id();
  }
}

function pageCheck(){
  if(preg_match('/^[1-9][0-9]*$/',$_GET['page'])){
    $page = (int)$_GET['page'];
  }else{
    $page = 1;
  }
}


?>
