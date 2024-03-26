<?php

require_once "Securite.class.php";
require_once "models/back/animaux.manager.php";

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

    // public function modification()
    // {
    //     if (Securite::verifAccessSession()) {
    //         $idFamille = (int)Securite::secureHTML($_POST['famille_id']);
    //         $libelle = Securite::secureHTML($_POST['famille_libelle']);
    //         $description = Securite::secureHTML($_POST['famille_description']);
    //         $this->famillesManager->updateFamille($idFamille, $libelle, $description);

    //         $_SESSION['alert'] = [
    //             "message" => "La famille a bien été modifiée",
    //             "type" => "alert-success"
    //         ];
    //         header('Location:' . URL . 'back/familles/visualisation');
    //     } else {
    //         throw new Exception("Vous n'avez pas le droit d'être la ! ");
    //     }
    // }

    // public function creationTemplate()
    // {
    //     if (Securite::verifAccessSession()) {
    //         require_once "views/famillesCreation.view.php";
    //     } else {
    //         throw new Exception("Vous n'avez pas le droit d'être la ! ");
    //     }
    // }

    // public function creationValidation()
    // {
    //     if (Securite::verifAccessSession()) {
    //         $libelle = Securite::secureHTML($_POST['famille_libelle']);
    //         $description = Securite::secureHTML($_POST['famille_description']);
    //         $idFamille = $this->famillesManager->createFamille($libelle, $description);

    //         $_SESSION['alert'] = [
    //             "message" => "La famille a bien été créée avec l'identifiant :" . $idFamille,
    //             "type" => "alert-success"
    //         ];
    //         header('Location:' . URL . 'back/familles/visualisation');
    //     } else {
    //         throw new Exception("Vous n'avez pas le droit d'être la ! ");
    //     }
    // }
}
