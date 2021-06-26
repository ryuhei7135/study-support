<?php

class Todo{
    public static function add($pdo){
        
    $pro_summary = filter_input(INPUT_POST,'pro_summary'); /* 問題概要の内容 */
    $pro_detail = filter_input(INPUT_POST,'pro_detail'); /* 問題詳細の内容 */
    $pro_attachment = filter_input(INPUT_POST,'pro_attachment'); /* 問題の添付ファイルの内容 */
    $so_summary = filter_input(INPUT_POST,'so_sosummary'); /* 対処概要の内容 */
    $so_detail = filter_input(INPUT_POST,'so_sodetail'); /* 対処詳細の内容 */
    $so_attachment = filter_input(INPUT_POST,'so_attachment'); /* 解決の添付ファイルの内容 */

    
    $status = filter_input(INPUT_POST,'status');
        
        switch ($status){
            case 'done':  /* 完了ボタンの場合 */
                $stmt = $pdo->prepare("INSERT INTO record (folder_id,pro_summary,pro_detail,pro_attachment,so_summary,so_detail,so_attachment) VALUES (:folder_id,:pro_summary,:pro_detail,:pro_attachment,:so_summary,:so_detail,:so_attachment)"); /* フォルダナンバーをテーブルに挿入 */
                break;
                
            case 'notDone': /* 未完了ボタンの場合 */
                $stmt = $pdo->prepare("INSERT INTO record (folder_id,pro_summary,pro_detail,pro_attachment,so_summary,so_detail,so_attachment,is_done) VALUES (:folder_id,:pro_summary,:pro_detail,:pro_attachment,:so_summary,:so_detail,:so_attachment,0)"); /* フォルダナンバーをテーブルに挿入 */

                break;
        }
    
        $stmt->bindValue('pro_summary', $pro_summary, PDO::PARAM_STR);
        $stmt->bindValue('pro_detail', $pro_detail, PDO::PARAM_STR);
        $stmt->bindValue('pro_attachment', $pro_attachment, PDO::PARAM_STR); //添付ファイルなのであとで型を変更する
        $stmt->bindValue('so_summary',$so_summary, PDO::PARAM_STR);
        $stmt->bindValue('so_detail', $so_detail, PDO::PARAM_STR);
        $stmt->bindValue('so_attachment',$so_attachment, PDO::PARAM_STR); //添付ファイルなのであとで型を変更する
        $stmt->bindValue('folder_id', $_COOKIE['folderId'], PDO::PARAM_INT);
        $stmt->execute();
        
    }

    public static function get($pdo){
        $folderId = $_COOKIE['folderId'];
        $stmt = $pdo->prepare("SELECT * FROM record WHERE folder_id = :folderId");
        $stmt->execute(['folderId'=>$folderId]);
        $records = $stmt->fetchAll();
        return $records;
    }

    public static function update($pdo){

        $update_pro_summary = filter_input(INPUT_POST,'pro_summary'); /* 問題概要の内容 */
        $update_pro_detail = filter_input(INPUT_POST,'pro_detail'); /* 問題詳細の内容 */
        $update_pro_attachment = filter_input(INPUT_POST,'pro_attachment'); /* 問題の添付ファイルの内容 */
        $update_so_summary = filter_input(INPUT_POST,'so_summary'); /* 対処概要の内容 */
        $update_so_detail = filter_input(INPUT_POST,'so_detail'); /* 対処詳細の内容 */
        $update_so_attachment = filter_input(INPUT_POST,'so_attachment'); /* 解決の添付ファイルの内容 */
    
        $status = filter_input(INPUT_POST,'status');
    
        switch ($status){
            case 'done':  /* 完了ボタンの場合 */
                $stmt = $pdo->prepare(
                "UPDATE record 
                 SET pro_summary = :update_pro_summary,
                     pro_detail = :update_pro_detail,
                     pro_attachment = :update_pro_attachment,
                     so_summary = :update_so_summary,
                     so_detail = :update_so_detail,
                     so_attachment = :update_so_attachment,
                     is_done = 1
                 WHERE id = :id");
                break;
            case 'notDone': /* 未完了ボタンの場合 */
                $stmt = $pdo->prepare(
                "UPDATE record 
                 SET pro_summary = :update_pro_summary,
                     pro_detail = :update_pro_detail,
                     pro_attachment = :update_pro_attachment,
                     so_summary = :update_so_summary,
                     so_detail = :update_so_detail,
                     so_attachment = :update_so_attachment,
                     is_done = 0
                 WHERE id = :id");
                break;
        }
    
        $stmt->bindValue('update_pro_summary', $update_pro_summary, PDO::PARAM_STR);
        $stmt->bindValue('update_pro_detail', $update_pro_detail, PDO::PARAM_STR);
        $stmt->bindValue('update_pro_attachment', $update_pro_attachment, PDO::PARAM_STR); //添付ファイルなのであとで型を変更する
        $stmt->bindValue('update_so_summary',$update_so_summary, PDO::PARAM_STR);
        $stmt->bindValue('update_so_detail', $update_so_detail, PDO::PARAM_STR);
        $stmt->bindValue('update_so_attachment',$update_so_attachment, PDO::PARAM_STR);
        $stmt->bindValue('id', $_SESSION['recordId'], PDO::PARAM_INT);
        $stmt->execute();
    
    }

    public static function delete($pdo){
        $recordId = filter_input(INPUT_POST,'recordId');
        if(empty($recordId)){
            return;
        }
        $stmt = $pdo->prepare("DELETE FROM record WHERE id = :recordId");
        $stmt->bindValue('recordId',$recordId,PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function viewRecord($pdo){
        if(empty($_SESSION['recordId'])){ 
            $_SESSION['recordId'] = filter_input(INPUT_POST,'recordId');
        }
        
        $stmt = $pdo->prepare("SELECT * FROM record WHERE id = :id");
        $stmt->execute(['id'=>$_SESSION['recordId']]);
        $_SESSION['allRecords'] = $stmt->fetchAll(); /* クリックされたリストの記録 */
        return $_SESSION['allRecords'];
    }


}

?>