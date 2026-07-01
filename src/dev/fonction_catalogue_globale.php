<?php
function AffichagecatalogueVehicule($pdo)
{

  if (!empty($_GET['champ_recherche'])) {

    $rech = '%' . $_GET['champ_recherche'] . '%';

    $sql = "select image, modele, marque , type_offre
FROM vehicule
WHERE marque LIKE ?
OR modele LIKE ?
OR type_offre LIKE ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$rech, $rech, $rech]);
    return  $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {

    $sql = "SELECT * FROM vehicule";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

 
   
}
   //Fonction affichage de la galerie dns des vignette
      function AfficheVehiculesGalerie($vehicules)
      {
        foreach ($vehicules as $vehicule) {

          // si le type d'offre est location on ouvre la page location sinon on ouvre la page détail achat
          if ($vehicule['type_offre'] == 'location') {

            $detail_v = "index_detail_voiture_location.php?id=" . $vehicule['id'];
          } else {
            $detail_v = "index_detail_voiture.php?id=" . $vehicule['id'];
          }
    ?>


          <div class="card">
            <a href="<?= $detail_v ?>" class="card-link">

              <img src="<?= htmlspecialchars($vehicule['image']) ?>" alt="">
            </a>
            <p><?= htmlspecialchars($vehicule['marque']) ?></p>
            <p><?= htmlspecialchars($vehicule['modele']) ?></p>
            <p><?= htmlspecialchars($vehicule['type_offre']) ?></p>
          </div>

      <?php
        }
      }
      ?>
