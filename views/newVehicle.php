<?php
include '../models/database.php';
include '../models/vehicles.php';
include '../models/users.php';
include '../controllers/addVehicleController.php';
$pageBackground = 'newVehicleBG';
$pageTitle = 'Ajout d\'un nouveau véhicule';
include '../header.php';
include $navbar;
?>
<div class="container">
    <?php if ($addSuccess) { ?>
        <div class="center-align">
            <div class="card-panel">
                <p>Le nouveau véhicule a bien été ajouté</p>
                <a href="vehiclesList.php" class="waves-effect blue-grey darken-4 btn-large">Liste des véhicules</a>
            </div>
        </div>
    <?php } else { ?>
        <div class="card-panel">
            <form method="POST" action="newVehicle.php" enctype="multipart/form-data">
                <div class="section">
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <input placeholder="5YJSEIXONEDSQJ41" id="serialNumber" name="serialNumber" type="text" class="validate" >
                            <label for="serialNumber">Numéro de série</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input placeholder="01/01/2000" id="firstRegistrationDate" name="firstRegistrationDate" type="text" class="datepicker">
                            <label for="firstRegistrationDate">Première immatriculation</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <select id="manufacturerSelector" name="manufacturerSelector">
                                <option disabled selected>Sélectionnez un constructeur</option>
                                <?php foreach ($manufacturersList as $manufacturer) { ?>
                                    <option value="<?= $manufacturer->id ?>"><?= $manufacturer->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <select id="modelSelector" name="modelSelector">
                                <option disabled selected>Sélectionnez un modèle</option>
                                <?php foreach ($modelsList as $model) { ?>
                                    <option value="<?= $model->id ?>"><?= $model->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <select id="userSelector" name="userSelector">
                                <option disabled selected>Sélectionnez un utilisateur</option>
                                <?php foreach ($usersList as $user) { ?>
                                    <option value="<?= $user->id ?>"><?= $user->firstName . ' ' . $user->lastName ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <select id="typeSelector" name="typeSelector">
                                <option disabled selected>Sélectionnez un type de véhicule</option>
                                <?php foreach ($vehicleTypesList as $vehicleType) { ?>
                                    <option value="<?= $vehicleType->id ?>"><?= $vehicleType->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <select id="energySelector" name="energySelector">
                                <option disabled selected>Sélectionnez une énergie</option>
                                <?php foreach ($energiesList as $energy) { ?>
                                    <option value="<?= $energy->id ?>"><?= $energy->type ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field col s12 m12 l12">
                            <div class="btn waves-effect blue-grey darken-4">
                                <span>Photo de l'intérieur</span>
                                <input type="file" name="interiorPic" id="interiorPic">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" name="interiorPicPath" id="interiorPicPath" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field col s12 m12 l12">
                            <div class="btn waves-effect blue-grey darken-4">
                                <span>Photo de l'extérieur</span>
                                <input type="file" name="exteriorPic" id="exteriorPic">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" name="exteriorPicPath" id="exteriorPicPath" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="center valign-wrapper">
                    <div class="row">
                        <button type="submit" name="submit" class="waves-effect waves-effect blue-grey darken-4 btn-large">Valider</button>
                        <p class="error"><?= isset($formError['add']) ? $formError['add'] : '' ?></p>
                    </div>
                </div>
        </div>
    </form>
    </div>
<?php } include '../footer.php'; ?>
</div>