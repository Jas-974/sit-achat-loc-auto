<?php
require_once __DIR__ . "/log.php";

function recupUtilisateurDeLaCommande(PDO $pdo): array
{

    //je recupére l'Id de la page détail_véhicule
    if (!isset($_SESSION['user_id'])) {
        return [
            "success" => false,
            "message" => "connexion_necessaire"
        ];
    }

    $user_id = $_SESSION["user_id"];

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
        return [
            "success" => true,
            "user" => $donnee_user

        ];
    }

    function recupVehiculeDeLaCommande(PDO $pdo): array
    {

if(!isset($_GET["id"]))
{
return [
            "success" => false,
            "message" => "ID manquant"

        ];
}
$id = (int) $_GET["id"];


// récupere les informations caractéristique de la voiture
// reqête de recupération des informations dans la base de donnée
$sql = "SELECT id, marque, modele, annee, kilometrage, boite, carburant, type_offre, prix, statut, status_command, image, loyer_mois, apport, prix_loc_jour,forfait_par_mois, caution 
FROM vehicule 
WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);

$donnee_vehicule = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$donnee_vehicule) {
  //pour debug

  return [
            "success" => false,
            "message" => "Véhicule introuvable"

        ];

}

return [
            "success" => true,
            "vehicule" => $donnee_vehicule

        ];


}

function miseAjourStatusVehiculeReserve(PDO $pdo):  void
{

if (isset($_POST['maj_status_command'])) {
  $id = (int) $_POST['id'];
  $status_command = $_POST['maj_status_command'];

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


function generationNumCommand(): string {
//génération du numero de command
  return 'CMD' . date('Ymd') . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

  }


Function enregCommandeVehiculeLocation($pdo, $donnee_user, $donnee_vehicule, $user_id) {
if (!isset($_POST['maj_status_command'])) {
    return false;
}
$status_command = $_POST['maj_status_command'];
//génération du numero de commande
$num_command = generationNumCommand();


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

 $commande_id = $pdo->lastInsertId();

 // insertion des donnée de la validation de la commande dans la table table_statu_command
  $sql_insert_status_command = " INSERT INTO table_statu_command (numero_command, nom, prenom, 
  email, type_offre, status_command, user_id, code_status_command, commande_id)
VALUES (:numero_command, :nom, :prenom, :email, :type_offre, :status_command, :user_id, :code_status_command, :commande_id)";

  $stmt_status_command  = $pdo->prepare($sql_insert_status_command);
  $stmt_status_command->execute([
    ":numero_command" => $num_command,
    ":nom" => $donnee_user["nom"],
    ":prenom" => $donnee_user["prenom"],
    ":email" => $donnee_user["email"],
    ":type_offre" => $donnee_vehicule["type_offre"],
    ":status_command" => $status_command,
    ":user_id" => $user_id,
    ":code_status_command" => 1,
     ":commande_id" => $commande_id
  ]);

  //gestion des logs commande location créer 
   GestionLog("INFO", "Commande location créée - commande_id = $commande_id" . " - utilisateur_id = $user_id" . " - véhicule_id =" . $donnee_vehicule["id"]);



//suppression du document temporaire apres ratachement à la commande
$sql_supp = "DELETE FROM documents_upload
WHERE  user_id = :user_id
AND car_id = :car_id";

$stmt_supp = $pdo->prepare($sql_supp);
$stmt_supp->execute([
":user_id" => $user_id,
":car_id" => $donnee_vehicule["id"]
]);

 return $commande_id;
 



}


?>
