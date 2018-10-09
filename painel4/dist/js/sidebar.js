var open = document.getElementById('open-navbar');
var close = document.getElementById('close-navbar');


open.addEventListener('click', function () {
    document.querySelector('.sidenav').classList.remove('open-b');
    document.querySelector('.sidenav').classList.add('open-a');
});


close.addEventListener('click', function () {
    document.querySelector('.sidenav').classList.remove('open-a');
    document.querySelector('.sidenav').classList.add('open-b');
});