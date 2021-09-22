class Record {
  static state = "false";

  static deleteRecord(e) {
    if (confirm("本当に削除しますか？")) {
      let currentTarget = $(e.currentTarget);
      fetch("?action=delete", {
        method: "POST",
        body: new URLSearchParams({
          recordId: currentTarget.data("recordId"),
          token: currentTarget.data("token"),
        }),
      });
      currentTarget.parent().remove();
    }
  }

  static clickRecord(e) {
    $(e.currentTarget).children("form").submit();
  }

  static showRecord(e) {
    if (this.state == "false") {
      //非表示状態の処理
      var target = $(e.currentTarget);
      target.parent().nextAll().show();

      //アイコンの変更
      target.html('<i class="fas fa-caret-up"></i>');

      this.state = "true";
    } else {
      //表示状態の処理
      var target = $(e.currentTarget);
      target.parent().nextAll().hide();

      // アイコンの変更
      target.html('<i class="fas fa-caret-down"></i>');

      this.state = "false";
    }
  }
}