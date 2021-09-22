<?php

require_once('Database.php');

$pdo = Database::getInstance();








class Image{

   public static function saveImageToFolder(){

        $uploadDir = './images/';

        // print_r($_FILES['attachment']['tmp_name']);


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

public static function addImages($pdo,$lastInsertId,$attachments){
    
    // $attachment = $_FILES['attachment']['name']; 

    $images = [];

    for($i=0;$i<count($attachments);$i++){
        //contentsの中身の連想配列を作る
        $image = array(
                'image_name' => $_FILES['attachment']['name'][$i], 
                'attachment' => $attachments[$i],
                'contentId' =>$lastInsertId[$i]
        );

        //contents[]に挿入する
        array_push($images,$image);
    }

    $stine = $pdo->prepare("INSERT INTO images 
        (`name`,`path`,content_id) 
        VALUES (:image_name,:attachment,:contentId)");

    foreach($images as $image){

        $image_name = $image['image_name'];
        $attachment = $image['attachment'];
        $contentId = $image['contentId'];

        $stine->bindValue(':image_name',$image_name, PDO::PARAM_STR);
        $stine->bindValue(':attachment',$attachment, PDO::PARAM_STR);
        $stine->bindValue(':contentId',$contentId, PDO::PARAM_INT); 
        $stine->execute();
    }

    


}




}


?>