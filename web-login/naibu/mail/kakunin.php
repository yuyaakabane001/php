<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
  <?php
  $dsn = 'データベース名';
  $user = 'ユーザー名';
  $password = 'パスワード';
  $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
  $sql = 'SELECT * FROM test_register_2';
  $stmt = $pdo->query($sql);
  $results = $stmt->fetchAll();
  foreach ($results as $row){
      echo $row['id'].',';
      echo $row['name'].',';
      echo $row['pass'].',';
      echo $row['mail'].'<br>';
    echo "<hr>";
  }

  ?>
  </body>
</html>
