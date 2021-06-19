<?php

class Folder{
    public static function make(){
        $icon = filter_input(INPUT_POST,'icon');/* <i class='fas fa-folder fa-3x'></i>を受け取る */
        $fp = fopen(FOLDER_TXT,'a'); /* テキストファイルを追記モードで開く */
        fwrite($fp,$icon.PHP_EOL); /* テキストファイルに追記*/
        fclose($fp);
        header('Location: http://localhost:8562/top.php');
        exit;
    }

    public static function getNumber(){

        $Number = filter_input(INPUT_POST,'folderNo');
        setcookie('folderNo',$Number);
        return $Number;
    
    }

    public static function getFolderName(){
        $folderName = filter_input(INPUT_POST,'folderName');
        $fp = fopen(FOLDER_NAME_TXT,'a'); 
        fwrite($fp,$folderName.PHP_EOL); 
        fclose($fp);
        header('Location: http://localhost:8562/top.php');
        exit;
    }


}

?>