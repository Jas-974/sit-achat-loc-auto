<?php
session_start();
require "config.php";
require "fonction_gestion_vehiculelocachat_admin.php";
?>

<?php
//les focntion de recupération de l'Id du vehicule et l'extration des informations
$idvehicule = RecupIdVehicule($_GET);
$vehicules_achat = RecupVehculeIdAchat($pdo, $idvehicule);
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
        <h1>Bascule du véhicule de Vente vers la location</h1>
    </div>
    <!--formulaire-->
    <div class="grande_box_formulaire_ajout_location">

        <div class="box_formulaire">
            <h1>Saisi des données du vehicule pour la location</h1>
            <!--formulaire de saisie de vehicule de location-->
            <form action="update_vehicule_achat_loc_admin.php" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars((string) $vehicules_achat['id']); ?>">

                <label for="prix_loc_jour">Prix à la location par jour:</label><br>
                <input type="text" id="prix_loc_jour" name="prix_loc_jour" required><br><br>

                <label for="forfait_par_mois">Forfait par mois :</label><br>
                <input type="text" id="forfait_par_mois" name="forfait_par_mois" required><br><br>

                <label for="caution">Caution :</label><br>
                <input type="text" id="caution" name="caution" required><br><br>


                <button type="submit"
                    style="width: 200px; height: 50px;background-color: #595959; color: white; border: none; border-radius: 10px;">Mise à jours de la base</button>
                <!--Fin formulaire-->
            </form>
        </div>

        <div class="box_formulaire">
            <h1>Le véhicule</h1>
            <!--Affichage des véhicules à l'achat-->

            <?php if ($vehicules_achat) : ?>


                <?= htmlspecialchars($vehicules_achat['id']); ?>
                <?= htmlspecialchars($vehicules_achat['marque']); ?>
                <?= htmlspecialchars($vehicules_achat['modele']); ?>
                <?= htmlspecialchars($vehicules_achat['statut']); ?>
            <?php endif; ?>
            <br>
            <br>

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