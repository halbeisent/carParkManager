<?php
/* J'inclus mon modèle database pour pouvoir me connecter */
include '../models/database.php';
/* J'inclus mon modèle vehicles pour avoir toutes les fonctions relatives à ma gestion de véhicules */
include '../models/vehicles.php';
/* J'inclus mon contrôleur pour cette vue */
include '../controllers/vehiclesListController.php';
/* J'inclus ma navbar en materialize via une navbar qui change dynamiquement, voir mon controleur pour plus d'informations */
include $navbar;
/* J'appelle mon id qui modifie mon fond de page dynamiquement */
$pageBackground = 'vehiclesListBG';
/* J'appelle ma variable qui change le titre de ma page dynamiquement */
$pageTitle = 'Liste des véhicules';
/* J'inclus mon header pour avoir toutes mes ressources (notemment materializecss, jquery) */
include '../header.php';
?>
<div class="container">
    <!-- Je remplis les informations de ma modale dynamiquement -->
    <?php foreach ($vehiclesList as $vehicle) { ?>
        <!-- Structure de la modale -->
        <div id="modal<?= $vehicle->id ?>" class="modal">
            <!-- Contenu de la modale -->
            <div class="modal-content">
                <h4>Suppression d'un véhicule</h4>
                <p>Êtes-vous sûr(e) de vouloir supprimer ce véhicule?</p>
            </div>
            <div class="modal-footer">
                <!-- Pour la suppression d'un véhicule, je fais passer son id en paramètre d'url delID -->
                <a href="vehiclesList.php?delId=<?= $vehicle->id ?>" class="modal-close waves-effect waves-red btn red">Supprimer</a>
            </div>
        </div>
    <?php } ?>
        <!-- J'affiche ma liste de véhicules sur un card-panel -->
    <div class="card-panel">
        <a href="newVehicle.php" class="waves-effect waves-light btn btn-large waves-effect blue-grey darken-4">Ajouter un véhicule</a>
        <table class="responsive-table striped bordered table-vehicles">
            <thead>
            <th>Constructeur</th>
            <th>Modèle</th>
            <th>Utilisateur</th>
            <th>Détails</th>
            <th>Modifier</th>
            <th>Supprimer</th>
            </thead>
            <tbody>
                <!-- Je remplis mon tableau au moyen d'un foreach -->
                <?php foreach ($vehiclesList as $vehicle) { ?>
                    <tr>
                        <td><?= $vehicle->manufacturerName ?></td>
                        <td><?= $vehicle->modelName ?></td>
                        <td><?= $vehicle->userFirstName . ' ' . $vehicle->userLastName ?></td>
                        <td><a href="vehicleDashboard.php?vehicleId=<?= $vehicle->id ?>"><i class="material-icons normalIcons">directions_car</i></a></td>
                        <td><a href="updateVehicle.php?vehicleId=<?= $vehicle->id ?>"><i class="material-icons normalIcons">mode_edit</i></a></td>
                        <td><a href="#modal<?= $vehicle->id ?>"<i class="material-icons modal-trigger delClass">delete</i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- J'inclus mon footer contenant mes scripts personnalisés en bas de page -->
<?php include '../footer.php'; ?>
