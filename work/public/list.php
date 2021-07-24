<?php

require_once('../app/config.php');

$pdo = Database::getInstance();

Token::create();

$records = Todo::get($pdo); /* フォルダ内で作成された記録のみ表示 */

$action = filter_input(INPUT_GET,'action');
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    Token::validate();

    switch ($action){
        case 'viewRecord': /* リストがクリックされたとき */
            Record::getRecordId(); /* クッキーで取得 */
            Record::getRecordTitle(); /* クッキーで取得 */
            header('Location: http://localhost/study-support/work/public/view.php');
            break;
        case 'addAndEdit':
            Record::getRecordId(); /* クッキーで取得 */
            Record::getRecordTitle(); /* クッキーで取得 */
            header('Location: http://localhost/study-support/work/public/edit.php');
            break;
        case 'delete': /* バツがクリックされたとき */
            Todo::delete($pdo);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <title>一覧画面</title>
</head>
<body>
    <div class="header-list">
        <div class="current_folder">
            <p><?= $_COOKIE['folderName']; ?></p>
        </div>
        <a href="reset.php">トップ画面へ</a>
        <div class="new_memo">
                <button id="makeTaskButton">タスク作成</button>
        </div>
    </div class="header-list">
    <div id="modal">
        <span>タスク名を入力：</span>
        <form action="?action=makeRecord" method="post">
            <input name="recordTitle" type="text" placeholder="実現したいことを入力">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        </form>
    </div>
    <div class="main-list">
        <div class="recordArea">
            <div class="complete-list">
                <p>完了した記録の表示領域</p>
                <table>
                    <?php foreach($records as $record): 
                            if($record->is_done == 1):  /* 完了 */
                    ?>
                    <tr>
                        <td>
                            <form action="?action=viewRecord" method="post">
                                <div class="record">
                                    <?= $record->created ;?><?= $record->title; ?>
                                </div>
                                <input type="hidden" name="recordId" value="<?= $record->id ?>">
                                <input type="hidden" name="recordTitle" value="<?= $record->title ?>">
                                <input type="hidden" name="token" value="<?= $_SESSION['token']?>">
                            </form>
                        </td>
                        <td>
                            <form action="?action=addAndEdit" method="post">
                                <i class="fas fa-edit addAndEdit"></i>
                                <input type="hidden" name="recordId" value="<?= $record->id ?>">
                                <input type="hidden" name="recordTitle" value="<?= $record->title ?>">
                                <input type="hidden" name="token" value="<?= $_SESSION['token']?>">
                            </form>
                        </td>
                        <td>
                            <form action="?action=delete" method="post">
                                <i class="fas fa-trash-alt delete"></i>
                                <input type="hidden" name="recordId" value="<?= $record->id ?>">
                                <input type="hidden" name="token" value="<?= $_SESSION['token']?>">
                            </form>
                        </td>
                    </tr>
                        
                    <?php endif; 
                    endforeach;
                    ?>
                </table>
            </div>
        
            <div class="doing-list">
                <p>未完了の記録の表示領域</p>
                <table>
                    <?php foreach($records as $record): 
                            if($record->is_done == 0):  /* 未完了 */
                    ?>
                    <tr>
                        <td>
                            <form action="?action=viewRecord" method="post">
                                <div class="record">
                                    <?= $record->created ;?><?= $record->title; ?>
                                </div>
                                <input type="hidden" name="recordId" value="<?= $record->id ?>">
                                <input type="hidden" name="recordTitle" value="<?= $record->title ?>">
                                <input type="hidden" name="token" value="<?= $_SESSION['token']?>">
                            </form>
                        </td>
                        <td>
                            <form action="?action=addAndEdit" method="post">
                                <i class="fas fa-edit addAndEdit"></i>
                                <input type="hidden" name="recordId" value="<?= $record->id ?>">
                                <input type="hidden" name="recordTitle" value="<?= $record->title ?>">
                                <input type="hidden" name="token" value="<?= $_SESSION['token']?>">
                            </form>
                        </td>
                        <td>
                        <td>
                            <form action="?action=delete" method="post">
                                <i class="fas fa-trash-alt delete"></i>
                                <input type="hidden" name="recordId" value="<?= $record->id ?>">
                                <input type="hidden" name="token" value="<?= $_SESSION['token']?>">
                            </form>
                        </td>
                    </tr>
                    <?php endif; 
                    endforeach;
                    ?>
                </table>
            </div>

        </div>
    </div>  
    <script src="js/main.js"></script>  
</body>
</html>