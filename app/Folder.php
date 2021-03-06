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
        $stmt = $pdo->prepare("DELETE FROM folders WHERE id = :id");
        $stmt->bindValue('id', $folderId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function makeFolder($pdo){
        $folderName = trim(filter_input(INPUT_POST,'folderName'));
        if($folderName == ''){
            return;
        }
        $stmt = $pdo->prepare("INSERT INTO folders (`name`) VALUES (:folderName)");
        $stmt->bindValue('folderName', $folderName, PDO::PARAM_STR);
        $stmt->execute();
        header('Location: ../index.php'); /* フォルダは作られるがリロードしないと表示されないので書いた */
    }

    public static function getFolder($pdo){
        $stmt = $pdo->query("SELECT * FROM folders");
        $folders = $stmt->fetchAll();

        return $folders;
    }


}

?>