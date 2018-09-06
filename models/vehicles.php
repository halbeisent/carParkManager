<?php

class vehicles extends database {

    public function __construct() {
        parent::__construct();
    }

    /* Je crée ma méthode addNewVehicle */
    public function addNewVehicle() {
        /* Je prépare ma requête avec les marqueurs nominatifs */
        $addVehicleQuery = 'INSERT INTO `g2c6d_vehicles` (`serialNumber`, `firstRegistrationDate`, `vehicleModels`, `vehicleManufacturers`, `users`, `vehiclesTypes`, `energies`, `interiorPic`, `exteriorPic`) '
                . 'VALUES (:serialNumber, STR_TO_DATE(:firstRegistrationDate, \'%d/%m/%Y\'), :vehicleModels, :vehicleManufacturers, :users, :vehicleTypes, :energies, :interiorPic, :exteriorPic)';
        /* Je prépare ma requête en raison de la présence de marqueurs nominatifs */
        $addVehicle = $this->database->prepare($addVehicleQuery);
        /* Les marqueurs nominatifs demande des bindValue qui permettent de remplir les paramètres d'objet */
        $addVehicle->bindValue(':serialNumber', $this->serialNumber, PDO::PARAM_STR);
        $addVehicle->bindValue(':firstRegistrationDate', $this->firstRegistrationDate, PDO::PARAM_STR);
        $addVehicle->bindValue(':vehicleModels', $this->vehicleModels, PDO::PARAM_INT);
        $addVehicle->bindValue(':vehicleManufacturers', $this->vehicleManufacturers, PDO::PARAM_INT);
        $addVehicle->bindValue(':users', $this->users, PDO::PARAM_INT);
        $addVehicle->bindValue(':vehicleTypes', $this->vehicleTypes, PDO::PARAM_INT);
        $addVehicle->bindValue(':energies', $this->energies, PDO::PARAM_INT);
        $addVehicle->bindValue(':interiorPic', $this->interiorPic, PDO::PARAM_STR);
        $addVehicle->bindValue(':exteriorPic', $this->exteriorPic, PDO::PARAM_STR);
        /* Une fois que tout est prêt j'éxécute ma méthode */
        return $addVehicle->execute();
    }

    /* Je créée ma méthode updateVehicle */
    public function updateVehicle() {
        /* Je prépare ma requête en raison de la présence de marqueurs nominatifs */
        $updateQuery = 'UPDATE `g2c6d_vehicles` SET `g2c6d_vehicles`.`serialNumber` = :serialNumber, `g2c6d_vehicles`.`firstRegistrationDate` = :firstRegistrationDate, `g2c6d_vehicles`.`vehicleModels` = :vehicleModels, '
                . '`g2c6d_vehicles`.`vehicleManufacturers` = :vehicleManufacturers, `g2c6d_vehicles`.`users` = :users, `g2c6d_vehicles`.`vehiclesTypes` = :vehiclesTypes, `g2c6d_vehicles`.`energies` = :energies,'
                . '`g2c6d_vehicles`.`interiorPic` = :interiorPic, `g2c6d_vehicles`.`exteriorPic` = :exteriorPic WHERE `id` = :vehicleId';
        $updateVehicle = $this->database->prepare($updateQuery);
        /* Je remplis mes paramètres avec le contenu des paramètres de l'objet ayant appelé la méthode */
        $updateVehicle->bindValue(':serialNumber', $this->serialNumber, PDO::PARAM_STR);
        $updateVehicle->bindValue(':firstRegistrationDate', $this->firstRegistrationDate, PDO::PARAM_STR);
        $updateVehicle->bindValue(':vehicleModels', $this->vehicleModels, PDO::PARAM_INT);
        $updateVehicle->bindValue(':vehicleManufacturers', $this->vehicleManufacturers, PDO::PARAM_INT);
        $updateVehicle->bindValue(':users', $this->users, PDO::PARAM_INT);
        $updateVehicle->bindValue(':vehiclesTypes', $this->vehicleTypes, PDO::PARAM_INT);
        $updateVehicle->bindValue(':energies', $this->energies, PDO::PARAM_INT);
        $updateVehicle->bindValue(':interiorPic', $this->interiorPic, PDO::PARAM_STR);
        $updateVehicle->bindValue(':exteriorPic', $this->exteriorPic, PDO::PARAM_STR);
        $updateVehicle->bindValue(':vehicleId', $this->id, PDO::PARAM_INT);
        return $updateVehicle->execute();
    }

