# アプリ名

SSDB

# 概要

ヘルプデスク業務・プログラミング学習をサポートするアプリ

# 開発の背景

現職のヘルプデスク業務では「ユーザーが実現したいこと」「解決に向けて試したこと」「試したことに対しての問題点」の3点を意識してきました。  
そこで試行錯誤したことを記録し、進捗を管理できるようなシステムがあればいいなという思いから作りました。

# こだわった点

・追記方式にすることで1つのタスクに対し、進捗度がわかりやすく、深堀りできる仕組みになっている  
  
・入力欄には全て項目があるので誰でも直感的に操作ができる  
  
・画面キャプチャーを記録できるので、言葉で表現しにくいことも記録できる

・フォルダーとタスクの削除機能にAjaxを使用

・レスポンシブデザイン対応

# 苦労した点

・フォルダクリック時にフォルダ内で作られたレコードのみを表示する機能  
  
・ローカル環境での画像アップロード機能
  
・本番環境でのS3を使用した画像アップロード機能  
  
・編集画面の「十」クリック時、新しいコンテンツの記入欄を表示する機能  
  
・コンテンツの追加と編集を一括に行う機能  
  
レコード：list.phpの記録  
コンテンツ:edit.phpの記録

# 使用技術
HTML/CSS/javascript/jquery/bootstrap/PHP/Mysql/AWS(s3)/Ajax

# 選定理由

webアプリ開発に特化しているから
