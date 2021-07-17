<?php

require_once('Record.php');


class Content extends Record{

    public static function getContent($pdo){

        $stmt = $pdo->prepare("SELECT * FROM contents WHERE record_id = :recordId");
        $stmt->bindValue('recordId',$_COOKIE['recordId'],PDO::PARAM_INT);
        $stmt->execute();
        $contents = $stmt->fetchAll();
        return $contents;
    }

    public static function addOrUpdate($pdo){

        /* 追加・編集されたコンテンツの情報を受け取る */
        $records = self::getContentProperty();

        /* レコードの完了・未完了を切り替える処理 */
        parent::toggleState($pdo);

        
        $stmt = $pdo->prepare("UPDATE contents
        SET challenge = :challenge,
        problem = :problem,
        attachment = :attachment 
        WHERE id = :contentId");


        $stine = $pdo->prepare("INSERT INTO contents 
        (challenge,problem,attachment,record_id) 
        VALUES (:challenge,:problem,:attachment,:recordId)");


        foreach($records as $record){

            $contentId = $record['id'];
            $challenge = $record['challenge'];
            $problem = $record['problem'];
            $attachment = $record['attachment'];

            if($contentId == ''){

                //  コンテンツの追加処理
                $stine->bindValue(':challenge', $challenge, PDO::PARAM_STR);
                $stine->bindValue(':problem', $problem, PDO::PARAM_STR); //添付ファイルなのであとで型を変更する
                $stine->bindValue(':attachment',$attachment, PDO::PARAM_STR);
                $stine->bindValue(':recordId',$_COOKIE['recordId'], PDO::PARAM_INT);
                $stine->execute();
                
            }else{

                // コンテンツの更新処理
                $stmt->bindValue(':contentId', $contentId, PDO::PARAM_INT);
                $stmt->bindValue(':challenge', $challenge, PDO::PARAM_STR);
                $stmt->bindValue(':problem', $problem, PDO::PARAM_STR); //添付ファイルなのであとで型を変更する
                $stmt->bindValue(':attachment',$attachment, PDO::PARAM_STR);
                $stmt->execute();


            }
                
        }
    }

    private static function getContentProperty(){

        $contentId = filter_input(INPUT_POST,'id',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);  /*[1,2] */ 
        $challenge = filter_input(INPUT_POST,'challenge',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); /* [contentId「1」を編集しました,contentId「1」を編集しました] */
        $problem = filter_input(INPUT_POST,'problem',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); /* [contentId「1」を編集しました,contentId「1」を編集しました]   */
        $attachment = filter_input(INPUT_POST,'attachment',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); /* [contentId「1」を編集しました,contentId「1」を編集しました]*/
        
        $records = [];

        // recordsの中身の連想配列を作り、records[]に挿入する処理
        for($i=0;$i<count($challenge);$i++){
            //recordsの中身の連想配列を作る
            $record = array(
                'id' =>$contentId[$i],
                'challenge' => $challenge[$i],
                'problem' => $problem[$i],
                'attachment' => $attachment[$i]
            );

            //records[]に挿入する
            array_push($records,$record);//[[id=>1,challenge=>contentId「1」を編集しました,probrem=>contentId「1」を編集しました,attachment=>contentId「1」を編集しました],[id=>2,challenge=>contentId「2」を編集しました,probrem=>contentId「2」を編集しました,attachment=>contentId「2」を編集しました]]
        }

        return $records;
    }

    
    
}
?>