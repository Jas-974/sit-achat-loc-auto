<?php
session_start();
?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
//connexion à la base de onndées pour extraire les images et affichage dans la section "les voiture du moment
$host = "localhost";
$dbname = "bd_locachat";   
$username = "root";
$password = "";
$dsn = "mysql:host=$host;dbname=$dbname";


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
FROM vehicule LIMIT 5" ;
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
  <meta charset="utf-8" >
  <meta name="viewport" content="width=device-width, initial-scale=1.0" >
  <!-- appel au fichier CSS-->
  <link rel="stylesheet" href="styles.css">
</head>

<header>
  <!-- Image du logo-->
  <img src="logo.png" alt="Logo"
  <img src="/dev_web_locachat/src/dev/images/logo/logo.png" alt="Logo"
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
if (isset($_GET['champ_recherche']) && !empty($_GET['champ_recherche'])) {
  try {
    $search = $_GET['champ_recherche'] . '%';
    $sql = "SELECT image, modele, marque, type_offre 
            FROM vehicule 
            WHERE marque LIKE ? OR modele LIKE ? OR type_offre LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$search, $search, $search]);

    while ($recherche = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo htmlspecialchars($recherche['image']) . ' '
         . htmlspecialchars($recherche['modele']) . ' '
         . htmlspecialchars($recherche['marque']) . ' '
         . htmlspecialchars($recherche['type_offre']) . '<br>';
    }
  } catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
  }
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


       <li>
        <!-- si la session admin est ouvert on affiche "Dashboard Admin"-->
        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>

          <a href="dashboard_admin.php" class="btn-nav">Dashboard Admin</a>

        <?php endif; ?>
      </li>



      <!-- si la session est ouvert on affiche pas le bouton-->
      <?php if (!isset($_SESSION["user_id"])): ?>
        <li>
          <a href="index_cnxn_creacompte.php" class="btn-nav">Créer un compte</a>
        </li>
      <?php endif; ?>

      <li>
        <a href="/dev_web_locachat/pages/recherche.php" class="btn-nav">Recherche de véhicule</a>
      </li>
      <?php elseif ($_SESSION["role"] !== "admin"): ?>

        <li>
          <a href="espace_client_news.php" class="btn-nav">Espace client</a>
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
      <a href="index_catalogue_globale.php?filtre=achat" class="btn-nav">Catalogue à Achat</a>
      <a href="index_catalogue_globale.php?filtre=location" class="btn-nav">Catalogue Location</a>

      <a href="index_catalogue_globale.php?filtre=tous" class="btn-nav">Voir le catalogue</a>
    </div>

    <div class="card-titre-photo-voiture">
      <p>Les voitures du moments</p>
      <p>Les voitures et Offres du moments</p>
    </div>

    <!--La gallery des photos du parc de voiture-->
    <div class="box_body">
      <!--<p>box_body</p>-->


      <div class="gallery">
        <div class="card">
          <img src="voiture 1.png" alt="">
          <p>Ceci est un petit texte sous l'image 0</p>
        </div>

        <div class="card">
          <img src="voiture 2.png" alt="">
          <p>Ceci est un petit texte sous l'image 1</p>
        </div>

        <div class="card">
          <img src="voiture 2.png" alt="">
          <p>Ceci est un petit texte sous l'image 1</p>
        </div>
        <div class="card">
          <img src="voiture 2.png" alt="">
          <p>Ceci est un petit texte sous l'image 1</p>
        </div>
        <div class="card">
          <img src="voiture 2.png" alt="">
          <p>Ceci est un petit texte sous l'image 1</p>
        </div>
        <div class="card">
          <img src="voiture 2.png" alt="">
          <p>Ceci est un petit texte sous l'image 1</p>
        </div>
        <div class="card">
          <img src="voiture 2.png" alt="">
          <p>Ceci est un petit texte sous l'image 1</p>
        </div>
        <div class="card">
          <img src="voiture 2.png" alt="">
          <p>Ceci est un petit texte sous l'image 1</p>
        </div>
        <div class="card">
          <img src="voiture 2.png" alt="">
          <p>Ceci est un petit texte sous l'image 1</p>
        </div>
      </div>

    </div>
  </main>





  <!--<p>je suis sortie de  la box_body</p>-->

  <br>
      <!--affichage des image dans les diffèrentes vignettes-->
      <div class="gallery">
        <?php foreach ($donnee_vehicule as $image_vehicule): ?>

          <?php
          // si le type d'offre est location on ouvre la page location sinon on ouvre la page détail achat
          if ($image_vehicule['type_offre'] == 'location') {

            $detail_v = "index_detail_voiture_location.php?id=" . $image_vehicule['id'];
          } else {
            $detail_v = "index_detail_voiture.php?id=" . $image_vehicule['id'];
          }
          ?>

          <div class="card">
            <a href="<?= $detail_v ?>" class="card-link">
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