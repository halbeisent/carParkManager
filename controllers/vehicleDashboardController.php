<?php

session_start();

if (isset($_SESSION['roleId'])) {
    $navbar = '../navbarParkManager.php';

    $vehicles = new vehicles();
    $checks = new checks();

    if (isset($_GET['vehicleId'])) {
        $vehicles->id = $_GET['vehicleId'];
        $vehicleDetails = $vehicles->getVehicleById();
        $checks->id = $_GET['vehicleId'];
        $maintenanceChecks = $checks->getMaintenanceAppointmentsByVehicleId();
        $roadSafetyChecks = $checks->getRoadSafetyAppointmentsByVehicleId();
    }
} else {
    header('Location: errorPage.php');
}