
<?php

function recupdonneeUtilisateurCommandeAchat(PDO $pdo): array
{

    if (!isset($_SESSION["user_id"])) {
        return [
            "success" => false,
            "message" => "connexion_necessaire"
        ];
    }


    // Je recupère les données de l'utilisateur
    $user_id = $_SESSION["user_id"];
    // récupere les informations du user
    // reqête de recupération des informations dans la base de donnée
    $sql = "SELECT id, nom, prenom, email 
FROM users 
WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $user_id]);
    $donnee_user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$donnee_user) {
        return [
            "success" => false,
            "message" => "utilisateur introuvable"
        ];
    }

    return  [
        "success" => true,
        "user" => $donnee_user
    ];
}

?>

<?php

// récupere les informations caractéristique de la voiture
// reqête de recupération des informations dans la base de donnée

function recupVehiculeCommandeAchat(PDO $pdo): array
{

    //je recupére l'Id détail_véhicule
    if (!isset($_GET['id'])) {
        return  [
            "success" => false,
            "message" => "ID manquant"
        ];
    }
    $id = (int) $_GET['id'];


//recup info vehicule dans la base de donnee
    $sql = "SELECT id, marque, modele, annee, kilometrage, boite, carburant, type_offre, prix, statut, status_command, image, loyer_mois, apport 
FROM vehicule 
WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $id]);

    $donnee_vehicule = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$donnee_vehicule) {

     return  [
            "success" => false,
            "message" => "Véhicule introuvable"
        ];
    }
  return  [
            "success" => true,
            "vehicule" => $donnee_vehicule
        ];  
}
?>

<?php
function majStatusVehiculeReserveAchat(PDO $pdo): void
{

//mise a jours de la table status commande avec la reservation en cours si clique sur "valider la prise en charge"
if (isset($_POST['maj_status_command'])) {
  $id = (int) $_POST['id'];
  $status_command = $_POST['maj_status_command'];

  //mise a jours en status reserve
  $sql = "UPDATE vehicule 
            SET status_command = :status_command,
            statut = :statut
            WHERE id = :id";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':status_command' => $status_command,
    ':statut' => 'reserve',
    ':id' => $id
  ]);
}
}
?>

<?php
//fonction enregistrement en base de la commande
 function enregCommandVehiculeAchat(PDO $pdo, array $donnee_user, array $donnee_vehicule, int $user_id)
 {
if(!isset($_POST['maj_status_command']))
    {
return false;
    }

 $status_command = $_POST['maj_status_command'];

  //extration du document uploadé avant création de la commande
$sql_document = "SELECT documents 
FROM documents_upload 
WHERE user_id = :user_id
AND car_id = :car_id
ORDER BY id DESC
LIMIT 1";

$stmt_doc = $pdo->prepare($sql_document);
$stmt_doc->execute([ ":user_id" => $user_id,
":car_id" => $donnee_vehicule["id"]]);

//recup chemin des documents uploadé
$documents_upload = $stmt_doc->fetchColumn();

  // insertion dans la table table_commandes
  $sql_insert_table_command = " INSERT INTO table_commandes (user_id, car_id, order_type, documents, adate)
VALUES (:user_id, :car_id, :order_type, :documents, CURRENT_TIMESTAMP)";

  $stmt_table_command  = $pdo->prepare($sql_insert_table_command);
  $stmt_table_command->execute([
    ":car_id" => $donnee_vehicule["id"],
    ":order_type" => $donnee_vehicule["type_offre"],
    ":user_id" => $user_id,
    ":documents" => $documents_upload ?: null
  ]);

  $id_commande = $pdo->lastInsertId();

   // insertion des donnée de la validation de la commande dans la table table_statu_command
  $sql_insert_status_command = " INSERT INTO table_statu_command (commande_id, user_id, nom, prenom, email, type_offre, status_command )
VALUES (:commande_id, :user_id, :nom, :prenom, :email, :type_offre, :status_command)";

  $stmt_status_command  = $pdo->prepare($sql_insert_status_command);
  $stmt_status_command->execute([
    ":commande_id" => $id_commande,
    ":user_id" => $user_id,
    ":nom" => $donnee_user["nom"],
    ":prenom" => $donnee_user["prenom"],
    ":email" => $donnee_user["email"],
    ":type_offre" => $donnee_vehicule["type_offre"],
    ":status_command" => $_POST["maj_status_command"]
  ]);

  
//suppression du document temporaire apres rattachement à la commande
$sql_supp = "DELETE FROM documents_upload
WHERE  user_id = :user_id
AND car_id = :car_id";

$stmt_supp = $pdo->prepare($sql_supp);
$stmt_supp->execute([
":user_id" => $user_id,
":car_id" => $donnee_vehicule["id"]
]);

return $id_commande;

 }
  ?>