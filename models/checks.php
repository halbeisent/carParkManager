<?php

class checks extends database {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getMaintenanceAppointmentsByVehicleId() {
        $appointmentsQuery = 'SELECT `g2c6d_maintenanceChecks`.`id`, `g2c6d_maintenanceChecks`.`maintenanceCheckDate`, `g2c6d_maintenanceChecks`.`maintenanceNextCheckDate` FROM `g2c6d_maintenanceChecks` WHERE `g2c6d_maintenanceChecks`.`vehicleId` = :vehicleId';
        $appointmentsList = $this->database->prepare($appointmentsQuery);
        $appointmentsList->bindValue(':vehicleId', $this->id, PDO::PARAM_INT);
        $appointmentsList->execute();
        $queryResults = $appointmentsList->fetchAll(PDO::FETCH_OBJ);
        return $queryResults;
    }   
    
    public function getMaintenanceAppointmentsByUserId() {
        $appointmentsQuery = 'SELECT `g2c6d_maintenanceChecks`.`id`, `g2c6d_maintenanceChecks`.`maintenanceCheckDate`, `g2c6d_maintenanceChecks`.`maintenanceNextCheckDate` FROM `g2c6d_maintenanceChecks` WHERE `g2c6d_maintenanceChecks`.`userId` = :userId';
        $appointmentsList = $this->database->prepare($appointmentsQuery);
        $appointmentsList->bindValue(':userId', $this->id, PDO::PARAM_INT);
        $appointmentsList->execute();
        $queryResults = $appointmentsList->fetchAll(PDO::FETCH_OBJ);
        return $queryResults;
    }
    
    public function getRoadSafetyAppointmentsByVehicleId() {
        $appointmentsQuery = 'SELECT `g2c6d_roadSafetyChecks`.`id`, `g2c6d_roadSafetyChecks`.`date`, `g2c6d_roadSafetyChecks`.`nextDate` FROM `g2c6d_roadSafetyChecks` WHERE `g2c6d_roadSafetyChecks`.`vehicleId` = :vehicleId';
        $appointmentsList = $this->database->prepare($appointmentsQuery);
        $appointmentsList->bindValue(':vehicleId', $this->id, PDO::PARAM_INT);
        $appointmentsList->execute();
        $queryResults = $appointmentsList->fetchAll(PDO::FETCH_OBJ);
        return $queryResults;
    }
    
    public function getRoadSafetyAppointmentsByUserId() {
        $appointmentsQuery = 'SELECT `g2c6d_roadSafetyChecks`.`id`, `g2c6d_roadSafetyChecks`.`date`, `g2c6d_roadSafetyChecks`.`nextDate` FROM `g2c6d_roadSafetyChecks` WHERE `g2c6d_roadSafetyChecks`.`userId` = :userId';
        $appointmentsList = $this->database->prepare($appointmentsQuery);
        $appointmentsList->bindValue(':userId', $this->id, PDO::PARAM_INT);
        $appointmentsList->execute();
        $queryResults = $appointmentsList->fetchAll(PDO::FETCH_OBJ);
        return $queryResults;
    }
    
    public function __destruct() {
        parent::__destruct();
    }
    
}