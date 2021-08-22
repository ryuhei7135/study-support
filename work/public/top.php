<?php

require_once('../app/config.php');
$pdo = Database::getInstance();

Token::create();

/* 作成されたフォルダを取得 */
$folders = Folder::getFolder($pdo);

$action = filter_input(INPUT_GET, 'action');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    Token::validate();


    switch ($action) {
        case 'getFolderProperty': /* フォルダがクリックされたとき */
            $folderId = Folder::getFolderId(); //cookieにフォルダーIDをセット
            Folder::getFolderName(); //cookieにフォルダ名をセット
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
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" type="text/css" href="responsive.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <title>トップ画面</title>
</head>
<body class="body">
    <nav class="navbar navbar-light bg-light">
        <div class="header-left">
            <h1 class="app-title">
                <span class="fas fa-digital-tachograph fa-lg"></span>
                <span class="big">S</span>tudy<span class="big">S</span>upport<span class="big">DB</span>
            </h1>
        </div>
    </nav>
    <div class="container-fluid ps-5 pe-5">
        <div class="main">
            <div class="header-top">
                <a href="#" class="btn makeFolderBtn">フォルダを作る</a>
            </div>
            <div class="modal">
                <div class="modal-form">
                    <form action="?action=makeFolder" method="post">
                        <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
                        <input class="folderName input" name="folderName" type="text" autocomplete="off" placeholder="フォルダ名"/>
                        <button class="create-folder">create</button>
                        <button class="close-modal">close</button>
                    </form>
                </div>
            </div>
            <div class="folderArea">
                <?php foreach ($folders as $folder) : ?>
                    <div class="folder">
                        <div class="folderIcon">
                            <form action="?action=getFolderProperty" method="post">
                                <i class='fas fa-folder fa-3x'></i>
                                <input type="hidden" name="folderId" value="<?= Utils::h($folder->id); ?>">
                                <input type="hidden" name="folderName" value="<?= Utils::h($folder->name); ?>">
                                <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
                            </form>
                        </div>
                        <div class="folderName">
                            <p><?= Utils::h($folder->name); ?></p>
                        </div>
                        <div class="folderDeleteButton" data-folder-id="<?= Utils::h($folder->id); ?>" data-token="<?= Utils::h($_SESSION['token']); ?>" >
                            <span class="folderDelete">X</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
    </div>

    <script>
        var folderId = <?= $folderId; ?>
    </script>

    <script src="js/main.js?p=(new Date()).getTime()"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>

</html>
