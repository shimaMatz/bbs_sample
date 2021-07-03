<?php
require './vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();

define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_NAME', $_ENV['DB_NAME']);

date_default_timezone_set('Asia/Tokyo');

try {
    $option = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    );
    $pdo = new PDO('mysql:charset=UTF8;dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS, $option);
} catch (PDOException $e) {
    $error_message[] = $e->getMessage();
}

if (isset($_POST['upload'])) {
    $image = uniqid(mt_rand(), true);//ファイル名をユニーク化
    $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得
    $file = "images/$image";
    $sql = "INSERT INTO images(name) VALUES (:image)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':image', $image, PDO::PARAM_STR);
    if (!empty($_FILES['image']['name'])) {//ファイルが選択されていれば$imageにファイル名を代入
        move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image);//imagesディレクトリにファイル保存
        if (exif_imagetype($file)) {//画像ファイルかのチェック
            $message = '画像をアップロードしました';
            $stmt->execute();
        } else {
            $message = '画像ファイルではありません';
        }
    }
}

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
    <h1>画像アップロード</h1>
    <!--送信ボタンが押された場合-->
    <?php if (isset($_POST['upload'])): ?>
        <p><?php echo $message; ?></p>
        <p><a href="image.php">画像表示へ</a></p>
    <?php else: ?>
        <form method="post" enctype="multipart/form-data">
            <p>アップロード画像</p>
            <input type="file" name="image">
            <input type="submit" name="upload" value="送信">
        </form>
    <?php endif;?>
</body>
</html>