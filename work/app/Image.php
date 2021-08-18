<?php

require_once('Database.php');

$pdo = Database::getInstance();

class Image{

   public static function saveImageToFolder(){

        $uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/study-support/work/app/images/';

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

    public static function addImages($pdo,$lastInsertId){

        $attachment = $_FILES['attachment']['name']; //[cat.png]
    
        $images = [];
    
        for($i=0;$i<count($attachment);$i++){
            //contentsの中身の連想配列を作る
            $image = array(
                    'attachment' => $attachment[$i],
                    'contentId' =>$lastInsertId[$i]
            );
    
            //contents[]に挿入する
            array_push($images,$image);//[[attachment=>dog.png,contentId=>1],[attachment=>cat.png,contentId=>2]]
        }
    
        $stine = $pdo->prepare("INSERT INTO images 
            (`name`,content_id) 
            VALUES (:attachment,:contentId)");
    
        foreach($images as $image){
    
            $attachment = $image['attachment'];
            $contentId = $image['contentId'];//後で直す
    
            $stine->bindValue(':attachment',$attachment, PDO::PARAM_STR);
            $stine->bindValue(':contentId',$contentId, PDO::PARAM_INT); 
            $stine->execute();
        }
    
        
    
    
    }




}


?>