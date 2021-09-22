class Folder {
  static deleteFolder(e) {
    if (confirm("本当に削除しますか？")) {
      let currentTarget = $(e.currentTarget);
      fetch("?action=deleteFolder", {
        method: "POST",
        body: new URLSearchParams({
          folderId: currentTarget.data("folderId"),
          token: currentTarget.data("token"),
        }),
      });
      currentTarget.parent().remove();
    }
  }
}
