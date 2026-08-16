
<?php
function RecupInformationUtilisateurConnecte($pdo)
{

    // récupere les informations de l'utilisateur connecté
    if (!isset($_SESSION["user_id"])) {

        return ["success" => false, "message" => "Connexion nécessaire."];
    }
    // reqête de recupération des informations dans la base de donnée
    $sql = "SELECT numero_client, pseudo, email FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $_SESSION["user_id"]]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return ["success" => false, "message" => "Utilisateur introuvable."];
    }
    return [

        "success" => true,
        "user" => $user
    ];
}
//Fonction affichage de 6 vignette de vehicule
function RecherchePourAfficheVehiculesEspaceClient($pdo): array
{
    // le champs recherche
    if (isset($_GET["champ_recherche"])) {
        $recherche = $_GET["champ_recherche"];
    } else {
        $recherche = "";
    }
    // on créé un tableau vide pour stocker le résultat des recherches
    $vehicules = [];

    $sql = "SELECT * FROM vehicule";
    $params = [];

    if (!empty($recherche)) {
        $sql .= " WHERE (titre LIKE :recherche 
              OR locachat LIKE :recherche)";
        $params['recherche'] = '%' . $recherche . '%';
    } else {
        $sql = "SELECT * FROM vehicule LIMIT 6";
    }
    // pour test 
    //echo $sql;
    //exit;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $vehicules;
}
//fonction d'affichage de la rubrique commande de l'espace client
function AffichageDeLaRubriqueCommand($pdo, $email): array
{
    // Requête pour récupérer les information dans la table table_status_command et afficher dans la rubrique "mes commandes"
    $sqlTcommand = "SELECT nom, prenom, type_offre, status_command, email, `date`, numero_command, code_status_command FROM table_statu_command WHERE email = :email";
    $stmtTcommand = $pdo->prepare($sqlTcommand);
    $stmtTcommand->execute([":email" => $email]);

    return $stmtTcommand->fetchAll(PDO::FETCH_ASSOC);
}
//fonction enregistrement de document
function enregDocument(PDO $pdo)
{
  
    // recupère le fichier téléverser et l'enregistre sur le serveur
    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) 
        {

        $tmp = $_FILES['document']['tmp_name'];
        $nom = $_FILES['document']['name'];
        $chemin = "uploads/" . $nom;

        //met le fichier dans le dossier Upload
        if (move_uploaded_file($tmp, $chemin)) {

            $sql = "INSERT INTO documents_locachat (nom, chemin) VALUES (:nom, :chemin)";


            $stmt = $pdo->prepare($sql);

   if ($stmt->execute([
    ":nom" => $nom,
    ":chemin" => $chemin
   ])) {
             return "Fichier envoyé avec succès";
            } else {
                return "Erreur SQL";
            }
        } else {
            return "Erreur lors du téléversement du fichier.";
        }
    }
    return "Aucun fichier selectionné.";
}


// fonction affichage document utilisateur dans l'espace client
function AffichDocUtilisateurEspaceClient(PDO $pdo, int $user_id): array
{
$sql = "SELECT documents, adate
FROM table_commandes
WHERE user_id = :user_id
AND documents IS NOT NULL
AND documents != ''
ORDER BY adate DESC";

$stmtAff = $pdo->prepare($sql);
$stmtAff->execute([":user_id" => $user_id]);

return $stmtAff->fetchAll(PDO::FETCH_ASSOC);
}


?>