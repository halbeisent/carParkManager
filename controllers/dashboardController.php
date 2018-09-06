<?php

session_start();

if (empty($_SESSION)) {
    header('Location: ../views/errorPage.php');
}

$users = new users();

$vehicles = new vehicles();

$checks = new checks();

$userRole = '';;

if (isset($_SESSION['userId'])) {
    $users->id = $_SESSION['userId'];
    $detailedUserProfile = $users->getUserbyId();
    $vehicles->userId = $_SESSION['userId'];
    $vehicleCard = $vehicles->getVehicleByUser();
    $checks->id = $_SESSION['userId'];
    $maintenanceChecks = $checks->getMaintenanceAppointmentsByUserId();
    $roadSafetyChecks = $checks->getRoadSafetyAppointmentsByUserId();
}



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

session_write_close();
