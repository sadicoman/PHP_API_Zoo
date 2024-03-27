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

    public function creationValidation()
    {
        if (Securite::verifAccessSession()) {
            $nom = Securite::secureHTML($_POST['animal_nom']);
            $description = Securite::secureHTML($_POST['animal_description']);
            $image = "";
            $famille = (int)Securite::secureHTML($_POST['famille_id']);
            $idAnimal = $this->animauxManager->createAnimal($nom, $description, $image, $famille);

            $continentsManager = new ContinentsManager();
            if (!empty($_POST['continents-1'])) {
                $continentsManager->addContinentAnimal($idAnimal, 1);
            }
            if (!empty($_POST['continents-2'])) {
                $continentsManager->addContinentAnimal($idAnimal, 2);
            }
            if (!empty($_POST['continents-3'])) {
                $continentsManager->addContinentAnimal($idAnimal, 3);
            }
            if (!empty($_POST['continents-4'])) {
                $continentsManager->addContinentAnimal($idAnimal, 4);
            }
            if (!empty($_POST['continents-5'])) {
                $continentsManager->addContinentAnimal($idAnimal, 5);
            }

            $_SESSION['alert'] = [
                "message" => "L'animal a bien été créée avec l'identifiant : " . $idAnimal,
                "type" => "alert-success"
            ];
            header('Location:' . URL . 'back/animaux/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être la ! ");
        }
    }

    public function modification($idAnimal)
    {
        if (Securite::verifAccessSession()) {
            $famillesManager = new FamillesManager();
            $familles = $famillesManager->getFamilles();
            $continentsManager = new ContinentsManager();
            $continents = $continentsManager->getContinent();

            $lignesAnimal = $this->animauxManager->getAnimal((int)Securite::secureHTML($idAnimal));
            $tabContinents = [];
            foreach ($lignesAnimal as $continent) {
                $tabContinents[] = $continent['continent_id'];
            }
            $animal = array_slice($lignesAnimal[0], 0, 5);

            require_once "views/animalModification.view.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function modificationValidation()
    {
        if (Securite::verifAccessSession()) {
            $idAnimal = Securite::secureHTML($_POST['animal_id']);
            $nom = Securite::secureHTML($_POST['animal_nom']);
            $description = Securite::secureHTML($_POST['animal_description']);
            $image = "";
            $famille = (int) Securite::secureHTML($_POST['famille_id']);

            $this->animauxManager->updateAnimal($idAnimal, $nom, $description, $image, $famille);

            $continents = [
                1 => !empty($_POST['continent-1']),
                2 => !empty($_POST['continent-2']),
                3 => !empty($_POST['continent-3']),
                4 => !empty($_POST['continent-4']),
                5 => !empty($_POST['continent-5']),
            ];

            $continentsManager = new ContinentsManager;

            foreach ($continents as $key => $continent) {
                //continent coché et non présent en BD
                if ($continents[$key] && !$continentsManager->verificationExisteAnimalContinent($idAnimal, $key)) {
                    $continentsManager->addContinentAnimal($idAnimal, $key);
                }

                //continent non coché et présent en BD
                if (!$continents[$key] && $continentsManager->verificationExisteAnimalContinent($idAnimal, $key)) {
                    $continentsManager->deleteDBContinentAnimal($idAnimal, $key);
                }
            }

            $_SESSION['alert'] = [
                "message" => "L'animal a bien été modifié",
                "type" => "alert-success"
            ];
            header('Location: ' . URL . 'back/animaux/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }
}
