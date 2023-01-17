let navbar= document.querySelector('.header .flex .navbar');

document.querySelector('#menu_btn').onclick =() => {
    navbar.classList.toggle('active');
    profile.classList.remove('active');
};

let profile= document.querySelector('.header .flex .profile');

document.querySelector('#user_btn').onclick =() => {
    profile.classList.toggle('active');
    navbar.classList.remove('active');
};

window.onscroll=()=>{
    navbar.classList.remove('active');
    profile.classList.remove('active');
}

