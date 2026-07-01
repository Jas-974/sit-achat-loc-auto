<?php
session_start();
require "config.php";
?>

<?php
// Extraction des véhicules pour affichages
$req = "SELECT id, marque, modele, statut FROM vehicule WHERE type_offre ='achat'";
$stat = $pdo->query($req);
$vehicules_achat = $stat->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <!-- appel au fichier CSS-->
  <link rel="stylesheet" href="./styles_admin_formulaire_ajout_location.css">



</head>

<body>

  <header>
    <!-- Image du logo-->
    <div class="logo">
      <img src="logo.png" alt="Logo">
    </div>

    <!--affichage des boutons-->
    <div class="container_bouton_dashboard">
      <ul style="display: flex; justify-content: flex-end; list-style: none; margin: 0; gap : 10px;">

        <li>
          <a href="dashboard_admin.php" class="btn-nav">Dashboard Administration</a>
        </li>
        <li>
          <a href="index.php" class="btn-nav">Recherche de véhicule</a>
        </li>

      </ul>
    </div>

  </header>


  <!--barre de titre-->
  <div class="box_titre_location_admin">
    <h1>Gérer les véhicules</h1>
  </div>


  <!--formulaire-->
  <div class="grande_box_formulaire_ajout_location">

    <div class="box_formulaire">
      <h1>Saisi de véhicule d'achat</h1>
      <!--formulaire de saisie de vehicule de location-->
      <form action="insert_v_achat.php" method="post">

        <label for="marque">Marque :</label><br>
        <input type="text" id="marque" name="marque" required><br><br>

        <label for="modele">Modele :</label><br>
        <input type="text" id="modele" name="modele" required><br><br>

        <label for="annee">Année :</label><br>
        <input type="text" id="annee" name="annee" required><br><br>

        <label for="kilometre">Kilomètrage :</label><br>
        <input type="number" id="kilometrage" name="kilometrage" required><br><br>
        
        <label for="boite">Boite de vitesse :</label><br>
        <input type="text" id="boite" name="boite" required><br><br>

        <label for="puissance">Puissance:</label><br>
        <input type="text" id="puissance" name="puissance" required><br><br>


        <label for="carburant">Carburant :</label><br>
        <input type="text" id="carburant" name="carburant" required><br><br>

        <label for="couleur">Couleur :</label><br>
        <input type="text" id="couleur" name="couleur" required><br><br>

        <label for="type_offre">Type d'offre :</label><br>
        <input type="text" id="type_offre" name="type_offre" value="achat"><br><br>

        <label for="prix">Prix :</label><br>
        <input type="text" id="prix" name="prix" required><br><br>

        <label for="statut">Status :</label><br>
        <input type="text" id="statut" name="statut" required><br><br>

        <label for="description">Descriptions :</label><br>
        <input type="text" id="description" name="description" required><br><br>

        <label for="loyer_mois">Loyer par mois :</label><br>
        <input type="text" id="loyer_mois" name="loyer_mois" required><br><br>

        <label for="apport">Apport :</label><br>
        <input type="text" id="apport" name="apport" required><br><br>


        <button type="submit"
          style="width: 200px; height: 50px;background-color: #595959; color: white; border: none; border-radius: 10px;">Insérer dans la base</button>
        <!--Fin formulaire-->
      </form>
    </div>

    <div class="box_formulaire">
      <h1>Suppression de véhicule à la location en base</h1>
      <!--Affichage des véhcules à l'achat-->
      <form method="post" action="delete_cara.php">

        <?php foreach ($vehicules_achat as $vehicule_achat): ?>
          <label>
            <input
              type="checkbox"
              name="vehicules_achat[]"
              value="<?= $vehicule_achat['id']; ?>">
               <?= htmlspecialchars($vehicule_achat['id']); ?>
            <?= htmlspecialchars($vehicule_achat['marque']); ?>
            <?= htmlspecialchars($vehicule_achat['modele']); ?>
             <?= htmlspecialchars($vehicule_achat['statut']); ?>
          </label>
          <br>
        <?php endforeach; ?>
<br>
        <button type="submit" style="width: 200px; height: 50px;background-color: #595959; color: white; border: none; border-radius: 10px;">
          Supprimer le véhicule de la base
        </button>

      </form>

    </div>







  </div>


  <br>
  <div class="footer">
    <footer>
      <p>&copy; 2023 Tous droits réservés. Conçu par LocAchat.</p>
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