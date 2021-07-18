<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");


if (!empty($_POST['email_send'])) {
    if ($_POST['email']) {
        $email = $_POST['email'];
    } else {
        $error_message[] = "メールアドレスを入力してください";
    }
    
    if ($_POST['email_title']) {
        $email_title = $_POST['email_title'];
    } else {
        $error_message[] = "メールタイトルを入力してください";
    }
    
    if ($_POST['email_content']) {
        $email_content = $_POST['email_content'];
    } else {
        $error_message[] = "メール本文を入力してください";
    }

    if ($error_message) {
        if (mb_send_mail($email, $email_title, $email_content)) {
            $succuse_message = "メールを送信しました。";
        } else {
            $error_message[] = "メールの送信に失敗しました。";
        }
    }
}
var_dump($succuse_message);
exit;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>メール送信フォーム</h2>

    <?php if (empty($_POST['email_send']) && !empty($succuse_message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $succuse_message;?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <?php foreach ($error_message as $value): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $value; ?>
            </div> 
        <?php endforeach;?>
    <?php endif; ?>
    <form action="" method="post">
    <p>送信先</p>
    <input type="email" name="email" id="email">

    <p>メールタイトル</p>
    <input type="text" name="email_title" id="email_title">

    <p>本文</p>
    <textarea name="email_content" id="email_content" cols="30" rows="10"></textarea>
    
    <input type="submit" name="email_send" value="送信">
    </form>
</body>
</html>