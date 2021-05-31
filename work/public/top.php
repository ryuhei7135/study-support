<?php

require_once('../app/config.php');

createToken();

const FILENAME = '../app/folder.txt';

$action = filter_input(INPUT_GET,'action');

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    validateToken();

    switch ($action){
        case 'createFolder': /* 「フォルダを作る」が押下されたとき */
            // validateToken();
            createFolders();
            break;
        case 'getFolderNo': /* フォルダがクリックされたとき */
            // validateToken();
            $number = getFolderNo();
            break;
    
    }

}

$folders = file(FILENAME,FILE_IGNORE_NEW_LINES);  /* テキストファイルの内容を配列で取得 */


if(isset($_COOKIE['folderNo'])){
    print_r($_COOKIE['folderNo']);
}else{
    echo 'クッキーのセットに失敗';
}








?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <title>トップ画面</title>
</head>
<body>
    <div class="header-top">
        <form action="?action=createFolder" method="post"> 
            <input type="hidden" name="icon" value="<i class='fas fa-folder fa-3x'></i>"> <!-- ボタンを押下するとPOST形式で<i class='fas fa-folder fa-3x'></i>が送られる -->
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
            <button>フォルダを作る</button>
        </form>
    </div>

    <div class="doing-top">
        <p>作業途中の仕事</p>
    <?php

    $i = 0;

    ?>
    <?php foreach($folders as $folder): $i++ ?>   <!-- フォルダナンバーを付与 -->
        <form action="?action=getFolderNo" method="post">
            <?= $folder; ?>
            <input type="hidden" name="folderNo" value="<?= $i; ?>">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        </form>
    <?php endforeach;?>
    </div>

    <div class="complete-top">
        <p>完了した仕事</p>
    </div>

    <script>
        var folderNo = <?= $number; ?> //javascriptセッションを渡す
    </script>

    <script src="js/main.js"></script>
</body>
</html>

