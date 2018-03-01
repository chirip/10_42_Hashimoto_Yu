<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
    div{padding: 10px;font-size:16px;}

</style>
<title>ログイン</title>
</head>
<body>

<!-- ログインメニュー -->
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="main.php">メイン</a>
            <a class="navbar-brand" href="index.php">記事作成</a>
            <a class="navbar-brand" href="new_account.php">ユーザー作成</a>
            <a class="navbar-brand" href="login.php">ログイン</a>
            <a class="navbar-brand" href="logout.php">ログアウト</a>
        </div>
    </nav>
</header>


<!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
<form action="login_act.php" method="post">
  <div class="jumbotron">
   <fieldset>
    <legend>ログイン</legend>
     <label>ログインID：<input type="text" name="lid"></label><br>
     <label>パスワード：<input type="password" name="lpw"></label><br>
     <input type="submit" value="LOGIN">
    </fieldset>
  </div>
</form>

</body>
</html>