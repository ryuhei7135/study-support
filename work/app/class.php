<?php
/* 学習記録記入欄のテキストボックスのクラス */
Class textClam{
    public $title;
    public $divClass;
    public $postName;
    public function __construct($title,$className,$postName){
        $this->title = $title;
        $this->className = $className;
        $this->postName = $postName;

    }

}


?>