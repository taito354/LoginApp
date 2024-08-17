const btn = document.querySelector('#search_btn');
const form = document.querySelector('#search_form');

console.log(btn);
console.log(form);

btn.addEventListener('click', modal_open);
function modal_open(){

    if(form.style.display == "none"){
        form.style.display = "flex";
    }else{
        form.style.display = "none";
    }

}
