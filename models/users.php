<?php

/* On crée une class users qui hérite de la classe database via extends
 */

class users extends database {

    public $id = '';
    public $mailAddress = '';
    public $userGroups = '';
    public $password = '';
    public $lastName = '';
    public $firstName = '';
    public $birthDate = '';
    public $licenseScanPath = '';
    public $isValid = '';

    public function __construct() {
        // On appelle le __construct() du parent via "parent::""
        parent::__construct();
    }

    /* Je créée la fonction addUser */

    public function addUser() {
        /* Préparation de la requête */
        $addQuery = 'INSERT INTO `g2c6d_users` (`mailAddress`, `password`, `lastName`, `firstName`, `birthDate`, `licenseScanPath`, `licenseNumber`, `isValid`, `streetNumber`, `streetName`, `zipCode`, `city`, `userGroups`) VALUES (:mailAddress, :password, :lastName, :firstName, STR_TO_DATE(:birthDate, \'%d/%m/%Y\'), :licenseScanPath, :licenseNumber, :isValid, :streetNumber, :streetName, :zipCode, :city, 3)';
        /* Je prépare ma requête en raison des marqueurs nominatifs */
        $addUser = $this->database->prepare($addQuery);
        /* Je bind mes values par sécurité */
        $addUser->bindValue(':mailAddress', $this->mailAddress, PDO::PARAM_STR);
        $addUser->bindValue(':password', $this->password, PDO::PARAM_STR);
        $addUser->bindValue(':lastName', $this->lastName, PDO::PARAM_STR);
        $addUser->bindValue(':firstName', $this->firstName, PDO::PARAM_STR);
        $addUser->bindValue(':birthDate', $this->birthDate, PDO::PARAM_STR);
        $addUser->bindValue(':licenseScanPath', $this->licenseScanPath, PDO::PARAM_STR);
        $addUser->bindValue(':licenseNumber', $this->licenseNumber, PDO::PARAM_STR);
        $addUser->bindValue(':isValid', $this->isValid, PDO::PARAM_INT);
        $addUser->bindValue(':streetNumber', $this->streetNumber, PDO::PARAM_STR);
        $addUser->bindValue(':streetName', $this->streetName, PDO::PARAM_STR);
        $addUser->bindValue(':zipCode', $this->zipCode, PDO::PARAM_STR);
        $addUser->bindValue(':city', $this->city, PDO::PARAM_STR);
        /* J'éxécute ma requête une fois prête */
        return $addUser->execute();
    }
    
    public function getMailCheck() {
        $emailQuery = 'SELECT COUNT(*) AS `usedMailAddress` FROM `g2c6d_users` WHERE `mailAddress` = :mailAddress';
        $emailCheck = $this->database->prepare($emailQuery);
        $emailCheck->bindValue(':mailAddress', $this->mailAddress, PDO::PARAM_STR);
        $emailCheck->execute();
        $queryResult = $emailCheck->fetch(PDO::FETCH_OBJ);
        return $queryResult;
    }

    /* Je créée la fonction updateUser */

    public function updateUser() {
        /* Je définis ma requête et je la stocke dans une variable pour plus tard */
        $updateQuery = 'UPDATE `g2c6d_users` '
                . 'SET `mailAddress` = :mailAddress, `userGroups` = :userGroups, `lastName` = :lastName, `firstName` = :firstName, `birthDate` = STR_TO_DATE(:birthDate, \'%d/%m/%Y\'), `licenseScanPath` = :licenseScanPath, `licenseNumber` = :licenseNumber, '
                . '`isValid` = :isValid, `streetNumber` = :streetNumber, `streetName` = :streetName, `zipCode` = :zipCode, `city` = :city WHERE `id` = :id';
        /* Je prépare ma requête en raison des marqueurs nominatifs */
        $userUpdate = $this->database->prepare($updateQuery);
        /* Je bind mes values par sécurité */
        $userUpdate->bindValue(':id', $this->id, PDO::PARAM_INT);
        $userUpdate->bindValue(':mailAddress', $this->mailAddress, PDO::PARAM_STR);
        $userUpdate->bindValue(':userGroups', $this->userGroups, PDO::PARAM_INT);
        $userUpdate->bindValue(':lastName', $this->lastName, PDO::PARAM_STR);
        $userUpdate->bindValue(':firstName', $this->firstName, PDO::PARAM_STR);
        $userUpdate->bindValue(':birthDate', $this->birthDate, PDO::PARAM_STR);
        $userUpdate->bindValue(':licenseScanPath', $this->licenseScanPath, PDO::PARAM_STR);
        $userUpdate->bindValue(':licenseNumber', $this->licenseNumber, PDO::PARAM_STR);
        $userUpdate->bindValue(':isValid', $this->isValid, PDO::PARAM_INT);
        $userUpdate->bindValue(':streetNumber', $this->streetNumber, PDO::PARAM_STR);
        $userUpdate->bindValue(':streetName', $this->streetName, PDO::PARAM_STR);
        $userUpdate->bindValue(':zipCode', $this->zipCode, PDO::PARAM_STR);
        $userUpdate->bindValue(':city', $this->city, PDO::PARAM_STR);
        /* Ma requête prête, je l'éxécute */
        return $userUpdate->execute();
    }

    /* Je créée la fonction getHashByMail */

