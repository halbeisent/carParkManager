<?php

session_start();

if (isset($_POST['submit'])) {
    $users = new users();
    $formError = array();
    if (!empty($_POST['email'])) {
        $users->mailAddress = htmlspecialchars($_POST['email']);
    } else {
        $formError['email'] = 'Le mail est nécessaire pour se connecter';
    }
    if (!empty($_POST['password'])) {
        $users->password = htmlspecialchars($_POST['password']);
    } else {
        $formError['password'] = 'Le mot de passe est nécessaire pour se connecter';
    }
    if (count($formError) == 0) {
        $passwordHash = $users->getHashByMail();
        if (is_object($passwordHash)) {
            if (password_verify($_POST['password'], $passwordHash->password)) {
                $users->getUserByMail();
                $_SESSION['lastName'] = $users->lastName;
                $_SESSION['firstName'] = $users->firstName;
                $_SESSION['userId'] = $users->id;
                $_SESSION['roleId'] = $users->userGroups;
                header('location: views/dashboard.php');
            } else {
                $formError['login'] = 'Mauvaise adresse mail ou mot de passe';
            }
        } elseif (!$passwordHash) {
            $formError['login'] = 'Mauvaise adresse mail ou mot de passe';
        } else {
            $formError['login'] = $passwordHash;
        }
    }
}

session_write_close();
