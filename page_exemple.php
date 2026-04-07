<?php
// Simulation de données (comme si ça venait de ta base)
$donnee_vehicule = [
  "marque" => "Renault",
  "modele" => "Clio V",
  "prix" => 16990,
  "image" => "images/voiture_1.png"
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Détail véhicule</title>

  <style>
    body {
      font-family: Arial;
    }

    .container {
      display: flex;
      gap: 20px;
      padding: 20px;
    }

    .box_img img {
      width: 300px;
      border-radius: 10px;
    }
  </style>
</head>

<body>

<h1>Détail du véhicule</h1>

<div class="container">

  <!-- IMAGE -->
  <div class="box_img">
    <img src="<?= htmlspecialchars($donnee_vehicule['image']) ?>" alt="image véhicule">
  </div>

  <!-- TEXTE -->
  <div>
    <h2><?= htmlspecialchars($donnee_vehicule['marque']) ?> <?= htmlspecialchars($donnee_vehicule['modele']) ?></h2>
    <p>Prix : <?= htmlspecialchars($donnee_vehicule['prix']) ?> €</p>
  </div>

</div>

</body>
</html>
✅ Ce que fait cet exemple
affiche une image dynamique 🖼️
affiche du texte dynamique 📄
utilise htmlspecialchars (sécurité 👍)
structure simple et claire
🧪 Résultat attendu

Tu verras :

une image à gauche
les infos à droite (marque, modèle, prix)
🔥 Important

Assure-toi que ton image existe ici :

htdocs/
  images/
    voiture_1.png
💡 Si tu veux aller plus loin

Je peux t’aider à :

connecter directement à ta base de données
afficher plusieurs voitures
faire une page de détail comme ton projet

Dis-moi 👍