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
WHERE id = '$id'";

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
WHERE id = '$id'";

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

      echo '<td>' . $ligne_affich_command['documents'] . '</td>';
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
?>
