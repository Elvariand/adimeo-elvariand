
// Création du message d'avertissement lorsque l'on clique sur le bouton de deconnexion
document.querySelector("#btn-logout").addEventListener("click", function (e) {

    e.preventDefault();

    document.getElementById("boxBack").classList.add("show");

    document.getElementById("boxTxt").innerHTML = "<h4>Do you really wish to logout ?</h4>";

    document.getElementById("cancelBtn").classList.remove("d-none");

    // Si l'utilisateur clique sur annuler, cela referme le message d'erreur et la navigation peut continuer
    document.getElementById("cancelBtn").addEventListener("click", function () {
        document.getElementById("boxBack").classList.remove("show");
        document.getElementById("cancelBtn").classList.add("d-none");
    });

    // S'il clique sur l'autre bouton, il se déconnecte réellement en passant par la route logout
    document.getElementById("errorBtn").addEventListener("click", function () {
        if (document.getElementById("cancelBtn").classList.contains('d-none')) {
            document.getElementById("boxBack").classList.remove("show");
        } else {

            // Déconnexion de google
            google.accounts.id.revoke();
            google.accounts.id.disableAutoSelect();
            window.location.href = "http://localhost:8000/logout";
        }
    });

});