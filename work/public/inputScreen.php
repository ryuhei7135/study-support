<?php
require_once('../app/class.php');
require_once('../app/data.php');

require_once('../app/config.php');

createToken();

$pdo = getPdoInstance();


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    validateToken();
    
    addTodo($pdo);

    header('Location:http://localhost:8562/list.php');
    exit;

}





// var_dump($pro_summary); 
// var_dump($pro_detail); 
// var_dump($pro_attachment); 
// var_dump($pro_sosummary); 
// var_dump($pro_sodetail); 
// var_dump($so_attachment); 




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <title>学習記録記入画面</title>
</head>
<body>
    <div class="header-is">
        <div class="date">
            <p>記入日が表示されます</p>
        </div>
    </div>
    <div class="main">
        <form action="" method="post"> <!-- サーバにデータを送信 -->
            <div class="problem">
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
            <?php foreach($problems as $problem): ?>
                <div class="<?php echo $problem->className; ?>">
                    <span><?php echo $problem->title;?></span>
                    <textarea name="<?= $problem->postName; ?>" cols="30" rows="1"></textarea>
                </div>
            <?php endforeach ?>
        
            </div>
        
            <div class="solution">
                <?php foreach($solutions as $solution): ?>
                    <div class="<?php echo $solution->className; ?>">
                        <span><?php echo $solution->title;?></span>
                        <textarea name="<?= $solution->postName; ?>" cols="30" rows="1"></textarea>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="btn-is">
                <button name="status" value="done">完了</button>
                <button name="status" value="notDone">保管</button>
            </div>
        </form>

    </div>
    
</body>
</html>
