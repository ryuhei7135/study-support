<?php

require_once('../app/config.php');

$pdo = Database::getInstance();

Token::create();

$records = Todo::get($pdo); /* フォルダ内で作成された記録のみ表示 */

$action = filter_input(INPUT_GET,'action');
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    Token::validate();

    switch ($action){
        case 'addOrEdit': /* リストがクリックされたとき */
            Record::getRecordId(); /* クッキーで取得 */
            Record::getRecordTitle(); /* クッキーで取得 */
            header('Location: http://localhost/study-support/work/public/edit.php');
            break;
        case 'delete': /* バツがクリックされたとき */
            Record::delete($pdo);
            break;
        case 'makeRecord':
            Record::makeRecord($pdo);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" type="text/css" href="responsive.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title>一覧画面</title>
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
            <a href="reset.php" class="back top">トップ画面へ</a>
        </div>
    </nav>
    <div class="container-fluid ps-5 pe-5">
        <div class="main">
            <div class="folder title">
                <h2><?= Utils::h($_COOKIE['folderName']); ?></h2>
            </div>
            <div class="new_memo">
                <a href="#" class="btn makeTaskBtn">タスク作成</a>
            </div>
            <div class="modal">
                <div class="modal-form">
                    <form action="?action=makeRecord" method="post">
                        <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
                        <input class="taskName input" name="recordTitle" type="text" autocomplete="off" placeholder="実現したいこと"/>
                        <button class="create-folder">create</button>
                        <button class="close-modal">close</button>
                    </form>
                </div>
            </div>
            <div class="recordArea">
                <div class="row">
                    <div class="col-md-6">
                        <div class="complete-list">
                            <table class="design10">
                                <tr>
                                    <th>完了</th>
                                    <th></th>
                                    <th class="pulldown-btn">
                                        <i class="fas fa-caret-down"></i>
                                    </th>
                                </tr>
                                <?php foreach($records as $record): 
                                        if($record->is_done == 1):  /* 完了 */
                                ?>
                                    <tr class="record">
                                        <td class="record">
                                            <form action="?action=addOrEdit" method="post">
                                                <?= Utils::h($record->created);?>
                                                <input type="hidden" name="recordId" value="<?= Utils::h($record->id); ?>">
                                                <input type="hidden" name="recordTitle" value="<?= Utils::h($record->title); ?>">
                                                <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']);?>">
                                            </form>
                                        </td>
                                        <td class="record">
                                            <form action="?action=addOrEdit" method="post">
                                                <?= Utils::h($record->title);?>
                                                <input type="hidden" name="recordId" value="<?= Utils::h($record->id); ?>">
                                                <input type="hidden" name="recordTitle" value="<?= Utils::h($record->title); ?>">
                                                <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']);?>">
                                            </form>
                                        </td>
                                        <td class="deleteRecord" data-record-id="<?= Utils::h($record->id); ?>" data-token="<?= Utils::h($_SESSION['token']);?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </td>
                                    </tr>
                                <?php endif; 
                                endforeach;
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="doing-list">
                            <table class="design10">
                                <tr>
                                    <th>未完了</th>
                                    <th></th>
                                    <th class="pulldown-btn">
                                        <i class="fas fa-caret-down"></i>
                                    </th>
                                </tr>
                                <?php foreach($records as $record): 
                                        if($record->is_done == 0):  /* 未完了 */
                                ?>
                                    <tr class="record">
                                        <td class="record">
                                            <form action="?action=addOrEdit" method="post">
                                                <?= Utils::h($record->created);?>
                                                <input type="hidden" name="recordId" value="<?= Utils::h($record->id); ?>">
                                                <input type="hidden" name="recordTitle" value="<?= Utils::h($record->title); ?>">
                                                <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']);?>">
                                            </form>
                                        </td>
                                        <td class="record">
                                            <form action="?action=addOrEdit" method="post">
                                                <?= Utils::h($record->title);?>
                                                <input type="hidden" name="recordId" value="<?= Utils::h($record->id); ?>">
                                                <input type="hidden" name="recordTitle" value="<?= Utils::h($record->title); ?>">
                                                <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']);?>">
                                            </form>
                                        </td>
                                        <td class="deleteRecord" data-record-id="<?= Utils::h($record->id); ?>" data-token="<?= Utils::h($_SESSION['token']);?>"> 
                                            <i class="fas fa-trash-alt"></i>
                                        </td>
                                    </tr>
                                <?php endif; 
                                endforeach;
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/main.js?p=(new Date()).getTime()"></script>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>
</html>