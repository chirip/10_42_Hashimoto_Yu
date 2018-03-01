<?php 

session_start();
include("functions.php");
chkSsid();

//DB定義
const DB = "";
const DB_ID = "";
const DB_PW = "";
const DB_NAME = "";

//PDOでデータベース接続
$pdo = db_con();
$lid =  $_SESSION["lid"];

// 実行したいSQL文（最新順番3つ取得）
$sql = 'SELECT * FROM content WHERE lid=:lid ORDER BY puttime';
//MySQLで実行したいSQLセット。プリペアーステートメントで後から値は入れる
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid',$lid,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

$flag = $stmt->execute();

$view="";
if($flag==false){
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
}else{//以下sqlの実行が成功した場合。
	while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$view .='<tr>';
	
		$view .='<td>';
		$view .='<a href="detail_after.php?id='.$result["id"].'">';
		$view .= $result["bookname"];
		$view .='</a>';    
		$view .='</td>';
	
		$view .='<td>';
		$view .= $result["bookurl"];
		$view .='</td>';
	
	
		$view .='<td>';
		$view .= $result["detail"];
		$view .='</td>';
	
		$view .='<td>';
		$view .= $result["puttime"];
		$view .='</td>';
	
		$view .='<td>';
		$view .='<a href="delete.php?id='.$result["id"].'">';
		$view .='[削除]';
		$view .='</a>';
		$view .='</td>';
		
		$view .='</tr>';
		
	}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>マイページ</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<style>div{padding: 10px;font-size:16px;}</style>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">	</head>
<body>
	<!-- Head[Start] -->
	<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
        <div class="navbar-header">
            <?php if($_SESSION["kanri_flg"]=="0"){ ?>
            <a class="navbar-brand" href="main_after.php">メイン</a>
            <a class="navbar-brand" href="my_page.php">マイページ</a>
            <a class="navbar-brand" href="index.php">書籍登録</a>
            <a class="navbar-brand" href="logout.php">ログアウト</a>
            <?php } ?>

            <!-- 管理者用メニュー表示 -->
            <?php if($_SESSION["kanri_flg"]=="1"){ ?>
                <a class="navbar-brand" href="main_after.php">メイン</a>
                <a class="navbar-brand" href="kanri_main.php">書籍管理</a>
                <a class="navbar-brand" href="kanri.php">ユーザー管理</a>
                <a class="navbar-brand" href="logout.php">ログアウト</a>
            <?php } ?>
        </div>
    </nav>
</header>

<div><?=$_SESSION["lid"]?>さん、こんにちは</div>

<div class="container jumbotron">
	<table>
		<tbody>
			<tr>
				<th class="w2">書籍名</th>
				<th class="w1">link</th>
				<!-- <th class="w3">URL</th> -->
				<th class="w4">コメント</th>
				<th class="w5">日時</th>
				<th class="w5">[削除]</th>
			</tr>
			<?=$view?>
		</tbody>
	</table>
</div>

</body>
</html>
<?php 
}
?>