<?php

/* Je démarre ma session pour en récupérer les variables */
session_start();

/* Si ma variable superglobale SESSION est vide */
if (empty($_SESSION)) {
    /* Je redirige vers ma page d'erreur */
    header('Location: ../views/errorPage.php');
}

/* J'instancie un objet users héritant des paramètres de la classe users */
$users = new users();

/* J'instancie un objet vehicles héritant des paramètres de la classe vehicles */
$vehicles = new vehicles();

/* J'instancie un objet checks héritant des paramètres de la classe checks */
$checks = new checks();

/* J'initialise ma variable userRole à vide */
$userRole = '';

/* Si ma variable de session existe */
if (isset($_SESSION['userId'])) {
    /* Je remplis les paramètres de l'objet ayant appelé la méthode avec mes variables de session */
    $users->id = $_SESSION['userId'];
    $detailedUserProfile = $users->getUserbyId();
    $vehicles->userId = $_SESSION['userId'];
    $vehicleCard = $vehicles->getVehicleByUser();
    $checks->id = $_SESSION['userId'];
    $maintenanceChecks = $checks->getMaintenanceAppointmentsByUserId();
    $roadSafetyChecks = $checks->getRoadSafetyAppointmentsByUserId();
}


/* Le tableau de bord étant commun à tous les utilisateurs, j'inclus du code visant à déterminer quelle navbar charger */
if ($_SESSION['roleId'] == 3) {
    $userRole = 'Utilisateur';
    $navbar = '../navbarUser.php';
} else if ($_SESSION['roleId'] == 2) {
    $userRole = 'Gestionnaire de parc';
    $navbar = '../navbarParkManager.php';
} else if ($_SESSION['roleId'] == 1) {
    $userRole = 'Administrateur';
    $navbar = '../navbarAdmin.php'; 
}

/* Pour finir, je ferme ma session en gardant les variables pour plus tard*/
session_write_close();
