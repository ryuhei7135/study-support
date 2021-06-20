<?php

require_once('../app/config.php');

$pdo = Database::getInstance();

Token::create();



$worklists = Todo::get($pdo); /* フォルダ内で作成された記録のみ表示 */

// if($_SERVER['REQUEST_METHOD'] === 'POST'){
//         validateToken();
//         Todo::delete($pdo);
//         header('Location: http://localhost:8562/list.php');
//         exit;
//     }

$action = filter_input(INPUT_GET,'action');

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    Token::validate();


    switch ($action){
        case 'viewRecord': 
            $_SESSION['allRecords'] = Todo::viewRecord($pdo);
            break;
        case 'delete': 
            Todo::delete($pdo);
            break;
        
    
    }

}



if(isset($_COOKIE['folderNo'])){
    echo '開いているフォルダ番号:'.$_COOKIE['folderNo'];
}else{
    echo 'allRecordだけではなくfolderNoも削除されてしまっているのでリストが表示されていません';
}








    // // if(empty($_SESSION['allRecords'])){
    // //     echo '内容を取得できていません';
    // // }else{
    // //     var_dump($_SESSION['allRecords']);
    // }


if(empty($_SESSION['allRecords'])){ //リストがクリックされ、情報が入ってきたらページ遷移するという処理だが、入ってこなくてもデフォルトで文字列 ’[]’ が入っていて、ページ遷移してしまう。とりあえす入ってこなかったら中身を辛煮する処理にしてあるが改善の余地がありそう
    $allRecord = '';
}else{
    $allRecord = json_encode($_SESSION['allRecords']);
}

// var_dump($allRecord);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <title>一覧画面</title>
</head>
<body>
    <div class="header-list">
        <a href="reset.php">トップ画面へ</a>
    </div class="header-list">
    <div class="main-list">
        <div class="current_folder">
            <p>現在開いているフォルダが表示されます</p>
        </div>
        <div class="new_memo">
            <a href="./inputScreen.php">
                <button>メモ作成</button>
            </a>
        </div>
        <div class="record">

            <div class="complete-list">
                <p>完了した記録の表示領域</p>
                <ul>
                <?php foreach($worklists as $worklist): 
                        if($worklist->is_done == 1):  /* 完了 */
                ?>
                    <li >
                        <form action="?action=viewRecord" method="post">
                                <span class="lists"><?= $worklist->created ;?><?= $worklist->pro_summary; ?></span> 
                                <input name="id" type="hidden" value="<?= $worklist->id ?>"> 
                                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                        </form>
                        <form action="?action=delete" method="post">
                            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                            <input name="id" type="hidden" value="<?= $worklist->id ?>"> 
                            <span class="delete">X</span>
                        </form>
                    </li>

                <?php endif; 
                endforeach;
                ?>
                </ul>
                
            </div>
        
            <div class="doing-list">
                <p>未完了の記録の表示領域</p>
                <ul>
                <?php foreach($worklists as $worklist): ?>
                    <?php if($worklist->is_done == 0): ?> <!-- /* 未完了 */ -->
                    <li>
                    <form action="?action=viewRecord" method="post">
                                <span class="lists"><?= $worklist->created ;?><?= $worklist->pro_summary; ?></span> 
                                <input name="id" type="hidden" value="<?= $worklist->id ?>"> 
                                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                        </form>
                        <form action="?action=delete" method="post">
                            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                            <input name="id" type="hidden" value="<?= $worklist->id ?>"> 
                            <span class="delete">X</span>
                        </form>
                    </li>

                    <?php endif;?> 
                <?php endforeach; ?>
                </ul>
            </div>

        </div>
    </div>  

    <script>
        var allRecord = <?= $allRecord; ?>
    </script>

    <script src="js/main.js"></script>  
</body>
</html>