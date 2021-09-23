<?php

class Database{

    private static $instance;

    public static function getInstance(){

        try{
            if(!isset(self::$instance)){

                // self::$instance = new PDO(DSN,DB_USER,DB_PASS,
                // [
                //     PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                //     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                //     PDO::ATTR_EMULATE_PREPARES => false,
                // ]
                // );

                self::$instance = new PDO(DSN,DB_USER,DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone='+09:00'"
                ]
                );
            }
            
            return self::$instance;
            
        }catch(PDOException $e){
            echo $e->getMessage();
            exit;
        }
    }
}

?>