let themeSwitch = document.getElementById("themeSwitch");
let blackSun = document.getElementById("black-sun");
let whiteSun = document.getElementById("white-sun");
let html = document.querySelector("html");


var today = new Date();
var expiry = new Date(today.getTime() + 7 * 24 * 3600 * 1000); // plus 7 days


/* En fonction de si le switch de theme est activé ou non, on rajoute des classes aux éléments HTML de la page sur laquelle l'utilisateur est.
    Cela permet via bootstrap de passer au thème jour et nuit très facilement.
    On garde l'info en cookie afin de l'avoir pour toute la navigation et se souvenir des préférence utilisateur
*/
$(document).ready(function () {

    let cname = "theme";
    let ctheme = getCookie("theme");

    if (ctheme != null) {

        if (ctheme == "theme-dark") {

            html.setAttribute('data-bs-theme', "dark");
            themeSwitch.classList.remove("checked");
            whiteSun.classList.remove("d-none");
            blackSun.classList.add("d-none");
            themeSwitch.checked = false;
            themeSwitch.setAttribute("value", "theme-dark");
            
        } else {
            
            html.setAttribute('data-bs-theme', "light");
            themeSwitch.classList.add("checked");
            whiteSun.classList.add("d-none");
            blackSun.classList.remove("d-none");
            themeSwitch.checked = true;
            themeSwitch.setAttribute("value", "theme-light");
            
        }
    }
    
    $('#themeSwitch').on('change', function (e) {
        
        if (themeSwitch.classList.contains("checked") == true) {
            
            html.setAttribute('data-bs-theme', "dark");
            themeSwitch.classList.remove("checked");
            whiteSun.classList.remove("d-none");
            blackSun.classList.add("d-none");
            themeSwitch.checked = false;
            themeSwitch.setAttribute("value", "theme-dark");
            setCookie(cname, this.value);
            
        } else {
            html.setAttribute('data-bs-theme', "light");
            themeSwitch.classList.add("checked");
            whiteSun.classList.add("d-none");
            blackSun.classList.remove("d-none");
            themeSwitch.checked = true;
            themeSwitch.setAttribute("value", "theme-light");
            setCookie(cname, this.value);
        }

    });
});




// Les fonctions setCookie getCookie & deleteCookie sont là pour gérer les cookies comme les réponses par exemple
function setCookie(name, value) {

    document.cookie = name + "=" + value + "; path=/; expires=" + expiry.toGMTString();

}

function getCookie(name) {

    var re = new RegExp(name + "=([^;]+)");
    var value = re.exec(document.cookie);
    return (value != null) ? value[1] : null;

}


function deleteCookie(name) {

    document.cookie = name + "=null; path=/; expires=" + expired.toGMTString();

}
