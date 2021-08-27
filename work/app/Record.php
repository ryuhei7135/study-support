<?php

class Record{

    public static function makeRecord($pdo){
        $recordTitle = trim(filter_input(INPUT_POST,'recordTitle'));
        if($recordTitle == ''){
            return;
        }
        $stmt = $pdo->prepare("INSERT INTO records (title,folder_id) VALUES (:title,:folderId)");
        $stmt->bindValue('title', $recordTitle, PDO::PARAM_STR);
        $stmt->bindValue('folderId', $_COOKIE['folderId'], PDO::PARAM_INT);
        $stmt->execute();
        header('Location: http://localhost/study-support/work/public/list.php'); 
    }

    public static function getRecordId(){

        $recordId = filter_input(INPUT_POST,'recordId');
        setcookie('recordId',$recordId);
    
    }

    public static function getRecordTitle(){
        $recordTitle = filter_input(INPUT_POST,'recordTitle');
        setcookie('recordTitle',$recordTitle);
    }

    public static function toggleState($pdo){

        $status = filter_input(INPUT_POST,'status');

        if($status == 'done'){         /* 完了ボタンの場合 */

            $sql = $pdo->prepare( 
                "UPDATE records 
                 SET is_done = 1
                 WHERE id = :recordId");
        }else{                       /* 未完了ボタンの場合 */

            $sql = $pdo->prepare( 
                "UPDATE records 
                    SET is_done = 0
                    WHERE id = :recordId");
        }

        $sql->bindValue('recordId', $_COOKIE['recordId'], PDO::PARAM_INT);
        $sql->execute();

    }

    public static function delete($pdo){
        $recordId = filter_input(INPUT_POST,'recordId');
        if(empty($recordId)){
            return;
        }
        $stmt = $pdo->prepare("DELETE FROM records WHERE id = :recordId");
        $stmt->bindValue('recordId',$recordId,PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function addRecord($pdo){
        
        $goal = filter_input(INPUT_POST,'goal'); /* 問題概要の内容 */
        $challenge = filter_input(INPUT_POST,'challenge'); /* 問題詳細の内容 */
        $problem = filter_input(INPUT_POST,'problem'); /* 問題の添付ファイルの内容 */
        $attachment = filter_input(INPUT_POST,'attachment'); /* 対処概要の内容 */
        $recordId = filter_input(INPUT_POST,'recordId'); /* 対処概要の内容 */
    
        $stmt = $pdo->prepare("INSERT INTO record (folder_id,record_title) VALUES (:folder_id,:record_title)"); /* レコードテーブルにタイトルを挿入。これを記録画面の実現したいことに使う */
        
        $status = filter_input(INPUT_POST,'status');
            
            switch ($status){
                case 'done':  /* 完了ボタンの場合 */
                    $stmt = $pdo->prepare("INSERT INTO content (challenge,problem,attachment,record_id) VALUES (:challenge,:problem,:attachment,:record_id)"); /* フォルダナンバーをテーブルに挿入 */
                    break;
                    
                case 'notDone': /* 未完了ボタンの場合 */
                    $stmt = $pdo->prepare("INSERT INTO content (challenge,problem,attachment,is_done,record_id) VALUES (:challenge,:problem,:attachment,0,:record_id)"); /* フォルダナンバーをテーブルに挿入 */
                    break;
            }
        
            $stmt->bindValue('folder_id', $_COOKIE['folderId'], PDO::PARAM_INT);
            $stmt->bindValue('record_title', $goal, PDO::PARAM_STR);
            $stmt->bindValue('challenge', $challenge, PDO::PARAM_STR);
            $stmt->bindValue('problem', $problem, PDO::PARAM_STR); 
            $stmt->bindValue('attachment', $attachment, PDO::PARAM_STR); 
            $stmt->bindValue('record_id', $recordId, PDO::PARAM_STR); 
            $stmt->execute();
            
        }

        public static function getRecord($pdo){
            $folderId = $_COOKIE['folderId'];
            $stmt = $pdo->prepare("SELECT * FROM records WHERE folder_id = :folderId");
            $stmt->execute(['folderId'=>$folderId]);
            $records = $stmt->fetchAll();
            return $records;
        }

}


?>