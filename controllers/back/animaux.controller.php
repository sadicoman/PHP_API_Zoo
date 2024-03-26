<?php

require_once "Securite.class.php";
require_once "models/back/animaux.manager.php";
require_once "models/back/familles.manager.php";
require_once "models/back/continents.manager.php";

class AnimauxController
{
    private $animauxManager;

    public function __construct()
    {
        $this->animauxManager = new AnimauxManager();
    }

    public function visualisation()
    {
        if (Securite::verifAccessSession()) {
            $animaux = $this->animauxManager->getAnimaux();
            require_once "views/animauxVisualisation.view.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être la ! ");
        }
    }

    public function suppression()
    {
        if (Securite::verifAccessSession()) {

            $idAnimal = (int)Securite::secureHTML($_POST['animal_id']);

            $this->animauxManager->delateDBAnimalContinent($idAnimal);
            $this->animauxManager->delateDBAnimal($idAnimal);
            $_SESSION['alert'] = [
                "message" => "L'animal est supprimée",
                "type" => "alert-success"
            ];
            header('Location:' . URL . 'back/animaux/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être la ! ");
        }
    }

    public function creation()
    {
        if (Securite::verifAccessSession()) {
            $famillesManager = new famillesManager();
            $familles = $famillesManager->getFamilles();

            $continentsManager = new continentsManager();
            $continents = $continentsManager->getContinent();

            require_once "views/animalCreation.view.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être la ! ");
        }
    }
}
