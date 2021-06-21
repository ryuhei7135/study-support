<?php

require_once('../app/config.php');
$pdo = Database::getInstance();

Token::create();

$stmt = $pdo->query("SELECT * FROM folder");
$folders = $stmt->fetchAll();

$action = filter_input(INPUT_GET,'action');

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    Token::validate();


    switch ($action){
        case 'getFolderProperty': /* フォルダがクリックされたとき */
            $folderId = Folder::getFolderId();
            $folderName = Folder::getFolderName();
            break;
        case 'makeFolder': /* フォルダ名が入力されたとき */
            Folder::makeFolder($pdo);
            break;
        case 'deleteFolder':
            Folder::deleteFolder($pdo);
            
            break;
    
    }

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
            <button id="makeFolderButton">フォルダを作る</button>
    </div>
    <div id="modal">
        <span>フォルダ名を入力：</span>
        <form action="?action=makeFolder" method="post">
            <input name="folderName" type="text" placeholder="新しいフォルダ">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        </form>
    </div>

    <div class="doing-top">
        <p>作業途中の仕事</p>
        <?php foreach($folders as $folder): ?>   
        <form action="?action=getFolderProperty" method="post">
            <i class='fas fa-folder fa-3x'></i>
            <input type="hidden" name="folderId" value="<?= $folder->id; ?>">
            <input type="hidden" name="folderName" value="<?= $folder->folder_name; ?>">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        </form>
        <p><?= $folder->folder_name; ?></p> 
        <form action="?action=deleteFolder" method="post">
            <span class="folderDelete">X</span>
            <input type="hidden" name="folderId" value="<?= $folder->id; ?>">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        </form>
        <?php  endforeach;?>


    </div>

    <div class="complete-top">
        <p>完了した仕事</p>
    </div>

    <script>
        var folderId = <?= $folderId; ?> 
    </script>

    <script src="js/main.js"></script>
</body>
</html>