<?php

session_start();

/* J'instancie un nouvel objet users avec ma méthode users() */
$users = new users();

/* J'initialise mon tableau contenant mes futures erreurs de formulaire à vide */
$formError = array();

$userGroupsList = $users->getUserGroups();

/* Si je passe un id en paramètre d'URL */
if (isset($_GET['id'])) {
    /* Je remplis l'objet $users->id avec la valeur du paramètre d'URL */
    $users->id = $_GET['id'];

    /* J'initialise ma variable updateSuccess à false */
    $updateSuccess = false;

    /* Si je passe un updateBtn en POST */
    if (isset($_POST['submit'])) {
        //Création des regex pour controler les données du formulaire
        $regexName = '/^[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+$/';
        $regexBirthdate = '/^(0[1-9]|([1-2][0-9])|3[01])\/(0[1-9]|1[012])\/((19|20)[0-9]{2})$/';
        $regexEmail = '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/'; // regex date au format yyyy-mm-dd
        $regexPhoneNumber = '/^[0-9]{10,10}$/';
        $regexPassword = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';
        $fileUpload = '/tmp/fileUploads/';

        //Création d'un tableau pour retranscrire les erreurs lord du remplissage du formulaire
        $formError = array();

        /* Si le POST de mon lastName n'est pas vide */
        if (!empty($_POST['lastName'])) {
            /* Je vérifie si son contenu match avec la RegEx */
            if (preg_match($regexName, $_POST['lastName'])) {
                /* Si c'est le cas, je remplis l'objet $users->lastName en prenant soin de retirer tous les caractères html du champ */
                $users->lastName = htmlspecialchars($_POST['lastName']);
            } else {
                /* Si le POST de mon lastName est vide, j'affiche un message d'erreur */
                $formError['lastName'] = 'Votre nom ne doit contenir que des lettres';
            }
        } else {
            /* Si le POST de mon lastName ne match pas, j'affiche un message d'erreur */
            $formError['lastName'] = 'Champ obligatoire';
        }

        /* Si le POST de mon firstName n'est pas vide */
        if (!empty($_POST['firstName'])) {
            /* Je vérifie si son contenu match avec la RegEx */
            if (preg_match($regexName, $_POST['firstName'])) {
                /* Si c'est le cas, je remplis l'objet $users->firstName en prenant soin de retirer tous les caractères html du champ */
                $users->firstName = htmlspecialchars($_POST['firstName']);
            } else {
                /* Si le POST de mon firstName est vide, j'affiche un message d'erreur */
                $formError['firstName'] = 'Votre prénom ne doit contenir que des lettres';
            }
        } else {
            /* Si le POST de mon firstName ne match pas, j'affiche un message d'erreur */
            $formError['firstName'] = 'Champ obligatoire';
        }

        /* Si le POST de mon birthDate n'est pas vide */
        if (!empty($_POST['birthDate'])) {
            /* Si le POST de mon birthDate match avec la RegEx */
            if (preg_match($regexBirthdate, $_POST['birthDate'])) {
                /* Si c'est le cas, je remplis l'objet $users->birthDate en prenant soin de retirer tous les caractères html du champ */
                $users->birthDate = htmlspecialchars($_POST['birthDate']);
            } else {
                /* Si mon POST birthDate ne match pas, j'affiche un message d'erreur */
                $formError['birthDate'] = 'Votre date de naissance est invalide';
            }
        } else {
            /* Si mon POST birthDate est vide, j'affiche un message d'erreur */
            $formError['birthDate'] = 'Champ obligatoire';
        }


        /* Si mon POST streetNumber vide, j'affiche un message d'erreur */
        if (!empty($_POST['streetNumber'])) {
            /*  S'il est bien rempli, je remplis l'objet $users->streetNumber en prenant soin de supprimer les caractères html du champ */
            $users->streetNumber = htmlspecialchars($_POST['streetNumber']);
        } else {
            /* Sinon, j'affiche un message d'erreur */
            $formError['streetNumber'] = 'Champ obligatoire';
        }

        /* Si mon POST streetName n'est pas vide, j'affiche un message d'erreur */
        if (!empty($_POST['streetName'])) {
            /* S'il est bien rempli, je remplis l'objet $users->streetName en prenant soin de supprimer les caractères html du champ */
            $users->streetName = htmlspecialchars($_POST['streetName']);
        } else {
            /* Sinon j'affiche un message d'erreur */
            $formError['streetName'] = 'Champ obligatoire';
        }

        /* Si mon POST zipCode n'est pas vide, j'affiche un message d'erreur */
        if (!empty($_POST['zipCode'])) {
            /* S'il est bien rempli, je remplis l'objet $users->zipCode en prenant soin de supprimer les caractères html du champ */
            $users->zipCode = htmlspecialchars($_POST['zipCode']);
        } else {
            /* Sinon j'affiche un message d'erreur */
            $formError['zipCode'] = 'Champ obligatoire';
        }

        /* Si mon POST city est rempli */
        if (!empty($_POST['city'])) {
            /* Si mon POST city match avec la RegEx */
            if (preg_match($regexName, $_POST['city'])) {
                /* Je remplis mon objet $users->city en prenant soin de supprimer les caractères html */
                $users->city = htmlspecialchars($_POST['city']);
            } else {
                /* Si mon POST city ne match pas, j'affiche un message d'erreur */
                $formError['city'] = 'Votre nom de ville est invalide';
            }
        } else {
            /* Si mon POST city est vide, j'affiche un message d'erreur */
            $formError['city'] = 'Champ obligatoire';
        }

        if (!empty($_POST['userGroupSelector'])) {
            $users->userGroups = htmlspecialchars($_POST['userGroupSelector']);
        }

        /* Si mon POST email est rempli */
        if (!empty($_POST['email'])) {
            /* Si mon POST email match avec la RegEx */
            if (preg_match($regexEmail, $_POST['email'])) {
                /* Je remplis l'objet $users->mailAddress en prenant soin de supprimer les caractères html */
                $users->mailAddress = htmlspecialchars($_POST['email']);
            } else {
                /* Si mon POST email ne match pas, j'affiche un message d'erreur */
                $formError['email'] = 'L\'Adresse saisie est invalide';
            }
        } else {
            /* Si mon POST email est vide, j'affiche un message d'erreur */
            $formError['email'] = 'Champ obligatoire';
        }

        /* Si mon POST licenseScanPath est rempli */
        if (!empty($_FILES['licenseScan'])) {
            $licenseScanName = $_POST['lastName'] . '_' . $_POST['firstName'];
            $licenseExtension = pathinfo($_FILES['licenseScan']['name']);
            $allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf');
            if (in_array($licenseExtension['extension'], $allowedExtensions)) {
                $licenseScanFile = $fileUpload . $licenseScanName . '.' . $licenseExtension['extension'];
                move_uploaded_file($_FILES['licenseScan']['tmp_name'], $licenseScanFile);
                chmod($licenseScanFile, 0777);
            } else {
                $formError['fileExtension'] = 'Extension non autorisée!';
            }
        }

        /* Si mon POST licenseNumber est rempli */
        if (!empty($_POST['licenseNumber'])) {
            /* Je remplis l'objet $users->licenseNumber */
            $users->licenseNumber = $_POST['licenseNumber'];
        } else {
            /* Sinon, j'affiche un message d'erreur */
            $formError['licenseNumber'] = 'Champ obligatoire';
        }

        /* Si mon POST isValid est rempli et que sa valeur est on */
        if (!empty($_POST['isValid']) && $_POST['isValid'] == 'on') {
            /* Je stocke dans l'objet $users->isValid la valeur 1 */
            $users->isValid = 1;
        } else {
            /* Sinon, je stocke la valeur 0 */
            $users->isValid = 0;
        }
        /* Si mon tableau formError ne contient aucune ligne */
        if (count($formError) == 0) {
            /* Si ma méthode updateUser ne s'éxécuté pas */
            if (!$users->updateUser()) {
                /* J'affiche un message d'erreur */
                $formError['update'] = 'l\'envoi  du formulaire à échoué';
            } else {
                /* Si tout va bien, ma méthode s'éxécute et je passe updateSuccess à true */
                $updateSuccess = true;
            }
        }
    }
    /* Puis, j'affiche le profil après mise à jour */
    $detailedUserProfile = $users->getUserbyId();
}

if ($_SESSION['roleId'] == 3) {
    $navbar = '../navbarUser.php';
} else if ($_SESSION['roleId'] == 2) {
    $navbar = '../navbarParkManager.php';
} else if ($_SESSION['roleId'] == 1) {
    $navbar = '../navbarAdmin.php';
}

session_write_close();
