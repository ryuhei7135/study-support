<?php
/* 学習記録記入欄のテキストボックスのクラス */
Class textClam{
    public $title;
    public $className;
    public $postName;
    public $id;
    public function __construct($title,$className,$postName,$id){
        $this->title = $title;
        $this->className = $className;
        $this->postName = $postName;
        $this->id = $id;
    }

}


?>