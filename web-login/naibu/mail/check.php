<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
  <?php
    if(isset($_GET['token'])) {
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $sql = 'SELECT * FROM test_token_2';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchALL();
        $x=array();
        foreach($results as $a) {$x[]=$a['token'];}
        if(in_array($_GET['token'], $x)) {
          foreach ($x as $key) {
              if($_GET['token'] == $key) {
                header("location: https://サーバー/web-login/naibu/mail/register.php?token=$key");
                }
          }
        } else {
          echo '照会エラー：　もう一度メール登録をしてください。'. "<br>";
        }
    } else {
      echo "不正な手順でのアクセスを検知しました。メール登録を行ってください。". "<br>";
    }
  ?>
  <form action="https://サーバー/web-login/naibu/mail/send_test.php" method="POST">
  <input type="submit" value="戻る"></form>
  </body>
</html>
