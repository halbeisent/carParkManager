<?php

/* Pour me déconnecter, je démarre une session */
session_start();
/* Je déparamètre les variables de session */
session_unset();
/* Puis je la détruis */
session_destroy();

/* Pour finir, je redirige l'utilisateur vers la connexion */
header('Location: ../index.php');
exit;
?>