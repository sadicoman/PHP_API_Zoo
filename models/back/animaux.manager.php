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

    public function delateDBAnimalContinent($idAnimal)
    {
        $bdd = $this->getBdd();
        $req = $bdd->prepare("DELETE FROM animal_continent WHERE animal_id= :idAnimal");

        $req->bindValue(':idAnimal', $idAnimal, PDO::PARAM_INT);

        $req->execute();

        $req->closeCursor();
    }

    public function delateDBanimal($idAnimal)
    {
        $bdd = $this->getBdd();
        $req = $bdd->prepare("DELETE FROM animal WHERE animal_id= :idAnimal");

        $req->bindValue(':idAnimal', $idAnimal, PDO::PARAM_INT);

        $req->execute();

        $req->closeCursor();
    }

    public function createAnimal($libelle, $description, $image, $famille)
    {
        $bdd = $this->getBdd();
        $req = $bdd->prepare("Insert into animal (animal_nom,animal_description, animal_image, famille_id) values (:libelle, :description, :image, :famille)");

        $req->bindValue(":libelle", $libelle, PDO::PARAM_STR);
        $req->bindValue(":description", $description, PDO::PARAM_STR);
        $req->bindValue(":image", $image, PDO::PARAM_STR);
        $req->bindValue(":famille", $famille, PDO::PARAM_INT);

        $req->execute();
        $req->closeCursor();

        return $bdd->lastInsertId();
    }
}
