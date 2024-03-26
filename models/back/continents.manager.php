<?php

require_once "models/Model.php";

class ContinentsManager extends Model
{
    public function getContinent()
    {
        $bdd = $this->getBdd();
        $req = $bdd->prepare("SELECT * FROM continent");

        $req->execute();

        $animaux = $req->fetchAll(PDO::FETCH_ASSOC);

        return $animaux;
    }
}