    /* Je créée la méthode getVehiclesList */
    public function getVehiclesList() {
        /* Je stocke ma méthode dans une variable nommée vehicleQuery */
        $vehicleQuery = 'SELECT `g2c6d_vehicles`.`id`, `g2c6d_vehicleModels`.`name` AS `modelName`, `g2c6d_manufacturers`.`name` AS `manufacturerName`, `g2c6d_vehicles`.`exteriorPic`, `g2c6d_vehicles`.`id` AS `vehicleId`, `g2c6d_users`.`firstName` AS `userFirstName`, `g2c6d_users`.`lastName` AS `userLastName` FROM `g2c6d_vehicles` LEFT JOIN `g2c6d_vehicleModels` ON `g2c6d_vehicleModels`.`id` = `g2c6d_vehicles`.`vehicleModels` LEFT JOIN `g2c6d_manufacturers` ON `g2c6d_manufacturers`.`id` = `g2c6d_vehicles`.`vehicleManufacturers` LEFT JOIN `g2c6d_users` ON `g2c6d_users`.`id` = `g2c6d_vehicles`.`users`';
        $listQuery = $this->database->query($vehicleQuery);
        $queryResult = $listQuery->fetchAll(PDO::FETCH_OBJ);
        return $queryResult;
    }

    /* Je créée ma méthode getVehicleByUser */
    public function getVehicleByUser() {
        $vehicleQuery = 'SELECT `g2c6d_manufacturers`.`name` AS `manufacturerName`, `g2c6d_vehicleModels`.`name` AS `modelName`, `g2c6d_vehicles`.`interiorPic`, `g2c6d_vehicles`.`exteriorPic`, `g2c6d_vehicles`.`id` AS `vehicleId` '
                . 'FROM `g2c6d_vehicles` '
                . 'LEFT JOIN `g2c6d_manufacturers` '
                . 'ON `g2c6d_manufacturers`.`id` = `g2c6d_vehicles`.`vehicleManufacturers` '
                . 'LEFT JOIN `g2c6d_vehicleModels` '
                . 'ON `g2c6d_vehicleModels`.`id` = `g2c6d_vehicles`.`vehicleModels` '
                . 'WHERE `g2c6d_vehicles`.`users` = :userId';
        /* Je prépare ma requête en raison de la présence de marqueur nominatif */
        $getVehicleDetails = $this->database->prepare($vehicleQuery);
        $getVehicleDetails->bindValue(':userId', $this->userId, PDO::PARAM_INT);
        /* j'éxécute ma requête */
        $getVehicleDetails->execute();
        /* Puis je récupère toutes les lignes qu'elle me retourne */
        $queryResult = $getVehicleDetails->fetchAll(PDO::FETCH_OBJ);
        return $queryResult;
    }

