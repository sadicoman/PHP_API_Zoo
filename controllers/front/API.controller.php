<?php

require_once "models/front/API.manager.php";

class APIController
{
    private $apiManager;

    public function __construct()
    {
        $this->apiManager = new APIManager();
    }

    public function getAnimaux()
    {
        $animaux = $this->apiManager->getDBAnimaux();

        // header('Content-Type: application/json'); // Indique que la réponse est au format JSON
        // echo json_encode($animaux); // Encode les données en JSON et les envoie

        echo "<pre>";
        print_r($animaux);
        echo "</pre>";
    }

    public function getAnimal($idAnimal)
    {
        $lignesAnimal = $this->apiManager->getDBAnimal($idAnimal);
        echo "<pre>";
        print_r($lignesAnimal);
        echo "</pre>";
    }

    public function getContinents()
    {
        $continents = $this->apiManager->getDBContinents();
        echo "<pre>";
        print_r($continents);
        echo "</pre>";
    }

    public function getFamilles()
    {
        $familles = $this->apiManager->getDBFamilles();
        echo "<pre>";
        print_r($familles);
        echo "</pre>";
    }
}
