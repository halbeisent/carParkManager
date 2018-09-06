<?php

/* Je démarre ma session pour m'assurer du role de qui est connecté */
session_start();

/* Si c'est bien le gestionnaire de parc qui est connecté */
if ($_SESSION['roleId'] == 2) {
    /* Je charge la navbar adéquate */
    $navbar = '../navbarParkManager.php';
}
/* J'instancie un nouvel objet vehicles héritant des paramètres de la classe vehicles */
$vehicles = new vehicles();

/* J'initialise un tableau formError à vide */
$formError = array();

/* J'initialise ma variable updateSuccess à false */
$updateSuccess = false;

/* Je définis le dossier d'upload des images */
$fileUpload = '../uploads/vehiclePics/';

/* Si j'accède à cette page en faisant passer un id de véhicule en paramètre d'URL */
if (isset($_GET['vehicleId'])) {
    /* Je rémplis les variables avec les paramètres d'objet qui m'intéressent */
    $vehicles->id = $_GET['vehicleId'];
    $vehicleDetails = $vehicles->getVehicleById();
    $energiesList = $vehicles->getEnergiesList();
    $vehicleTypesList = $vehicles->getVehiclesTypesList();
    $modelsList = $vehicles->getModelsList();
    $manufacturersList = $vehicles->getManufacturersList();
    /* Pour remplir mon select d'utilisateurs, j'instancie un nouvel objet users qui va hériter de la classe users */
    $users = new users();
    /* Puis je remplis ma variable usersList avec le résultat retourné vers ma méthode */
    $usersList = $users->getUserList();

    /* J'initialise ma variable updateSuccess à false */
    $updateSuccess = false;

    /* A l'envoi du formulaire */
    if (isset($_POST['submit'])) {

        /* Si mon POST serialNumber n'est pas vide */
        if (!empty($_POST['serialNumber'])) {
            /* Je stocke son contenu dans mon paramètre d'objet en retirant les caractères html */
            $vehicles->serialNumber = htmlspecialchars($_POST['serialNumber']);
        } else {
            /* S'il est vide */
            $formError['serialNumber'] = 'Champ obligatoire';
        }

        /* Si mon POST firstRegistrationDate n'est pas vide */
        if (!empty($_POST['firstRegistrationDate'])) {
            /* Je stocke son contenu dans mon paramètre d'objet en retirant les caractères html */
            $vehicles->firstRegistrationDate = htmlspecialchars($_POST['firstRegistrationDate']);
        } else {
            /* S'il est vide */
            $formError['firstRegistrationDate'] = 'Sélection obligatoire';
        }

        /* Si mon POST modelSelector n'est pas vide */
        if (!empty($_POST['modelSelector'])) {
            /* Je stocke son contenu dans mon paramètre d'objet en retirant les caractères html */
            $vehicles->vehicleModels = htmlspecialchars($_POST['modelSelector']);
        } else {
            /* S'il est vide */
            $formError['modelSelector'] = 'Sélection obligatoire';
        }

        /* Si mon POST manufacturerSelector n'est pas vide */
        if (!empty($_POST['manufacturerSelector'])) {
            /* Je stocke son contenu dans mon paramètre d'objet en retirant les caractères html */
            $vehicles->vehicleManufacturers = htmlspecialchars($_POST['manufacturerSelector']);
        } else {
            /* S'il est vide */
            $formError['manufacturerSelector'] = 'Sélection obligatoire';
        }

        /* Si mon POST userSelector n'est pas vide */
        if (!empty($_POST['userSelector'])) {
            /* Je stocke son contenu dans mon paramètre d'objet en retirant les caractères html */
            $vehicles->users = htmlspecialchars($_POST['userSelector']);
        } else {
            /* S'il est vide */
            $formError['userSelector'] = 'Sélection obligatoire';
        }

        /* Si mon POST typeSelector n'est pas vide */
        if (!empty($_POST['typeSelector'])) {
            /* Je stocke son contenu dans mon paramètre d'objet en retirant les caractères html */
            $vehicles->vehicleTypes = htmlspecialchars($_POST['typeSelector']);
        } else {
            /* S'il est vide */
            $formError['typeSelector'] = 'Sélection obligatoire';
        }

        /* Si mon POST energySelector n'est pas vide */
        if (!empty($_POST['energySelector'])) {
            /* Je stocke son contenu dans mon paramètre d'objet en retirant les caractères html */
            $vehicles->energies = htmlspecialchars($_POST['energySelector']);
        } else {
            /* S'il est vide */
            $formError['energySelector'] = 'Sélection obligatoire';
        }

        if (!empty($_FILES['interiorPic'])) {
            /* Je définis le nom que je souhaite pour mon fichier */
            $interiorPicFileName = $_POST['manufacturerSelector'] . '_' . $_POST['modelSelector'] . '_interiorPic';
            $interiorPicFileExtension = pathinfo($_FILES['interiorPic']['name']);
            /* J'autorise les extensions */
            $allowedExtensions = array('jpg', 'jpeg', 'png');
            if (in_array($interiorPicFileExtension['extension'], $allowedExtensions)) {
                /* Je définis le nom de on fichier avec extension */
                $interiorPicFile = $fileUpload . $interiorPicFileName . '.' . $interiorPicFileExtension['extension'];
                /* Je déplace mon fichier */
                move_uploaded_file($_FILES['interiorPic']['tmp_name'], $interiorPicFile);
                /* Je donne les bons droits sur mon fichier */
                chmod($interiorPicFile, 0777);
                /* Je stocke son contenu dans mon paramètre d'objet */
                $vehicles->interiorPic = $interiorPicFile;
            } else {
                $formError['fileExtension'] = 'Extension non autorisée';
            }
        }

        if (!empty($_FILES['exteriorPic'])) {
            /* Je définis le nom que je souhaite pour mon fichier */
            $exteriorPicFileName = $_POST['manufacturerSelector'] . '_' . $_POST['modelSelector'] . '_exteriorPic';
            $exteriorPicFileExtension = pathinfo($_FILES['exteriorPic']['name']);
            /* J'autorise les extensions */
            $allowedExtensions = array('jpg', 'jpeg', 'png');
            if (in_array($exteriorPicFileExtension['extension'], $allowedExtensions)) {
                /* Je définis le nom de on fichier avec extension */
                $exteriorPicFile = $fileUpload . $exteriorPicFileName . '.' . $exteriorPicFileExtension['extension'];
                /* Je déplace mon fichier */
                move_uploaded_file($_FILES['exteriorPic']['tmp_name'], $exteriorPicFile);
                /* Je donne les bons droits sur mon fichier */
                chmod($exteriorPicFile, 0777);
                /* Je stocke son contenu dans mon paramètre d'objet */
                $vehicles->exteriorPic = $exteriorPicFile;
            } else {
                $formError['fileExtension'] = 'Extension non autorisée';
            }
        }

        /* Si je n'ai aucune erreur */
        if (count($formError) == 0) {
            /* Si ma méthode ne s'éxécute pas */
            if (!$vehicles->updateVehicle()) {
                $formError['add'] = 'L\'envoi du formulaire a échoué';
            } else {
                /* Je passe updateSuccess à true */
                $updateSuccess = true;
            }
        }
    }
}

/* Je ferme ensuite ma session */
session_write_close();
