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

    public function getAnimal($idAnimal)
    {
        $req = "SELECT a.animal_id, animal_nom, animal_description, animal_image, a.famille_id, continent_id from animal a
            inner join famille f on a.famille_id=f.famille_id 
            left join animal_continent ac on ac.animal_id = a.animal_id
            WHERE a.animal_id = :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $lignesAnimal = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $lignesAnimal;
    }

    public function updateAnimal($idAnimal, $nom, $description, $image, $famille)
    {
        $req = "Update animal 
        set animal_nom = :nom, animal_description = :description, animal_image = :image, famille_id = :famille
        where animal_id= :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->bindValue(":famille", $famille, PDO::PARAM_INT);
        $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":image", $image, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function getImageAnimal($idAnimal)
    {
        $req = "SELECT animal_image from animal where animal_id = :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $image['animal_image'];
    }
}
