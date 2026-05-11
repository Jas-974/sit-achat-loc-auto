<?php
session_start();
require "config.php";


<<<<<<< HEAD
<<<<<<< HEAD
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pdo = new PDO('mysql:host=localhost;dbname=bd_locachat', 'root', '');

if (!empty($_GET['champ_recherche'])) {

    $search = '%' . $_GET['champ_recherche'] . '%';

    $sql = "SELECT * FROM vehicule 
            WHERE marque LIKE ? 
            OR modele LIKE ? 
            OR type_offre LIKE ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$search, $search, $search]);

    $vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);
// affichage par defaut
} else {
    $sql = "SELECT * FROM vehicule";
    $stmt = $pdo->query($sql);
    $vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
=======
=======
>>>>>>> feature/page_cnxn_crea_compte

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

<<<<<<< HEAD
>>>>>>> feature/page_catalogue_globale
=======
>>>>>>> feature/page_cnxn_crea_compte
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <!-- appel au fichier CSS-->
<<<<<<< HEAD
<<<<<<< HEAD
  <link rel="stylesheet" href="styles_page_catalogue_globale_news.css">
=======
  <link rel="stylesheet" href="styles_page_catalogue_globale.css">
>>>>>>> feature/page_catalogue_globale
=======
  <link rel="stylesheet" href="styles_page_catalogue_globale.css">
>>>>>>> feature/page_cnxn_crea_compte
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
<<<<<<< HEAD
<<<<<<< HEAD
         <!-- si la session est ouvert on affiche "Déconnexion"-->
        <?php if (isset($_SESSION["user_id"])): ?>

          <a href="logout.php" class="btn-nav">Déconnexion</a>

        <?php else: ?>

          <a href="index_cnxn_creacompte.php" class="btn-nav">Connexion</a>

        <?php endif; ?>
       
=======
        <a href="index_cnxn_creacompte.php"
          class="btn-nav">Connexion</a>
>>>>>>> feature/page_catalogue_globale
=======
        <a href="index_cnxn_creacompte.php"
          class="btn-nav">Connexion</a>
>>>>>>> feature/page_cnxn_crea_compte
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
<<<<<<< HEAD
<<<<<<< HEAD
        
         <?php
          // si le type d'offre est location on ouvre la page location sinon on ouvre la page détail achat
          if ($vehicule['type_offre'] == 'location') {

            $detail_v = "index_detail_voiture_location.php?id=" . $vehicule['id'];
          } else {
            $detail_v = "index_detail_voiture.php?id=" . $vehicule['id'];
          }
          ?>


        <div class="card">
          <a href="<?=  $detail_v ?>" class="card-link">
              
          <img src="<?= htmlspecialchars($vehicule['image']) ?>" alt="">
          </a>
          <p><?= htmlspecialchars($vehicule['marque']) ?></p>
          <p><?= htmlspecialchars($vehicule['modele']) ?></p>
          <p><?= htmlspecialchars($vehicule['type_offre']) ?></p>
        </div>
    
=======
=======
>>>>>>> feature/page_cnxn_crea_compte
        <div class="card">
          <img src="<?= htmlspecialchars($vehicule['fichier']) ?>" alt="">
          <p><?= htmlspecialchars($vehicule['titre']) ?></p>
          <p><?= htmlspecialchars($vehicule['description']) ?></p>
          <p><?= htmlspecialchars($vehicule['locachat']) ?></p>
        </div>
<<<<<<< HEAD
>>>>>>> feature/page_catalogue_globale
=======
>>>>>>> feature/page_cnxn_crea_compte
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