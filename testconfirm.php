
<!DOCTYPE html>
<html lang="ja">
<head>
  <title>入力内容の確認|お問い合わせフォーム</title>
</head>
<body>
  <?php
    /* データの受取り*/
    $name=$_POST["onamae"];
    $email=$_POST["email"];
    $inquery=$_POST["opinion"];
    /**/
 
    /*入力確認ページHTMLの吐き出し*/
    echo '<h3>ご入力内容の確認</h3>';
    echo "<p>【名前】{$name}</p>";
    echo "<p>【E-mail】{$email}</p>";
    echo "<p>【ご感想・ご意見】{$inquery}</p>";
 
    /*メール送信ボタン表示*/
    echo '<form method="post" action="mailsend.php">';
    echo '<input type="hidden" name="m_name" value="'.$name.'">';
    echo '<input type="hidden" name="m_address" value="'.$email.'">';
    echo '<input type="hidden" name="m_contents" value="'.$inquery.'">';
    echo '<input type="submit" name="ok" value="上記内容で送信する">';
    echo '</form>';
   ?>
</body>
</html>