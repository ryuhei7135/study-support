<?php
/* 学習記録記入画面のテキストボックスのインスタンス */
$proSummary = new textClam('問題概要:','box pro_summary','pro_summary');
$proDetail = new textClam('問題詳細:','box pro_detail','pro_detail');
$proAttachment = new textClam('添付ファイル:','box pro_attachment','pro_attachment');
$soSummary = new textClam('対処概要:','box pro_sosummary','pro_sosummary');
$soDetail = new textClam('対処詳細:','box pro_sodetail','pro_sodetail');
$soAttachment = new textClam('添付ファイル:','box pro_attachment','so_attachment');


$problems = array($proSummary,$proDetail,$proAttachment);

$solutions =array($soSummary,$soDetail,$soAttachment);



?>