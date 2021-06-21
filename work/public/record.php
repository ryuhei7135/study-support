<?php

require_once('../app/config.php');

Token::create();


$pdo = Database::getInstance();
$allRecords = $_SESSION['allRecords'];

if(isset($_SESSION['allRecords'])){
    echo 'allRecordsがセットされています<br />';
}else{
    echo 'allRecordsがセットされていません<br />';
}


if(isset($_SESSION['id'])){
    echo 'クリックされたリストのID：'.$_SESSION['id'];
}else{
    'idがセットされていません';
}





?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <title>記録画面</title>
</head>
<body>
    <div class="header-is">
        <div class="date">
            <a href="edit.php">編集する</a>
            <a href="reset.php">一覧へ戻る</a>
        </div>
    </div>
    <div class="main">
            <div class="problem"> <!-- textClamクラスを使うとpタグがforeachの中にあるので表示する内容が同じになってしまう。とはいえオブジェクト指向に改善したほうが良い -->
            <?php foreach($allRecords as $allRecord): ?>
                <div class="box pro_summary">
                    <span>問題概要:</span>
                    <p><?= $allRecord->pro_summary; ?></p>
                </div>

                <div class="box pro_detail">
                    <span>問題詳細:</span>
                    <p><?= $allRecord->pro_detail; ?></p>
                </div>

                <div class="box pro_attachment">
                    <span>添付ファイル:</span>
                    <p><?= $allRecord->pro_attachment; ?></p>
                </div>
            <?php endforeach; ?>
            </div>
        
            <div class="solution"> <!-- textClamクラスを使うとpタグがforeachの中にあるので表示する内容が同じになってしまう。とはいえオブジェクト指向に改善したほうが良い -->
            <?php foreach($allRecords as $allRecord): ?>
                <div class="box pro_sosummary">
                    <span>対処概要:</span>
                    <p><?= $allRecord->so_summary; ?></p>
                </div>

                <div class="box pro_sosummary">
                    <span>対処概要:</span>
                    <p><?= $allRecord->so_detail; ?></p>
                </div>

                <div class="box pro_sosummary">
                    <span>添付ファイル:</span>
                    <p><?= $allRecord->so_attachment; ?></p>
                </div>
            <?php endforeach; ?>
            </div>
    </div>
    <script src="js/main.js"></script>
</body>
</html>