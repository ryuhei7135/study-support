<?php

define('DSN','mysql:dbname=heroku_494641d6253bc4a;host=us-cdbr-east-04.cleardb.com;charset=utf8');
define('DB_USER', 'bb805e1b9243e2');
define('DB_PASS', '313fe960');


require_once('Token.php');
require_once('Database.php');
require_once('Folder.php');
require_once('Record.php');
require_once('Content.php');
require_once('Image.php');
require_once('Utils.php');
require_once('S3.php');

// session_set_cookie_params(60);
session_start();
?>