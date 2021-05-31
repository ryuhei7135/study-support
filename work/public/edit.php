<?php

require_once('../app/config.php');

createToken();

$pdo = getPdoInstance();

$allRecords = $_SESSION['allRecords'];



// if(empty($allRecords)){
//     echo '内容を取得できていません';
// }else{
//     print_r($allRecords);
// }

// if(isset($_SESSION['allRecords'])){
//     echo 'allRecordsがセットされています<br />';
// }else{
//     echo 'allRecordsがセットされていません<br />';
// }

// if(isset($_SESSION['folderNo'])){
//     echo 'folderNoがセットされています';
// }else{
//     'folderNoがセットされていません';
// }


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    validateToken();
    updateTodo($pdo);
    
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
                    <textarea name="pro_summary" id="" cols="30" rows="1"><?= $allRecord->pro_summary; ?></textarea>
                </div>

                <div class="box pro_detail">
                    <span>問題詳細:</span>
                    <textarea name="pro_detail" id="" cols="30" rows="1"><?= $allRecord->proDetail; ?></textarea>
                </div>

                <div class="box pro_attachment">
                    <span>添付ファイル:</span>
                    <textarea name="pro_attachment" id="" cols="30" rows="1"><?= $allRecord->proAttachment; ?></textarea>
                </div>
                <?php endforeach; ?>
            </div>
        
            <div class="solution"> <!-- textClamクラスを使うとpタグがforeachの中にあるので表示する内容が同じになってしまう。とはいえオブジェクト指向に改善したほうが良い -->
                <?php foreach($allRecords as $allRecord): ?>
                <div class="box pro_sosummary">
                    <span>対処概要:</span>
                    <textarea name="pro_sosummary" id="" cols="30" rows="1"><?= $allRecord->soSummary; ?></textarea>
                </div>

                <div class="box pro_sosummary">
                    <span>対処概要:</span>
                    <textarea name="pro_sodetail" id="" cols="30" rows="1"><?= $allRecord->soDetail; ?></textarea>
                </div>

                <div class="box pro_sosummary">
                    <span>添付ファイル:</span>
                    <textarea name="so_attachment" id="" cols="30" rows="1"><?= $allRecord->soAttachment; ?></textarea>
                </div>
                <?php endforeach; ?>                                            
            </div>
            <div class="btn-is">
                <button name="status" value="done">完了</button>
                <button name="status" value="notDone">保管</button>
            </div>
        </form>
    </div>

</body>
</html>

