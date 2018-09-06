<?php

session_start();

/* J'instancie un nouvel objet users */
$vehicles = new vehicles();


if ($_SESSION['roleId'] == 2) {
    $navbar = '../navbarParkManager.php';
    /* Si je fais passer un id en paramètre d'URL */
    if (isset($_GET['delId'])) {
        /* Je le stocke dans l'objet $users->id */
        $vehicles->id = $_GET['delId'];
        /* Puis j'éxécute ma méthode */
        $vehiclesRemoval = $vehicles->deleteVehicleOnly();
        /* Si ma requête renvoie true */
        if ($vehiclesRemoval) {
            $isDeleted = true;
        }
    }
} else {
    header('Location: errorPage.php');
}

$vehiclesList = $vehicles->getVehiclesList();

session_write_close();
