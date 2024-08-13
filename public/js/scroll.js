//ページを離れるときに現在のスクロール位置を保存
window.addEventListener("beforeunload", () => {
    localStorage.setItem("scrollPosition", window.scrollY);
});



//ページが読み込まれた時に、保存したスクロール位置を復元する
window.addEventListener('load', () => {
    const scrollPosition = localStorage.getItem("scrollPosition");

    if(scrollPosition){
        window.scrollTo(0, parseInt(scrollPosition, 10));
        localStorage.removeItem("scrollPosition");
    }
});
