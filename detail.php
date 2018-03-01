<?php
// session_start();
include("functions.php");
//1.GETでidを取得
$id = $_GET["id"];


//2.DB接続など
$pdo = db_con();

//3.SELECT * FROM content WHERE id=***; を取得（bindValueを使用！）
//table結合
$stmt = $pdo->prepare("SELECT * FROM `content` JOIN `user_table` ON (`content` . lid = `user_table` . lid) WHERE id = :id");
$stmt->bindValue(":id",$id,PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  $result = $stmt->fetch();
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>detail</title>
<link href="css/reset.css" rel="stylesheet">
<link href="css/base.css" rel="stylesheet">
<link href="css/common_sp.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
<link href="css/design.css" rel="stylesheet">

</head>
<body id = "column ">
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
      <li><a class="button all" href="main.php">ALL</a></li>
      <li><a class="button cate1" href="cate1.php">CATE1</a></li>
      <li><a class="button cate2" href="cate2.php">CATE2</a></li>
      <li><a class="button cate3" href="cate3.php">CATE3</a></li>
      <li><a class="button other" href="other.php">OTHER</a></li>
    </ul>
  </div>
</header>


  <!-- Head[End] -->


  <!-- Main[Start] -->
  <section id="column_single" class="inner article_<?php echo h($result["category"])?>">
  <div class="article_box cf">

    <!--　タイトルエリア  -->
    <div class="ttlArea">

      <!-- パンくずリスト -->
      <div id="column_breadcrumb">
        <ul itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
          <li><a href="http://localhost/gs/kadai/10_42_Hashimoto_Yu/main.php" itemprop="url">
            <span itemprop="title">TOP</span></a>
          </li>
            <li><a href="http://localhost/gs/kadai/10_42_Hashimoto_Yu/<?php echo h($result["category"])?>.php" itemprop="url">
              <span itemprop="title"><?php echo h($result["category"])?></span></a>
            </li>
              <li><?php echo h($result["title"])?></li>
        </ul>
      </div>
      
      <!-- 記載時間表示 -->
      <p class="date"><?php echo h($result["time"])?><span><?php echo h($result["category"])?></span></p>
      
      <!-- 記事タイトル -->
      <h2><?php echo h($result["title"])?></h2>
    </div>
        
    <!-- ライター情報 -->
    <div class="propArea cf">
      <div class="prof_box cf">
        <div class="prof_img">
          <img src="https://www.e-webseisaku.com/wp/wp-content/uploads/2017/04/uedalogo-120x120.png" width="96" height="96" alt="panda" class="avatar avatar-96 wp-user-avatar wp-user-avatar-96 alignnone photo" /></div>
            <dl>
              <dt><?php echo h($result["lid"])?></dt>
              <dd><?php echo h($result["comment"])?></dd>
            </dl>
        </div>
      <div class="shareBtn cf">
        <ul class="cf">
          <li><a href="https://twitter.com/share" class="twitter-share-button" 
            data-url="https://www.e-webseisaku.com/column/web/2466/" 
            data-text="<?php echo $result["title"]?>" 
            data-lang="ja" 
            data-hashtags="">ツイート</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
          <li><div class="fb-like" data-layout="button" ></div></li>
          <!-- <li><a href="http://b.hatena.ne.jp/entry/https://www.e-webseisaku.com/column/web/2466/" class="hatena-bookmark-button" data-hatena-bookmark-title="【デザイナーで無い人も！】デザインがうまくなる4大原則" data-hatena-bookmark-layout="standard-balloon" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script></li> -->
        </ul>
      </div>
    </div>

    <!--　TOPイメージ  -->
    <div class="top_img">
      <img src="<?php echo h($result["image"])?>"/>    
    </div>

    <!-- 本文 -->
      <!-- 記載ルール -->
      <!-- 
        <div class="tArea"> 見出し毎のブロック
        <h3>　小見出し
        <p>　本文
        <a> image

        <div class="quotation_box">　引用
          <dl>
            <dd>ここに引用<br/></dd>
            <dt><a href="ここにURL" target="_blank">出典元</a></dt>
          </dl>
        </div>-->
        
    <?php echo $result["detail"]?>
    <!-- ここまで本文 -->

    <!--　ページ送り -->
    <div id="pageNav" class="clear">        
      <ul>
        <li class="next"><a href="#" rel="next">&lt;PREV</a></li>
        <li class="to_blog"><a href="#">COLUMN 一覧</a></li>
        <li class="before"><a href="#" rel="prev">NEXT&gt;</a></li>
      </ul>
    </div>
  </div>
  <!-- ここまで詳細メインコンテンツ -->

 <!--同じカテゴリーの記事  -->
  <!-- <div class="cate_list">
    <h2 class="list_ttl">同じカテゴリーの記事</h2>
    <ul class="cf">
    <?php
      // title detail 表示上限文字数準備
        while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
          $strText = $result["detail"];
          $strTitle = $result["title"];
          $lengthText = 55; //text欄の表示上限
          $lengthTitle = 35; //title欄の表示上限
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
      <?php } ?> -->

  
<!-- Main[End] -->


</body>
</html>