    /* Je créée ma méthode getVehicleById */ 
    public function getVehicleById() {
        $vehicleQuery = 'SELECT `g2c6d_vehicles`.`id`, `g2c6d_vehicles`.`serialNumber` AS `serialNumber`, `g2c6d_vehicles`.`firstRegistrationDate`, `g2c6d_vehicles`.`vehicleModels`, `g2c6d_vehicles`.`vehicleManufacturers`, `g2c6d_vehicleModels`.`name` AS `modelName`, `g2c6d_manufacturers`.`name` AS `manufacturerName`, `g2c6d_vehicles`.`users`, `g2c6d_users`.`lastName` AS `userLastName`, `g2c6d_users`.`firstName` AS `userFirstName`, '
                . '`g2c6d_vehicles`.`vehiclesTypes` AS `vehicleCategory`, `g2c6d_vehiclesTypes`.`name` AS `vehiclesTypes`, `g2c6d_vehicles`.`energies`, `g2c6d_energies`.`type` AS `energyType`, `g2c6d_vehicles`.`interiorPic` AS `interiorPic`, `g2c6d_vehicles`.`exteriorPic` AS `exteriorPic`'
                . 'FROM `g2c6d_vehicles` '
                . 'LEFT JOIN `g2c6d_manufacturers` '
                . 'ON `g2c6d_manufacturers`.`id` = `g2c6d_vehicles`.`vehicleManufacturers` '
                . 'LEFT JOIN `g2c6d_vehicleModels` '
                . 'ON `g2c6d_vehicleModels`.`id` = `g2c6d_vehicles`.`vehicleModels` '
                . 'LEFT JOIN `g2c6d_users` '
                . 'ON `g2c6d_users`.`id` = `g2c6d_vehicles`.`users` '
                . 'LEFT JOIN `g2c6d_vehiclesTypes` '
                . 'ON `g2c6d_vehiclesTypes`.`id` = `g2c6d_vehicles`.`vehiclesTypes` '
                . 'LEFT JOIN `g2c6d_energies` '
                . 'ON  `g2c6d_energies`.`id` = `g2c6d_vehicles`.`energies` '
                . 'WHERE `g2c6d_vehicles`.`id` = :vehicleId';
        /* Je prépare ma requête en raison de la présence de marqueurs nominatifs */
        $getVehicleInfo = $this->database->prepare($vehicleQuery);
        $getVehicleInfo->bindValue(':vehicleId', $this->id, PDO::PARAM_INT);
        /* J'éxécute ma méthode */
        $getVehicleInfo->execute();
        /* Je stocke le résultat d'une lignt dans la variable $queryResult */
        $queryResult = $getVehicleInfo->fetch(PDO::FETCH_OBJ);
        return $queryResult;
    }

    /* Je créée ma méthode deleteVehicleOnly */
    public function deleteVehicleOnly() {
        /* Je stocke ma requête dans une variable */
            $deleteVehicleQuery = 'DELETE FROM `g2c6d_vehicles` WHERE `id` = :vehicleId';
            /* Je prépare ma requête en raison de la présence de marqueurs nominatifs */
            $deleteVehicleQueryResult = $this->database->prepare($deleteVehicleQuery);
            $deleteVehicleQueryResult->bindValue('vehicleId', $this->id, PDO::PARAM_INT);
            /* J'éxécute ma méthode */
            return $deleteVehicleQueryResult->execute();
    }

    /* Je créée ma méthode getManufacturersList */
    public function getManufacturersList() {
        $manufacturersListQuery = 'SELECT `g2c6d_manufacturers`.`id`, `g2c6d_manufacturers`.`name` FROM `g2c6d_manufacturers`';
        $manufacturersList = $this->database->query($manufacturersListQuery);
        /* Je récupère le résultat de ma méthode ligne par ligne */
        $queryResult = $manufacturersList->fetchAll(PDO::FETCH_OBJ);
        return $queryResult;
    }

    /* Je créée ma méthode getModelsList */
    public function getModelsList() {
        $modelsListQuery = 'SELECT `g2c6d_vehicleModels`.`id`, `g2c6d_vehicleModels`.`name` FROM `g2c6d_vehicleModels`';
        $modelsList = $this->database->query($modelsListQuery);
        /* Je récupère le résultat de ma méthode ligne par ligne */
        $queryResult = $modelsList->fetchAll(PDO::FETCH_OBJ);
        return $queryResult;
    }

    /* Je créée ma méthode getEnergiesList */
    public function getEnergiesList() {
        $energiesQuery = 'SELECT `g2c6d_energies`.`id`, `g2c6d_energies`.`type` FROM `g2c6d_energies`';
        $energiesList = $this->database->query($energiesQuery);
        /* Je récupère le résultat de ma méthode ligne par ligne */
        $queryResult = $energiesList->fetchAll(PDO::FETCH_OBJ);
        return $queryResult;
    }

    /* Je créée ma méthode getVehiclesTypesList */
    public function getVehiclesTypesList() {
        $vehicleTypesQuery = 'SELECT `g2c6d_vehiclesTypes`.`id`, `g2c6d_vehiclesTypes`.`name` FROM `g2c6d_vehiclesTypes`';
        $vehicleTypesList = $this->database->query($vehicleTypesQuery);
        /* Je récupère le résultat de ma méthode ligne par ligne */
        $queryResult = $vehicleTypesList->fetchAll(PDO::FETCH_OBJ);
        return $queryResult;
    }

    public function __destruct() {
        parent::__destruct();
    }

}
