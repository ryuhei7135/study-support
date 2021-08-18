<?php

define('DSN','mysql:host=localhost;dbname=study_support;charset=utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', '');

require_once('Token.php');
require_once('Database.php');
require_once('Todo.php');
require_once('Folder.php');
require_once('Record.php');
require_once('Content.php');
require_once('Image.php');
require_once('Utils.php');

session_start();
?>