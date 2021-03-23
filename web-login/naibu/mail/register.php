<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
  <h2>ユーザー登録</h2> <br>
  <?php
    $p=0;
    if(isset($_POST['sousin'])) {
      if($_POST['name'] !== "" && $_POST['pass'] !== "") {
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        $sql = 'SELECT * FROM test_token_2';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchALL();
        foreach ($results as $row) {
          if($_GET['token'] = $row['token']) {$m=$row['mail'];}  
        }
        $sql = "CREATE TABLE IF NOT EXISTS test_register_2"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "pass TEXT,"
        . "mail TEXT"
        .");";
        $stmt = $pdo->query($sql);
        $sql = 'SELECT * FROM test_register_2';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchALL();
        $arr=array();
        foreach ($results as $row) {
          $arr[]=$row['name'];
        }
        if(!in_array($_POST['name'], $arr)) {
          $sql = $pdo -> prepare("INSERT INTO test_register_2 (name, pass, mail) VALUES (:name, :pass, :mail)");
          $sql -> bindParam(':name', $name, PDO::PARAM_STR);
          $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
          $sql -> bindParam(':mail', $mail, PDO::PARAM_STR);
          $name = $_POST['name'];
          $pass = $_POST['pass'];
          $mail = $m;
          $sql -> execute();
          $p=1;
          $token = $_GET['token'];
          $sql = 'delete from test_token_2 where token=:token';
          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(':token', $token, PDO::PARAM_INT);
          $stmt->execute();
        } else {echo "既に使用されているユーザー名です"."<br>";}
      } else {echo "記入欄が埋まっていません". "<br>";}
    }
    if($p == 1){header("location: https://サーバー/web-login/naibu/mail/kansei.php");}
  ?>
  <form action=<?php print($_SERVER['SCRIPT_NAME']) ?> method="POST">
  <?php echo "ユーザー名："; ?>
  <input type="text" name="name" valeu=""> <br>
  <?php echo "パスワード："; ?>
  <input type="password" name="pass" valeu=""> <br>
  <input type="submit" name="sousin" value="登録">
  </form>
  </body>
</html>
