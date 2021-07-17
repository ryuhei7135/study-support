<?php

//一覧画面へ戻るがクリックされたとき
if(isset($_COOKIE['folderId'],$_COOKIE['folderName'],$_COOKIE['recordId'],$_COOKIE['recordTitle'])){
    //クッキーのリセット
    setcookie('recordId',''); 
    setcookie('recordTitle',''); 
    header('Location:http://localhost:8562/list.php');
}


//トップ画面へ戻るがクリックされたとき
if(isset($_COOKIE['folderId'],$_COOKIE['folderName']) && !isset($_COOKIE['recordId'],$_COOKIE['recordTitle'])){
    //クッキーのリセット
    setcookie('folderId',''); 
    setcookie('folderName',''); 
    header('Location:http://localhost:8562/top.php');
}


?>