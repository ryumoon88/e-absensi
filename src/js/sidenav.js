var sidenav = document.querySelector('.sidenav-body');
var sidenav_btn_open = document.querySelector('#sidenav-btn-open');
var sidenav_btn_close = document.querySelector('#sidenav-btn-close');
var sidenav_overlay = document.querySelector('.sidenav-overlay');

sidenav_btn_open.addEventListener('click', function () {
    sidenav.classList.add('sidenav-open');
    sidenav_overlay.classList.add('overlay-open');
})

sidenav_btn_close.addEventListener('click', function () {
    sidenav.classList.remove('sidenav-open')
    sidenav_overlay.classList.remove('overlay-open');
})

sidenav_overlay.addEventListener('click', function () {
    sidenav.classList.add('pulse');
    setTimeout(() => {
        sidenav.classList.remove('pulse')
    }, 500);
})
