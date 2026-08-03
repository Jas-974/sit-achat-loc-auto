<?php
//focntion validation de la commande
function MiseaJourCommandValider($pdo)
{
  if (isset($_GET['id']) && isset($_GET['valider'])) {
    $id = $_GET['id'];
    $act_valider = $_GET['valider'];

    if ($act_valider == "valider") {
      $maj_table = "UPDATE table_statu_command
SET status_command = 'Commande Validée , merci de proceder au paiement',
code_status_command = '2'
WHERE commande_id = '$id'";

      $stmt = $pdo->prepare($maj_table);
      $stmt->execute();
    }
  }
}
?>

<?php
//fonction rejet de la commande
function MiseaJourCommandRejeter($pdo)
{
  if (isset($_GET['id']) && isset($_GET['rejeter'])) {


    $id = $_GET['id'];
    $act_rejeter = $_GET['rejeter'];

    if ($act_rejeter == "rejeter") {
      $maj_table = "UPDATE table_statu_command
SET status_command = 'Commande Rejeter merci de vous rapprocher du Service Client au +262 46 78 24',
code_status_command = '3'
WHERE commande_id = '$id'";

      $stmt = $pdo->prepare($maj_table);
      $stmt->execute();
    }
  }
}
?>

<?php
//fonction select  infos commandes 
function selectInfoCommandForDashboard($pdo)
{
  $sql = "SELECT 

table_commandes.id,
users.nom,
users.prenom,
table_statu_command.numero_command,
table_statu_command.status_command,
table_commandes.order_type,
table_commandes.documents,
table_commandes.adate

FROM table_commandes
INNER JOIN users
ON table_commandes.user_id = users.id

INNER JOIN table_statu_command
ON table_commandes.id = table_statu_command.commande_id";


  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $donnee_command = $stmt->fetchALL(PDO::FETCH_ASSOC);

  return $donnee_command ?: [];

}
?>

<?php
//fonction affichage des commande en cours
function affichTableauComValidRejet($app_command)
{
  if (!empty($app_command)) {
    echo '<table border="1" style="width:100%; border-collapse:collapse;">';

    echo '<tr>
  <th>id</th>
    <th>Nom</th>
      <th>Prenom</th>
        <th>Numéro de Commande</th>
          <th>Type de commande</th>
          <th>Status de la réservation</th>
            <th>Documents</th>
              <th>Date</th>
              <th>Validation</th>';

    //afficher tableau des commande a valider
    foreach ($app_command as $ligne_affich_command) {
      echo '<tr>';
      echo '<td>' . $ligne_affich_command['id'] . '</td>';
      echo '<td>' . $ligne_affich_command['nom'] . '</td>';
      echo '<td>' . $ligne_affich_command['prenom'] . '</td>';
      echo '<td>' . $ligne_affich_command['numero_command'] . '</td>';
      echo '<td>' . $ligne_affich_command['order_type'] . '</td>';
      echo '<td>' . $ligne_affich_command['status_command'] . '</td>';

     

if (!empty($ligne_affich_command['documents']))
  {
    echo '<td>
    <a href="' . htmlspecialchars($ligne_affich_command['documents']) . '"
    target="_blank">Voir le document</a></td>';
    
  } else {
     echo '<td>Aucun document</td>';

  }

      echo '<td>' . $ligne_affich_command['adate'] . '</td>';
      //afficher les boutons de validation/rejet de dossier
      echo '<td>
  <a href="?id=' . $ligne_affich_command['id'] . '&valider=valider">Valider</a>
  <a href="?id=' . $ligne_affich_command['id'] . '&rejeter=rejeter">Rejeter</a>
  </td>';

      echo '</tr>';
    }

    echo '</table>';
  } else {
    echo '<p> pas de commande en attente de validation. </p>';
  }
}

//stat des données du dashboard

function NbreCommande (PDO $pdo, int $code_status_command): int
{

$sql ="SELECT COUNT(*)
FROM table_statu_command
WHERE code_status_command = :code_status_command";

 $stmt = $pdo->prepare($sql);
  $stmt->execute(["code_status_command" => $code_status_command]);

  return (int) $stmt->fetchColumn();

}
//fonction calcule commande total
function NbreTotalCommande(PDO $pdo): int
{

$sql ="SELECT COUNT(*)
FROM table_commandes";

 $stmt = $pdo->prepare($sql);
  $stmt->execute();

  return (int) $stmt->fetchColumn();

}

//Fonction commande Location en cours
function NbreCommandeLocation (PDO $pdo, string $tlcommande): int
{

$sql ="SELECT COUNT(*)
FROM table_commandes
WHERE order_type = :tlcommande";

 $stmt = $pdo->prepare($sql);
  $stmt->execute(["tlcommande" => $tlcommande]);

  return (int) $stmt->fetchColumn();

}
//Fonction commande Achat en cours
function NbreCommandeAchat (PDO $pdo, string $tAcommande): int
{

$sql ="SELECT COUNT(*)
FROM table_commandes
WHERE order_type = :tAcommande";

 $stmt = $pdo->prepare($sql);
  $stmt->execute(["tAcommande" => $tAcommande]);

  return (int) $stmt->fetchColumn();

}

//fonction calcule commande total
function NbreUtilisateurInscrit(PDO $pdo): int
{

$sql ="SELECT COUNT(*)
FROM users";

 $stmt = $pdo->prepare($sql);
  $stmt->execute();

  return (int) $stmt->fetchColumn();

}

//Fonction Vehicule disponible
function NbreVehiculeDisponible (PDO $pdo, string $VehiculeDispo): int
{

$sql ="SELECT COUNT(*)
FROM vehicule
WHERE statut = :VehiculeDispo";

 $stmt = $pdo->prepare($sql);
  $stmt->execute(["VehiculeDispo" => $VehiculeDispo]);

  return (int) $stmt->fetchColumn();

}


//Fonction Vehicule réservé
function NbreVehiculeReserve (PDO $pdo, string $VehiculeRes): int
{

$sql ="SELECT COUNT(*)
FROM vehicule
WHERE statut = :VehiculeRes";

 $stmt = $pdo->prepare($sql);
  $stmt->execute(["VehiculeRes" => $VehiculeRes]);

  return (int) $stmt->fetchColumn();

}

//fonction calcule total vehicule
function NbreTotalVehicule(PDO $pdo): int
{

$sql ="SELECT COUNT(*)
FROM vehicule";

 $stmt = $pdo->prepare($sql);
  $stmt->execute();

  return (int) $stmt->fetchColumn();

}

// fonction pour vérifier le status des log

function VerifNombreLog(string $emplacementFichierLog, string $typeLog): int
{
// vérif si fichier log existe
if(!file_exists($emplacementFichierLog))
  {
    return 0;
  }

  $ligneFichierLog = file($emplacementFichierLog);
//Initilaisation compteur
  $compteur = 0;
//lecture du fichier
foreach ($ligneFichierLog as $ligneFichierLogs)
  {
if (str_contains($ligneFichierLogs, $typeLog))
  {

$compteur++;
  }
  }
return $compteur;

}
?>
