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

    public function addContinentAnimal($idAnimal, $idContinent)
    {
        $bdd = $this->getBdd();
        $req = $bdd->prepare("Insert into animal_continent (animal_id, continent_id) values (:idAnimal, :idContinent)");

        $req->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $req->bindValue(":idContinent", $idContinent, PDO::PARAM_INT);

        $req->execute();
        $req->closeCursor();
    }
}
