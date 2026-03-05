<?php
session_start();
require "config.php";



// récupère le bouton cliqué

if (isset($_GET["filtre"])) {
    $filtre = $_GET["filtre"];
} else {
    $filtre = "tous";
}

if ($filtre == "achat") {
    $sql = "SELECT * FROM image_galerie WHERE locachat = 'A l\'achat'";
} 
elseif ($filtre == "location") {
    $sql = "SELECT * FROM image_galerie WHERE locachat = 'location'";
} 
else {
    $sql = "SELECT * FROM image_galerie";
}

$stmt = $pdo->query($sql);
$vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <!-- appel au fichier CSS-->
  <link rel="stylesheet" href="styles_page_catalogue_globale.css">
</head>

<header>
  <!-- Image du logo-->

  <div class="logo">
    <img src="logo.png" alt="Logo">
  </div>


  <!-- contener  qui abrite les boutons Connexion et création de compte-->
  <div class="container_bouton_accueilcnxn">
    <ul style="display: flex; justify-content: flex-end; list-style: none; padding: 80px; margin: 0; gap : 10px;">

      <li>
        <a href="index.php"
          class="btn-nav">Accueil</a>
      </li>
      </li>
      <li>
        <a href="index_cnxn_creacompte.php"
          class="btn-nav">Connexion</a>
      </li>
      </li>
    </ul>
  </div>

</header>


<body>

  <div class="box_titre_catalogue_vehicule">
    <p>
    <h1>Le catalogue de véhicule</h1>
    </p>
  </div>
  <div class="box_body">
    <div class="gallery">
      <!-- Affiche la gallerie-->
      <?php foreach ($vehicules as $vehicule): ?>
        <div class="card">
          <img src="<?= htmlspecialchars($vehicule['fichier']) ?>" alt="">
          <p><?= htmlspecialchars($vehicule['titre']) ?></p>
          <p><?= htmlspecialchars($vehicule['description']) ?></p>
          <p><?= htmlspecialchars($vehicule['locachat']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <br>
  <div class="footer">
    <footer>
      <p>&copy; 2026 Tous droits réservés. LocAchat</p>
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