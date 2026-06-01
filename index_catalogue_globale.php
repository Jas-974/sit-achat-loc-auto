<?php
session_start();
require "config.php";
?>



<?php
// select des veihcule en base

$pdo = new PDO("mysql:host=sql305.infinityfree.com;dbname=if0_41302948_bd_locachat;charset=utf8", "if0_41302948", "B7jc5nTtIiq");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$vehicules = AffichagecatalogueVehicule($pdo);

function AffichagecatalogueVehicule($pdo)
{

  if (!empty($_GET['champ_recherche'])) {

    $rech = '%' . $_GET['champ_recherche'] . '%';

    $sql = "select image, modele, marque , type_offre
FROM vehicule
WHERE marque LIKE ?
OR modele LIKE ?
OR type_offre LIKE ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$rech, $rech, $rech]);
    return  $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {

    $sql = "SELECT * FROM vehicule";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>

      <?php
      //Fonction affichage de la galerie dns la vignette
      function AfficheVehiculesGalerie($vehicules)
      {
        foreach ($vehicules as $vehicule) {

          // si le type d'offre est location on ouvre la page location sinon on ouvre la page détail achat
          if ($vehicule['type_offre'] == 'location') {

            $detail_v = "index_detail_voiture_location.php?id=" . $vehicule['id'];
          } else {
            $detail_v = "index_detail_voiture.php?id=" . $vehicule['id'];
          }
      ?>


          <div class="card">
            <a href="<?= $detail_v ?>" class="card-link">

              <img src="<?= htmlspecialchars($vehicule['image']) ?>" alt="">
            </a>
            <p><?= htmlspecialchars($vehicule['marque']) ?></p>
            <p><?= htmlspecialchars($vehicule['modele']) ?></p>
            <p><?= htmlspecialchars($vehicule['type_offre']) ?></p>
          </div>

      <?php
        }
      }
      ?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <!-- appel au fichier CSS-->
  <link rel="stylesheet" href="styles_page_catalogue_globale_news.css">
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
        <!-- si la session est ouvert on affiche "Déconnexion"-->
        <?php if (isset($_SESSION["user_id"])): ?>

          <a href="logout.php" class="btn-nav">Déconnexion</a>

        <?php else: ?>

          <a href="index_cnxn_creacompte.php" class="btn-nav">Connexion</a>

        <?php endif; ?>

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

<!--Apple a la fonction d'affichage du catalogue dans des vignettes-->
<?php AfficheVehiculesGalerie($vehicules) ?>

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