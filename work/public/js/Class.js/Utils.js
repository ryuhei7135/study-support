class Utils {
  //ブラウザバックボタン押下時
  static clickBackBtn() {
    history.pushState(null, null, null);
    window.alert("ブラウザの戻るボタンは使わないでください");
  }
}
