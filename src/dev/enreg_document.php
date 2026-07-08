<?php
session_start();

// se connecte à la BDD
//$pdo = new PDO("mysql:host=sql305.infinityfree.com;dbname=if0_41302948_bd_locachat;charset=utf8", "if0_41302948", "B7jc5nTtIiq");
$pdo = new PDO("mysql:host=localhost;port=3307;dbname=bd_locachat;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// vérification que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Utilisateur non connécté");
}

// vérification de l'ID
if (!isset($_POST['id'])) {
    die("id du véhcule est manquant");
}

$user_id = $_SESSION["user_id"];
$id = (int) $_POST['id'];



if (isset($_FILES['files'])) {

    $nom = $_FILES['files']['name'];
    $tmp = $_FILES['files']['tmp_name'];

    $rep_upload = "uploads/";
    // pas de repertoire on créé
    if (!is_dir($rep_upload)) {
        mkdir($rep_upload, 0777, true);
    }

    $fichier_doc = [];
    // boucle pour traiter plusieurs fichiers
    foreach ($_FILES['files']['tmp_name'] as $index => $tmp_name) {

        if (!empty($tmp_name) && $_FILES['files']['error'][$index] === UPLOAD_ERR_OK) {

            $nom = $_FILES['files']['name'][$index];
$rename_nom = time() . "_" . uniqid() . "_" . $nom . "_" . $user_id;
$adress_fichier = $rep_upload . $rename_nom;


           if( move_uploaded_file($tmp_name, $adress_fichier)){
            $fichier_doc[] = $adress_fichier;
            echo "Fichier enregistré : " . htmlspecialchars($rename_nom) . "<br>";
        }
        }
    }
} else {
    echo "Aucun fichier reçu";
}
// on concatene les documents
if (!empty($fichier_doc)){
$doc = implode(",", $fichier_doc);
$sql = "INSERT INTO documents_upload (user_id, car_id, documents)
VALUES (:user_id, :car_id, :documents)";

$stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":documents" => $doc,
        ":user_id" => $user_id,
        ":car_id" => $id
    ]);

}


$page_retour = $_POST["page_retour"] ?? "commande_voiture_location.php";
header("Location: ". $page_retour . "?id=" . $id);
exit;

?>