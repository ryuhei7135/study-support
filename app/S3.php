<?php

class S3{

    public static function GetS3Instance(){
        $s3 = new Aws\S3\S3Client([
            'version'  => 'latest',
            'region'   => 'ap-northeast-1',
        ]);

        return $s3;

    }

    public static function saveImageToBacket($s3,$bucket,$upload_image){

        $attachments = [];

        for($j = 0;$j<count($upload_image);$j++){

            

            if(is_uploaded_file($upload_image[$j])){

                // 画像をバケットに保存
                $result = $s3->putObject(array(
                    'Bucket' => $bucket,
                    'Key' => $_FILES['attachment']['name'][$j],
                    'Body' => fopen($upload_image[$j],'rb'),
                    'ACL' => 'public-read', // 画像は一般公開されます
                    'ContentType' => mime_content_type($upload_image[$j]),
                ));

                // var_dump($result['ObjectURL']);

                array_push($attachments,$result['ObjectURL']);

                echo '画像アップロード処理が実行されました';

            }
        }   

        return $attachments;
    
    }
}

?>
