<?php
include '../models/database.php';
include '../models/vehicles.php';
include '../models/checks.php';
$pageBackground = 'vehicleDashboardBody';
$pageTitle = 'Dashboard Véhicule';
include '../header.php';
include '../controllers/vehicleDashboardController.php';
include $navbar;
?>
<div class="jumbo"></div>
<div class="container icons">
    <div class="big-icon"></div>
</div>
<div class="details">
    <h3><?= $vehicleDetails->manufacturerName . ' ' . $vehicleDetails->modelName ?></h3>
    <p><?= $vehicleDetails->userFirstName . ' ' . $vehicleDetails->userLastName; ?></p>
</div>
<div class="container">
    <div class="section">
        <h5>Informations du véhicule</h5>
        <div class="card-panel">
            <p class="center-align">Numéro de série (VIN): <?= $vehicleDetails->serialNumber ?></p>
            <p class="center-align">Catégorie de véhicule: <?= $vehicleDetails->vehiclesTypes ?></p>
            <p class="center-align">Carburant du véhicule: <?= $vehicleDetails->energyType ?></p>
        </div>
    </div>
    <div class="section">
        <h5>Entretien du véhicule</h5>
        <div class="card-panel">
            <table>
                <thead>
                    <tr>
                        <th>Dernière visite d'entretien</th>
                        <th>Prochaine visite d'entretien</th>
                        <th>Détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($maintenanceChecks as $maintenanceCheck) { ?>
                        <tr>
                            <td><?= $maintenanceCheck->maintenanceCheckDate ?></td>
                            <td><?= $maintenanceCheck->maintenanceNextCheckDate ?></td>
                            <td><a href="maintenanceCheck.php?mcid=<?= $maintenanceCheck->id ?>"><i class="material-icons">description</i></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="section">
        <h5>Contrôle technique</h5>
        <div class="card-panel">
            <table>
                <thead>
                    <tr>
                        <th>Dernier contrôle technique</th>
                        <th>Prochain contrôle technique</th>
                        <th>Détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roadSafetyChecks as $roadSafetyCheck) { ?>
                        <tr>
                            <td><?= $roadSafetyCheck->date ?></td>
                            <td><?= $roadSafetyCheck->nextDate ?></td>
                            <td><a href="roadSafetyCheck.php?rcid=<?= $roadSafetyCheck->id ?>"><i class="material-icons">description</i></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>