<?php

require_once('../app/config.php');

$pdo = Database::getInstance();

Token::create();

//同じレコード内で作られたコンテンツを取得

$contents = Content::getContent($pdo);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> <!-- jQueryスクリプト -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet"> <!-- Lightboxのスタイルシート -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script> <!-- Lightbox本体スクリプト -->
    <title>記録画面</title>
</head>
<body>
    <div class="header-is">
        <div class="date">
            <a href="reset.php">一覧へ戻る</a>
        </div>
    </div>
    <div class="main">
            <div class="recordArea"> <!-- textClamクラスを使うとpタグがforeachの中にあるので表示する内容が同じになってしまう。とはいえオブジェクト指向に改善したほうが良い -->
            <div class="title">
                    <h2><?= $_COOKIE['recordTitle']; ?></h2>
            </div>
                <?php foreach($contents as $content): ?>
                <div class="box challenge">
                    <span>試したこと:</span>
                    <p><?= $content->challenge ?></p>
                </div>

                <div class="box problem">
                    <span>問題点:</span>
                    <p><?= $content->problem; ?></p>
                </div>
                <div class="box attachment">
                    <span>添付ファイル:</span>
                    <a href="http://localhost/study-support/work/app/images/<?= $content->attachment; ?>" data-lightbox="group"><img src="http://localhost/study-support/work/app/images/<?= $content->attachment; ?>" width="300"></a>
                </div>
                <?php endforeach ?>
            </div>
    </div>
    <script src="js/main.js"></script>
</body>
</html>