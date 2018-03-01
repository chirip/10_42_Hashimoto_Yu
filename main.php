<?php
session_start();

include("functions.php");

//$_SESSION["lid"]の有無を判定（ログインの後か前か判定）
if(!isset($_SESSION["lid"]) || $_SESSION["lid"]=="" ){
  $lid = "ゲスト";//ログイン前ならゲスト表記
}else{
  $lid = $_SESSION["lid"];//ログイン後なjら$_SESSION["lid"]を表記
}

//ページャー用
//ページャー用定義　1ページあたり10件表示
define('COMMENTS_PER_PAGE', 10);

// ページャーで表示された数値を取得して反映
if(preg_match('/^[1-9][0-9]*$/',$_GET['page'])){
  $page = (int)$_GET['page'];
}else{
  $page = 1;
}


//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成
$offset = COMMENTS_PER_PAGE * ($page - 1);//ページャー用オフセット

$sql = 'SELECT *,(SELECT COUNT(*) FROM `content`) AS COUNT FROM content ORDER BY time DESC LIMIT '.$offset.','.COMMENTS_PER_PAGE;
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// SELECT *,(SELECT COUNT(*) FROM `content`) AS COUNT FROM content ORDER BY time DESC LIMIT 動作確認



//文字数を指定してdetailを表示
function myMb_truncate ( $str , $length = 40 , $etc = '...' ) {
  if ( $length == 0 ) {
    return ''; }
  if ( mb_strlen ( $str , 'utf8') > $length ) {
    return mb_substr ( $str , 0 , $length , 'utf8' ).$etc;
  } else {
    return $str;
  }
}


//３．データ表示
$view="";
if($status==false){
  queryError($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
//   while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
//     //一つ下のクラスはカテゴリーと揃える　英語表記
//     $view .= '<li class="web">';
//     $view .= '<a href="detail.php?id='.$result["id"].'class="cf"'.'">';
//     $view .= '<div class="imgArea">';
//     $view .= '<img src="'.h($result["image"]).'">';
//     $view .= '</div>';
//     $view .= '<div class="tArea">';
//     $view .= '<p class="date"><time>'.h($result["time"]).'</time>';
//     $view .= '<span>'.h($result["category"]).'</span></p>';
//     $view .= '<h3>'.h($result["title"]).'</h3>';
//     $view .= '<p class="txt">'.h($result["detail"]).'</p>';
//     $view .= '<p class="more">view more</p>';
//     $view .= '</div>';
//     $view .= '</a></li>';
//   }
// }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>メインページ</title>
<link href="css/reset.css" rel="stylesheet">
<link href="css/base.css" rel="stylesheet">
<link href="css/common_sp.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
<link href="css/design.css" rel="stylesheet">

<!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

</head>
<body id="column">
  <div id="wrapper">
<!-- Head[Start] -->
<!-- ログイン前メニュー -->
    <header>
      
      <div id="main_image">
        <div class="cover">
          <p>IKU-CHICHI</p>
          <h1>育父</h1>
        </div>
      </div>

      <div class="nav">
        <ul class="cf">
        <li><a class="button" href="main.php">ALL</a></li>
          <li><a class="button" href="cate1.php">CATE1</a></li>
          <li><a class="button" href="cate2.php">CATE2</a></li>
          <li><a class="button" href="cate3.php">CATE3</a></li>
          <li><a class="button" href="other.php">OTHER</a></li>
        </ul>
      </div>
    </header>

  <!-- Head[End] -->

  <!-- Main[Start] -->

  <h2 class="list_ttl">コラム一覧<span> Column List</span></h2>

  <section id="column_list" class="inner">
    <ul class="cf">
      
      <?php
      // title detail 表示上限文字数準備
        while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
          $strText = $result["detail"];
          $strTitle = $result["title"];
          $lengthText = 55; //text欄の表示上限
          $lengthTitle = 35; //title欄の表示上限

          $total =$result["COUNT"];
          $totalPages = ceil($total / COMMENTS_PER_PAGE);

      ?>

        <li class="<?php echo h($result["category"])?>">
          <a href="detail.php?id=<?php echo h($result["id"])?>" class="cf">
            <div class="imgArea">
              <img src="<?php echo h($result["image"])?>">
            </div>
            <div class="tArea">
              <p class="date"><time><?php echo h($result["time"])?></time>
              <span><?php echo h($result["category"])?></span></p>
              <h3><?php echo h(myMb_truncate ( $strTitle , $lengthTitle ))?></h3>
              <p class="txt"><?php echo h(myMb_truncate ( $strText , $lengthText ))?></p>
              <p class="more">view more</p>
            </div>
          </a>
        </li>
        
      <?php } ?>
    </ul>  



<!-- ページネーション -->
<div class='wp-pagenavi'>
  <?php if($page > 1) :  ?>
    <a class="nextpostslink" rel="next" href="?page=<?php echo $page-1; ?>">«</a>
  <?php endif ; ?>

  <?php for($i = 1; $i <= $totalPages; $i++) :  ?>  
    <a class="page larger" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
  <?php endfor ; ?>

  <?php if($page < $totalPages) :  ?>
    <a class="nextpostslink" rel="next" href="?page=<?php echo $page+1; ?>">»</a>
  <?php endif ; ?>
</div>    

  </section>

</body>
</html>
<?php } ?>

