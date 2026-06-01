<?php
session_start();
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
//connexion à la base de onndées pour extraire les images et affichage dans la section "les voiture du moment
$host = "sql305.infinityfree.com";
$dbname = "if0_41302948_bd_locachat";
$username = "if0_41302948";
$password = "B7jc5nTtIiq";

//fonction connexion a la base de donnée
function ConnexBD($host, $dbname, $username, $password)
{
  try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  } catch (PDOException $e) {
    throw new Exception("Erreur connexion BDD : " . $e->getMessage());
  }
}
//appel de la fonction avec le bonne variable
$pdo = ConnexBD($host, $dbname, $username, $password);

?>

<?php
//Fonction pour recupérer les informations véhicules
function selectImageEtInformation(PDO $pdo): array
{
  // récupere les images et les informations
  $sql = "SELECT id, image, marque, modele, type_offre, statut 
FROM vehicule LIMIT 5";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  // recupérer plusieur ligne avec fetchAll
  $donnee_vehicule = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $donnee_vehicule ?: [];
}
?>

<?php
//fonction affichage connexion/deconnexion
function AffichagebtnConnexdeconnex()
{
  if (isset($_SESSION["user_id"])) {
    return '<a href="logout.php" class="btn-nav">Déconnexion</a>';
  } else {
    return '<a href="index_cnxn_creacompte.php" class="btn-nav">Connexion</a>';
  }
}
?>

<?php
//fonction affichage bouton dashboard admin si session admin ouvert
function AffichageBtnDashboardAdminIndex()
{
  if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    return '<a href="dashboard_admin.php" class="btn-nav">Dashboard Admin</a>';
  } else {

    return '';
  }
}
?>

<?php
function AffichageBtnEspaceClientIndex()
{
  if (!isset($_SESSION["user_id"])) {
    return '<a href="index_cnxn_creacompte.php" class="btn-nav">Créer un compte</a>';
  } elseif ($_SESSION["role"] !== "admin") {
    return '<a href="espace_client_news.php" class="btn-nav">Espace client</a>';
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        //champs faire une recherche véhicule
        function RechVehicule($pdo, $Champ_recherche)
        {

          if (!empty($champ_recherche)) {

            try {

              $Rech = $champ_recherche . '%';

              $sql = "select image, modele, marque , type_offre
FROM vehicule
WHERE marque LIKE ?
OR modele LIKE ?
OR type_offre LIKE ?";

              $stmt = $pdo->prepare($sql);
              $stmt->execute([$rech, $rech, $rech]);
              while ($Res_recherche = $stmt->fetch(PDO::FETCH_ASSOC)) {

                echo htmlspecialchars($Res_recherche['image']) . '' .
                  htmlspecialchars($Res_recherche['modele']) . '' .
                  htmlspecialchars($Res_recherche['marque']) . '' .
                  htmlspecialchars($Res_recherche['type_offre']) . '' . '<br>';
              }
            } catch (PDOException $e) {

              echo "Erreur SQL / " . $e->getMessage();
            }
          }
        }
        ?>

      </li>


      <li>
        <!-- si la session est ouvert on affiche "Déconnexion"-->
        <?php echo AffichagebtnConnexdeconnex(); ?>

      </li>
      <li>
        <!-- si session admin ouverte alors afficher bouton dashboard appel de la focntion-->
        <?= AffichageBtnDashboardAdminIndex(); ?>


      </li>
      <!-- si la session est ouvert on affiche le bouton espace client-->
      <li>
        <?= AffichageBtnEspaceClientIndex(); ?>
     
      </li>
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

        <?php
        $donnee_vehicule = selectImageEtInformation($pdo);

        foreach ($donnee_vehicule as $image_vehicule): ?>

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