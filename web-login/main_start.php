<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form action=<?php print($_SERVER['SCRIPT_NAME']) ?> method="get">
      <p>ログイン</p>
      <?php if(isset($_GET['f'])){echo "ユーザー名またはパスワードに誤りがあります"."<br>";} ?>
      <input type="text" name="name"><br>
      <input type="password" name="pass"><br><br>
      <input type="submit" name="login" value="ログイン"><br><br>
      <p>↓新規登録のお済でない方はこちらから↓</p>
      <input type="submit" name="touroku" value="新規登録">
    </form>
    <?php
    if(isset($_GET['login'])) {
        if($_GET['name'] !== "" && $_GET['pass'] !== "") {
            $name=$_GET['name'];
            $pass=$_GET['pass'];
            header("location: 'http://サーバー/web-login/naibu/login/login_check.php?a=$name&b=$pass'");}
    }
    if(isset($_GET['touroku'])) {
        header("location: 'https://サーバー/web-login/naibu/mail/send_test.php'");
    }
    ?>
  </body>
</html>