<?php
class APIController
{
    public function getAnimaux()
    {
        echo "Envoi des informations sur les animaux";
    }

    public function getAnimal($idAnimal)
    {
        echo "Données JSON de l'animal " . $idAnimal . " demandées";
    }

    public function getContinents()
    {
        echo "Envoi des informations sur les continents";
    }

    public function getFamilles()
    {
        echo "Envoi des informations sur les familles";
    }
}
