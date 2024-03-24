<?php
// Définition de l'URL de base de l'application. Remplace "index.php" dans l'URL par une chaîne vide pour obtenir l'URL racine.
// Utilise HTTPS si disponible, sinon HTTP.
define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

try {
    // Vérifie si le paramètre 'page' est présent dans l'URL. S'il est absent ou vide, une exception est lancée.
    if (empty($_GET['page'])) {
        throw new Exception("La page n'existe pas");
    } else {
        // Nettoie et découpe l'URL en segments pour déterminer quelle page charger.
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));

        // Si les segments requis de l'URL sont vides, une exception est lancée.
        if (empty($url[0]) || empty($url[1])) throw new Exception("La page n'existe pas");

        // Gère les routes de l'application en fonction du premier segment de l'URL.
        switch ($url[0]) {
            case "front":
                // Routeur frontal : gère les demandes pour l'interface utilisateur.
                switch ($url[1]) {
                    case "animaux":
                        // Affiche les données JSON pour tous les animaux.
                        echo "données JSON des animaux demandées";
                        break;
                    case "animal":
                        // Affiche les données JSON pour un animal spécifique, identifié par $url[2].
                        echo "données JSON de l'animal " . $url[2] . " demandées";
                        break;
                    case "continents":
                        // Affiche les données JSON pour les continents.
                        echo "données JSON des continents demandées";
                        break;
                    case "familles":
                        // Affiche les données JSON pour les familles d'animaux.
                        echo "données JSON des familles demandées";
                        break;
                    default:
                        // Si aucune route valide n'est trouvée, une exception est lancée.
                        throw new Exception("La page n'existe pas");
                }
                break;
            case "back":
                // Routeur backend : gère les demandes pour l'administration ou les processus backend.
                echo "page back end demandée";
                break;
            default:
                // Si le premier segment de l'URL ne correspond à aucune catégorie connue, une exception est lancée.
                throw new Exception("La page n'existe pas");
        }
    }
} catch (Exception $e) {
    // Capture et affiche le message d'erreur si une exception est lancée à n'importe quel point.
    $msg = $e->getMessage();
    echo $msg;
}
