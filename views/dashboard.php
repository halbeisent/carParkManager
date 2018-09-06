<?php
/* J'inclus les ressources dont j'ai besoin */
include '../models/database.php';
include '../models/users.php';
include '../models/vehicles.php';
include '../models/checks.php';
/* Je définis le nom de ma page et son fond */
$pageTitle = 'Dashboard utilisateur';
$pageBackground = 'userDashboardBody';
include '../header.php';
include '../controllers/dashboardController.php';
/* J'inclus ma navbar en fonction du role utilisateur via sa variable */
include $navbar;
?>
<div class="jumbo"></div>
<div class="container icons">
    <div class="big-icon"></div>
</div>
<div class="details">
    <h3><?= $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] ?></h3>
    <p><?= $userRole; ?></p>
</div>
<div class="container">
    <div class="section">
        <h5>Votre profil</h5>
        <div class="card-panel">
            <p class="center-align">
                <strong>Nom:</strong> <?= $users->lastName ?><br />
                <strong>Prénom:</strong> <?= $users->firstName ?><br />
                <strong>Addresse:</strong> <?= $users->streetNumber ?> <?= $users->streetName ?> <?= $users->zipCode ?> <?= $users->city ?><br />
                <strong>Date de naissance:</strong> <?= $users->birthDate ?><br />
                <strong>Scan du permis:</strong> <a href="<?= $users->licenseScanPath ?>">Ouvrir</a><br />
                <strong>Numéro du permis:</strong> <?= $users->licenseNumber ?><br />
            </p>
        </div>
    </div>
    <div class="divider"></div>
    <div class="section">
        <h5>Véhicule(s) attribué(s)</h5>
        <div class="row">
            <?php foreach ($vehicleCard as $vehicle) { ?>
                <div class="col s12 m6 l6">
                    <div class="card">
                        <div class="card-image">
                            <img src="<?= $vehicle->exteriorPic ?>">
                            <span class="card-title"><?= $vehicle->manufacturerName ?> <?= $vehicle->modelName ?></span>
                        </div>
                        <div class="card-action">
                            <div class="row">
                                <div class="action-btn col"><a class="btn-floating btn-large blue-grey darken-3" href="vehicleDashboard.php?vehicleId=<?= $vehicle->vehicleId ?>"><i class="material-icons">dashboard</i></a></div>
                                <div class="action-btn col"><a class="btn-floating btn-large blue-grey darken-3" href="vehicleHistory.php?vehicleId=<?= $vehicle->vehicleId ?>"><i class="material-icons">history</i></a></div>
                                <?php if ($_SESSION['roleId'] == 2) { ?>
                                    <div class="action-btn col"><a class="btn-floating btn-large blue-grey darken-3" href="vehicleForm.php?vehicleId=<?= $vehicle->vehicleId ?>"><i class="material-icons">edit</i></a></div>
                                    <div class="action-btn col"><a class="btn-floating btn-large red" href="dashboard.php?delVehicle=<?= $vehicle->vehicleId ?>"><i class="material-icons">delete</i></a></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
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
<?php
include '../footer.php';
?>