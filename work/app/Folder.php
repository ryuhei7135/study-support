<?php

class Folder{
    

    public static function getFolderId(){

        $folderId = filter_input(INPUT_POST,'folderId');
        setcookie('folderId',$folderId);
        return $folderId;
    
    }

    public static function getFolderName(){
        $folderName = filter_input(INPUT_POST,'folderName');
        setcookie('folderName',$folderName);
        return $folderName;
    }

    

    public static function deleteFolder($pdo){
        
        $folderId = filter_input(INPUT_POST,'folderId');
        $stmt = $pdo->prepare("DELETE FROM folder WHERE id = :id");
        $stmt->bindValue('id', $folderId, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: http://localhost:8562/top.php'); /* フォルダは削除されているがリロードしないと画面からは消えないので書いた */

    }

    public static function makeFolder($pdo){
        $folderName = filter_input(INPUT_POST,'folderName');
        $stmt = $pdo->prepare("INSERT INTO folder (folder_name) VALUES (:folderName)");
        $stmt->bindValue('folderName', $folderName, PDO::PARAM_STR);
        $stmt->execute();
        header('Location: http://localhost:8562/top.php'); /* フォルダは作られるがリロードしないと表示されないので書いた */
    }


}

?>