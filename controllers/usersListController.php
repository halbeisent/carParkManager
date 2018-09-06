<?php

session_start();

/* J'instancie un nouvel objet users */
$users = new users();


if ($_SESSION['roleId'] == 1) {
    /* Si je fais passer un id en paramètre d'URL */
    if (isset($_GET['delId'])) {
        /* Je le stocke dans l'objet $users->id */
        $users->id = $_GET['delId'];
        /* Puis j'éxécute ma méthode */
        $userRemoval = $users->deleteUserById();
        /* Si ma requête renvoie true */
        if ($userRemoval) {
            $isDeleted = true;
        }
    }
} else {
    header('Location: errorPage.php');
}

$usersList = $users->getUserList();

if ($_SESSION['roleId'] == 3) {
    $navbar = '../navbarUser.php';
} else if ($_SESSION['roleId'] == 2) {
    $navbar = '../navbarParkManager.php';
} else if ($_SESSION['roleId'] == 1) {
    $navbar = '../navbarAdmin.php';
}

session_write_close();
