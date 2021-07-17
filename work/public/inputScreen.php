<?php
require_once('../app/class.php');
require_once('../app/data.php');

require_once('../app/config.php');

Token::create();

$pdo = Database::getInstance();

$record = $_SESSION['record'];


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    Token::validate();
    
    Todo::add($pdo);

    header('Location:http://localhost:8562/list.php');
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <title>学習記録記入画面</title>
</head>
<body>
    <div class="header-is">
        <a href="http://localhost:8562/list.php">一覧画面へ戻る</a>
        <div class="date">
            <p>記入日が表示されます</p>
        </div>
    </div>
    <div class="main">
        <form action="" method="post" class="recordForm">
                <div class="entryRecordArea">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                    <div class="box goal" id="goal">
                        <span>実現したいこと</span>
                        <textarea name="goal" cols="30" rows="1"></textarea>
                    </div>
                    <div class="cloneTarget1">
                        <?php foreach($textboxes as $textbox): ?> 
                        <div class="<?php echo $textbox->className; ?>" id="<?= $textbox->id;?>">
                            <span><?php echo $textbox->title;?></span>
                            <textarea name="<?= $textbox->postName; ?>" cols="30" rows="1"></textarea>
                        </div>
                        <input type="hidden" name="recordId" value="<?= $record['id'] ?>">
                        <?php endforeach ?>
                    </div>
                </div>
            <div class="btn-is">
                <button name="status" value="done">完了</button>
                <button name="status" value="notDone">保管</button>
            </div>
        </form>
        <p class="plus">+</p>
    </div>


    <script src="js/main.js"></script>
</body>
</html>