<?php
/* J'appelle mon modèle database pour la connexion */
include '../models/database.php';
/* J'appelle mon modèle users pour la gestion de mes utilisateurs */
include '../models/users.php';
/* J'appelle mon controller pour le traitement de ma page usersList */
include '../controllers/usersListController.php';
/* J'inclus ma navbar dynamiquement en fonction du roleId qui passe en paramètre de session */
include $navbar;
/* Je modifie le fond de ma page dynamiquement en fonction du type de contenu déclaré dans mon controller */
$pageBackground = 'listBG';
/* Je modifie le titre de ma page dynamiquement */
$pageTitle = 'Utilisateurs';
/* J'inclus mon header contenant mes ressources principales */
include '../header.php';
?>
<div class="container">
    <?php foreach ($usersList as $user) { ?>
        <!-- Structure de ma modale je remplis les différents liens nécéssitant un identifiant dynamiquement -->
        <div id="modal<?= $user->id ?>" class="modal">
            <div class="modal-content">
                <h4>Suppression d'utilisateur</h4>
                <p>Êtes-vous sûr(e) de vouloir supprimer cet utilisateur?</p>
            </div>
            <div class="modal-footer">
                <a href="usersList.php?delId=<?= $user->id ?>" class="modal-close waves-effect waves-red btn red">Supprimer</a>
            </div>
        </div>
    <?php } ?>
    <div class="card-panel">
        <table class="responsive-table striped bordered table-users">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Détails</th>
                    <th>Modifier</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usersList as $user) { ?>
                    <tr>
                        <td><?= $user->lastName ?></td>
                        <td><?= $user->firstName ?></td>
                        <td><?= $user->mailAddress ?></td>
                        <td><a href="userDetails.php?id=<?= $user->id ?>"<i class="material-icons normalIcons">edit_mode</i></a></td>
                        <td><a href="#modal<?= $user->id ?>"<i class="material-icons modal-trigger delClass">delete</i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../footer.php'; ?>