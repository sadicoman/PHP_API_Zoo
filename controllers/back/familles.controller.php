<?php

require_once "Securite.class.php";
require_once "models/back/familles.manager.php";

class FamillesController
{
    private $famillesManager;

    public function __construct()
    {
        $this->famillesManager = new FamillesManager();
    }

    public function visualisation()
    {
        if (Securite::verifAccessSession()) {
            $familles = $this->famillesManager->getFamilles();
            require_once "views/famillesVisualisation.view.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être la ! ");
        }
    }

    public function creation()
    {
    }

    public function suppression()
    {
        if (Securite::verifAccessSession()) {

            $idFamille = (int)Securite::secureHTML($_POST['famille_id']);

            if ($this->famillesManager->compterAnimaux($idFamille) > 0) {
                $_SESSION['alert'] = [
                    "message" => "La famille n'a pas été supprimé",
                    "type" => "alert-danger"
                ];
            } else {
                $this->famillesManager->delateDBfamille($idFamille);
                $_SESSION['alert'] = [
                    "message" => "La famille est supprimée",
                    "type" => "alert-success"
                ];
            }
            header('Location:' . URL . 'back/familles/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être la ! ");
        }
    }
}
