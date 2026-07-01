<?php
function gPostValue($champ){
 // Récupération de la valeur du champ dans une variable
    if (isset($_POST[$champ])) {
        return trim($_POST[$champ]);
    } else {
        return "";
    }

}

function champsVide($donnees){
 // Récupération de la valeur du champ dans une variable
foreach($donnees as $valeur) {
    if ($valeur === ""){
        return false;
    }

    }
        return true;
    }
