<?php
session_start();
require "config.php";



// vérification que l'utilisateur est connecté
if (isset($_SESSION['user_id']) && isset($_GET['numero_command'])) {

$user_id = (int) $_SESSION["user_id"];
$numero_command = $_GET['numero_command'];

//récup commande_id

$req_commande = "SELECT commande_id
FROM table_statu_command
WHERE numero_command = :numero_command
AND user_id = :user_id";

$stmt_commande = $pdo->prepare($req_commande);
    $stmt_commande->execute([
        ':numero_command' => $numero_command,
        ':user_id' => $user_id
    ]);

$commande_id = $stmt_commande->fetchColumn();

if($commande_id){

$sql= "UPDATE table_statu_command SET code_status_command = 4,
 status_command = 'Commande annulée'
WHERE numero_command =  :numero_command
AND user_id = :user_id";


$stmt = $pdo->prepare($sql);
    $stmt->execute([':numero_command' => $numero_command,
    ':user_id' => $user_id]);


    //recup véhicule en lien
    $sql_vehicule = "SELECT car_id
    FROM table_commandes
    WHERE id = :commande_id";

    $stmt_vehicule = $pdo->prepare($sql_vehicule);
    $stmt_vehicule->execute([
        ':commande_id' => $commande_id
    ]);

$car_id = $stmt_vehicule->fetchColumn();

//rendre au statu initial du vehicule
if($car_id){

$sql_lib_vehicule =" UPDATE vehicule
SET statut ='disponible',
status_command = NULL
WHERE id = :car_id";

$stmt_lib = $pdo->prepare($sql_lib_vehicule);
    $stmt_lib->execute([
        ':car_id' => $car_id
    ]);


}
}

 header("Location: espace_client_news.php");
 exit;
}