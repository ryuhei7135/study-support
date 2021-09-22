class Modal {
  /* モーダルの位置を画面の中央に設定する関数 */
  static centeringModalSyncer() {
    var w = $(window).width();
    var h = $(window).height();

    var cw = $(".modal").outerWidth();
    var ch = $(".modal").outerHeight();

    $(".modal").css({
      left: (w - cw) / 2 + "px",
      top: (h - ch) / 2 + "px",
    });
  }

  static showModal(e) {
    e.preventDefault();
    //モーダル表示
    $("body").append('<div class="modal-bg"></div>');
    this.centeringModalSyncer();
    $(".modal-bg,.modal").fadeIn("slow");

    //モーダル非表示
    $(".close-modal").click(function (e) {
      e.preventDefault();
      $(".modal,.modal-bg").fadeOut("slow", function () {
        $(".modal-bg").remove();
      });
    });
  }
}