<?php
// On crée une class database
class database {
    // On crée un attribut $DataBase qui sera disponible dans ses enfants car on la mis en public
    public $database;
    // On crée la méthode magique __construct pour se connecter à la base de donnée mySQL
    public function __construct() {
        // On essaye de se connecter en instanciant un nouvelle objet PDO
        try {
            $this->database = new PDO('mysql:host=127.0.0.1;dbname=fleetManage;charset=utf8', 'e2nExoUser', 'E2n.2018');
            // Si erreur, on "attrape" l'exception que l'on stock dans $e et on arrête le script PHP.
        } catch (Exception $errorMessage) {
            die('Erreur : ' . $errorMessage->getMessage()); // On affiche le message d'erreur avec la methode getMessage;
        }
    }
    // on crée la méthode magique __destruct qui nous permet de nous déconnecter de la base de donnée
    public function __destruct() {
        $this->database = NULL;
    }

}
