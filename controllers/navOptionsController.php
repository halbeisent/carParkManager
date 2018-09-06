<?php

/* Je démarre ma session pour récupérer l'identifiant du role */
session_start();

/* Je stocke l'identifiant du role de l'utilisateur dans ma variable userRole */
$userRole = $_SESSION['roleId'];

/* Puis je ferme ma session */
session_close();