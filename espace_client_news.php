<?php
session_start();
require_once 'fonction_espace_client.php';
require "config.php";

?>

<?php
// appel a la fonction :récupere les informations de l'utilisateur connecté
$res_fonction = RecupInformationUtilisateurConnecte($pdo);

if (!$res_fonction["success"]) {

  if (!$res_fonction["message"] == "Connexion nécessaire") {

    header("Location: cnxn.php?message=connexion_necessaire");
    exit;
  }
  echo ($res_fonction["message"]);
  exit;
}

$user = $res_fonction["user"];

//fonction affichage liste de 6 vehicules dans l'espace client
$vehicules = RecherchePourAfficheVehiculesEspaceClient($pdo);

//Appel de la fonction affichage de la rubrique Command
$info_command = AffichageDeLaRubriqueCommand($pdo, $user["email"]);
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <!-- appel au fichier CSS-->
  <link rel="stylesheet" href="styles_page_espace_client.css">
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
        <!--Affichage des information de la commande en cours-->

        <!--parcours la table pour trouver s'il y a des commande en cours-->
        <?php if (!empty($info_command)) : ?>


          <?php foreach ($info_command as $info_commands) : ?>

            <p><strong>Numero de commande: </strong><?= htmlspecialchars($info_commands["numero_command"]) ?></p>

            <p><strong>Date: </strong><?= htmlspecialchars($info_commands["date"]) ?></p>
            <p><strong>La commande: </strong><?= htmlspecialchars($info_commands["type_offre"]) ?></p>


            <p><strong>Status de la commande: </strong><?= htmlspecialchars($info_commands["status_command"]) ?></p>


            <?php if ($info_commands['code_status_command'] == '2') : ?>

              <p><a href="page_paiement.php?numero_command=<?= htmlspecialchars($info_commands["numero_command"]) ?>">Procéder au paiement</a></p>
              <p><a href="annul_commandes.php?numero_command=<?= htmlspecialchars($info_commands["numero_command"]) ?>">Annuler la commande</a></p>
            <?php endif; ?>


          <?php endforeach; ?>
        <?php else : ?>
          <p>Aucune commande en cours.</p>
        <?php endif; ?>

      </div>

      <!--<a>BOX D</a>-->
      <div class=" box_body_mes_documents">


        <h1>Mes documents</h1>
        <p></p>

        <?php
        $conn = new mysqli("localhost", "root", "", "bd_locachat", 3307);
        //$conn = new mysqli("sql305.infinityfree.com", "if0_41302948", "B7jc5nTtIiq", "if0_41302948_bd_locachat");
        //appel de la fonction enreg document
        $enreg_doc = enregDocument($conn);
        echo $enreg_doc;
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

          <?php
          // si le type d'offre est location on ouvre la page location sinon on ouvre la page détail achat
          if ($vehicule['type_offre'] == 'location') {

            $detail_v = "index_detail_voiture_location.php?id=" . $vehicule['id'];
          } else {
            $detail_v = "index_detail_voiture.php?id=" . $vehicule['id'];
          }
          ?>

          <div class="card">
            <!-- rendre la carte comme un lien-->
            <a href="<?= $detail_v ?>" class="card-link">
              <img src="<?= htmlspecialchars($vehicule['image']) ?>" alt="">
              <p><?= htmlspecialchars($vehicule['modele']) ?></p>
              <p><?= htmlspecialchars($vehicule['type_offre']) ?></p>
              <p><?= htmlspecialchars($vehicule['description']) ?></p>
            </a>
          </div>

        <?php endforeach; ?>

      <?php else : ?>
        <p>Aucun véhicule trouvé.</p>
      <?php endif; ?>
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