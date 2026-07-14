

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
    return '';
}
?>

<?php
//champs faire une recherche véhicule
function RechVehicule($pdo, $champ_recherche): array
{

    if (empty($champ_recherche)) {
        return [];
    }
        try {

            $rech = $champ_recherche . '%';

            $sql = "select image, modele, marque , type_offre
FROM vehicule
WHERE marque LIKE ?
OR modele LIKE ?
OR type_offre LIKE ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$rech, $rech, $rech]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur SQL / " . $e->getMessage());
        }
    }
?>