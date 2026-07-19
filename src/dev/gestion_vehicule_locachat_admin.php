<?php
session_start();
require "config.php";
require "fonction_gestion_vehiculelocachat_admin.php";
?>

<?php
//les focntion de recupération de l'Id du vehicule et l'extration des informations
$idvehicule = RecupIdVehicule($_GET);
$vehicules_location = RecupVehculeIdLocation($pdo, $idvehicule);
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
        <h1>Bascule du véhicule de location vers la vente</h1>
    </div>


    <!--formulaire-->
    <div class="grande_box_formulaire_ajout_location">

        <div class="box_formulaire">
            <h1>Saisi des données du vehicule pour la vente</h1>
            <!--formulaire de saisie de vehicule de location-->
            <form action="update_vehicule_loc_achat_admin.php" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars((string) $vehicules_location['id']); ?>">

                <label for="prix">Prix :</label><br>
                <input type="text" id="prix" name="prix" required><br><br>

                <label for="loyer_mois">Loyer par mois :</label><br>
                <input type="text" id="loyer_mois" name="loyer_mois" required><br><br>

                <label for="apport">Apport :</label><br>
                <input type="text" id="apport" name="apport" required><br><br>

                <label for="locachat">type d'offre :</label><br>
                <input type="text" id="locachat" name="locachat" required><br><br>

                <button type="submit"
                    style="width: 200px; height: 50px;background-color: #595959; color: white; border: none; border-radius: 10px;">Mise à jour de la base</button>
                <!--Fin formulaire-->
            </form>
        </div>

        <div class="box_formulaire">
            <h1>Le véhicule</h1>
            <!--Affichage des véhicules à l'achat-->

            <?php if ($vehicules_location) : ?>


                <?= htmlspecialchars($vehicules_location['id']); ?>
                <?= htmlspecialchars($vehicules_location['marque']); ?>
                <?= htmlspecialchars($vehicules_location['modele']); ?>
                <?= htmlspecialchars($vehicules_location['statut']); ?>
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