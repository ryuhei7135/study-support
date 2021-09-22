# アプリ名

SSDB

# 概要

プログラミング・資格学習をサポートするアプリ

# 開発の背景

位置共有アプリの開発段階で何度も課題に直面しました。
そこで試行錯誤してきたことを記録し、思考を整理しながら効率的に学習を進められるようなツールがあればいいなという思いから作りました。

# こだわった点

・追記方式にすることで1つのタスクに対し、進捗度がわかりやすく、深堀りできる仕組みになっている  
  
・入力欄には全て項目があるので誰でも直感的に操作ができる  
  
・画面キャプチャーを記録できるので、言葉で表現しにくいことも記録できる

# 苦労した点

・フォルダクリック時にフォルダ内で作られたレコードのみを表示する機能  
  
・ローカル環境での画像アップロード機能
  
・本番環境でのS3を使用した画像アップロード機能  
  
・編集画面の「十」クリック時、新しいコンテンツの記入欄を表示する機能  
  
・コンテンツの追加と編集を一括に行う機能  
  
レコード：list.phpの記録  
コンテンツ:edit.phpの記録

# 使用技術
HTML/CSS/javascript/jquery/bootstrap/PHP/Mysql/aws(s3)

# 選定理由

webアプリ開発に特化しているから
