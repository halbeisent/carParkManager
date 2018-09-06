<?php
include '../models/database.php';
include '../models/users.php';
include '../controllers/userDetailsController.php';
$pageTitle = 'Modifier un utilisateur';
$pageBackground = 'enrollBody';
include '../header.php';
include $navbar;
?>
<div class="container">
    <?php
    if ($_SESSION['roleId'] == 1) {
        if ($updateSuccess) {
            ?>
            <div class="center-align">
                <div class="card-panel">
                    <h5>Le nouvel utilisateur a bien été modifié</h5>
                    <a href="usersList.php" class="waves-effect waves-effect blue-grey darken-4 btn-large">Retour à la liste des utilisateurs</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="card-panel">
                <form method="POST" action="userDetails.php?id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
                    <div class="section">
                        <h5>Votre identité</h5>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <input id="firstName" name="firstName" type="text" class="validate" value="<?= $users->firstName ?>" />
                                <label for="firstName">Prénom</label>
                                <p class="error"><?= isset($formError['firstName']) ? $formError['firstName'] : '' ?></p>
                            </div>
                            <div class="input-field col s12 m6 l6 ">
                                <input id="lastName" name="lastName" type="text" class="validate" value="<?= $users->lastName ?>" />
                                <label for="lastName">Nom</label>
                                <p class="error"><?= isset($formError['lastName']) ? $formError['lastName'] : '' ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <input id="birthDate" name="birthDate" type="text" class="datepicker" value="<?= $users->birthDate ?>" />
                                <label for="birthDate">Date de naissance</label>
                                <p class="error"><?= isset($formError['birthDate']) ? $formError['birthDate'] : '' ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l2">
                                <input id="streetNumber" name="streetNumber" type="text" class="validate" value="<?= $users->streetNumber ?>" />
                                <label for="streetNumber">Numéro de rue</label>
                                <p class="error"><?= isset($formError['streetNumber']) ? $formError['streetNumber'] : '' ?></p>
                            </div>
                            <div class="input-field col s12 m6 l10">
                                <input id="streetName" name="streetName" type="text" class="validate" value="<?= $users->streetName ?>" />
                                <label for="streetName">Nom de rue</label>
                                <p class="error"><?= isset($formError['streetName']) ? $formError['streetName'] : '' ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l2">
                                <input id="zipCode" name="zipCode" type="text" class="validate" value="<?= $users->zipCode ?>" />
                                <label for="zipCode">Code postal</label>
                                <p class="error"><?= isset($formError['zipCode']) ? $formError['zipCode'] : '' ?></p>
                            </div>
                            <div class="input-field col s12 m6 l10">
                                <input id="city" name="city" type="text" class="validate" value="<?= $users->city ?>" />
                                <label for="city">Ville</label>
                                <p class="error"><?= isset($formError['city']) ? $formError['city'] : '' ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="section">
                        <h5>Vos informations de connexion</h5>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <input placeholder="adresse@domaine.fr" id="email" name="email" type="email" class="validate" value="<?= $users->mailAddress ?>" />
                                <label for="email">Email</label>
                                <p class="error"><?= isset($formError['email']) ? $formError['email'] : '' ?></p>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <select id="userGroupSelector" name="userGroupSelector">
                                    <option disabled selected>Choisir un type d'utilisateur</option>
                                    <?php foreach ($userGroupsList as $userGroup) { ?>
                                        <option value="<?= $userGroup->id ?>" <?= $userGroup->id == $users->userGroups ? 'selected' : '' ?>><?= $userGroup->role ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="section">
                        <h5>Vos informations de conducteur</h5>
                        <div class="row">
                            <div class="file-field input-field col s12 m6 l12">
                                <div class="btn blue-grey darken-4">
                                    <span>Scan du permis</span>
                                    <input type="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" name="licenseScanPath" id="licenseScanPath" value="<?= $users->licenseScanPath ?>" />
                                </div>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <input placeholder="123456AB" id="licenseNumber" name="licenseNumber" type="text" class="validate" value="<?= $users->licenseNumber ?>" />
                                <label for="licenseNumber">Numéro du permis</label>
                                <p class="error"><?= isset($formError['licenseNumber']) ? $formError['licenseNumber'] : '' ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <label>
                                <input type="checkbox" name="isValid" class="filled-in" />
                                <span>Permis valide?</span>
                            </label>
                        </div>
                    </div>
                    <div class="center valign-wrapper">
                        <div class="row">
                            <button type="submit" name="submit" class="waves-effect waves-effect blue-grey darken-4 btn-large">Valider</button>
                            <p class="error"><?= isset($formError['add']) ? $formError['add'] : '' ?></p>
                        </div>
                    </div>
                </form>
            </div>
            <?php
        } include '../footer.php';
    } else {
        header('Location: errorPage.php');
    }
    ?>
</div>