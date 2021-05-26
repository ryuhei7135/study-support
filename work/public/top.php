<?php

require_once('../app/config.php');

createToken();


/* フォルダナンバーを受け取る */
/* セッションで情報を保持 */
if(empty($_SESSION['folderNo'])){  /* クリックされたフォルダのフォルダナンバーを受け取る */
$_SESSION['folderNo'] = (filter_input(INPUT_POST,'folderNo'));
}


// $folderNo = $_SESSION['folderNo']; //クリックしたフォルダナンバーを受け取れているか
// echo $folderNo;









const FILENAME = '../app/folder.txt';

if($_SERVER['REQUEST_METHOD'] === 'POST'){ /* フォルダナンバーを１増やす */
    
    
    $icon = filter_input(INPUT_POST,'icon');  /* <i class='fas fa-folder fa-3x'></i>を受け取る */
    $fp = fopen(FILENAME,'a'); /* テキストファイルを追記モードで開く */
    fwrite($fp,$icon.PHP_EOL); /* テキストファイルに追記*/
    fclose($fp);
    header('Location: http://localhost:8562/top.php');
    exit;
}

$folders = file(FILENAME,FILE_IGNORE_NEW_LINES);  /* テキストファイルの内容を配列で取得 */



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
        <form action="" method="post"> 
            <input type="hidden" name="icon" value="<i class='fas fa-folder fa-3x'></i>"> <!-- ボタンを押下するとPOST形式で<i class='fas fa-folder fa-3x'></i>が送られる -->
            <button>フォルダを作る</button>
        </form>
    </div>

    <div class="doing-top">
        <p>作業途中の仕事</p>
    <?php

    $number = 0;

    ?>
    <?php foreach($folders as $folder): $number++ ?>   <!-- フォルダナンバーを付与 -->
        <form action="" method="post">
            <?= $folder; ?>
            <input type="hidden" name="folderNo" value="<?= $number; ?>">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        </form>
    <?php endforeach;?>
    </div>

    <div class="complete-top">
        <p>完了した仕事</p>
    </div>

    <script>
        var folderNo = <?= $_SESSION['folderNo']; ?> //javascriptセッションを渡す
    </script>

    <script src="js/main.js"></script>
</body>
</html>
