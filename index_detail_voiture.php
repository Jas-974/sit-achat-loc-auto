<?php
session_start();
require "config.php";
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <!--Responsive-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- appel au fichier CSS-->
  <link rel="stylesheet" href="styles_page_detail_voiture.css">

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
      <img src="Logo.png" alt="Logo">
    </div>

    <!-- contener  qui abrite les boutons Connexion et création de compte-->
    <div class="container_bouton_cnxn_creacompte">
      <ul style="display: flex; justify-content: flex-end; list-style: none; padding: 80px; margin: 0; gap : 10px;">
        <li>
          <!-- la barre de recherche-->
          <form method="GET" action="">
            <div class="barre-recherche">
              <input type="text" name="champ_recherche" placeholder="Rechercher un véhicule, achat, location...">
              <button type="submit">🔍</button>
            </div>
          </form>
        </li>
        <li>
          <a href="index.php" class="btn-nav">Accueil</a>
        </li>
        <li>
          <!-- si la session est ouvert on affiche "Déconnexion"-->
          <?php if (isset($_SESSION["user_id"])): ?>
          <a href="logout.php" class="btn-nav">Déconnexion</a>
          <?php else: ?>
          <a href="index.php" class="btn-nav">Connexion</a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </header>

  <div class="containertitre">Renault Clio V</div>
  <!--container globale image et le descriptif-->
  <div class="container_img_descriptif">
    <!--box de l'image-->
    <div class="box_img">
      <img src="voiture 2.png" alt="image" class="box_image_vehicule">
    </div>

    <!--grande box du descriptif du véhicule -->
    <div class="container_descriptif">
      <div class="box_descriptif" style="text-align : left" ;>
        <H1 style="color:#595959; display:inline" ;>19 000</H1>
        <img src="img_disponible.png" style="display: inline; vertical-align: middle" ;><br><br>

        <!--bouton commander-->
        <a class="btn-comm">Passer Commande</a><br><br>
        <strong>Informations du véhicule</strong><br>
        Marques : Renault<br>
        Modèle : Clio<br>
        Année : 2025<br>
        Energie : Essence <br>
        Kilometrage : 65000 Km <br>
        Boite de vitesse : Automatique<br>
      </div>
      <!--box affichage du prix-->
      <div class="box_prix" style ="line-height: 2";  >
        <strong>Acheter ce véhicule</strong><br>
        Prix du céhicule : 19 000&euro;<br>
        Frais de dossiers : 250&euro;<br>
        <strong>Total TTC 19 000&euro;</strong><br>
      </div>
      <!--Affichage des garanties-->
      <div class="box_garantie"  style ="line-height: 2";>
        <a class="btn-comm">Passer Commande</a><br><br>
        <span>&#10003;Garanti 12 mois</span><br>
        <span>&#10003;Historique vérifié</span><br>
        <span>&#10003;Kilométrage certifié</span><br><br>
        <span>&#128222;+262 46 78 25</span><br>
        Disponible lun - Ven 9h-18h
      </div>
    </div>
  </div>

  <div class="footer">
    <footer>
      <p>&copy; 2023 Tous droits réservés. Conçu par Jane Doe.</p>
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