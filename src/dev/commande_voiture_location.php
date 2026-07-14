<?php
session_start();

require "config.php";
require_once __DIR__ . '/fonction_commande_voiture_location.php';
require __DIR__ . "/config.php";

?>


<?php
$recupUser = recupUtilisateurDeLaCommande($pdo);

if (!$recupUser["success"]) {
  header("Location: cnxn.php?message=connexion_necessaire");
  exit;
}

$donnee_user = $recupUser["user"];
$user_id = $donnee_user["id"];



$recVehicule = recupVehiculeDeLaCommande($pdo);

if (!$recVehicule["success"]) {
  echo $recVehicule["message"];
  exit;
}

$donnee_vehicule = $recVehicule["vehicule"];
?>

<?php

if(isset($_POST["maj_status_command"])){


//appel de la fonction de mise a jours du status reservé dans la table vehicule
miseAjourStatusVehiculeReserve($pdo);

  //appel de la fonction génération du numero de command
  $num_command = generationNumCommand();

  $Enreg_command_OK = enregCommandeVehiculeLocation($pdo, $donnee_user, $donnee_vehicule, $user_id);

  if($Enreg_command_OK) {

  //retour vers la page commande
  header("Location: commande_voiture_location.php?id=" . $donnee_vehicule["id"]);
  exit;
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
  <link rel="stylesheet" href="styles_page_commande_voiture.css">

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
  <!--Afficher le type d'offre-->
  <div class="containertitre">
    <strong>Constituer votre dossier <?= htmlspecialchars($donnee_vehicule["type_offre"]) ?><br></strong>
  </div>
  <!--container globale image et le descriptif-->
  <div class="container_img_descriptif">
    <!--box de l'image-->
    <div class="box_img">
      <img src="<?= htmlspecialchars($donnee_vehicule["image"]); ?>" alt="image" class="box_image_vehicule">
    </div>

    <!--grande box du descriptif du véhicule -->
    <div class="container_descriptif">
      <div class="box_televersement_document" style="text-align : left; line-height: 2" ;>

        <strong>
          <h1><?= htmlspecialchars($donnee_vehicule["marque"]) ?> <?= htmlspecialchars($donnee_vehicule["modele"]) ?></h1>
        </strong><br>
        <strong>Televerser vos documents:</strong><br>
        &#10003;Votre Carte nationale d'identité<span style="color:#FFC000;">*</span><br>
        &#10003;Votre permis de conduire<span style="color:#FFC000;">*</span><br>
        &#10003;Un Relevé d'Identité Bancaire<span style="color:#FFC000;">*</span><br>
        &#10003;Un justificatif d'adresse de mois de 3 mois<span style="color:#FFC000;">*</span><br>

        <!--televerser les fcihier-->
        <form action="enreg_document.php" method="post" enctype="multipart/form-data"
          style="display: flex; flex-direction: column; gap: 15px;">
          <input type="hidden" name="id" value="<?= $donnee_vehicule['id'] ?>">
          <input type="hidden" name="page_retour" value="commande_voiture_location.php">
          <label for="files">Choisissez des fichiers à téléverser :</label>
          <input type="file" id="files" name="files[]" multiple required>
          <button type="submit">Téléverser</button><br>
        </form><br>

        <strong><span style="color:#FFC000;">* </span>Les documents sont obligatoires
          pour que votre dossier soit constitué et validé</strong>


        <!-- bouton de prise en charge de dossier-->
        <form method="POST" action="?id=<?= $donnee_vehicule['id'] ?>">
          <input type="hidden" name="id" value="<?= $donnee_vehicule['id'] ?>">
          <!--boite de dialogue pour confirmer la prise en charge du dossier-->
          <button class="btn-comm" type="submit" name="maj_status_command" value="Réservation en cours" onclick="return confirm('Confirmer la prise en charge du dossier ?')">Valider la prise en charge

          </button>
        </form>

      </div>
      <!--box affichage du prix-->
      <div class="box_desc" style="line-height: 1" ;>
        <!--affichage dynamiques des données du véhicule-->
        <strong>Informations du véhicule</strong><br>
        Marques : <?= htmlspecialchars($donnee_vehicule["marque"]) ?><br>
        Modèle : <?= htmlspecialchars($donnee_vehicule["modele"]) ?><br>
        Année : <?= htmlspecialchars($donnee_vehicule["annee"]) ?><br>
        Energie : <?= htmlspecialchars($donnee_vehicule["carburant"]) ?><br>
        Kilometrage : <?= htmlspecialchars($donnee_vehicule["kilometrage"]) ?> Km<br>
        Boite de vitesse : <?= htmlspecialchars($donnee_vehicule["boite"]) ?><br><br>

        <strong>Acheter ce véhicule</strong><br>
        Prix de la location par jours: <H1 style="color:#595959; display:inline" ;><?= htmlspecialchars($donnee_vehicule["prix_loc_jour"]) ?>&euro;</H1><br><br>
        Forfait/mois : <?= htmlspecialchars($donnee_vehicule["forfait_par_mois"]) ?>&euro;<br><br>
        Caution : <?= htmlspecialchars($donnee_vehicule["caution"]) ?>&euro;
      </div>


      <!--Affichage des garanties et asurances comprise-->
      <div class="box_info" style="line-height: 2" ;>
        <img src="img-separation.png" alt="image"><br><br>
        <strong>
          <H3> Rendez vous dans votre espace client pour suivre votre dossier</H3>
        </strong><br>

        <span>&#128222;+262 46 78 25</span><br>
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