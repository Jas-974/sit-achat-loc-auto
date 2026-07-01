<?php
function supressionVehiculeLoc(PDO $pdo, array $id_vehicule): bool
{
foreach ($id_vehicule as $id_v) {
    $req = $pdo->prepare("DELETE FROM vehicule WHERE id = ?");
    $req->execute([$id_v]); 
}
return true;
}
?>