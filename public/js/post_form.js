const post_form_btn = document.querySelector('#post_form_btn');
const post_form = document.querySelector('.post_form');
const modal_background = document.querySelector('.modal_background');

//ボタンを押したら、フォームを開く(フォームのdisplayを切り替える)
post_form_btn.addEventListener('click', function(){

    //フォームを開く（画面中央）
    post_form.style.display = "block";

    //タイムラインを暗くする（画面に薄黒いカバーを重ねる）
    modal_background.style.display = "block";
});


const back_btn = document.querySelector('.back_btn');
//×ボタンを押したらフォームを閉じる
back_btn.addEventListener('click', function(){

    //フォームを閉じる
    post_form.style.display = "none";

    //背景を消す
    modal_background.style.display = "none";
});
