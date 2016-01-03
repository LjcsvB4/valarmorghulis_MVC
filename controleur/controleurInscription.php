<?php

require 'modele/modeleInscription.php';
// Affiche la liste de tous les billets du blog
function inscription() {
    /*$billets = getBillets();*/
    require 'vue/vueInscription.php';
}

// Affiche les détails sur un billet
function billet($idBillet) {
    $billet = getBillet($idBillet);
    $commentaires = getCommentaires($idBillet);
    require 'vue/vueViewPost.php';
}
// Affiche une erreur
/*function erreur($msgErreur) {
    require 'vue/vueErreur.php';
}*/

function accueil() {
    /*$billets = getBillets();*/
    require 'vue/vueMemberPage.php';
}

function accueilAdmin() {
    /*$billets = getBillets();*/
    require 'vue/admin/vueAccueil.php';
}

function connexion() {
    /*$billets = getBillets();*/
    require 'vue/vueConnexion.php';
}


