<?php

session_start();

if ($_SESSION['roleId'] == 2) {
    $navbar = '../navbarParkManager.php';
}

$vehicles = new vehicles();

$formError = array();

$updateSuccess = false;

$fileUpload = '../uploads/vehiclePics/';

if (isset($_GET['vehicleId'])) {
    $vehicles->id = $_GET['vehicleId'];
    $vehicleDetails = $vehicles->getVehicleById();
    $energiesList = $vehicles->getEnergiesList();
    $vehicleTypesList = $vehicles->getVehiclesTypesList();
    $modelsList = $vehicles->getModelsList();
    $manufacturersList = $vehicles->getManufacturersList();
    $users = new users();
    $usersList = $users->getUserList();


    $updateSuccess = false;

    if (isset($_POST['submit'])) {

        if (!empty($_POST['serialNumber'])) {
            $vehicles->serialNumber = htmlspecialchars($_POST['serialNumber']);
        } else {
            $formError['serialNumber'] = 'Champ obligatoire';
        }

        if (!empty($_POST['firstRegistrationDate'])) {
            $vehicles->firstRegistrationDate = htmlspecialchars($_POST['firstRegistrationDate']);
        } else {
            $formError['firstRegistrationDate'] = 'Sélection obligatoire';
        }

        if (!empty($_POST['modelSelector'])) {
            $vehicles->vehicleModels = htmlspecialchars($_POST['modelSelector']);
        } else {
            $formError['modelSelector'] = 'Sélection obligatoire';
        }

        if (!empty($_POST['manufacturerSelector'])) {
            $vehicles->vehicleManufacturers = htmlspecialchars($_POST['manufacturerSelector']);
        } else {
            $formError['manufacturerSelector'] = 'Sélection obligatoire';
        }

        if (!empty($_POST['userSelector'])) {
            $vehicles->users = htmlspecialchars($_POST['userSelector']);
        } else {
            $formError['userSelector'] = 'Sélection obligatoire';
        }

        if (!empty($_POST['typeSelector'])) {
            $vehicles->vehicleTypes = htmlspecialchars($_POST['typeSelector']);
        } else {
            $formError['typeSelector'] = 'Sélection obligatoire';
        }

        if (!empty($_POST['energySelector'])) {
            $vehicles->energies = htmlspecialchars($_POST['energySelector']);
        } else {
            $formError['energySelector'] = 'Sélection obligatoire';
        }

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
        
        if (count($formError) == 0) {
            if (!$vehicles->updateVehicle()) {
                $formError['add'] = 'L\'envoi du formulaire a échoué';
            } else {
                $updateSuccess = true;
            }
        }
    }
}

session_write_close();
