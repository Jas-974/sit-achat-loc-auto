<?php
session_start();
require_once "fonction_loc_vs_achat.php";
require "config.php";
?>

<?php
// Extraction des véhicules pour affichages
$vehicules_achat = ExtractVehiculeAchat($pdo);
?>

<?php
// Extraction des véhicules pour affichages
$vehicules_location = ExtractVehiculeLocation($pdo);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- appel au fichier CSS-->
  <link rel="stylesheet" href="./style_admin_LocVsAchat.css">
</head>

<body>

  <header>
    <!-- Image du logo-->
    <div class="logo">
      <img src="/dev_web_locachat/src/dev/images/logo/logo.png" alt="Logo">
    </div>

    <!--affichage des boutons-->
    <div class="container_bouton_dashboard">
      <ul style="display: flex; justify-content: flex-end; list-style: none; margin: 0; gap : 10px;">

        <li>
          <a href="dashboard_admin.php" class="btn-nav">Dashboard Administration</a>
        </li>
        <li>
          <a href="index.php" class="btn-nav">Recherche de véhicule</a>
        </li>

      </ul>
    </div>

  </header>


  <!--barre de titre-->
  <div class="box_titre_location_admin">
    <h1>Gérer les véhicules</h1>
  </div>


  <!--formulaire-->
  <div class="grande_box_formulaire_ajout_location">
    <div class="box_formulaire">
      <h1>Liste de véhicule en location en base</h1>
      <!--Affichage des véhcules à l'achat-->
      <?php foreach ($vehicules_location as $vehicule_location): ?>
        <a href="gestion_vehicule.php?id=<?= $vehicule_location['id']; ?>">
          <?= htmlspecialchars($vehicule_location['id']); ?>
          <?= htmlspecialchars($vehicule_location['marque']); ?>
          <?= htmlspecialchars($vehicule_location['modele']); ?>
          <?= htmlspecialchars($vehicule_location['statut']); ?>
        </a>
        <br>
      <?php endforeach; ?>
      <br>
    </div>

    <div class="box_formulaire">
      <h1>Liste de véhicule à la vente en base</h1>
      <!--Affichage des véhcules à l'achat-->


      <?php foreach ($vehicules_achat as $vehicule_achat): ?>
        <a href="gestion_vehicule.php?id=<?= $vehicule_achat['id']; ?>">
          <?= htmlspecialchars($vehicule_achat['id']); ?>
          <?= htmlspecialchars($vehicule_achat['marque']); ?>
          <?= htmlspecialchars($vehicule_achat['modele']); ?>
          <?= htmlspecialchars($vehicule_achat['statut']); ?>
        </a>
        <br>
      <?php endforeach; ?>
      <br>
    </div>
  </div>


  <br>
  <div class="footer">
    <footer>
      <p>&copy; 2023 Tous droits réservés. Conçu par LocAchat.</p>
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