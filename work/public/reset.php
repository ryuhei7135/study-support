<?php

//一覧画面へ戻るがクリックされたとき
if(isset($_COOKIE['folderId'],$_COOKIE['folderName'],$_COOKIE['recordId'],$_COOKIE['recordTitle'])){
    //クッキーのリセット
    setcookie('recordId',''); 
    setcookie('recordTitle',''); 
    header('Location: http://localhost/study-support/work/public/list.php');
}


//トップ画面へ戻るがクリックされたとき
if(isset($_COOKIE['folderId'],$_COOKIE['folderName']) && !isset($_COOKIE['recordId'],$_COOKIE['recordTitle'])){
    //クッキーのリセット
    setcookie('folderId',''); 
    setcookie('folderName',''); 
    header('Location: http://localhost/study-support/work/public/top.php');
}


?>