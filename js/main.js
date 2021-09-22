'"use strict"';
{
  $(function () {
    $(".folderDeleteButton").click(function (e) {
      Folder.deleteFolder(e);
    });

    $(".record").click(function (e) {
      Record.clickRecord(e);
    });

    $(".deleteRecord").click(function (e) {
      Record.deleteRecord(e);
    });

    $(".makeFolderBtn,.makeTaskBtn").click(function (e) {
      Modal.showModal(e);
    });

    /* 編集画面のプラスボタンクリック時の処理 */
    $(".plus").click(function () {
      Content.makeEntryField();
    });

    $(".done,.notDone").click(function (e) {
      Content.submitContents(e);
    });

    $(".pulldown-btn").click(function (e) {
      Record.showRecord(e);
    });

    //ブラウザバック無効化
    history.pushState(null, null, null);

    $(window).on("popstate", function () {
      Utils.clickBackBtn();
    });

    const folders = document.querySelectorAll("i"); /* フォルダ */

    /* フォルダをクリックするとフォルダIDを送信 */
    folders.forEach((folder) => {
      folder.addEventListener("click", () => {
        folder.parentNode.submit();
      });
    });

    /* フォルダがクリックされたときの処理  一覧画面へ遷移 */
    if (typeof folderId !== "undefined") {
      window.location.href =
        "../list.php";
    } else {
    }

    // 画像のプレビュー表示処理
    $("#input-file").change(function (e) {
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
  });
}