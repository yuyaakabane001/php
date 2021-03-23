<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h2>ユーザー登録</h2>
    <?php echo "メールアドレスを入れてください";?>
    <form action="<?php print($_SERVER['SCRIPT_NAME']) ?>" method="post">
    <input type="text" name="mail">
    <input type="submit" name="b" value="送信"></form>

    <?php
    if (isset($_POST["b"])) {
        $to = $_POST["mail"];
        $num = mt_rand();
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $sql = "CREATE TABLE IF NOT EXISTS test_token_2"
        ."("."token TEXT,"
        ."mail TEXT".");";
        $stmt = $pdo->query($sql);
        $sql = $pdo -> prepare("INSERT INTO test_token_2 (token, mail) VALUES (:token, :mail)");
        $sql -> bindParam(':token', $token, PDO::PARAM_STR);
        $sql -> bindParam(':mail', $mail, PDO::PARAM_STR);
        $token = $num;
        $mail = $to;
        $sql -> execute();

        require 'src/Exception.php';
        require 'src/PHPMailer.php';
        require 'src/SMTP.php';
        require 'setting.php';

        // PHPMailerのインスタンス生成
            $mail = new PHPMailer\PHPMailer\PHPMailer();

            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = MAIL_HOST;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = MAIL_ENCRPT;
            $mail->Port = SMTP_PORT;

            // メール内容設定
            $mail->CharSet = "UTF-8";
            $mail->Encoding = "base64";
            $mail->setFrom(MAIL_FROM,MAIL_FROM_NAME);
            $mail->addAddress("$to", '受信者さん');
            $mail->Subject = MAIL_SUBJECT;
            $mail->isHTML(true);
            $body = "＜確認メール＞このURLをクリックしてください"."\r\n"."https://サーバー/web-login/naibu/mail/check.php?token=$token";

            $mail->Body  = $body; // メール本文

            if(!$mail->send()) {
                echo 'メッセージは送られませんでした！';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo '送信完了！';
            }
        }
    ?>
  </body>
</html>
