<?php

require_once('../app/config.php');

Token::create();

$pdo = Database::getInstance();

$allRecords = $_SESSION['allRecords'];



if($_SERVER['REQUEST_METHOD'] === 'POST'){
    Token::validate();
    Todo::update($pdo);
    
    header('Location:http://localhost:8562/reset.php');
    exit;
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
    <title>編集画面</title>
</head>
<body>
    <div class="header-is">
        <div class="date">
            <a href="reset.php">一覧へ戻る</a>
        </div>
    </div>
    <div class="main">
        <form action="" method="post">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
            <div class="problem"> <!-- textClamクラスを使うとpタグがforeachの中にあるので表示する内容が同じになってしまう。とはいえオブジェクト指向に改善したほうが良い -->
                <?php foreach($allRecords as $allRecord): ?>
                <div class="box pro_summary">
                    <span>問題概要:</span>
                    <textarea name="pro_summary" cols="30" rows="1"><?= $allRecord->pro_summary; ?></textarea>
                </div>

                <div class="box pro_detail">
                    <span>問題詳細:</span>
                    <textarea name="pro_detail" cols="30" rows="1"><?= $allRecord->pro_detail; ?></textarea>
                </div>

                <div class="box pro_attachment">
                    <span>添付ファイル:</span>
                    <textarea name="pro_attachment" cols="30" rows="1"><?= $allRecord->pro_attachment; ?></textarea>
                </div>
                <?php endforeach; ?>
            </div>
        
            <div class="solution"> <!-- textClamクラスを使うとpタグがforeachの中にあるので表示する内容が同じになってしまう。とはいえオブジェクト指向に改善したほうが良い -->
                <?php foreach($allRecords as $allRecord): ?>
                <div class="box pro_sosummary">
                    <span>対処概要:</span>
                    <textarea name="so_summary" cols="30" rows="1"><?= $allRecord->so_summary; ?></textarea>
                </div>

                <div class="box pro_sosummary">
                    <span>対処詳細:</span>
                    <textarea name="so_detail" cols="30" rows="1"><?= $allRecord->so_detail; ?></textarea>
                </div>

                <div class="box pro_sosummary">
                    <span>添付ファイル:</span>
                    <textarea name="so_attachment" cols="30" rows="1"><?= $allRecord->so_attachment; ?></textarea>
                </div>
                <?php endforeach; ?>                                            
            </div>
            <div class="btn-is">
                <button name="status" value="done">完了</button>
                <button name="status" value="notDone">保管</button>
            </div>
        </form>
    </div>
    <script src="js/main.js"></script>
</body>
</html>