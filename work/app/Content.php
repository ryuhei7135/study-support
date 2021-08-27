<?php

require_once('Record.php');


class Content{

    public static function getContent($pdo){

        $stmt = $pdo->prepare("SELECT * FROM contents WHERE record_id = :recordId");
        $stmt->bindValue('recordId',$_COOKIE['recordId'],PDO::PARAM_INT);
        $stmt->execute();
        $contents = $stmt->fetchAll();
        return $contents;
    }

    public static function addOrUpdate($pdo){

        $id = filter_input(INPUT_POST,'id',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); 
        $challenge = filter_input(INPUT_POST,'challenge',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); 
        $problem = filter_input(INPUT_POST,'problem',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); 
        $recordId = $_COOKIE['recordId'];
    
    
        $contents = [];
    
        // contentsの中身の連想配列を作り、contents[]に挿入する処理
        for($i=0;$i<count($challenge);$i++){
            //contentsの中身の連想配列を作る
            $content = array(
                'id' =>$id[$i],
                'challenge' => $challenge[$i],
                'problem' => $problem[$i],
                'recordId' => $recordId
            );
    
            //contents[]に挿入する
            array_push($contents,$content);
        }
    
        // /* 追加 */
        $stine = $pdo->prepare("INSERT INTO contents 
            (challenge,problem,record_id) 
            VALUES (:challenge,:problem,:recordId)");
    
        // /* 更新 */
        $stmt = $pdo->prepare("UPDATE contents
        SET challenge = :challenge,
        problem = :problem
        WHERE id = :contentId");
    
    
        $lastInsertId = [];
    
        foreach($contents as $content){
    
            $contentId = $content['id'];
            $challenge = $content['challenge'];
            $problem = $content['problem'];
    
            if($contentId !== ''){
    
                //更新
                $stmt->bindValue(':challenge', $challenge, PDO::PARAM_STR);
                $stmt->bindValue(':problem', $problem, PDO::PARAM_STR); 
                $stmt->bindValue(':contentId', $contentId, PDO::PARAM_INT);
                $stmt->execute();
                
                
            }else{
    
                // 追加
                $stine->bindValue(':challenge', $challenge, PDO::PARAM_STR);
                $stine->bindValue(':problem', $problem, PDO::PARAM_STR); 
                $stine->bindValue(':recordId',$_COOKIE['recordId'], PDO::PARAM_INT); 
                $stine->execute();
                
                array_push($lastInsertId,$pdo->lastInsertId());
            }
            
            
        }
        
        return $lastInsertId;
    }

    private static function getContentProperty(){

        $contentId = filter_input(INPUT_POST,'id',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);  
        $challenge = filter_input(INPUT_POST,'challenge',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); 
        $problem = filter_input(INPUT_POST,'problem',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); 
        $attachment = $_FILES['attachment']['name']; 

        
        $contents = [];

        // contentsの中身の連想配列を作り、contents[]に挿入する処理
        for($i=0;$i<count($challenge);$i++){
            //contentsの中身の連想配列を作る
            $content = array(
                'id' =>$contentId[$i],
                'challenge' => $challenge[$i],
                'problem' => $problem[$i],
                'attachment' => $attachment[$i]

            );

            //contents[]に挿入する
            array_push($contents,$content);
        }

        return $contents;
    }

    private static function add($stine,$challenge,$problem,$attachment){

        $stine->bindValue(':challenge', $challenge, PDO::PARAM_STR);
        $stine->bindValue(':problem', $problem, PDO::PARAM_STR); 
        $stine->bindValue(':attachment',$attachment, PDO::PARAM_STR);
        $stine->bindValue(':recordId',$_COOKIE['recordId'], PDO::PARAM_INT);
        $stine->execute();

    }

    private static function update($stmt,$contentId,$challenge,$problem,$attachment){

        $stmt->bindValue(':contentId', $contentId, PDO::PARAM_INT);
        $stmt->bindValue(':challenge', $challenge, PDO::PARAM_STR);
        $stmt->bindValue(':problem', $problem, PDO::PARAM_STR); 
        $stmt->bindValue(':attachment',$attachment, PDO::PARAM_STR);
        $stmt->execute();

    }

    



    private static function saveImageToFolder($uploadDir){

        for($j = 0;$j<count($_FILES['attachment']['tmp_name']);$j++){

        $tmp_path = $_FILES['attachment']['tmp_name'][$j]; //アップロードされた画像が格納されている一時的なパス
        $fileName = basename($_FILES['attachment']['name'][$j]); //アップロードされた画像のファイル名

        $save_path = $uploadDir.$fileName;//画像を保存するフォルダのパス

        if(is_uploaded_file($tmp_path)){ //画像はあるか

            echo $fileName.'を'.$uploadDir.'アップしました。';

            // 画像をフォルダに保存する
            move_uploaded_file($tmp_path,$save_path);
        }

    }
        
    }



    
    
}
?>