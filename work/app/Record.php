<?php

class Record{

    public static function makeRecord($pdo){
        $recordTitle = filter_input(INPUT_POST,'recordTitle');
        $stmt = $pdo->prepare("INSERT INTO records (title,folder_id) VALUES (:title,:folderId)");
        $stmt->bindValue('title', $recordTitle, PDO::PARAM_STR);
        $stmt->bindValue('folderId', $_COOKIE['folderId'], PDO::PARAM_INT);
        $stmt->execute();
        header('Location: http://localhost:8562/list.php'); 
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

            $btdh = $pdo->prepare( //後で変数名変更
                "UPDATE records 
                 SET is_done = 1
                 WHERE id = :recordId");
        }else{                       /* 未完了ボタンの場合 */

            $btdh = $pdo->prepare( //後で変数名変更
                "UPDATE records 
                    SET is_done = 0
                    WHERE id = :recordId");
        }

        $btdh->bindValue('recordId', $_COOKIE['recordId'], PDO::PARAM_INT);
        $btdh->execute();

    }

}


?>