<?php

require_once "models/front/API.manager.php";
require_once "models/Model.php";

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

        Model::sendJSON($this->formatDataLignesAnimaux($animaux));
    }

    public function getAnimal($idAnimal)
    {
        $lignesAnimal = $this->apiManager->getDBAnimal($idAnimal);

        Model::sendJSON($this->formatDataLignesAnimaux($lignesAnimal));
    }

    private function formatDataLignesAnimaux($lignes)
    {
        $formattedData = [];
        foreach ($lignes as $ligne) {
            if (!array_key_exists($ligne['animal_id'], $formattedData)) {
                $formattedData[$ligne['animal_id']] = [
                    'id' => $ligne['animal_id'],
                    'nom' => $ligne['animal_nom'],
                    'description' => $ligne['animal_description'],
                    'image' => $ligne['animal_image'],
                    'famille' => [
                        'idFamille' => $ligne['famille_id'],
                        'libelle' => $ligne['famille_libelle'],
                        'descriptionFamille' => $ligne['famille_description'],
                    ],
                ];
            }
            // Exemple de reformattage des données

            $formattedData[$ligne['animal_id']]['continents'][] = [
                'idContinent' => $ligne['continent_id'],
                'libelleContinent' => $ligne['continent_libelle'],
            ];
        }
        return $formattedData;
    }

    public function getContinents()
    {
        $continents = $this->apiManager->getDBContinents();

        Model::sendJSON($continents);
    }

    public function getFamilles()
    {
        $familles = $this->apiManager->getDBFamilles();

        Model::sendJSON($familles);
    }

    public function sendMessage()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");

        $obj = json_decode(file_get_contents('php://input'));

        // $to = "francois.szczt@hotmail.fr";
        // $subject = "Message du site MyZoo de : ".$obj->nom;
        // $message = $obj->contenu;
        // $headers = "From : ".$obj->email;
        // mail($to, $subject, $message, $headers);

        $messageRetour = [
            'from' => $obj->email,
            'to' => "francois.szczt@hotmail.fr"
        ];

        echo json_encode($messageRetour);
    }
}
