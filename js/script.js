const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

// LOGIN POPUP
document.querySelector("#show-login").addEventListener("click",function(){
    document.querySelector(".pop-up.login").classList.add("active");
});
document.querySelector(".container .close-btn").addEventListener("click",function(){
    document.querySelector(".pop-up.login").classList.remove("active");
});

function verification() {
    const popUp = document.querySelector('.pop-up.login');
    const container = document.getElementById('container');
    if (popUp && container) {
        popUp.classList.add('active');
        container.classList.add('active');
    } else {
        console.error("Popup or container element not found.");
    }
}
function poploginwithError() {
    const popUp = document.querySelector('.pop-up.login');
    if (popUp && container) {
        popUp.classList.add('active');
    } else {
        console.error("Popup or container element not found.");
    }
}
function poplogin() {
    const popUp = document.querySelector('.pop-up.login');
    if (popUp) {
        popUp.classList.add('active');
    } else {
        console.error("Popup or container element not found.");
    }
}




