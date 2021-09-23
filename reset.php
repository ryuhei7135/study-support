<?php //一覧画面へ戻るがクリックされたときif(isset($_COOKIE['folderId'],$_COOKIE['folderName'],$_COOKIE['recordId'],$_COOKIE['recordTitle'])){ //クッキーのリセット setcookie('recordId',''); setcookie('recordTitle',''); header('Location: http://localhost/study-support/public/list.php');} //トップ画面へ戻るがクリックされたときif(isset($_COOKIE['folderId'],$_COOKIE['folderName']) && !isset($_COOKIE['recordId'],$_COOKIE['recordTitle'])){ //クッキーのリセット setcookie('folderId',''); setcookie('folderName',''); header('Location: http://localhost/study-support/public/index.php');} ?><?php

//一覧画面へ戻るがクリックされたとき
if(isset($_COOKIE['folderId'],$_COOKIE['folderName'],$_COOKIE['recordId'],$_COOKIE['recordTitle'])){
    //クッキーのリセット
    setcookie('recordId',''); 
    setcookie('recordTitle',''); 
    header('Location: ./list.php');
}elseif(isset($_COOKIE['folderId'],$_COOKIE['folderName']) && !isset($_COOKIE['recordId'],$_COOKIE['recordTitle'])){
    //トップ画面へ戻るがクリックされたとき
    setcookie('folderId',''); 
    setcookie('folderName',''); 
    header('Location: ./index.php');
}else{
    //トップ画面でセッションの有効期限が切れたとき
    header('Location: ./index.php');
}


// //トップ画面へ戻るがクリックされたとき
// if(isset($_COOKIE['folderId'],$_COOKIE['folderName']) && !isset($_COOKIE['recordId'],$_COOKIE['recordTitle'])){
//     //クッキーのリセット
//     setcookie('folderId',''); 
//     setcookie('folderName',''); 
//     header('Location: ./index.php');
// }


?>