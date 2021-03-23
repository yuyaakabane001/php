<!DOCTYPE html>
<html lang= "ja">
  <head>
    <meta http-equiv="content-Type" content="text/html;charset=utf-8" />
    <title>mission_5</title>
  </head>
  <body>
    <?php
      $y=0;
      $dsn = 'データベース名';
      $user = 'ユーザー名';
      $password = 'パスワード';
      $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

      $sql = "CREATE TABLE IF NOT EXISTS keijiban_1"
      . "("
      ."id INT AUTO_INCREMENT PRIMARY KEY,"
      ."name char(32),"
      ."comment TEXT,"
      ."comment_time TEXT,"
      ."comment_pass TEXT"
      .");";
      $stmt = $pdo->query($sql);

      if (isset($_POST["sousin"])) {
          if ($_POST["kakuninn"] === "donot") {
            if ($_POST["name"] !== "" && $_POST["comment"] !== "") {
              $sql = $pdo -> prepare("INSERT INTO keijiban_1 (name, comment, comment_time, comment_pass) VALUES (:name, :comment, :jikan, :pass)");
              $sql -> bindParam(':name', $name, PDO::PARAM_STR);
          	  $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
              $sql -> bindParam(':jikan', $time, PDO::PARAM_STR);
              $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
              $name = $_POST["name"];
              $comment = $_POST["comment"];
              $time = date("m月d日H:i:s");
              $pass = $_POST["password_1"];
              $sql -> execute();
            } else {
              echo "記入欄が埋まっていません" . "<br>";
            }
          } elseif ($_POST["kakuninn"] === "do") {
            if ($_POST["name"] !== "" && $_POST["comment"] !== "") {
              $id = $_POST["bangou"];
              $name = $_POST["name"];
              $comment = $_POST["comment"];
              $time = date("m月d日H:i:s");
              $pass = $_POST["password_1"];
              $sql = 'update keijiban_1 set name=:name,comment=:comment,comment_time=:jikan,comment_pass=:pass where id=:id';
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(':name', $name, PDO::PARAM_STR);
              $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
              $stmt->bindParam(':jikan', $time, PDO::PARAM_STR);
              $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
              $stmt->bindParam(':id', $id, PDO::PARAM_INT);
              $stmt->execute();
            }
          }
      } elseif (isset($_POST["sakujo"])) {
          if ($_POST["delete"] !== "") {
            $number = $_POST["delete"];
            $sql = 'SELECT * FROM keijiban_1';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchALL();
            $txt = array();
            $p = array();
            foreach ($results as $key) {
              $txt[]=$key['id'];
              $p[$key['id']] = $key['comment_pass'];
            }
            if (in_array($_POST["delete"], $txt)) {
              if ($p[$number] !== "") {
                if ($_POST["password_2"] === $p[$number]){
                  $id = $_POST["delete"];
                  $sql = 'delete from keijiban_1 where id=:id';
                  $stmt = $pdo->prepare($sql);
                  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                  $stmt->execute();
                } else {
                  echo "パスワードに誤りがあります"."<br>";
                }
              } else {
                echo "この投稿にはパスワードがないため削除できません"."<br>";
              }
            } else {
              echo "指定行に誤りがあります"."<br>";
            }
          } else {
            echo "指定番号を入力してください"."<br>";
          }

      } elseif (isset($_POST["henshuu"])) {
          $num = $_POST["kaihen_num"];
          $sql = 'SELECT * FROM keijiban_1';
          $stmt = $pdo->query($sql);
          $results = $stmt->fetchALL();
          $arr = array();
          $q = array();
          foreach ($results as $row) {
            $arr[]=$row['id'];
            $q[$row['id']] = $row['comment_pass'];
          }
          if (in_array($num, $arr)) {
            if ($q[$num] !== "") {
              if ($_POST["password_3"] === $q[$num]) {
                foreach ($results as $row) {
                  if ($row['id'] === $num) {
                    $g = $row['id'];
                    $name_0 = $row['name'];
                    $comment_0 = $row['comment'];
                  }
                }
                $kakunin = "do";
                $y=1;
              } else {
                echo "パスワードに誤りがあります"."<br>";
              }
            } else {
              echo "この投稿にはパスワードがないため、編集できません" . "<br>";
            }
          } else {
            echo "指定行に誤りがあります"."<br>";
          }
      }

      if ($y !== 1) {
        $kakunin = "donot";
        $g = "";
        $name_0 = "";
        $comment_0 = "";
      }
      echo "________________________"."<br>";
    ?>
    <br><br>
    <form action=<?php print($_SERVER['SCRIPT_NAME']) ?> method="post">
      <?php echo "【投稿フォーム】"; ?><br>
      <?php echo "名前　　　　　　　　：" ?>
      <input type="text" name="name" value="<?php echo $name_0; ?>"> <br />
      <?php echo "コメント　　　　　　：" ?>
      <input type="text" name="comment" value="<?php echo $comment_0; ?>"> <br />
      <?php echo "パスワード　　　　　："; ?>
      <input type="password" name="password_1"> <?php echo " ＊パスワードを設定しない場合、後から削除・編集ができなくなるので注意してください"; ?><br /><br>
      <input type="hidden" name="kakuninn" value="<?php echo $kakunin; ?>">
      <input type="hidden" name="bangou" value="<?php echo $g; ?>">
      <input type="submit" name="sousin" value="送信"> <br /> <br /> <br />

      <?php echo "【削除フォーム】" ?><br>
      <?php echo "削除したい投稿番号　：" ?>
      <input type="number" name="delete"> <br />
      <?php echo "パスワード　　　　　："; ?>
      <input type="password" name="password_2"> <br> <br>
      <input type="submit" name="sakujo" value="削除"><br> <br> <br>

      <?php echo "【編集フォーム】" ?> <br>
      <?php echo "編集したい投稿の番号：" ?>
      <input type="number" name="kaihen_num"> <br>
      <?php echo "　　パスワード　　　：" ?>
      <input type="password" name="password_3"> <br><br>
      <input type="submit" name="henshuu" value="編集"> <br /> <br /> <br /><br>
    </form>
    <h1>投稿一覧</h1><br>
    <?php
      $sql = 'SELECT * FROM keijiban_1';
      $stmt = $pdo->query($sql);
      $hyouji = $stmt->fetchAll();
      foreach ($hyouji as $key) {
        echo $key['id']. ": ";
        echo $key['name']. "「";
        echo $key['comment']. "」/";
        echo $key['comment_time'].'<br>';
        echo "<hr>";
      }
    ?>
  </body>
</html>
