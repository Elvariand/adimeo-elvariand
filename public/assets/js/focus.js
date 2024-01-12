
function magnify(imgID, zoom) {
    img = document.getElementById(imgID);
    var img, glass, w, h, bw;
    url = "/assets/img/apod/hd/hd_" + img.src.substring(41);

    /* Creation de la loupe */
    glass = document.createElement("DIV");
    glass.setAttribute("class", "img-magnifier-glass text-center mx-auto d-flex justify-content-center");
    img.parentElement.insertBefore(glass, img);

    /* On règle le background sur l'image HD et zoomée */
    glass.style.backgroundImage = "url('" + url + "')";
    glass.style.backgroundRepeat = "no-repeat";
    glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
    bw = 3;
    w = glass.offsetWidth / 2;
    h = glass.offsetHeight / 2;

    /* Execute la fonction de loupe quand on bouge la souris sur l'image */
    glass.addEventListener("mousemove", moveMagnifier);
    img.addEventListener("mousemove", moveMagnifier);

    /* et avec les ecrans tactiles*/
    glass.addEventListener("touchmove", moveMagnifier);
    img.addEventListener("touchmove", moveMagnifier);


    function moveMagnifier(e) {
        var pos, x, y, delta;

        e.preventDefault();
        /* on récupère les position X et Y du curseur */
        pos = getCursorPos(e);
        x = pos.x;
        y = pos.y;
        /* on adapte au décalage lié aux réglages bootstrap */
        margin = getComputedStyle(img).getPropertyValue('margin-left');
        delta = parseInt(margin.substring(0,margin.length-2));

        /* Avec ça la loupe reste à l'intérieur de l'image */
        if (x > img.width - (w / zoom)) { x = img.width - (w / zoom); }
        if (x < w / zoom) { x = w / zoom; }
        if (y > img.height - (h / zoom)) { y = img.height - (h / zoom); }
        if (y < h / zoom) { y = h / zoom; }

        /* Position de la loupe avec le delta lié à bootstrap */
        glass.style.left = (x - w + delta) + "px";
        glass.style.top = (y - h) + "px";

        /* Déplacement du BG HD pour voir effectivement ce que l'on point avec la souris */
        glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
    }

    function getCursorPos(e) {
        var a, x = 0, y = 0;

        /* Les positions X et Y de l'image */
        a = img.getBoundingClientRect();

        /* Calcul de la position du curseur relative à l'image */
        x = e.pageX - a.left;
        y = e.pageY - a.top;

        /* Compensation du scroll */
        x = x - window.scrollX;
        y = y - window.scrollY;
        return { x: x, y: y };
    }
}