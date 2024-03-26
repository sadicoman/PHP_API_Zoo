<?php

require_once "models/Model.php";

class FamillesManager extends Model
{
    public function getFamilles()
    {
        $bdd = $this->getBdd();
        $req = $bdd->prepare("SELECT * FROM famille");

        $req->execute();

        $familles = $req->fetchAll(PDO::FETCH_ASSOC);

        return $familles;
    }
}
