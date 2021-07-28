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

        /* 追加・更新されたコンテンツの情報を受け取る */
        $contents = self::getContentProperty();

        $stmt = $pdo->prepare("UPDATE contents
        SET challenge = :challenge,
        problem = :problem,
        attachment = :attachment 
        WHERE id = :contentId");

        $stine = $pdo->prepare("INSERT INTO contents 
        (challenge,problem,attachment,record_id) 
        VALUES (:challenge,:problem,:attachment,:recordId)");

        $uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/study-support/work/app/images/';

        /* コンテンツの追加・更新処理 */
        foreach($contents as $content){

            self::saveImageToFolder($uploadDir); /* 画像をフォルダに保存 */

            $contentId = $content['id'];
            $challenge = $content['challenge'];
            $problem = $content['problem'];
            $attachment = $content['attachment'];

            if($contentId == ''){

                // 追加
                self::add($stine,$challenge,$problem,$attachment);
                
            }else{

                //更新
                self::update($stmt,$contentId,$challenge,$problem,$attachment);

            }
                
        }
    }

    private static function getContentProperty(){

        $contentId = filter_input(INPUT_POST,'id',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);  /*[1,2] */ 
        $challenge = filter_input(INPUT_POST,'challenge',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); /* [contentId「1」を編集しました,contentId「2」を編集しました] */
        $problem = filter_input(INPUT_POST,'problem',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); /* [contentId「1」を編集しました,contentId「2」を編集しました]   */
        $attachment = $_FILES['attachment']['name']; //[dog.png,cat.png]

        
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
            array_push($contents,$content);//[[id=>1,challenge=>contentId「1」を編集しました,probrem=>contentId「1」を編集しました,attachment=>dog.png],[id=>2,challenge=>contentId「2」を編集しました,probrem=>contentId「2」を編集しました,attachment=>cat.png]]
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

    /* [
        [name] => [dog.jpg,cat.jpg] ,
        [type] => [text/plain,text/plain]

       ]*/



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