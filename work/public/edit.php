<?php

require_once('../app/config.php');

Token::create();

$pdo = Database::getInstance();

//レコード内で作成されたコンテンツを取得
$contents = Content::getContent($pdo);//[[id=>1,challenge=>readJSinhead,probrem=>noProces,attachment=>none,record_id=>1],[id=>2,challenge=>readJSinbody,probrem=>success,attachment=>none,record_id=>1]]

//完了または保管がクリックされたとき
if($_SERVER['REQUEST_METHOD'] === 'POST'){ 

    Token::validate($pdo);

    // contentsテーブルへの追加・更新
    $lastInsertId = Content::addOrUpdate($pdo);

    // 画像をフォルダに保存
    Image::saveImageToFolder();

    // 画像をimagesテーブルに保存 コンテンツIDを受け取れないかもしれない 明日テスト
    Image::addImages($pdo,$lastInsertId);

    /* レコードの完了・未完了の切り替え */
    Record::toggleState($pdo);
    
    header('Location: http://localhost/study-support/work/public/reset.php');
    // exit;
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" type="text/css" href="responsive.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>
    <title>編集画面</title>
</head>
<body class="body">
    <nav class="navbar navbar-light bg-light">
        <h1 class="app-title">学習サポートDB</h1>
        <div class="header-right">
            <a href="reset.php" class="back list">一覧へ戻る</a>
        </div>
    </nav>
    <div class="container">
        <div class="main">
            <div class="record title">
                <h2><?= Utils::h($_COOKIE['recordTitle']);?></h2>
            </div>
            <form action="" method="post" class="sbmt-content" enctype="multipart/form-data"> 
                <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
                <div class="entryRecordArea"> <!-- foreachを使うとテキストエリアの初期値が同じ内容になってしまう。とはいえオブジェクト指向に改善したほうが良い -->
                    <!-- コンテンツを表示 -->
                    <?php foreach($contents as $content): ?> 
                        <div class="box11">
                            <div class="entryRecord">
                                <input type="hidden" name="id[]" value="<?= $content->id; ?>">
                                <!-- 試したこと -->
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">試したこと</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="challenge[]" rows="3"><?= $content->challenge; ?></textarea>
                                </div>
                                <!-- 問題点 -->
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">問題点</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="problem[]" rows="3"><?= $content->problem; ?></textarea>
                                </div>
                                <!-- 添付ファイル -->
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">添付ファイル</label>
                                    <!-- コンテンツごとに画像を表示 -->
                                    <?php
                                        $stmt = $pdo->prepare("SELECT * FROM images WHERE content_id = :contentId");
                                        $stmt->bindValue('contentId',$content->id,PDO::PARAM_INT);
                                        $stmt->execute();
                                        $images = $stmt->fetchAll();
                                    ?>
                                    <?php foreach($images as $image): ?> 
                                        <?php if($image->name !== ''): ?>
                                        <a class="img" href="http://localhost/study-support/work/app/images/<?= Utils::h($image->name); ?>" data-lightbox="group"><img src="http://localhost/study-support/work/app/images/<?= Utils::h($image->name); ?>" width="200" height="100px"></a>
                                        <a class="img" href="../app/delete_image.php?id=<?= Utils::h($image->id); ?>">削除</a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <input class="status" type="hidden" name="status" value=""> <!-- クリックされたボタンに応じてvalueが格納される -->
                <div class="edit-btn">
                    <a href="#" class="btn done" value="done">完了</a>
                    <a href="#" class="btn notDone" value="notDone">保管</a>
                </div>
            </form>
            <!-- 新しいコンテンツの記入欄 -->
            <div class="cloneTarget">
                <div class="box11">
                    <input type="hidden" name="id[]" value="">
                    <!-- 試したこと -->
                    <div class="mb-3 challenge">
                        <label for="exampleFormControlTextarea1" class="form-label">試したこと</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="challenge[]" rows="3"></textarea>
                    </div>
                    <!-- 問題点 -->
                    <div class="mb-3 problem">
                        <label for="exampleFormControlTextarea1" class="form-label">問題点</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="problem[]" rows="3"></textarea>
                    </div>
                    <!-- 添付ファイル -->
                    <div class="mb-3 attachment">
                        <label for="exampleFormControlTextarea1" class="form-label">添付ファイル</label>
                        <input name="attachment[]" type="file" accept="image/*" id="input-file"  multiple>
                        <div id="preview"></div>
                    </div>
                </div>
            </div>
            <p class="plus">+</p>
        </div>
    </div>
    <script src="js/main.js?p=(new Date()).getTime()"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>
</html>