    public function getHashByMail() {
        /* Je stocke ma requête dans une variable pour une utilisation ultérieure */
        $checkQuery = 'SELECT `password` FROM `g2c6d_users` WHERE `mailAddress` = :mailAddress';
        /* Je prépare ma requête en raison des marqueurs nominatifs */
        $loginCheck = $this->database->prepare($checkQuery);
        /* Je bind ma value par sécurité */
        $loginCheck->bindValue(':mailAddress', $this->mailAddress, PDO::PARAM_STR);
        /* Si j'éxécute ma requête */
        if ($loginCheck->execute()) {
            /* Je stocke le résultat de ma requête dans la variable checkResult qui devient un tableau d'objets */
            $checkResult = $loginCheck->fetch(PDO::FETCH_OBJ);
        } else {
            /* Sinon checkResult me stocke un message d'erreur */
            $checkResult = 'Un problème est survenu, si le problème persiste, contactez l\'administrateur';
        }
        /* Je retourne checkResult dont le contenu change en fonction de l'éxécution ou non de la requête */
        return $checkResult;
    }

    /* Je créée la fonction getUserByMail */

    public function getUserByMail() {
        /* Je stocke ma requête pour l'utiliser plus tard */
        $userQuery = 'SELECT `lastName`, `firstName`, `id`, `userGroups` FROM `g2c6d_users` WHERE `mailAddress` = :mailAddress';
        /* Je prépare ma requête en raison des marqueurs nominatifs */
        $user = $this->database->prepare($userQuery);
        /* Je bind ma value par sécurité */
        $user->bindValue(':mailAddress', $this->mailAddress, PDO::PARAM_STR);
        /* Si ma requête s'éxécute */
        if ($user->execute()) {
            /* Je stocke le contenu de ma requête dans la variable userParams */
            $userParams = $user->fetch(PDO::FETCH_OBJ);
            $this->id = $userParams->id;
            $this->lastName = $userParams->lastName;
            $this->firstName = $userParams->firstName;
            $this->userGroups = $userParams->userGroups;
            /* J'en profite pour créer une variable qui va me stocker un message de bonne éxécution ou non à des fins de debug */
            $errorMsg = 'La requête s\'est bien exécutée';
        } else {
            $errorMsg = 'Un problème est survenu, si le problème persiste, contactez l\'administrateur';
        }
        return $errorMsg;
    }

    //Génération de la liste utilisateurs
    public function getUserList() {
        /* Je stocke ma requête dans une variable pour une utilisation ultérieure */
        $userQuery = 'SELECT `id`, `firstName`, `lastName`, `mailAddress` FROM `g2c6d_users`';
        /* J'éxécute ma requête */
        $listQuery = $this->database->query($userQuery);
        /* Puis j'en récupère les résultats */
        $queryResult = $listQuery->fetchAll(PDO::FETCH_OBJ);
        /* Puis je retourne la variable queryResult */
        return $queryResult;
    }

    /* Je créée ma requête getUserById */

    public function getUserbyId() {
        /* Je créée une variable qui va me stocker un booléen en fonction du résultat de la requête */
        $getSuccess = false;
        /* Je stocke ma requête pour la réutiliser ultérieurement */
        $query = 'SELECT `id`, `lastName`, `firstName`, DATE_FORMAT(`birthDate`, "%d/%m/%Y") AS `birthDate`, `streetNumber`, `streetName`, `zipCode`, `city`, `mailAddress`, `userGroups`, `licenseScanPath`, `licenseNumber`, `isValid` FROM `g2c6d_users` WHERE `id` = :id';
        /* Je prépare ma requête en raison de la présence de marqueurs nominatifs */
        $getUser = $this->database->prepare($query);
        /* Je bind ma value pour raisons de sécurité */
        $getUser->bindValue(':id', $this->id, PDO::PARAM_INT);
        /* Si ma requête s'éxécute correctement */
        if ($getUser->execute()) {
            /* Alors je stocke ses résultats dans la variable user */
            $user = $getUser->fetch(PDO::FETCH_OBJ);
            /* Si j'ai bien récupéré un objet */
            if (is_object($user)) {
                /* J'effectue mon hydratation pour renseigner mon tableau user */
                $this->lastName = $user->lastName;
                $this->firstName = $user->firstName;
                $this->birthDate = $user->birthDate;
                $this->streetNumber = $user->streetNumber;
                $this->streetName = $user->streetName;
                $this->zipCode = $user->zipCode;
                $this->city = $user->city;
                $this->mailAddress = $user->mailAddress;
                $this->userGroups = $user->userGroups;
                $this->licenseScanPath = $user->licenseScanPath;
                $this->licenseNumber = $user->licenseNumber;
                $this->isValid = $user->isValid;
                /* Puis je passe getSuccess à true */
                $getSuccess = true;
            }
        }
        /* Pour finir je retourne le résultat de getSuccess */
        return $getSuccess;
    }

    public function getUserGroups() {
        $userGroupsQuery = 'SELECT `g2c6d_userGroups`.`id`, `g2c6d_userGroups`.`role` FROM `g2c6d_userGroups`';
        $userGroupsResult = $this->database->query($userGroupsQuery);
        $userGroupsResult->execute();
        $userGroupsList = $userGroupsResult->fetchAll(PDO::FETCH_OBJ);
        return $userGroupsList;
    }

    /* Je crée ma méthode deleteUserById */

    public function deleteUserById() {
        /* Je stocke ma requête dans une variable pour la réutiliser ultérieurement */
        $userQuery = 'DELETE FROM `g2c6d_users` WHERE `id` = :id';
        /* Je prépare ma requête ma requête en raison de la présence d'un marqueur nominatif */
        $userDelete = $this->database->prepare($userQuery);
        /* Je bind ma value par sécurité */
        $userDelete->bindValue(':id', $this->id, PDO::PARAM_STR);
        /* Puis je retourne le résultat de l'éxécution de userDelete */
        return $userDelete->execute();
    }

    public function __destruct() {
        // On appelle le __destruct() du parent via "parent::""
        parent::__destruct();
    }

}
