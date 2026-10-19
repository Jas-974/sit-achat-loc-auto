<?php
function annulerCommande(
    PDO $pdo,
    int $user_id,
    string $numero_command): bool
    {

$pdo->beginTransaction();
try{

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

if(!$commande_id){
    throw new Exception("Commande introuvable");

}


if($commande_id){

$sql= "UPDATE table_statu_command SET code_status_command = 4,
 status_command = 'Commande annulée'
WHERE numero_command =  :numero_command
AND user_id = :user_id
AND code_status_command = 2";


$stmt = $pdo->prepare($sql);
    $stmt->execute([':numero_command' => $numero_command,
    ':user_id' => $user_id]);


    if ($stmt->rowCount() !== 1) {
       throw new Exception("Annulation Impossible");
           }

    //recup véhicule en lien
    $sql_vehicule = "SELECT car_id
    FROM table_commandes
    WHERE id = :commande_id";

    $stmt_vehicule = $pdo->prepare($sql_vehicule);
    $stmt_vehicule->execute([
        ':commande_id' => $commande_id
    ]);

$car_id = $stmt_vehicule->fetchColumn();

if(!$car_id) {

throw new Exception("Véhicule introuvable");
}

//rendre au statu initial du vehicule
if($car_id){

$sql_lib_vehicule =" UPDATE vehicule
SET statut ='disponible',
status_command = NULL
WHERE id = :car_id
AND statut = 'reserve'";

$stmt_lib = $pdo->prepare($sql_lib_vehicule);
    $stmt_lib->execute([
        ':car_id' => $car_id
    ]);

    if($stmt_lib->rowCount() !== 1) {
        throw new Exception("Impossible de liberer le véhicule");
    }


}
}

$pdo->commit();
return true;
 }
 catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log($e->getMessage());
     return false;
}


}