<?php
require './vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();

// 管理ページのログインパスワード
define('PASSWORD', $_ENV['ADMIN_PASSWORD']);
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_NAME', $_ENV['DB_NAME']);
define('ADMIN_USER', $_ENV['ADMIN_USER']);
define('ADMIN_PASSWORD', $_ENV['ADMIN_PASSWORD']);

date_default_timezone_set('Asia/Tokyo');

session_start();

try {
    $option = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    );
    $pdo = new PDO('mysql:charset=UTF8;dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS, $option);
} catch (PDOException $e) {
    $error_message[] = $e->getMessage();
}



if (!empty($_POST['btn_submit'])) {
    if (!empty($_POST['admin_password']) && $_POST['admin_password'] === PASSWORD) {
        $_SESSION['admin_login'] = true;
    } else {
        $error_message[] = 'ログインに失敗しました。';
    }
}


if (!empty($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
    header('Location: ./admin_mypage.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="black_neko.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="signin.css">
    <link rel="stylesheet" href="paging.css">
    <title>ひと言掲示板　管理者ログイン</title>
</head>
<body>


<div class="container">
    <form class="form-signin post_block" action="" method="POST">
    <h1 class="h3 mb-3 font-weight-normal">管理者ログイン</h1>
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success" role="alert">
        <?php echo $success_message; ?>
    </div>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
        <?php foreach ($error_message as $value):?>
        <div class="alert alert-danger" role="alert">
            <?php echo $value; ?>
        </div> 
        <?php endforeach;?>
    <?php endif; ?>
    <label for="inputEmail" class="sr-only">メールアドレス</label>
    <input type="email" id="inputEmail" name ="email" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">パスワード</label>
    <input type="password" id="admin_password" name="admin_password" class="form-control" placeholder="Password" required>
    <button id="btn_submit" name="btn_submit" class="btn btn-lg btn-primary btn-block" type="submit" value="login">ログイン</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>