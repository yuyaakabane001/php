<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    $f=0;
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = 'SELECT * FROM test_register_2';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchALL();
    foreach ($results as $row) {
      if($_GET['a']==$row['name']) {if($_GET['b']==$row['pass']) {$f=1;
      $a=$row['id'];}}
    }
    if($f==1){header("location: http://サーバー/web-login/naibu/login/main_web.php?a=$a");}
      else {header("location: http://サーバー/web-login/main_start.php?f=1");}
    ?>
  </body>
</html>
