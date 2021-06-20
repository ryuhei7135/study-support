<?php

class Todo{
    public static function add($pdo){
        
    $pro_summary = filter_input(INPUT_POST,'pro_summary'); /* 問題概要の内容 */
    $pro_detail = filter_input(INPUT_POST,'pro_detail'); /* 問題詳細の内容 */
    $pro_attachment = filter_input(INPUT_POST,'pro_attachment'); /* 問題の添付ファイルの内容 */
    $pro_sosummary = filter_input(INPUT_POST,'pro_sosummary'); /* 対処概要の内容 */
    $pro_sodetail = filter_input(INPUT_POST,'pro_sodetail'); /* 対処詳細の内容 */
    $so_attachment = filter_input(INPUT_POST,'so_attachment'); /* 解決の添付ファイルの内容 */
    
    
    $status = filter_input(INPUT_POST,'status');
    
        
        switch ($status){
            case 'done':  /* 完了ボタンの場合 */
                $stmt = $pdo->prepare("INSERT INTO worklists (pro_summary,proDetail,proAttachment,soSummary,soDetail,soAttachment,folderNo) VALUES (:pro_summary,:proDetail,:proAttachment,:soSummary,:soDetail,:soAttachment,:folderNo)"); /* フォルダナンバーをテーブルに挿入 */
                break;
                
            case 'notDone': /* 未完了ボタンの場合 */
                $stmt = $pdo->prepare(" INSERT INTO worklists (pro_summary,proDetail,proAttachment,soSummary,soDetail,soAttachment,is_done,folderNo) VALUES (:pro_summary,:proDetail,:proAttachment,:soSummary,:soDetail,:soAttachment,0,:folderNo)"); /* フォルダナンバーをテーブルに挿入 */
                break;
        }
    
        $stmt->bindValue('pro_summary', $pro_summary, PDO::PARAM_STR);
        $stmt->bindValue('proDetail', $pro_detail, PDO::PARAM_STR);
        $stmt->bindValue('proAttachment', $pro_attachment, PDO::PARAM_STR); //添付ファイルなのであとで型を変更する
        $stmt->bindValue('soSummary',$pro_sosummary, PDO::PARAM_STR);
        $stmt->bindValue('soDetail', $pro_sodetail, PDO::PARAM_STR);
        $stmt->bindValue('soAttachment',$so_attachment, PDO::PARAM_STR); //添付ファイルなのであとで型を変更する
        $stmt->bindValue('folderNo', $_COOKIE['folderNo'], PDO::PARAM_INT);
        $stmt->execute();
        
    }

    public static function get($pdo){
        $folderNo = $_COOKIE['folderNo'];
        $stmt = $pdo->prepare("SELECT * FROM worklists WHERE folderNo = :folderNo");
        $stmt->execute(['folderNo'=>$folderNo]);
        $worklists = $stmt->fetchAll();
        return $worklists;
    }

    public static function update($pdo){

        $update_pro_summary = filter_input(INPUT_POST,'pro_summary'); /* 問題概要の内容 */
        $update_pro_detail = filter_input(INPUT_POST,'pro_detail'); /* 問題詳細の内容 */
        $update_pro_attachment = filter_input(INPUT_POST,'pro_attachment'); /* 問題の添付ファイルの内容 */
        $update_pro_sosummary = filter_input(INPUT_POST,'pro_sosummary'); /* 対処概要の内容 */
        $update_pro_sodetail = filter_input(INPUT_POST,'pro_sodetail'); /* 対処詳細の内容 */
        $update_so_attachment = filter_input(INPUT_POST,'so_attachment'); /* 解決の添付ファイルの内容 */
    
        $status = filter_input(INPUT_POST,'status');
    
        switch ($status){
            case 'done':  /* 完了ボタンの場合 */
                $stmt = $pdo->prepare(
                "UPDATE worklists 
                 SET pro_summary = :update_pro_summary,
                     proDetail = :update_pro_detail,
                     proAttachment = :update_pro_attachment,
                     soSummary = :update_pro_sosummary,
                     soDetail = :update_pro_sodetail,
                     soAttachment = :update_so_attachment,
                     is_done = 1
                 WHERE id = :id");
                break;
            case 'notDone': /* 未完了ボタンの場合 */
                $stmt = $pdo->prepare(
                "UPDATE worklists 
                 SET pro_summary = :update_pro_summary,
                     proDetail = :update_pro_detail,
                     proAttachment = :update_pro_attachment,
                     soSummary = :update_pro_sosummary,
                     soDetail = :update_pro_sodetail,
                     soAttachment = :update_so_attachment,
                     is_done = 0
                 WHERE id = :id");
                break;
        }
    
        $stmt->bindValue('update_pro_summary', $update_pro_summary, PDO::PARAM_STR);
        $stmt->bindValue('update_pro_detail', $update_pro_detail, PDO::PARAM_STR);
        $stmt->bindValue('update_pro_attachment', $update_pro_attachment, PDO::PARAM_STR); //添付ファイルなのであとで型を変更する
        $stmt->bindValue('update_pro_sosummary',$update_pro_sosummary, PDO::PARAM_STR);
        $stmt->bindValue('update_pro_sodetail', $update_pro_sodetail, PDO::PARAM_STR);
        $stmt->bindValue('update_so_attachment',$update_so_attachment, PDO::PARAM_STR);
        $stmt->bindValue('id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
    
    }

    public static function delete($pdo){
        $id = filter_input(INPUT_POST,'id');
        if(empty($id)){
            return;
        }
        $stmt = $pdo->prepare("DELETE FROM worklists WHERE id = :id");
        $stmt->bindValue('id',$id,PDO::PARAM_INT);
        $stmt->execute();
        header('Location: http://localhost:8562/list.php'); /* DBからは削除されているがリロードしないと画面からは消えないので書いた */
    }

    public static function viewRecord($pdo){
        if(empty($_SESSION['id'])){ 
            $_SESSION['id'] = filter_input(INPUT_POST,'id');
        }
        
        $stmt = $pdo->prepare("SELECT * FROM worklists WHERE id = :id");
        $stmt->execute(['id'=>$_SESSION['id']]);
        $_SESSION['allRecords'] = $stmt->fetchAll(); /* クリックされたリストの記録 */
        return $_SESSION['allRecords'];
    }


}

?>