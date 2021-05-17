<?php

function getPdoInstance(){

    try{
        $pdo = new PDO(DSN,DB_USER,DB_PASS,
        [
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
        );

        return $pdo;
    }catch(PDOException $e){
        echo $e->getMessage();
        exit;
    }
}

function createToken(){
    if(!isset($_SESSION['token'])){
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
}

function validateToken(){
    if(empty($_SESSION['token']) ||
    $_SESSION['token']!== filter_input(INPUT_POST,'token')){
        exit('Invalid post request');
    }
}

function addTodo($pdo){
    /* ------------------------------------サーバに送られてきたデータを取得----------------------------- */
$pro_summary = filter_input(INPUT_POST,'pro_summary'); /* 問題概要の内容 */
$pro_detail = filter_input(INPUT_POST,'pro_detail'); /* 問題詳細の内容 */
$pro_attachment = filter_input(INPUT_POST,'pro_attachment'); /* 問題の添付ファイルの内容 */
$pro_sosummary = filter_input(INPUT_POST,'pro_sosummary'); /* 対処概要の内容 */
$pro_sodetail = filter_input(INPUT_POST,'pro_sodetail'); /* 対処詳細の内容 */
$so_attachment = filter_input(INPUT_POST,'so_attachment'); /* 解決の添付ファイルの内容 */
/* ---------------------------------------------ここまで--------------------------------------- */

$status = filter_input(INPUT_POST,'status');

    /* -------------------------------データベースへ送信------------------------------------------- */
    switch ($status){
        case 'done':  /* 完了ボタンの場合 */
            $stmt = $pdo->prepare("INSERT INTO worklists (title) VALUES (:pro_summary)");
            $stmt->bindValue('pro_summary', $pro_summary, PDO::PARAM_STR);
            $stmt->execute();
            break;
        case 'notDone': /* 未完了ボタンの場合 */
            $stmt = $pdo->prepare("INSERT INTO worklists (title,is_done) VALUES (:pro_summary,0)");
            $stmt->bindValue('pro_summary', $pro_summary, PDO::PARAM_STR);
            $stmt->execute();
            break;
    }
    /* ---------------------------------------ここまで ---------------------------------------------------------*/
}

?>