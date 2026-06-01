<?php
session_start();
require "config.php";
?>

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
ON table_commandes.id = table_statu_command.id";


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

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <!--Responsive-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- appel au fichier CSS-->
  <link rel="stylesheet" href="styles_dashboard_admin.css">
</head>


<body>
  <header>
    <!-- Image du logo-->
    <div class="logo">
      <img src="logo.png" alt="Logo">
    </div>

    <!-- contener  qui abrite les boutons Connexion et création de compte-->
    <div class="container_bouton">
      <ul style="display: flex; justify-content: flex-end; list-style: none; padding: 80px; margin: 0; gap : 10px;">
        <li>
          <a href="index.php" class="btn-nav">Accueil</a>
        </li>
        <li>
          <!-- si la session est ouvert on affiche "Déconnexion"-->
          <?php if (isset($_SESSION["user_id"])): ?>
            <a href="logout.php" class="btn-nav">Déconnexion</a>
          <?php else: ?>
            <a href="index_cnxn_creacompte.php" class="btn-nav">Connexion</a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </header>

  <div class="containertitre"><strong> LocAchat Admin </strong></div>
  <!--container globale image et le descriptif-->

  <!--grand container infos et gestion du parc -->
  <div class="container_management">
    <!--box info -->
    <div class="box_info" ;>
      <div class="box_info_1" ;>
        <strong> Commande en cours</strong><br><br>
        <a>12 commandes a valider</a><br>
        <a>1 commandes rejeté</a><br>
        <a>2 commandes valider</a><br>
      </div>
      <div class="box_info_1" ;>
        <strong> Dashboard</strong><br><br>
        <a>Nombre d'utilisateur connecté : XXXXX</a><br>
        <a>Nombre d'utilisateur inscrit : XXXXXX</a>
      </div>
      <div class="box_info_1" ;>
        <strong> Accés au Log</strong><br><br>
      </div>

    </div>
    <a><strong>
        <h3>Commandes en Attente de Validation</h3>
      </strong></a>
    <div class="box_info_command_in_progress" ;>
      <!--la table d'affichage des commandes en cours-->
      <?php
      MiseaJourCommandRejeter($pdo);
      ?>
      <?php

      // echo '<p>';
      //var_dump($pdo);
      //echo '</p>';
      //appel de la fonction validation de la commande "bouton valider"
      MiseaJourCommandValider($pdo);
      ?>
      <!--appel à la fonction extraction des données des commande en cours -->
      <?php $app_command = selectInfoCommandForDashboard($pdo); ?>
      <?php
      //echo '<p>';
      //var_dump($app_command);
      //echo '</p>';
      ?>

      <?php
      //appel de la fonction affichage tableau commande en cours
      affichTableauComValidRejet($app_command);
      ?>

      

     
    </div>
    <div class="box_véhicule_management" ;>
      <div class="box_info_1" ;>
        <strong> Gestion des véhicule de location</strong><br><br>
        <a href="admin_ajout_location.php">
          Ajouter un véhicule à la location
        </a>
        <br>
        <a href="admin_ajout_location.php">
          Suppression d'un véhicule à la location
        </a>
      </div>
      <div class="box_info_1" ;>
        <strong>Ajout de véhicule à la vente</strong><br><br>
        <a href="test.php">
          Ajouter un véhicule à la vente
        </a>
        <br>
        <a href="test.php">
          Suppression d'un véhicule à la vente
        </a>
      </div>
      <div class="box_info_1" ;>
        <strong>Vente Vs Location</strong><br><br>
        <a href="admin_ajout_location.php">
          Location --> Vente
        </a>
        <br>
        <a href="admin_ajout_location.php">
          Vente --> Location
        </a>
      </div>
    </div>
  </div>




  <div class="footer">
    <footer>
      <p>&copy; 2026 Tous droits réservés. Conçu par LocAchat.</p>
      <nav>

        <a href="#">Accueil</a>
        <a href="#">À propos</a>
        <a href="#">Contact</a>
        <a href="#">Mentions légales</a>
      </nav>
    </footer>
  </div>
</body>

</html>
<!--Notes dev pour HTML, CSS,...:https://www.w3schools.com/-->