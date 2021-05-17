<?php

require_once('../app/config.php');

$pdo = getPdoInstance();

$stmt = $pdo->query("SELECT * FROM worklists");
$worklists = $stmt->fetchAll();

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
        <div class="current_folder">
            <p>現在開いているフォルダが表示されます</p>
        </div>
        <div class="new_memo">
            <a href="./inputScreen.php">
                <button>メモ作成</button>
            </a>
        </div>
    </div class="header-list">
    <div class="record">

        <div class="complete-list">
            <p>完了した記録の表示領域</p>
            <ul>
            <?php foreach($worklists as $worklist): 
                    if($worklist->is_done == 1):  /* 完了 */
            ?>
                <li>
                    <span><?= $worklist->created ?></span>
                    <span><?= $worklist->title ?></span>
                </li>

            <?php endif; 
            endforeach;
            ?>
            </ul>
            
        </div>
    
        <div class="doing-list">
            <p>未完了の記録の表示領域</p>
            <ul>
            <?php foreach($worklists as $worklist): 
                    if($worklist->is_done == 0): /* 未完了 */
            ?>
                <li>
                    <span><?= $worklist->created ?></span>
                    <span><?= $worklist->title ?></span>
                </li>

            <?php endif; 
            endforeach;
            ?>
            </ul>
        </div>

    </div>

</body>
</html>