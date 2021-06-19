<?php

require_once('../app/config.php');

Token::create();


const FOLDER_TXT = '../app/folder.txt';
const FOLDER_NAME_TXT = '../app/folderName.txt';

$action = filter_input(INPUT_GET,'action');

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    Token::validate();


    switch ($action){
        case 'makeFolder': /* 「フォルダを作る」が押下されたとき */
            // validateToken();
            Folder::make();
            break;
        case 'getFolderNo': /* フォルダがクリックされたとき */
            // validateToken();
            $number = Folder::getNumber();
            break;
        case 'getFolderName':
            Folder::getFolderName();
            break;
    
    }

}

$folders = file(FOLDER_TXT,FILE_IGNORE_NEW_LINES);  /* テキストファイルの内容を配列で取得 */
$folderNames = file(FOLDER_NAME_TXT,FILE_IGNORE_NEW_LINES);  /* テキストファイルの内容を配列で取得 */



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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <title>トップ画面</title>
</head>
<body>
    <div class="header-top">
            <input type="hidden" name="icon" value="<i class='fas fa-folder fa-3x'></i>"> <!-- ボタンを押下するとPOST形式で<i class='fas fa-folder fa-3x'></i>が送られる -->
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
            <button id="makeFolderButton">フォルダを作る</button>
    </div>
    <div id="modal">
        <span>フォルダ名を入力：</span>
        <form action="?action=getFolderName" method="post">
            <input name="folderName" type="text" placeholder="新しいフォルダ">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        </form>
    </div>

    <div class="doing-top">
        <p>作業途中の仕事</p>
        <?php $i = 0;?>

        <?php foreach($folders as $folder): ?>   
        <form action="?action=getFolderNo" method="post">
            <?= $folder; ?>
            <input type="hidden" name="folderNo" value="<?= $i; ?>"><!-- フォルダナンバーを付与 -->
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        </form>
        <p><?= $folderNames[$i] ?></p> <!-- DBのfolderNameから表示したほうが綺麗だが、フォルダ名を挿入してしまうと、inputScreen.phpのaddTodosで別レコードに記録が挿入されてしまうのでこうなった。とはいえDBから取ってくるロジックに直したほうがいい -->
        <?php $i++; ?>
        <?php  endforeach;?>


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