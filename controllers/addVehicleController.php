<?php
/* Je démarre la session pour récupérer les variables qui me serviront à vérifier les droits d'accès */
session_start();

/* J'instancie un objet vehicles qui héritera des attributs de la classe vehicles */
$vehicles = new vehicles();
/* Je stocke le résultat de ma méthode getEnergiesList dans la variable energiesList */
$energiesList = $vehicles->getEnergiesList();
/* Je stocke le résultat de ma méthode getVehiclesTypesList dans la variable vehicleTypesList */
$vehicleTypesList = $vehicles->getVehiclesTypesList();
/* Je stocke le résultat de ma méthode getModelsList dans la variable modelsList */
$modelsList = $vehicles->getModelsList();
/* Je stocke le résultat de ma méthode getManufacturersList dans la variable manufacturersList */
$manufacturersList = $vehicles->getManufacturersList();

/* J'instancie un objet users qui héritera des attributs de la classe users */
$users = new users();
/* Je stocke le résultat de ma méthode getUserList dans la variable usersList */
$usersList = $users->getUserList();

/* J'initialise ma variable addSuccess à false */
$addSuccess = false;

/* J'initialise mon tableau d'erreurs à vide */
$formError = array();

/* Je définis dès le départ mon répertoire d'upload de fichiers */
$fileUpload = '../uploads/vehiclePics/';

/* Si ma variable de session roleId est égal à 2 (donc si l'utilisateur est gestionnaire de parc */
if ($_SESSION['roleId'] == 2) {
    /* Je stocke le chemin vers la navbar adéquate dans la variable navbar */
    $navbar = '../navbarParkManager.php';

    /* à l'envoi du formulaire */
    if (isset($_POST['submit'])) {

        /* Si mon POST n'est pas vide */
        if (!empty($_POST['serialNumber'])) {
            $vehicles->serialNumber = htmlspecialchars($_POST['serialNumber']);
        } else {
            $formError['serialNumber'] = 'Champ obligatoire';
        }

        /* Si mon POST n'est pas vide */
        if (!empty($_POST['firstRegistrationDate'])) {
            $vehicles->firstRegistrationDate = htmlspecialchars($_POST['firstRegistrationDate']);
        } else {
            $formError['firstRegistrationDate'] = 'Sélection obligatoire';
        }

        /* Si mon POST n'est pas vide */
        if (!empty($_POST['modelSelector'])) {
            $vehicles->vehicleModels = htmlspecialchars($_POST['modelSelector']);
        } else {
            $formError['modelSelector'] = 'Sélection obligatoire';
        }

        /* Si mon POST n'est pas vide */
        if (!empty($_POST['manufacturerSelector'])) {
            $vehicles->vehicleManufacturers = htmlspecialchars($_POST['manufacturerSelector']);
        } else {
            $formError['manufacturerSelector'] = 'Sélection obligatoire';
        }

        /* Si mon POST n'est pas vide */
        if (!empty($_POST['userSelector'])) {
            $vehicles->users = htmlspecialchars($_POST['userSelector']);
        } else {
            $formError['userSelector'] = 'Sélection obligatoire';
        }

        /* Si mon POST n'est pas vide */
        if (!empty($_POST['typeSelector'])) {
            $vehicles->vehicleTypes = htmlspecialchars($_POST['typeSelector']);
        } else {
            $formError['typeSelector'] = 'Sélection obligatoire';
        }

        /* Si mon POST n'est pas vide */
        if (!empty($_POST['energySelector'])) {
            $vehicles->energies = htmlspecialchars($_POST['energySelector']);
        } else {
            $formError['energySelector'] = 'Sélection obligatoire';
        }

        /* Si ma variable superglobale FILES n'est pas vide */
        if (!empty($_FILES['interiorPic'])) {
            $interiorPicFileName = $_POST['manufacturerSelector'] . '_' . $_POST['modelSelector'] . '_interiorPic';
            $interiorPicFileExtension = pathinfo($_FILES['interiorPic']['name']);
            $allowedExtensions = array('jpg', 'jpeg', 'png');
            if (in_array($interiorPicFileExtension['extension'], $allowedExtensions)) {
                $interiorPicFile = $fileUpload . $interiorPicFileName . '.' . $interiorPicFileExtension['extension'];
                move_uploaded_file($_FILES['interiorPic']['tmp_name'], $interiorPicFile);
                chmod($interiorPicFile, 0777);
                $vehicles->interiorPic = $interiorPicFile;
            } else {
                $formError['fileExtension'] = 'Extension non autorisée';
            }
        }

        /* Si ma variable superglobale FILES n'est pas vide */
        if (!empty($_FILES['exteriorPic'])) {
            $exteriorPicFileName = $_POST['manufacturerSelector'] . '_' . $_POST['modelSelector'] . '_exteriorPic';
            $exteriorPicFileExtension = pathinfo($_FILES['exteriorPic']['name']);
            $allowedExtensions = array('jpg', 'jpeg', 'png');
            if (in_array($exteriorPicFileExtension['extension'], $allowedExtensions)) {
                $exteriorPicFile = $fileUpload . $exteriorPicFileName . '.' . $exteriorPicFileExtension['extension'];
                move_uploaded_file($_FILES['exteriorPic']['tmp_name'], $exteriorPicFile);
                chmod($exteriorPicFile, 0777);
                $vehicles->exteriorPic = $exteriorPicFile;
            } else {
                $formError['fileExtension'] = 'Extension non autorisée';
            }
        }
        /* Si le nombre de lignes de mon tableau est égal à 0 */
        if (count($formError) == 0) {
            if (!$vehicles->addNewVehicle()) {
                $formError['add'] = 'L\'envoi du formulaire a échoué';
            } else {
                $addSuccess = true;
            }
        }
    }
} else {
    header('Location: errorPage.php');
}