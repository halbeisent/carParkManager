<?php

/* Je démarre ma session pour récupérer mes variables */
session_start();

/* On instancie un nouvel objet héritant des paramètres de la classe  */
$users = new users();

/* Création des regex pour controler les données du formulaire */
$regexName = '/^[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+$/';
$regexBirthdate = '/^(0[1-9]|([1-2][0-9])|3[01])\/(0[1-9]|1[012])\/((19|20)[0-9]{2})$/';
$regexEmail = '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/'; // regex date au format yyyy-mm-dd
$regexPhoneNumber = '/^[0-9]{10,10}$/';
$regexPassword = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';
$fileUpload = '../uploads/licenseScans/';

/* Initialise $addSuccess en False pour afficher message */
$addSuccess = false;

/* Initialisation de hasLicense en False pour */
$hasLicense = false;

/* Si ma variable de session est vide (et n'existe donc pas) je charge la navbar par défaut */
if (empty($_SESSION)) {
    $navbar = '../defaultNavbar.php';
}

/* A l'envoi du formulaire */
if (isset($_POST['submit'])) {

    /* Création d'un tableau pour retranscrire les erreurs lors du remplissage du formulaire */
    $formError = array();

    /* Si mon POST lastName n'est pas vide */
    if (!empty($_POST['lastName'])) {
        /* Je vérifie si son contenu correspond à ce que je veux */
        if (preg_match($regexName, $_POST['lastName'])) {
            /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode en prenant soin de supprimer les caractères html */
            $users->lastName = htmlspecialchars($_POST['lastName']);
        } else {
            /* Si le contenu ne correspond pas, je stocke un message d'erreur */
            $formError['lastName'] = 'Votre nom ne doit contenir que des lettres';
        }
    } else {
        /* Si mon POST est vide, je stocke un message d'erreur */
        $formError['lastName'] = 'Champ obligatoire';
    }

    /* Si mon POST firstName est vide */
    if (!empty($_POST['firstName'])) {
        /* Je vérifie si son contenu correspond à ce que je veux */
        if (preg_match($regexName, $_POST['firstName'])) {
            /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode en prenant soin de supprimer les caractères html */
            $users->firstName = htmlspecialchars($_POST['firstName']);
        } else {
            /* Si le contenu ne correspond pas, je stocke un message d'erreur */
            $formError['firstName'] = 'Votre prénom ne doit contenir que des lettres';
        }
    } else {
        /* Si mon POST est vide, je stocke un message d'erreur */
        $formError['firstName'] = 'Champ obligatoire';
    }

    /* Si mon POST birthDate n'est pas vide */
    if (!empty($_POST['birthDate'])) {
        /* Si son contenu correspond à ce que je souhaite */
        if (preg_match($regexBirthdate, $_POST['birthDate'])) {
            /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode en prenant soin de supprimer les caractères html */
            $users->birthDate = htmlspecialchars($_POST['birthDate']);
        } else {
            /* Si son contenu ne correspond pas, je stocke un message d'erreur */
            $formError['birthDate'] = 'Votre date de naissance est invalide';
        }
    } else {
        /* Si mon POSt est vide, je stocke un message d'erreur */
        $formError['birthDate'] = 'Champ obligatoire';
    }

    /* Si mon POST streetNumber n'est pas vide */
    if (!empty($_POST['streetNumber'])) {
        /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode en prenant soin de supprimer les caractères html */
        $users->streetNumber = htmlspecialchars($_POST['streetNumber']);
    } else {
        /* S'il est vide, je stocke un message d'erreur */
        $formError['streetNumber'] = 'Champ obligatoire';
    }

    /* Si mon POST streetName n'est pas vide */
    if (!empty($_POST['streetName'])) {
        /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode en prenant soin de supprimer les caractères html */
        $users->streetName = htmlspecialchars($_POST['streetName']);
    } else {
        /* S'il est vide, je stocke un message d'erreur */
        $formError['streetName'] = 'Champ obligatoire';
    }

    /* Si mon POST zipCode n'est pas vide */
    if (!empty($_POST['zipCode'])) {
        /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode en prenant soin de supprimer les caractères html */
        $users->zipCode = htmlspecialchars($_POST['zipCode']);
    } else {
        /* S'il est vide, je stocke un message d'erreur */
        $formError['zipCode'] = 'Champ obligatoire';
    }

    /* Si mon POST city n'est pas vide */
    if (!empty($_POST['city'])) {
        /* Je vérifie si son contenu correspond à ce que je demande */
        if (preg_match($regexName, $_POST['city'])) {
            /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode en prenant soin de supprimer les caractères html */
            $users->city = htmlspecialchars($_POST['city']);
        } else {
            /* Si son contenu ne correspond pas, je stocke un message d'erreur */
            $formError['city'] = 'Votre nom de ville est invalide';
        }
    } else {
        /* S'il est vide, je stocke un message d'erreur */
        $formError['city'] = 'Champ obligatoire';
    }
    
    /* Si mon POST email est vide */
    if (!empty($_POST['email'])) {
        /* Je vérifie si son contenu correspond à mes exigences*/
        if (preg_match($regexEmail, $_POST['email'])) {
            /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode en prenant soin de supprimer les caractères html */
            $users->mailAddress = htmlspecialchars($_POST['email']);
        } else {
            /* Si son contenu ne correspond pas à ma demande */
            $formError['email'] = 'L\'Adresse saisie est invalide';
        }
        /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode en prenant soin de supprimer les caractères html */
        $users->mailAddress = htmlspecialchars($_POST['email']);
        /* J'appelle ma méthode vérifiant que le mail est unique */
        $emailMatch = $users->getMailCheck();
        /* Si je ne récupère pas un objet */
        if (!is_object($emailMatch)) {
            /* Je stocke un message d'erreur */
            $formError['email'] = 'Un problème est survenu';
        } else if ($emailMatch->usedMailAddress) {
            /* Sinon j'affiche un message si le mail existe déjà */
            $formError['email'] = 'email déjà utilisé';
        }
    } else {
        $formError['email'] = 'Champ obligatoire';
    }

    /* Si mon POST password n'est pas vide */
    if (!empty($_POST['password'])) {
        /* Si son contenu correspond à mes exigences */
        if (preg_match($regexPassword, $_POST['password']) && $_POST['password'] == $_POST['passwordCheck']) {
            /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode en prenant soin de supprimer les caractères html tout en cryptant le mot de passe */
            $users->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        } else {
            /* Si le contenu ne correspond pas à mes exigences */
            $formError['password'] = 'Le mot de passe saisi doit comporter au moins 8 caractères, dont au moins une majuscule, une minuscule et un caractère spécial';
            /* Si le mot de passe de vérification ne correspond pas au mot de passe précédent */
            $formError['passwordCheck'] = 'Les mots de passe ne sont pas identiques';
        }
    } else {
        /* S'il est vide, je stocke un message d'erreur */
        $formError['password'] = 'Champ obligatoire';
    }

    /* Si mon POST licenseScan n'est pas vide */
    if (!empty($_FILES['licenseScan'])) {
        /* Je définis le nom que mon fichier doit avoir */
        $licenseScanName = $_POST['lastName'] . '_' . $_POST['firstName'];
        /* Je récupère l'extension de mon fichier */
        $licenseExtension = pathinfo($_FILES['licenseScan']['name']);
        /* Je définis les extensions autorisées */
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf');
        /* l'extension du fichier envoyé est présent dans la liste des extensions autorisées */
        if (in_array($licenseExtension['extension'], $allowedExtensions)) {
            /* Je créée le nom de fichier complet avec extension */
            $licenseScanFile = $fileUpload . $licenseScanName . '.' . $licenseExtension['extension'];
            /* Je déplace ensuite le fichier vers sa destination finale */
            move_uploaded_file($_FILES['licenseScan']['tmp_name'], $licenseScanFile);
            /* Je modifie les droits du fichiers pour pouvoir l'ouvrir */
            chmod($licenseScanFile, 0777);
            /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode */
            $users->licenseScanPath = $licenseScanFile;
        } else {
            /* Si l'extension ne correspond pas */
            $formError['fileExtension'] = 'Extension non autorisée!';
        }
    }

    /* Si mon  POST licenseNumber n'est pas vide */
    if (!empty($_POST['licenseNumber'])) {
        /* Je stocke son contenu dans le paramètre de l'objet ayant appelé la méthode en prenant soin de supprimer les caractères html */
        $users->licenseNumber = htmlspecialchars($_POST['licenseNumber']);
    } else {
        /* S'il est vide */
        $formError['licenseNumber'] = 'Champ obligatoire';
    }

    /* Si mon POST isValid n'est pas vide et que son contenu est 'on' */
    if (!empty($_POST['isValid']) && $_POST['isValid'] == 'on') {
        /* Je stocke la valeur   dans ma propriété d'objet devant contenir un booléen */
        $users->isValid = 1;
    } else {
        $users->isValid = 0;
    }

//on vérifie que nous avons crée une entrée submit dans l'array $_POST, si présent on éxécute la méthide addPatient()
    if (count($formError) == 0) {
        if (!$users->addUser()) {
            $formError['add'] = 'l\'envoi  du formulaire à échoué';
        } else {
            $addSuccess = true;
        }
    }
}

session_write_close();
?>
