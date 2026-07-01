<?php
session_start();
require "config.php";



// vérification que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Utilisateur non connécté");
}

$user_id = $_SESSION["user_id"];


$numero_command = $_GET['numero_command'];

 echo '<p>';
      var_dump($numero_command);
      echo '</p>';

$sql= "UPDATE table_statu_command SET code_status_command = 4,
 status_command = 'Commande annulée'
WHERE numero_command =  '$numero_command'
AND user_id = '$user_id'";


$stmt = $pdo->prepare($sql);
    $stmt->execute();
 header("Location: /dev_web_locachat/src/dev/espace_client_news.php");
 exit;


 echo "Lignes modifiées : " . $stmt->rowCount();
exit;