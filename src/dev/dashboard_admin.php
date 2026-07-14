<?php
session_start();
require_once "fonction_dashboard_administrateur.php";
require "config.php";
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
        <a href="LocVsAchat.php">
          Location --> Vente
        </a>
        <br>
        <a href="LocVsAchat.php">
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
