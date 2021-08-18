"use strict";
{
  $(function () {
    const deletes = document.querySelectorAll(".delete"); /* バツボタン */
    const folders = document.querySelectorAll("i"); /* フォルダ */
    const records =
      document.querySelectorAll(".record"); /* 一覧画面に表示されているリスト */
    console.log(records[0]);
    const addAndEdits =
      document.querySelectorAll(
        ".addAndEdit"
      ); /* 一覧画面に表示されているリスト */
    const icons = document.querySelectorAll('[name="icon"]'); //<i class='fas fa-folder fa-3x'></i>
    const foldersDelete = document.querySelectorAll(".folderDelete");

    deletes.forEach((span) => {
      // console.log(span);
      span.addEventListener("click", () => {
        if (!confirm("本当に削除しますか？")) {
          return;
          // alert("キャンセルされました");
        }
        span.parentNode.submit();
      });
    });

    /* フォルダをクリックするとフォルダIDを送信 */
    folders.forEach((folder) => {
      folder.addEventListener("click", () => {
        folder.parentNode.submit();
      });
    });

    /* フォルダがクリックされたときの処理  一覧画面へ遷移 */
    if (typeof folderId !== "undefined") {
      window.location.href =
        "http://localhost/study-support/work/public/list.php";
    } else {
    }

    records.forEach((record) => {
      record.addEventListener("click", () => {
        record.firstElementChild.submit();
      });
    });

    addAndEdits.forEach((addAndEdit) => {
      addAndEdit.addEventListener("click", () => {
        addAndEdit.parentNode.submit();
      });
    });

    /* フォルダ作成 */
    /* 非同期でフォルダを作ることに成功したが、リロードしないと表示されないのでDOM操作で予めフォルダを作っておく処理が必要 */
    // makeFolderButton.addEventListener('click',()=>{
    //     fetch('?action=makeFolder',{
    //         method:'POST',
    //         body: new URLSearchParams({
    //             icon: icon.value,
    //             token: token.value
    //         })
    //     })
    //     /* フォルダは作られるがリロードしないと表示されないので前もって作っておく */
    //     const i = document.createElement('i');
    //     i.classList.add("fas","fa-folder","fa-3x");
    //     document.querySelector('.doing-top').appendChild(i);
    // });

    foldersDelete.forEach((folderDelete) => {
      folderDelete.addEventListener("click", () => {
        if (confirm("本当に削除しますか？")) {
          folderDelete.parentNode.submit();
        }
      });
    });

    /* モーダルの位置を画面の中央に設定する関数 */
    function centeringModalSyncer() {
      var w = $(window).width();
      var h = $(window).height();

      var cw = $(".modal").outerWidth();
      var ch = $(".modal").outerHeight();

      $(".modal").css({
        left: (w - cw) / 2 + "px",
        top: (h - ch) / 2 + "px",
      });
    }

    $(".makeFolderBtn,.makeTaskBtn").click(function (e) {
      e.preventDefault();
      //モーダル表示
      $("body").append('<div class="modal-bg"></div>');
      centeringModalSyncer();
      $(".modal-bg,.modal").fadeIn("slow");

      //モーダル非表示
      $(".close-modal").click(function (e) {
        e.preventDefault();
        $(".modal,.modal-bg").fadeOut("slow", function () {
          $(".modal-bg").remove();
        });
      });
    });

    //ブラウザバック無効化
    history.pushState(null, null, null);

    //ブラウザバックボタン押下時
    $(window).on("popstate", function (event) {
      history.pushState(null, null, null);
      window.alert("ブラウザの戻るボタンは使わないでください");
    });

    /* 編集画面のプラスボタンクリック時の処理 */

    $(".plus").click(function () {
      var clone = $(".cloneTarget").clone(true); //コピーを作成

      clone.attr("class", "entryRecord"); //次回クリック時にコピーする要素
      // clone.appendTo($(".entryRecordArea")); //コピーを挿入
      clone.appendTo($(".entryRecordArea")).hide().slideDown(); //コピーを挿入
    });

    // 画像のプレビュー表示
    $("#input-file").change(function (e) {
      // $("img").remove();
      //画像が選択されたファイルフォームを取得
      let inputFile = e.target;

      //ファイルフォームの兄弟要素のプレビューを取得
      let preview = inputFile.nextElementSibling;

      //アップロードされたファイルの情報を取得
      var file = $(this).prop("files")[0];
      var fileReader = new FileReader();

      //プレビューを表示
      fileReader.onloadend = function () {
        $(preview).html(
          '<img src="' + fileReader.result + '" width="180" height="180"/>'
        );
      };

      fileReader.readAsDataURL(file);
    });

    /* 完了・未完了ボタンクリック時の処理 */
    $(".done,.notDone").click(function (e) {
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
      // console.log($(".editbtn").closest(".sbmt-content").length);
    });
  });
}
