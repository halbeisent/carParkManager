<?php

/* Je démarre ma variable de session */
session_start();

/* Je prépare le fond de ma page */
$pageBackground = '#errorPageBG';

/* Si ma variable de session est vide */
if (empty($_SESSION)) {
    $errorMessage = 'Erreur, vous devez vous connecter pour accéder à cette page.';
    $navbar = '../defaultNavbar.php';
    /* S'il n'est pas vide */
} else if ($_SESSION['roleId'] == 3) {
    $errorMessage = 'Erreur: vous n\'avez pas accès à cette page';
    $navbar = '../navbarUser.php';
} else if ($_SESSION['roleId'] == 2) {
    $errorMessage = 'Erreur: vous n\'avez pas accès à cette page';
    $navbar = '../navbarParkManager.php';
} else if ($_SESSION['roleId'] == 1) {
    $errorMessage = 'Erreur: vous n\'avez pas accès à cette page';
    $navbar = '../navbarAdmin.php';
}

/* Je ferme ma session en gardant les variables de session et leur contenu */
session_write_close();
?>