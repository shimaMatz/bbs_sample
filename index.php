<?php
require './vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();


include_once("paging.php");
//オブジェクトを生成
$pageing = new Paging();
//1ページ毎の表示数を設定
$pageing -> count = 5;
//全体の件数を設定しhtmlを生成
$pageing -> setHtml(10);



define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_NAME', $_ENV['DB_NAME']);

date_default_timezone_set('Asia/Tokyo');

//変数の初期化
$current_date = null;
$data = null;
$message = array();
$message_array = array();
$success_message = null;
$error_message = array();
$pdo = null;
$stmt = null;
$res = null;
$option = null;

session_start();

if (!empty($_POST['btn_logout'])) {
    unset($_SESSION['admin_login']);
}

try {
    $option = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    );
    $pdo = new PDO('mysql:charset=UTF8;dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS, $option);
} catch (PDOException $e) {
    $error_message[] = $e->getMessage();
}

//メッセージ投稿処理
if (!empty($_POST['btn_submit'])) {
    $message = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $_POST['message']);

    // メッセージの入力チェック
    if (!strlen($message)) {
        $error_message[] = 'ひと言メッセージを入力してください。';
    }
    if (empty($error_message)) {
        $current_date = date("Y-m-d H:i:s");

        $pdo->beginTransaction();

        try {
            $stmt = $pdo->prepare("INSERT INTO message (message, post_date) VALUES (:message, :current_date)");
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->bindParam(':current_date', $current_date, PDO::PARAM_STR);
    
            $res = $stmt->execute();

            $res = $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
        }

        if ($res) {
            $_SESSION['success_message'] = 'メッセージを書き込みました。';
        } else {
            $error_message[] = '書き込みに失敗しました。';
        }
        $stmt->null;

        header('Location: ./');
        exit;
    }
}

$row_count =10;
//テーブル全体の件数を取得
$sql = "SELECT COUNT(*) FROM message";
$message_array = $pdo -> query($sql);
$count = $message_array -> fetch(PDO::FETCH_COLUMN);

//現在のページを取得 存在しない場合は1とする
$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (int)$_GET['page'];
}
if (!$page) {
    $page = 1;
}

//$pageの数から件数分を表示するSQLクエリを生成 配列で取得
$sql = "SELECT * FROM message";
$sql .= " ORDER BY id DESC LIMIT ".(($page - 1) * $row_count).", ".$row_count;
$message_array = $pdo -> query($sql);
$aryPref = $message_array -> fetchAll(PDO::FETCH_ASSOC);

//Pagingクラスを生成し、ページングのHTMLを生成
$pageing = new Paging();
$pageing -> count = $row_count;
$pageing -> setHtml($count);

$pdo = null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="image\bara_logo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/paging.css">
    <title>ひとりごと掲示板</title>
</head>
<body>
    <div class="container">
        <div class="row post_block">
            <div class="col-md-2"></div>
            <div class="col-md-8">
            <form action="" method="post">
            <label class="form-label" for="message">ひと言掲示板</label>
            <?php if (empty($_POST['btn_submit']) && !empty($_SESSION['success_message'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($_SESSION['success_message'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <?php foreach ($error_message as $value):?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $value; ?>
                </div> 
                <?php endforeach;?>
            <?php endif; ?>
            <textarea class="form-control" name="message" id="message" cols="30"></textarea>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <button type="submit" name="btn_submit" class="btn btn-primary post_btn" value="投稿する">投稿する</button>
                </div>
                <div class="col-md-2"></div>
            </div>
            </form>
            </div>
            <div class="col-md-2">
            </div>
        </div>

        <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <?php if (!empty($aryPref)):?>
                <?php foreach ($aryPref as $value):?>
                    <div class="contents_block">
                        <time><?php echo date('Y年m月d日 H:i', strtotime($value['post_date'])); ?></time><br>
                        <label for=""><?php echo nl2br(htmlspecialchars($value['message'], ENT_QUOTES, 'UTF-8')); ?></label>
                    </div>
                    
                <?php endforeach; ?>
            <?php else: ?>
                    <div class="contents_block">
                        <label for="">投稿がありません。</label>
                    </div>
            <?php endif; ?>
            <?php echo $pageing -> html; ?>
        </div>
        <div class="col-md-2"></div>
        </div>

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
            <?php if ($_SESSION['admin_login']):?>
                <form method="post" action="">
                    <input type="submit" name="btn_logout" value="ログアウト">
                </form>
            <?php endif;?>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>