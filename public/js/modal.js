const delete_form_open = document.querySelector('#delete_form_open');
const delete_btn = document.querySelector('#delete_btn');

delete_btn.style.display = "none";

//削除ボタンを表示する関数を定義
const modal_open = () => {
    delete_btn.style.display = "block";
};

// 表示ボタンに削除ボタンを表示する関数を割り当てる
delete_form_open.addEventListener('click', modal_open);

delete_btn.addEventListener('click',function(event){

    const check = confirm("本当にアカウントを削除してよろしいですか？");

    if(!check){
        event.preventDefault();
    }
});

