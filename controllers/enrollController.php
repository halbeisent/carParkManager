<?php

session_start();

// On instancie un nouvel $patients objet comme classe patients
$users = new users();

//Création des regex pour controler les données du formulaire
$regexName = '/^[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+$/';
$regexBirthdate = '/^(0[1-9]|([1-2][0-9])|3[01])\/(0[1-9]|1[012])\/((19|20)[0-9]{2})$/';
$regexEmail = '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/'; // regex date au format yyyy-mm-dd
$regexPhoneNumber = '/^[0-9]{10,10}$/';
$regexPassword = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';
$fileUpload = '../uploads/licenseScans/';

//Initialise $addSuccess en False pour afficher message
$addSuccess = false;

$hasLicense = false;

if (empty($_SESSION)) {
    $navbar = '../defaultNavbar.php';
}

if (isset($_POST['submit'])) {

//Création d'un tableau pour retranscrire les erreurs lord du remplissage du formulaire
    $formError = array();

    if (!empty($_POST['lastName'])) {
        if (preg_match($regexName, $_POST['lastName'])) {
            $users->lastName = htmlspecialchars($_POST['lastName']);
        } else {
            $formError['lastName'] = 'Votre nom ne doit contenir que des lettres';
        }
    } else {
        $formError['lastName'] = 'Champ obligatoire';
    }

    if (!empty($_POST['firstName'])) {
        if (preg_match($regexName, $_POST['firstName'])) {
            $users->firstName = htmlspecialchars($_POST['firstName']);
        } else {
            $formError['firstName'] = 'Votre prénom ne doit contenir que des lettres';
        }
    } else {
        $formError['firstName'] = 'Champ obligatoire';
    }

    if (!empty($_POST['birthDate'])) {
        if (preg_match($regexBirthdate, $_POST['birthDate'])) {
            $users->birthDate = htmlspecialchars($_POST['birthDate']);
        } else {
            $formError['birthDate'] = 'Votre date de naissance est invalide';
        }
    } else {
        $formError['birthDate'] = 'Champ obligatoire';
    }

    if (!empty($_POST['streetNumber'])) {
        $users->streetNumber = htmlspecialchars($_POST['streetNumber']);
    } else {
        $formError['streetNumber'] = 'Champ obligatoire';
    }

    if (!empty($_POST['streetName'])) {
        $users->streetName = htmlspecialchars($_POST['streetName']);
    } else {
        $formError['streetName'] = 'Champ obligatoire';
    }

    if (!empty($_POST['zipCode'])) {
        $users->zipCode = htmlspecialchars($_POST['zipCode']);
    } else {
        $formError['zipCode'] = 'Champ obligatoire';
    }

    if (!empty($_POST['city'])) {
        if (preg_match($regexName, $_POST['city'])) {
            $users->city = htmlspecialchars($_POST['city']);
        } else {
            $formError['city'] = 'Votre nom de ville est invalide';
        }
    } else {
        $formError['city'] = 'Champ obligatoire';
    }

    if (!empty($_POST['email'])) {
        if (preg_match($regexEmail, $_POST['email'])) {
            $users->mailAddress = htmlspecialchars($_POST['email']);
        } else {
            var_dump($users->mailAddress);
            $formError['email'] = 'L\'Adresse saisie est invalide';
        }
        $users->mailAddress = htmlspecialchars($_POST['email']);
        $emailMatch = $users->getMailCheck();
        if (!is_object($emailMatch)) {
            $formError['email'] = 'Un problème est survenu';
        } else if ($emailMatch->usedMailAddress) {
            $formError['email'] = 'email déjà utilisé';
        }
    } else {
        $formError['email'] = 'Champ obligatoire';
    }

    if (!empty($_POST['password'])) {
        if (preg_match($regexPassword, $_POST['password']) && $_POST['password'] == $_POST['passwordCheck']) {
            $users->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        } else {
            $formError['password'] = 'Le mot de passe saisi doit comporter au moins 8 caractères, dont au moins une majuscule, une minuscule et un caractère spécial';
            $formError['passwordCheck'] = 'Les mots de passe ne sont pas identiques';
        }
    } else {
        $formError['password'] = 'Champ obligatoire';
    }

    if (!empty($_FILES['licenseScan'])) {
        $licenseScanName = $_POST['lastName'] . '_' . $_POST['firstName'];
        $licenseExtension = pathinfo($_FILES['licenseScan']['name']);
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf');
        if (in_array($licenseExtension['extension'], $allowedExtensions)) {
            $licenseScanFile = $fileUpload . $licenseScanName . '.' . $licenseExtension['extension'];
            move_uploaded_file($_FILES['licenseScan']['tmp_name'], $licenseScanFile);
            chmod($licenseScanFile, 0777);
            $users->licenseScanPath = $licenseScanFile;
        } else {
            $formError['fileExtension'] = 'Extension non autorisée!';
        }
    }

    if (!empty($_POST['licenseNumber'])) {
        $users->licenseNumber = $_POST['licenseNumber'];
    } else {
        $formError['licenseNumber'] = 'Champ obligatoire';
    }

    if (!empty($_POST['isValid']) && $_POST['isValid'] == 'on') {
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
