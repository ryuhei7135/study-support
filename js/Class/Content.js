class Content {
  // 新たなコンテンツの記入欄を挿入
  static makeEntryField() {
    var clone = $(".cloneTarget").clone(true); //コピーを作成

    clone.attr("class", "entryRecord"); //次回クリック時にコピーする要素
    // clone.appendTo($(".entryRecordArea")); //コピーを挿入
    clone.appendTo($(".entryRecordArea")).hide().slideDown(); //コピーを挿入
  }

  /* 完了・未完了ボタンクリック時の処理 */
  static submitContents(e) {
    // aタグのイベントの無効化;
    e.preventDefault();

    if ($(e.target).attr("value") == "done") {
      /* 完了ボタンのとき */
      $(".status").attr("value", "done");
    } else {
      /* 未完了のとき */
      $(".status").attr("value", "notDone");
    }
    //aタグの親のフォームを送信
    $(".edit-btn").closest(".sbmt-content").submit();
  }
}