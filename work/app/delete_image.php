<?php

require_once('./config.php');


$pdo = Database::getInstance();

/* 画像の削除処理 */
$sql = 'DELETE FROM images WHERE id=:image_id;';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':image_id', (int)$_GET['id'], PDO::PARAM_INT);
$stmt->execute();


header('Location:http://localhost/study-support/work/public/edit.php');
exit();
?>