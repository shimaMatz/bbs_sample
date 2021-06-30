<?php
require './vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();

// データベースの接続情報
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_NAME', $_ENV['DB_NAME']);

// 変数の初期化
$csv_data = null;
$sql = null;
$pdo = null;
$option = null;
$message_array = array();
$limit = null;
$stmt = null;

session_start();

if (!empty($_POST['limit'])) {
    if ($_POST['limit'] === "10") {
        $limit = 10;
    } elseif ($_POST['limit'] === "30") {
        $limit = 30;
    }
}


if (!empty($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
    try {
        $option = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_MULTI_STATEMENTS => false
        );
        $pdo = new PDO('mysql:charset=UTF8;dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS, $option);

        if (!empty($limit)) {
            $stmt = $pdo->prepare("SELECT * FROM message ORDER BY post_date ASC LIMIT :limit");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        } else {
            $stmt = $pdo->prepare("SELECT * FROM message ORDER BY post_date ASC");
        }

        $stmt->execute();
        $message_array = $stmt->fetchAll();

        // データベースの接続を閉じる
        $stmt = null;
        $pdo = null;
    } catch (PDOException $e) {
        // 管理者ページへリダイレクト
        header("Location: ./admin.php");
        exit;
    }

    // 出力の設定
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=メッセージデータ.csv");
    header("Content-Transfer-Encoding: binary");

    // CSVデータを作成
    if (!empty($message_array)) {
        
        // 1行目のラベル作成
        $csv_data .= '"ID","メッセージ","投稿日時"'."\n";
        
        foreach ($message_array as $value) {
        
            // データを1行ずつCSVファイルに書き込む
            $csv_data .= '"' . $value['id'] .  '","' . $value['message'] . '","' . $value['post_date'] . "\"\n";
        }
    }

    // ファイルを出力
    echo mb_convert_encoding($csv_data, "SJIS", "UTF-8");
// echo $csv_data;
} else {

    // ログインページへリダイレクト
    header("Location: ./admin.php");
    exit;
}

return;
