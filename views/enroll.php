<?php
if (!empty($_SESSION['userId'])) {
    header('Location: dashboard.php');
    exit;
} else {
    include '../models/database.php';
    include '../models/users.php';
    include '../controllers/enrollController.php';
    $pageBackground = 'enrollBody';
    $pageTitle = 'Inscription d\'un utilisateur';
    include '../header.php';
    include $navbar;
}
?>
<div class="container">
    <?php
    if (empty($_SESSION)) {
        if ($addSuccess) {
            ?>
            <div class="center-align">
                <div class="card-panel">
                    <h5>Le nouvel utilisateur a bien été enregistré</h5>
                    <a href="../index.php" class="waves-effect waves-effect blue-grey darken-4 btn-large">Veuillez vous connecter</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="card-panel">
                <form method="POST" action="enroll.php" enctype="multipart/form-data">
                    <div class="section">
                        <h5>Votre identité</h5>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <input id="firstName" name="firstName" type="text" class="validate" />
                                <label for="firstName">Prénom</label>
                                <p class="error"><?= isset($formError['firstName']) ? $formError['firstName'] : '' ?></p>
                            </div>
                            <div class="input-field col s12 m6 l6 ">
                                <input id="lastName" name="lastName" type="text" class="validate" />
                                <label for="lastName">Nom</label>
                                <p class="error"><?= isset($formError['lastName']) ? $formError['lastName'] : '' ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l4">
                                <input id="birthDate" name="birthDate" type="text" class="datepicker" />
                                <label for="birthDate">Date de naissance</label>
                                <p class="error"><?= isset($formError['birthDate']) ? $formError['birthDate'] : '' ?></p>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <h5>Votre Adresse</h5>
                        <div class="row">
                            <div class="input-field col s12 m6 l2">
                                <input id="streetNumber" name="streetNumber" type="text" class="validate" />
                                <label for="streetNumber">Numéro de rue</label>
                                <p class="error"><?= isset($formError['streetNumber']) ? $formError['streetNumber'] : '' ?></p>
                            </div>
                            <div class="input-field col s12 m6 l10">
                                <input id="streetName" name="streetName" type="text" class="validate" />
                                <label for="streetName">Nom de rue</label>
                                <p class="error"><?= isset($formError['streetName']) ? $formError['streetName'] : '' ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l2">
                                <input id="zipCode" name="zipCode" type="text" class="validate" />
                                <label for="zipCode">Code postal</label>
                                <p class="error"><?= isset($formError['zipCode']) ? $formError['zipCode'] : '' ?></p>
                            </div>
                            <div class="input-field col s12 m6 l10">
                                <input id="city" name="city" type="text" class="validate" />
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
                                <input placeholder="adresse@domaine.fr" id="email" name="email" type="email" class="validate" />
                                <label for="email">Email</label>
                                <p class="error"><?= isset($formError['email']) ? $formError['email'] : '' ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <input placeholder="Password2018" id="password" name="password" type="password" class="validate" />
                                <label for="password">Mot de passe</label>
                                <p class="error"><?= isset($formError['password']) ? $formError['password'] : '' ?></p>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <input placeholder="Password2018" id="passwordCheck" name="passwordCheck" type="password" class="validate" />
                                <label for="password">Confirmation du mot de passe</label>
                                <p class="error"><?= isset($formError['passwordCheck']) ? $formError['passwordCheck'] : '' ?></p>
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
                                    <input type="file" name="licenseScan" id="licenseScan">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" name="licenseScanPath" id="licenseScanPath" />
                                    <p class="error"><?= isset($formError['fileExtension']) ? $formError['fileExtension'] : '' ?></p>
                                </div>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <input placeholder="123456AB" id="licenseNumber" name="licenseNumber" type="text" class="validate" />
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