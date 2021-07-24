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

        /* 追加・編集されたコンテンツの情報を受け取る */
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

        foreach($contents as $content){

            $contentId = $content['id'];
            $challenge = $content['challenge'];
            $problem = $content['problem'];
            $fileName = self::saveImageToFolder($uploadDir); /* 画像をフォルダに保存 */


            // //画像をサーバで受け取る
            // $tmp_path = $_FILES['attachment']['tmp_name'];
            // $fileName = basename($_FILES['attachment']['name']);

            // $save_path = $uploadDir.$fileName;//画像を保存するフォルダのパス

            // if(is_uploaded_file($tmp_path)){ //ファイルはあるか

            //     echo $fileName.'を'.$uploadDir.'アップしました。';

            //     // ファイルをフォルダに保存する
            //     move_uploaded_file($tmp_path,$save_path);
            // }


            
            if($contentId == ''){

                //  コンテンツの追加処理
                self::add($stine,$challenge,$problem,$fileName);
                
            }else{

                // コンテンツの更新処理
                self::update($stmt,$contentId,$challenge,$problem,$fileName);

            }
                
        }
    }

    private static function getContentProperty(){

        $contentId = filter_input(INPUT_POST,'id',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);  /*[1,2] */ 
        $challenge = filter_input(INPUT_POST,'challenge',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); /* [contentId「1」を編集しました,contentId「2」を編集しました] */
        $problem = filter_input(INPUT_POST,'problem',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); /* [contentId「1」を編集しました,contentId「2」を編集しました]   */
        $attachment = $_FILES['attachment']['name']; //アップロードされた画像の名前

        
        $contents = [];

        // contentsの中身の連想配列を作り、contents[]に挿入する処理
        for($i=0;$i<count($challenge);$i++){
            //contentsの中身の連想配列を作る
            $content = array(
                'id' =>$contentId[$i],
                'challenge' => $challenge[$i],
                'problem' => $problem[$i],
                // 'attachment' => $attachment[$i]
                'attachment' => $attachment

            );

            //contents[]に挿入する
            array_push($contents,$content);//[[id=>1,challenge=>contentId「1」を編集しました,probrem=>contentId「1」を編集しました,attachment=>contentId「1」を編集しました],[id=>2,challenge=>contentId「2」を編集しました,probrem=>contentId「2」を編集しました,attachment=>contentId「2」を編集しました]]
        }

        return $contents;
    }

    private static function add($stine,$challenge,$problem,$fileName){

        $stine->bindValue(':challenge', $challenge, PDO::PARAM_STR);
        $stine->bindValue(':problem', $problem, PDO::PARAM_STR); 
        $stine->bindValue(':attachment',$fileName, PDO::PARAM_STR);
        $stine->bindValue(':recordId',$_COOKIE['recordId'], PDO::PARAM_INT);
        $stine->execute();

    }

    private static function update($stmt,$contentId,$challenge,$problem,$fileName){

        $stmt->bindValue(':contentId', $contentId, PDO::PARAM_INT);
        $stmt->bindValue(':challenge', $challenge, PDO::PARAM_STR);
        $stmt->bindValue(':problem', $problem, PDO::PARAM_STR); 
        $stmt->bindValue(':attachment',$$fileName, PDO::PARAM_STR);
        $stmt->execute();

    }

    private static function saveImageToFolder($uploadDir){

        //画像をサーバで受け取る
        $tmp_path = $_FILES['attachment']['tmp_name'];
        $fileName = basename($_FILES['attachment']['name']);

        $save_path = $uploadDir.$fileName;//画像を保存するフォルダのパス

        if(is_uploaded_file($tmp_path)){ //ファイルはあるか

            echo $fileName.'を'.$uploadDir.'アップしました。';

            // ファイルをフォルダに保存する
            move_uploaded_file($tmp_path,$save_path);
        }

        return $fileName;
    }



    
    
}
?>