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
            $this->famillesManager->delateDBfamille((int)Securite::secureHTML($_POST['famille_id']));
        } else {
            throw new Exception("Vous n'avez pas le droit d'être la ! ");
        }
    }
}
