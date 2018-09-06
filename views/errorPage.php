<?php
$pageTitle = 'Erreur d\'accès';
$pageBackground = 'errorPageBody';
include '../header.php';
include '../controllers/errorPageController.php';
include $navbar;
?>
<div class="container">
    <div class="center-align">
        <div class="card-panel">
            <?= $errorMessage ?>
            <div class="row">
                <button onclick="history.go(-1);" class="col s12 btn btn-large waves-effect blue-grey darken-4">Page précédente</button>
            </div>
        </div>
    </div>
</div>