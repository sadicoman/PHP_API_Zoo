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

    public function delateDBfamille($idFamille)
    {
        $bdd = $this->getBdd();
        $req = $bdd->prepare("DELETE FROM famille WHERE famille_id= :idFamille");

        $req->bindValue(':idFamille', $idFamille, PDO::PARAM_INT);

        $req->execute();

        $req->closeCursor();
    }

    public function compterAnimaux($idFamille)
    {
        $bdd = $this->getBdd();
        $req = $bdd->prepare("SELECT count(*) as 'nb' FROM famille f inner join animal a on a.famille_id = f.famille_id WHERE f.famille_id = :idFamille");

        $req->bindValue(':idFamille', $idFamille, PDO::PARAM_INT);

        // Exécuter la requête
        $req->execute();

        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        return $resultat['nb'];
    }

    public function updateFamille($idFamille, $libelle, $description)
    {
        $bdd = $this->getBdd();
        $req = $bdd->prepare("Update famille set famille_libelle = :libelle, famille_description = :description where famille_id= :idFamille");

        $req->bindValue(":idFamille", $idFamille, PDO::PARAM_INT);
        $req->bindValue(":libelle", $libelle, PDO::PARAM_STR);
        $req->bindValue(":description", $description, PDO::PARAM_STR);

        $req->execute();
    }
}
