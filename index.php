<?php
session_start();
?>


<?php
//connexion à la base de onndées pour extraire les images et affichage dans la section "les voiture du moment
$host = "localhost";
$dbname = "bd_locachat";
$username = "root";
$password = "";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion BDD : " . $e->getMessage());
}
?>

<?php
// récupere les images et les informations
$sql = "SELECT id, image, marque, modele, type_offre, statut 
FROM vehicule 
WHERE visibilite = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
// recupérer plusieur ligne avec fetchAll
$donnee_vehicule = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$donnee_vehicule) {
  die("Véhicule introuvable");
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- appel au fichier CSS-->
  <link rel="stylesheet" href="styles.css">
</head>

<header>
  <!-- Image du logo-->
  <img src="logo.png" alt="Logo"
    style="height: 60px; margin-right: 20px; margin-left: 10px; margin-top: 10px;">



  <!-- contener  avec  les boutons Connexion et création de compte-->
  <div class="container_bouton_cnxn_creacompte">
    <ul style="display: flex; justify-content: flex-end; list-style: none; padding: 80px; margin: 0; gap: 10px;">
      <li>
        <!-- la barre de recherche-->
        <form method="GET" action="index_catalogue_globale.php">
          <div class="barre-recherche">
            <input type="text" name="champ_recherche" placeholder="Rechercher un véhicule, achat, location...">
            <button type="submit">&#128269;</button>
          </div>
        </form>
        <!--Gestion du champs de la recherche-->
        <?php
        try {
          $pdo = new PDO('mysql:host=localhost;dbname=pdo_application', 'root', '');

          // Vérifie si l'utilisateur a tapé quelque chose
          if (isset($_GET['champ_recherche']) && !empty($_GET['champ_recherche'])) {
            // on vérifie que ca commence oar quoi avec %
            $search = $_GET['champ_recherche'] . '%';
            // requete de recherche sur plusieurs critères
            $sql = "SELECT image, modele, marque, type_offre FROM vehicule WHERE marque LIKE ? OR modele LIKE ? OR type_offre LIKE ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$search, $search, $search]);
            // ajout dans un tableau associatif
            while ($recherche = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo $recherche['image'] . ' ' . $recherche['modele'] . ' ' . $recherche['marque'] . ' ' . $recherche['marque'] . '<br>';
            }
          }
        } catch (PDOException $e) {
          echo "Erreur de connexion";
        }
        ?>

      </li>


      <li>
        <!-- si la session est ouvert on affiche "Déconnexion"-->
        <?php if (isset($_SESSION["user_id"])): ?>

          <a href="logout.php" class="btn-nav">Déconnexion</a>

        <?php else: ?>

          <a href="index_cnxn_creacompte.php" class="btn-nav">Connexion</a>

        <?php endif; ?>
      </li>
      <!-- si la session est ouvert on affiche pas le bouton-->
      <?php if (!isset($_SESSION["user_id"])): ?>
        <li>
          <a href="index_cnxn_creacompte.php" class="btn-nav">Créer un compte</a>
        </li>
      <?php else: ?>

        <li>
          <a href="index_espace_client.php" class="btn-nav">Espace client</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>

</header>


<body>
  <main>
    <div class="container_presentation">
      <h1>LocAchat</h1>

      <h1>Vous cherche des véhicules entre deux options achat/location?</h1><br>
      <h1>Vous ètes au bon endroit</h1>

      <h2>Découvrez notre nouveau service de location longue durée et vente</h2>
      Avec notre formule d’abonnement, vous bénéficiez d’un ensemble de services pensés pour vous simplifier la vie et
      rouler <br>
      l’esprit tranquille.<br>

      Ce qui est inclus (ou disponible en option) dans votre abonnement :<br>
      <ul>
        <a><strong>Assurance tous risques</strong></a><br>
        <a><strong>Assistance dépannage 24/7</strong></a><br>
        <a><strong>Entretien et service après-vente (SAV)</strong></a><br>
        <a><strong>Contrôle technique</strong></a><br>
      </ul>

    </div>


    <div class="container_one">
      <!--<p> je suis dans conteneur one</p>-->
      <!--Ajout du bouton dans la box-->

      <a href="index_catalogue_globale.php?filtre=tous" class="btn-nav">Voir le catalogue</a>
    </div>

    <div class="card-titre-photo-voiture">
      <p>Les voitures et Offres du moments</p>
    </div>

    <!--La gallery des photos du parc de voiture-->
    <div class="box_body">
      <!--<p>box_body</p>-->

  <!--affichage des image dans les diffèrentes vignettes-->
      <div class="gallery">
        <?php foreach ($donnee_vehicule as $image_vehicule): ?>
        
        <div class="card">
          <a href="index_detail_voiture.php?id=<?= $image_vehicule['id'] ?>" class="card-link">
            <img src="<?= htmlspecialchars($image_vehicule['image']) ?>"
                 alt="<?= htmlspecialchars($image_vehicule['marque'] ?? $image_vehicule['modele']) ?>"
                 class="image">
        </a>
            <p><?= htmlspecialchars($image_vehicule['marque']) ?></p>
            <p><?= htmlspecialchars($image_vehicule['modele']) ?></p>
            <p><?= htmlspecialchars($image_vehicule['type_offre']) ?></p>
            <p><?= htmlspecialchars($image_vehicule['statut']) ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>

  <!--<p>je suis sortie de  la box_body</p>-->


  <footer style="background-color: #595959; borde-radius: 10px; padding: 10px; text-align: center; color: yellow;">
    <p>&copy; 2026 Tous droits réservés. LocAchat</p>
    <nav>

      <a href="#" ; style="color: yellow;">Accueil</a>
      <a href="#" ; style="color: yellow;">À propos</a>
      <a href="#" ; style="color: yellow;">Contact</a>
      <a href="#" ; style="color: yellow;">Mentions légales</a>



    </nav>
  </footer>

</body>

</html>