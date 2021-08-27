<?php

require_once('../app/config.php');

Token::create();

$pdo = Database::getInstance();

//レコード内で作成されたコンテンツを取得
$contents = Content::getContent($pdo);

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

require_once('../app/parts/header.php');

?>


    <title>編集画面</title>
</head>
<body class="body">
    <nav class="navbar navbar-light bg-light">
        <div class="header-left">
            <h1 class="app-title">
                <span class="fas fa-digital-tachograph fa-lg"></span>
                <span class="big">S</span>tudy<span class="big">S</span>upport<span class="big">DB</span>
            </h1>
        </div>
        <div class="header-right">
            <a href="reset.php" class="back list">一覧へ戻る</a>
        </div>
    </nav>
    <div class="container-fluid ps-5 pe-5">
        <div class="main">
            <div class="record title">
                <h2><?= Utils::h($_COOKIE['recordTitle']);?></h2>
            </div>
            <form action="" method="post" class="sbmt-content" enctype="multipart/form-data"> 
                <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
                <div class="entryRecordArea"> 
                    <!-- コンテンツを表示 -->
                    <?php foreach($contents as $content): ?> 
                        <div class="entryRecordField">
                            <div class="entryRecord">
                                <input type="hidden" name="id[]" value="<?= $content->id; ?>">
                                <!-- 試したこと -->
                                <div class="mb-3 challenge">
                                    <label for="exampleFormControlTextarea1" class="form-label">試したこと</label>
                                    <textarea class="form-control exampleFormControlTextarea1yy"  name="challenge[]" rows="3"><?= $content->challenge; ?></textarea>
                                </div>
                                <!-- 問題点 -->
                                <div class="mb-3 problem">
                                    <label for="exampleFormControlTextarea1" class="form-label">問題点</label>
                                    <textarea class="form-control exampleFormControlTextarea1yy"  name="problem[]" rows="3"><?= $content->problem; ?></textarea>
                                </div>
                                <!-- 添付ファイル -->
                                <div class="mb-3 attachment">
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
                <input class="status" type="hidden" name="status" value=""> 
                <div class="edit-btn">
                    <a href="#" class="btn done" value="done">完了</a>
                    <a href="#" class="btn notDone" value="notDone">保管</a>
                </div>
            </form>
            <!-- 新しいコンテンツの記入欄 -->
            <div class="cloneTarget">
                <div class="entryRecordField">
                    <input type="hidden" name="id[]" value="">
                    <!-- 試したこと -->
                    <div class="mb-3 challenge">
                        <label for="exampleFormControlTextarea1" class="form-label">試したこと</label>
                        <textarea class="form-control exampleFormControlTextarea1yy"  name="challenge[]" rows="3"></textarea>
                    </div>
                    <!-- 問題点 -->
                    <div class="mb-3 problem">
                        <label for="exampleFormControlTextarea1" class="form-label">問題点</label>
                        <textarea class="form-control exampleFormControlTextarea1yy"  name="problem[]" rows="3"></textarea>
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
    <?php
    require_once('../app/parts/footer.php');

