<?php

require_once('../app/config.php');

Token::create();

$pdo = Database::getInstance();

//レコード内で作成されたコンテンツを取得
$contents = Content::getContent($pdo);//[[id=>1,challenge=>readJSinhead,probrem=>noProces,attachment=>none,record_id=>1],[id=>2,challenge=>readJSinbody,probrem=>success,attachment=>none,record_id=>1]]




if($_SERVER['REQUEST_METHOD'] === 'POST'){
    Token::validate();
    
    Content::addOrUpdate($pdo);

    // $records = Todo::update($pdo);
    
    header('Location:http://localhost:8562/reset.php');
    // exit;
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
        <div class="recordTitle">
            <h2><?= $_COOKIE['recordTitle'];?></h2>
        </div>
        <form action="" method="post">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
            <div class="entryRecordArea"> <!-- foreachを使うとテキストエリアの初期値が同じ内容になってしまう。とはいえオブジェクト指向に改善したほうが良い -->
                <?php foreach($contents as $content): ?>
                <div class="entryRecord">
                    <input type="hidden" name="id[]" value="<?= $content->id; ?>">
                    <div class="box challenge" id="challenge">
                        <span>試したこと:</span>
                        <textarea name="challenge[]" cols="30" rows="1"><?= $content->challenge; ?></textarea>
                    </div>
                    <div class="box problem" id="problem">
                        <span>問題点:</span>
                        <textarea name="problem[]" cols="30" rows="1"><?= $content->problem; ?></textarea>
                    </div>
                    <div class="box attachment" id="attachment">
                        <span>添付ファイル:</span>
                        <textarea name="attachment[]" cols="30" rows="1"><?= $content->attachment; ?></textarea>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="btn-is">
                <button name="status" value="done">完了</button>
                <button name="status" value="notDone">保管</button>
            </div>
        </form>
        <div class="cloneTarget">
            <input type="hidden" name="id[]" value="">
            <div class="box challenge" id="challenge">
                <span>試したこと:</span>
                <textarea name="challenge[]" cols="30" rows="1"></textarea>
            </div>
            
            <div class="box problem" id="problem">
                <span>問題点:</span>
                <textarea name="problem[]" cols="30" rows="1"></textarea>
            </div>
            <div class="box attachment" id="attachment">
                <span>添付ファイル:</span>
                <textarea name="attachment[]" cols="30" rows="1"></textarea>
            </div>
        </div>
        <p class="plus">+</p>
    </div>
    <script src="js/main.js"></script>
</body>
</html>