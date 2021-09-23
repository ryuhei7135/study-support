<?php

class Token{
    public static function create(){
        if(!isset($_SESSION['token'])){
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
    }

    public static function validate(){
        if(empty($_SESSION['token']) ||
        $_SESSION['token'] !== filter_input(INPUT_POST,'token')){
            // exit("<a href='../reset.php'>セッションの有効期限が切れました</a>");
            exit("<p>セッションの有効期限が切れました</p><a href='../reset.php'>戻る</a>");
        }
    }
}
?>