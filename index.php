<?php
define('FILENAME', './message.txt');
date_default_timezone_set('Asia/Tokyo');

//変数の初期化
$current_date = null;
$data = null;
$file_handle = null;
$split_data = null;
$message = array();
$message_array = array();
$success_message = null;
$error_message = array();

//メッセージ投稿処理
if (!empty($_POST['btn_submit'])) {
    if (empty($_POST['message'])) {
        $error_message[] = 'メッセージを入力してください';
    } else {
        $clean['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
        $clean['message'] = preg_replace('/\\r\\n|\\n|\\r/', '<br>', $clean['message']);
    }
    if (empty($error_message)) {
        if ($file_handle = fopen(FILENAME, "a")) {
            $current_date = date("Y-m-d H:i:s");
            $data ="'".$clean['message']."','".$current_date."'\n";
            fwrite($file_handle, $data);
            fclose($file_handle);
            $success_message = 'メッセージを書き込みました。';
        }
    }
}

//メッセージ読み込み処理
if ($file_handle = fopen(FILENAME, "r")) {
    while ($data = fgets($file_handle)) {
        $split_data = preg_split('/\'/', $data);

        $message = array(
            'message' => $split_data[1],
            'post_data' => $split_data[3]
        );
        array_unshift($message_array, $message);
    }
    fclose($file_handle);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <title>ひとりごと掲示板</title>
</head>
<body>
    <div class="container">
        <div class="row post_block">
            <div class="col-md-2"></div>
            <div class="col-md-8">
            <form action="" method="post">
            <label class="form-label" for="message">ひとりごと掲示板</label>
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
            <?php if (!empty($message_array)):?>
                <?php foreach ($message_array as $value):?>
                    <div class="contents_block">
                        <label for=""><?php echo date('Y年m月d日 H:i', strtotime($value['post_data'])); ?></label><br>
                        <label for=""><?php echo $value['message']; ?></label>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                    <div class="contents_block">
                        <label for="">投稿がありません。</label>
                    </div>
            <?php endif; ?>
        </div>
        <div class="col-md-2"></div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>