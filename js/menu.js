// DROPDOWN MENU
function dropdownClick(target) {
    if (document.querySelectorAll(target)[0].classList.contains('active')) {
        document.querySelectorAll(target)[0].classList.remove('active');
    }
    else document.querySelectorAll(target)[0].classList.toggle('active');
}
document.querySelector(".profileddtrigger").addEventListener("click", function() {
    dropdownClick('.profiledd');
}); 