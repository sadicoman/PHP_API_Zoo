<?php

require_once "models/Model.php";

class APIManager extends Model
{
    public function getDBAnimaux()
    {
        $bdd = $this->getBdd();
        $req = $bdd->prepare('SELECT * FROM animal a inner join famille f on f.famille_id = a.famille_id inner join animal_continent ac on ac.animal_id = a.animal_id inner join continent c on c.continent_id = ac.continent_id');

        // Exécuter la requête
        $req->execute();

        // Récupère toutes les lignes sous forme de tableau associatif
        $animaux = $req->fetchAll(PDO::FETCH_ASSOC);

        return $animaux;
    }

    public function getDBAnimal($idAnimal)
    {
        $bdd = $this->getBdd();
        // Préparer la requête SQL avec le paramètre :idAnimal
        $req = $bdd->prepare('SELECT * FROM animal a inner join famille f on f.famille_id = a.famille_id inner join animal_continent ac on ac.animal_id = a.animal_id inner join continent c on c.continent_id = ac.continent_id WHERE a.animal_id = :idAnimal');

        // Lier la valeur de $idAnimal au paramètre :idAnimal
        // PDO::PARAM_INT est utilisé ici pour indiquer que le paramètre est un entier
        $req->bindValue(':idAnimal', $idAnimal, PDO::PARAM_INT);

        // Exécuter la requête
        $req->execute();

        // Récupérer toutes les lignes sous forme de tableau associatif
        $lignesAnimal = $req->fetchAll(PDO::FETCH_ASSOC);

        return $lignesAnimal;
    }

    public function getDBFamilles()
    {
        $bdd = $this->getBdd();
        $req = $bdd->prepare('SELECT * FROM famille');

        // Exécuter la requête
        $req->execute();

        // Récupère toutes les lignes sous forme de tableau associatif
        $famille = $req->fetchAll(PDO::FETCH_ASSOC);

        return $famille;
    }

    public function getDBContinents()
    {
        $bdd = $this->getBdd();
        $req = $bdd->prepare('SELECT * FROM continent');

        // Exécuter la requête
        $req->execute();

        // Récupère toutes les lignes sous forme de tableau associatif
        $continent = $req->fetchAll(PDO::FETCH_ASSOC);

        return $continent;
    }
}
