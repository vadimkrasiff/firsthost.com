"use strict";
const setDisplayLeft = () => {
    let el = document.querySelector(".users");
    let left = el.style.left;
    if (left == '') el.style.left = '0px';
    left = +el.style.left.slice(0, el.style.left.length - 2);
    console.log(el.offsetWidth);
    if (el.offsetWidth < 160 * 7) { document.querySelector(".left_user").style.display = "none" }
    else { document.querySelector(".right_user").style.display = "flex"; }
   
}
const onRightClick = () => {

    let el = document.querySelector(".users");
    let left = el.style.left;
    if (left == '') el.style.left = '0px';

    left = +el.style.left.slice(0, el.style.left.length - 2);

    if (left < 0) {
        left += 160;
        document.querySelector(".users").style.left = left + 'px';
    } else {
        document.querySelector(".users").style.left = "0px";
    };
    if (left == 0 || left == "0px") { document.querySelector(".right_user").style.display = "none" }
    else { document.querySelector(".right_user").style.display = "flex"; };
}

const onLeftClick = () => {

    let el = document.querySelector(".users");
    let left = el.style.left;
    if (left == '') el.style.left = '0px';

    left = el.style.left.slice(0, el.style.left.length - 2);

    if (left > -el.offsetWidth + 160 * 7) {

        left -= 160;
        document.querySelector(".users").style.left = left + 'px';
    } else {
        document.querySelector(".users").style.left = "0px";
        document.querySelector(".right_user").style.display = "none"
    }
    if (left == 0 || left == "0px") { document.querySelector(".right_user").style.display = "none" }
    else { document.querySelector(".right_user").style.display = "flex"; };
}   