<?php
session_start();
require "config.php";
?>

<?php
// récupere les informations de l'utilisateur connecté
if (!isset($_SESSION["user_id"])) {
 header("Location: cnxn.php?message=connexion_necessaire");
    exit;
}
// reqête de recupération des informations dans la base de donnée
$sql = "SELECT numero_client, pseudo, email FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $_SESSION["user_id"]]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  die("Utilisateur introuvable.");
}


// le champs recherche
if (isset($_GET["champ_recherche"])) {
  $recherche = $_GET["champ_recherche"];
} else {
  $recherche = "";
}
// on créé un tableau vide pour stocker le résultat des recherches
$vehicules = [];

$sql = "SELECT * FROM vehicule";
$params = [];

if (!empty($recherche)) {
  $sql .= " WHERE (titre LIKE :recherche 
              OR locachat LIKE :recherche)";
  $params['recherche'] = '%' . $recherche . '%';
} else {
  $sql = "SELECT * FROM vehicule LIMIT 4";
}
// pour test 
//echo $sql;
//exit;


$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <!-- appel au fichier CSS-->
  <link rel="stylesheet" href="styles_page_espace_client.css">
</head>

<header>
  <!-- Image du logo-->

  <div class="logo">
    <img src="Logo.png" alt="Logo">
  </div>


  <!-- contener  qui abrite les boutons Connexion et création de compte-->
  <div class="container_bouton_cnxn_creacompte">
    <ul style="display: flex; justify-content: flex-end; list-style: none; padding: 80px; margin: 0; gap : 10px;">

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


<body>

  <div class="box_titre">
    <h2>Votre Espace Client</h2>
    <h4>Bienvenue dns votre tableau de bord</h4>
  </div>



  <div class="grande_box_espace_client">
    <!--<a>BOX A</a>-->
    <div class="box_body_espace_client">
      <!--<a>BOX B</a>-->
      <div class="box_body_mes_commandes">
       
        <h1>Mes commandes</h1>

        <h3>Commande #4587 -Renault Clio - Achat - En attente</h3>
        <h3>Commande #4589 -Renault Clio - Location En attente</h3>
      </div>

      <!--<a>BOX D</a>-->
      <div class="box_body_mes_documents">
       

        <h1>Mes documents</h1>
        <p></p>
        
        <?php
        $conn = new mysqli("localhost", "root", "", "bd_locachat");
        //Connexion à la base de donnée
        if ($conn->connect_error) {
          die("Erreur connexion BDD : " . $conn->connect_error);
        }
        // recupère le fichier téléverser et l'enregistre sur le serveur
        if (isset($_FILES['document']) && $_FILES['document']['error'] === 0) {

          $tmp = $_FILES['document']['tmp_name'];
          $nom = $_FILES['document']['name'];
          $chemin = "uploads/" . $nom;
          if (move_uploaded_file($tmp, $chemin)) {

            $sql = "INSERT INTO documents_locachat (nom, chemin) VALUES ('$nom', '$chemin')";

            if ($conn->query($sql) === TRUE) {
              echo "Fichier envoyé avec succès";
            } else {
              echo "Erreur SQL : " . $conn->error;
            }
          } else {
            echo "Erreur lors du téléversement du fichier.";
          }
        }
        ?>
        <h3>Facture_5676.pdf</h3>

      </div>
      <div class="box_body_mes_commandes">

       
        <h1>Mes informations</h1>

        <p><strong>Numero client</strong></p>
        <p><?= htmlspecialchars($user["numero_client"]) ?></p>

        <p><strong>Pseudo</strong></p>
        <p><?= htmlspecialchars($user["pseudo"]) ?></p>

        <p><strong>Email</strong></p>
        <p><?= htmlspecialchars($user["email"]) ?></p>
      </div>


    </div>



  </div>

  <div class="box_body">
    <div class="gallery">
      <?php if (!empty($vehicules)) : ?>

        <!-- la boucle d'affichage-->
        <?php foreach ($vehicules as $vehicule) : ?>
           <div class="card">

           <!-- rendre la carte comme un lien-->
          <a href="index_detail_voiture.php?id=<?= $vehicule['id'] ?>" class="card-link">
          <div class="card">
            <img src="<?= htmlspecialchars($vehicule['image']) ?>" alt="">
            </a> 
            <p><?= htmlspecialchars($vehicule['modele']) ?></p>
            <p><?= htmlspecialchars($vehicule['type_offre']) ?></p>
            <p><?= htmlspecialchars($vehicule['description']) ?></p>
          </div>
          </div>
        </a>
        <?php endforeach; ?>
      <?php else : ?>
        <p>Aucun véhicule trouvé.</p>
      <?php endif; ?>

    </div>
  </div>
  </div>

  <br>
  <div class="footer">
    <footer>
      <p>&copy; 2026 Tous droits réservés. Conçu par LocAchat.</p>
      <nav>

        <a href="#">Accueil</a>
        <a href="#">À propos</a>
        <a href="#">Contact</a>
        <a href="#">Mentions légales</a>


        <p>je suis dans le footer</p><br>
      </nav>
    </footer>
  </div>
</body>

</html>