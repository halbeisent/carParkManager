<?php

session_start();

$pageBackground = '#errorPageBG';

if (empty($_SESSION)) {
    $errorMessage = 'Erreur, vous devez vous connecter pour accéder à cette page.';
    $navbar = '../defaultNavbar.php';
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

session_write_close();
?>