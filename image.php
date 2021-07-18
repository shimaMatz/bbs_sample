<?php
require './vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();

define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_NAME', $_ENV['DB_NAME']);

date_default_timezone_set('Asia/Tokyo');

if (empty($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header('Location: ./');
    exit;
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
try {
    $sql = "SELECT * FROM images";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $image = $stmt->fetchAll();
} catch (Exception $e) {
    $pdo->rollBack();
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
    <h1>画像表示</h1>
    <?php foreach ($image as $value):?>
    <img src="images/<?php echo $value['name']; ?>" width="300" height="300"><br>
    <?php endforeach?>
    <a href="upload.php">画像アップロード</a>
</body>
</html>