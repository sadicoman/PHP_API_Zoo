<?php

require_once "models/Model.php";

class AnimauxManager extends Model
{
    public function getAnimaux()
    {
        $bdd = $this->getBdd();
        $req = $bdd->prepare("SELECT * FROM animal");

        $req->execute();

        $animaux = $req->fetchAll(PDO::FETCH_ASSOC);

        return $animaux;
    }
}
