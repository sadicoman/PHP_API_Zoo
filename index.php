<?php
session_start();

// Définition de l'URL de base de l'application. Remplace "index.php" dans l'URL par une chaîne vide pour obtenir l'URL racine.
// Utilise HTTPS si disponible, sinon HTTP.
define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "controllers/front/API.controller.php";
require_once "controllers/back/admin.controller.php";
require_once "controllers/back/familles.controller.php";
$apiController = new ApiController();
$adminController = new AdminController();
$famillesController = new FamillesController();

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
                        if (!isset($url[2]) || !isset($url[3])) {
                            $apiController->getAnimaux(-1, -1);
                        } else {
                            $apiController->getAnimaux((int)$url[2], (int)$url[3]);
                        }
                        break;
                    case "animal":
                        // Affiche les données JSON pour un animal spécifique, identifié par $url[2].
                        if (empty($url[2])) {
                            throw new Exception("L'identifiant de l'animal est manquant");
                        }
                        $apiController->getAnimal($url[2]);
                        break;
                    case "continents":
                        // Affiche les données JSON pour les continents.
                        $apiController->getContinents();
                        break;
                    case "familles":
                        // Affiche les données JSON pour les familles d'animaux.
                        $apiController->getFamilles();
                        break;
                    case "sendMessage":
                        $apiController->sendMessage();
                        break;
                    default:
                        // Si aucune route valide n'est trouvée, une exception est lancée.
                        throw new Exception("La page n'existe pas");
                }
                break;
            case "back":
                // Routeur backend : gère les demandes pour l'administration ou les processus backend.
                switch ($url[1]) {
                    case "login":
                        $adminController->getPageLogin();
                        break;
                    case "connexion":
                        $adminController->connexion();
                        break;
                    case "admin":
                        $adminController->getAccueilAdmin();
                        break;
                    case "deconnexion":
                        $adminController->deconnexion();
                        break;
                    case "familles":
                        switch ($url[2]) {
                            case "visualisation":
                                $famillesController->visualisation();
                                break;
                            case "validationsSupression":
                                $famillesController->suppression();
                                break;
                            case "validationModification":
                                $famillesController->modification();
                                break;
                            case "creation":
                                echo "creation";
                                break;
                            default:
                                throw new Exception("La page n'existe pas");
                        }
                        break;
                    default:
                        throw new Exception("La page n'existe pas");
                }
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
    echo "<a href='" . URL . "back/login'>login</a>";
}
