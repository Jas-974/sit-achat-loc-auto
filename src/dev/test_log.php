<?php

require_once __DIR__ . "/log.php";

GestionLog("INFO", "Test du système de logs");

echo "Test terminé";
GestionAlerte("Ceci est un test d'alerte");