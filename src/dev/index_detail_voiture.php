<?php
session_start();
require "config.php";
require_once __DIR__ . "/fonction_recup_detail_vehicule.php";
?>


<?php
//appel de la fonction récuperation détail véhicule
$res_recup_detail_vehicule = RecupInformationVehicule($pdo);
 if (!$res_recup_detail_vehicule["success"]){
 echo $res_recup_detail_vehicule["message"];
 exit;
 }
$donnee_vehicule = $res_recup_detail_vehicule["donnee_vehicule"];

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <!--Responsive-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- appel au fichier CSS-->
  <link rel="stylesheet" href="styles_page_detail_voiture_news.css">

  <style>
    .btn-comm {
      display: inline-block;
      width: 250px;
      height: 55px;
      line-height: 55px;
      background-color: #FFC000;
      color: black;
      text-align: center;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      font-size: 18px;
      border: none;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .btn-comm:hover {
      background-color: #FFC000;
      transform: scale(1.05);
    }
  </style>



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
  <div class="containertitre"><?= htmlspecialchars($donnee_vehicule["marque"] . " " . $donnee_vehicule["modele"]) ?></div>
  <!--container globale image et le descriptif-->
  <div class="container_img_descriptif">
    <!--box de l'image-->
    <div class="box_img">
      <img src="<?= htmlspecialchars($donnee_vehicule["image"]); ?>" alt="image" class="box_image_vehicule">
    </div>

    <!--grande box du descriptif du véhicule -->
    <div class="container_descriptif">
      <div class="box_descriptif" style="text-align : left" ;>
<!--pour test-->

      
               <H1 style="color:#595959; display:inline" ;><?= htmlspecialchars($donnee_vehicule["prix"]) ?>&euro;</H1>
        <H2 style="color:#588888; display:inline" ;><?= htmlspecialchars($donnee_vehicule["statut"]) ?></H2>
        
     

<!--fin test-->
<?php
//vérifie si le user est conncté
if (isset($_SESSION["user_id"])) {
    //echo '<a class="btn-comm" href="page_exemple.php">Passer Commande</a><br><br>';
    echo '<a class="btn-comm" href="car_sale.php?id=' . $donnee_vehicule['id'] . '">
    Passer Commande
</a>';
} else {
    echo '<a class="btn-comm" href="index_cnxn_creacompte.php">Passer Commande</a><br><br>';
}
?>

<br><br>     
        
        <strong>Informations du véhicule</strong><br>
        Marques : <?= htmlspecialchars($donnee_vehicule["marque"]) ?><br>
        Modèle : <?= htmlspecialchars($donnee_vehicule["modele"]) ?><br>
        Année : <?= htmlspecialchars($donnee_vehicule["annee"]) ?><br>
        Energie : <?= htmlspecialchars($donnee_vehicule["carburant"]) ?><br>
        Kilometrage : <?= htmlspecialchars($donnee_vehicule["kilometrage"]) ?> Km<br>
        Boite de vitesse : <?= htmlspecialchars($donnee_vehicule["boite"]) ?><br>
      </div>
      <!--box affichage du prix-->
      <div class="box_prix" style="line-height: 2" ;>
        <strong>Acheter ce véhicule</strong><br>
        Prix du véhicule : <?= htmlspecialchars($donnee_vehicule["prix"]) ?> €<br>
        Frais de dossiers : 250 €<br>
        <strong>Total TTC : <?= htmlspecialchars($donnee_vehicule["prix"]) + 250 ?> €</strong><br>
      </div>
      <!--Affichage des garanties-->
      <div class="box_garantie" style="line-height: 2" ;>


        <?php
//vérifie si le user est conncté
if (isset($_SESSION["user_id"])) {
    //echo '<a class="btn-comm" href="page_exemple.php">Passer Commande</a><br><br>';
    echo '<a class="btn-comm" href="car_sale.php?id=' . $donnee_vehicule['id'] . '">
    Passer Commande
</a>';
} else {
    echo '<a class="btn-comm" href="index_cnxn_creacompte.php">Passer Commande</a>';
}
?>
<br><br>
        <span>&#10003;Garanti 12 mois</span><br>
        <span>&#10003;Historique vérifié</span><br>
        <span>&#10003;Kilométrage certifié</span><br><br>
        <span>&#128222;+262 46 78 24</span><br>
        Disponible lun - Ven 9h-18h
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
<!--Notes site pour HTML, CSS,...:https://www.w3schools.com/-->