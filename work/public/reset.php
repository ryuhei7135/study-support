<?php
session_start();



//一覧画面へ戻る
if(isset($_SESSION['allRecords']) && isset($_COOKIE['folderNo'])){

    session_unset($_SESSION['allRecord']); 
    setcookie(session_name(),''); 
    header('Location:http://localhost:8562/list.php');
}else{
    ;
}


    //トップ画面へ戻る
if(isset($_COOKIE['folderNo']) && empty($_SESSION['allRecords'])){

    setcookie('folderNo',""); 
    header('Location:http://localhost:8562/top.php');
}else{
    ;
}


// $_SESSION = array(); /* セッションの初期化 */

// setcookie(session_name(),''); /* セッションクッキーの削除 */

// header('Location:http://localhost:8562/top.php');


?>