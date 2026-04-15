<?php
session_start();
require "config.php";


?>
<?php
if (!isset($_SESSION["user_id"])) {
  header("Location: cnxn.php?message=connexion_necessaire");
  exit;
}
//definir la variable $user_id
// Je recupère les données de l'utilisateur
$user_id =$_SESSION["user_id"];
// récupere les informations du user
// reqête de recupération des informations dans la base de donnée
$sql = "SELECT id, nom, prenom, email 
FROM users 
WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $user_id]);
$donnee_user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$donnee_user) {
  die("utilisateur introuvable");
}
?>

<?php
//je recupére l'Id de la page détail_véhicule
if (!isset($_GET['id']) || empty($_GET['id'])) {
  die("ID manquant");
}

$id = (int) $_GET['id'];
?>

<?php

// récupere les informations caractéristique de la voiture
// reqête de recupération des informations dans la base de donnée
$sql = "SELECT id, marque, modele, annee, kilometrage, boite, carburant, type_offre, prix, statut, status_command, image, loyer_mois, apport 
FROM vehicule 
WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);

$donnee_vehicule = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$donnee_vehicule) {
  die("Véhicule introuvable");
}
?>



<?php
//mise a jours de la table vehicule avec la reservation en cours
if (isset($_POST['maj_status_command'])) {
  $id = (int) $_POST['id'];
  $status_command = $_POST['maj_status_command'];

  $sql = "UPDATE vehicule 
            SET status_command = :status_command,
            statut = :statut
            WHERE id = :id";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
  ':status_command' => $status_command,
  ':statut' => 'reserve', 
  ':id' => $id
  ]);
    
    // insertion des donnée de la validation de la commande dans la table table_statu_command
$sql_insert_status_command =" INSERT INTO table_statu_command (nom, prenom, email, type_offre, status_command )
VALUES (:nom, :prenom, :email, :type_offre, :status_command)";

$stmt_status_command  = $pdo->prepare($sql_insert_status_command);
$stmt_status_command ->execute([
  ":nom" => $donnee_user["nom"],
  ":prenom" => $donnee_user["prenom"],
  ":email" => $donnee_user["email"],
  ":type_offre" => $donnee_vehicule["type_offre"],
  ":status_command" => $_POST["maj_status_command"]
]);
echo "insertion OK !";
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
          <label for="files">Choisissez des fichiers à téléverser :</label>
          <input type="file" id="files" name="files[]" multiple required>
          <button type="submit">Téléverser</button><br>
        </form><br>

        <strong><span style="color:#FFC000;">* </span>Les documents sont obligatoires
          pour que votre dossier soit constitué et validé</strong>


        <!--créer une action dèrrière ce bouton de prise en charge de dossier-->
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
        Prix : <H1 style="color:#595959; display:inline" ;><?= htmlspecialchars($donnee_vehicule["prix"]) ?>&euro;</H1><br><br>
        Loyer/mois : <?= htmlspecialchars($donnee_vehicule["loyer_mois"]) ?>&euro;<br><br>
        Apport : <?= htmlspecialchars($donnee_vehicule["apport"]) ?>&euro;
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
<!--Notes site pour HTML, CSS,...:https://www.w3schools.com/-->