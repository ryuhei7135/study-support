<?php


class Todo{
    public static function add($pdo){
        
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
        $stmt->bindValue('problem', $problem, PDO::PARAM_STR); //添付ファイルなのであとで型を変更する
        $stmt->bindValue('attachment', $attachment, PDO::PARAM_STR); 
        $stmt->bindValue('record_id', $recordId, PDO::PARAM_STR); 
        $stmt->execute();
        
    }

    public static function get($pdo){
        $folderId = $_COOKIE['folderId'];
        $stmt = $pdo->prepare("SELECT * FROM records WHERE folder_id = :folderId");
        $stmt->execute(['folderId'=>$folderId]);
        $records = $stmt->fetchAll();
        return $records;
    }

}

?>