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

require_once('../app/parts/header.php');

?>
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
    <?php
    require_once('../app/parts/footer.php');


