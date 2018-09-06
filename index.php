<?php
//Inclusion des ressources nécéssaires à la pages
include 'models/database.php';
include 'models/users.php';
include 'controllers/loginController.php';
$pageTitle = 'CarPark Manager - Connexion';
$pageBackground = 'loginBody';
include 'header.php';
?>
<div class="center-align">
    <!-- logo du site -->
    <img class="responsive-img siteLogo" src="assets/img/logo/siteLogo.png" />
    <div class="container">
        <div class="z-depth-1 grey lighten-4 row loginForm">
            <form class="col s12" method="POST">
                <div class="row">
                    <div class="col s12">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input <?= isset($formError['email']) ? 'class="invalid"' : '' ?> type="email" name="email" id="email" />
                        <label for="email">Adresse mail</label>
                        <?php if (isset($formError['email'])) { ?>
                            <span class="helper-text" data-error="<?= $formError['email'] ?>" data-success="right">Message d'erreur email</span>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input <?= isset($formError['password']) ? 'class="invalid"' : '' ?> type="password" name="password" id="password" />
                        <label for="password">Mot de passe</label>
                        <?php if (isset($formError['password'])) { ?>
                            <span class="helper-text" data-error="<?= $formError['password'] ?>" data-success="right">Message d'erreur mot de passe</span>
                        <?php } ?>
                    </div>
                    <?php if (isset($formError['login'])) { ?>
                        <p><?= $formError['login'] ?></p>
                    <?php } ?>
                    <a class="blue-grey-text left" href="views/enroll.php"><b>Nouvel utilisateur ?</b></a>
                    <a class="blue-grey-text right" href="views/newPassword.php"><b>Mot de passe oublié ?</b></a>
                </div>
                <br />
                <center>
                    <div class="row">
                        <button type="submit" name="submit" class="col s12 btn btn-large waves-effect blue-grey darken-4">Connexion</button>
                    </div>
                </center>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php' ?>