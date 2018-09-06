<?php

/* Je démarre ma session */
session_start();

/* A l'envoi du formulaire */
if (isset($_POST['submit'])) {
    /* J'instancie un nouvel objet users héritant de la classe users */
    $users = new users();
    /* J'initialise mon tableau d'erreur formError à vide */
    $formError = array();
    /* Si mon POST email n'est pas vide */
    if (!empty($_POST['email'])) {
        /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode en prenant soin de supprimer les caractères html */
        $users->mailAddress = htmlspecialchars($_POST['email']);
    } else {
        /* S'il est vide */
        $formError['email'] = 'Le mail est nécessaire pour se connecter';
    }
    /* Si mon POST password n'est pas vide */
    if (!empty($_POST['password'])) {
        /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode en prenant soin de supprimer les caractères html */
        $users->password = htmlspecialchars($_POST['password']);
    } else {
        /* S'il est vide */
        $formError['password'] = 'Le mot de passe est nécessaire pour se connecter';
    }
    
    /* Si mon tableau formError ne comporte aucune ligne */
    if (count($formError) == 0) {
        /* Je stocke le résultat de ma méthode getHashByMail dans la varaible passwordHash */
        $passwordHash = $users->getHashByMail();
        /* Si je récupère bien un objet */
        if (is_object($passwordHash)) {
            /* Si le mot de passe entré correspond */
            if (password_verify($_POST['password'], $passwordHash->password)) {
                /* Je récupère tous mes paramètres utilisateurs */
                $users->getUserByMail();
                /* Je remplis mes variables de session */
                $_SESSION['lastName'] = $users->lastName;
                $_SESSION['firstName'] = $users->firstName;
                $_SESSION['userId'] = $users->id;
                $_SESSION['roleId'] = $users->userGroups;
                /* Une fois connecté, je redirige l'utilisateur sur le dashboard */
                header('location: views/dashboard.php');
            } else {
                /* Si l'identifiant est incorrect, je donne un minimum d'infos à un potentiel attaquant */
                $formError['login'] = 'Mauvaise adresse mail ou mot de passe';
            }
        } elseif (!$passwordHash) {
            /* Si le mot de passe est incorrect, je donne un minimum d'infos à un potentiel attaquant */
            $formError['login'] = 'Mauvaise adresse mail ou mot de passe';
        } else {
            /* Si tout est bon, stocke le résultat dans ma variable */
            $formError['login'] = $passwordHash;
        }
    }
}

session_write_close();
