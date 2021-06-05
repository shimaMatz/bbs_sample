<?php
define( 'FILENAME', './message.txt');
date_default_timezone_set('Asia/Tokyo');

if( !empty($_POST['btn_submit']) ) {
	if( $file_handle = fopen( FILENAME, "a") ) {
	
		$current_date = date("Y-m-d H:i:s");

        $date ="'".$_POST['message']."','".$current_date."'\n";

        fwrite($file_handle,$date);

		fclose( $file_handle);
	}	

}


?>

<!DOCTYPE html>
<html lang="en">
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
            <div class="contents_block">
                <label for="">ID：1 </label>
                <label for="">2021年06月04日 15:54</label><br>
                <label for="">テスト</label>
            </div>
        </div>
        <div class="col-md-2"></div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>