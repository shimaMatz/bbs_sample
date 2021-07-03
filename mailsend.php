<html lang="ja">
<head>
  <title>メール送信完了|お問い合わせフォーム</title>
</head>
<body>
  <?php
    /* データの受取り */
    $m_name = $_POST['m_name'];
    $m_address = $_POST['m_address'];
    $m_contents = $_POST['m_contents'];
 
    /* メール送信の実行 */
    //メール本文作成
    //最初の行は空ける
 
    $mail_content = '';
    $mail_content .= "あなたにメールが届きました\n\n";
    $mail_content .= "【名前】".$m_name."\n\n";
    $mail_content .= "【E-mail】".$m_address."\n\n";
    $mail_content .= "【ご感想・ご意見】".$m_contents."\n\n";
 
    //エンコード処理
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");
 
    /* メール作成 */
    $mail_to = "sendto@me.com";
    $mail_subject = "【お問い合わせ】".$m_name."様";
    $mail_body = $mail_content;
    $mail_header = "From:".$m_address;
 
    /* メール送信 */
    // メール送信処理
        $mailsousin	= mb_send_mail($mail_to, $mail_subject, $mail_body, $mail_header);
 
        // メール送信結果
        if ($mailsousin == true) {
            echo '<p>お問い合わせメールを送信しました。</p>';
        } else {
            echo '<p>メール送信でエラーが発生しました。</p>';
        }
 
 
    ?>
</body>
</html>