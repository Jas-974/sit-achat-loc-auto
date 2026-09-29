<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class MiseaJourCommandRejeterTest extends TestCase
{

        private PDO $pdo;

        protected function setUp(): void
        {
                $_GET = [];
                // création de la table

                $port = getenv('DB_TEST_PORT') ?: '3307';
                $user = getenv('DB_TEST_USER') ?: 'root';
                $password = getenv('DB_TEST_PASSWORD') ?: '';

                $this->pdo = new PDO("mysql:host=127.0.0.1;port=$port;dbname=locachat_test;charset=utf8mb4", $user, $password);


                //nétoyage des table de la base

                $this->pdo->exec("DELETE FROM table_statu_command");
                $this->pdo->exec("DELETE FROM table_commandes");
                $this->pdo->exec("DELETE FROM vehicule");
                $this->pdo->exec("DELETE FROM users");

                //insertion données de test
                $this->pdo->exec("
INSERT INTO users(id, numero_client, nom, prenom,email, pseudo, pwd_hash, role)
VALUES
(1, 'TEST001', 'MrTest', 'Testutilisateur', 'mrtest@orange.fr', 'mrtest', 'test', 'client')
");

                $this->pdo->exec("INSERT INTO vehicule (id, marque, modele, type_offre, statut, status_command)
        VALUES
        (2,'peugeot', '208', 'location', 'reserve', 'Réservation en cours')");



                $this->pdo->exec("INSERT INTO table_commandes (id, user_id, car_id, order_type)
        VALUES
        (1,1,2, 'location')");

                //execution de la requete
                $this->pdo->exec("
INSERT INTO table_statu_command(numero_command, user_id, nom, prenom,email, type_offre, status_command, code_status_command, commande_id)
VALUES
('TEST001', 1, 'MrTest', 'Testutilisateur', 'mrtest@orange.fr', 'location', 'Réservation en cours', '1',1)
");
        }

        public function testRejetCommand()
        {
                $_GET["id"] = 1;
                $_GET["rejeter"] = "rejeter";

                MiseaJourCommandRejeter($this->pdo);
                $stmt = $this->pdo->query("SELECT * FROM table_statu_command WHERE commande_id = 1");
                $commande = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->assertEquals("Commande Rejeter merci de vous rapprocher du Service Client au +262 46 78 24", $commande["status_command"]);
                $this->assertEquals("3", $commande["code_status_command"]);

                // verif que le vehicule  est de nouveau disponible
                $stmtVehicules = $this->pdo->query("
                SELECT statut, status_command FROM vehicule WHERE id= 2
                ");

                $vehicule = $stmtVehicules->fetch(PDO::FETCH_ASSOC);
                $this->assertEquals("disponible", $vehicule["statut"]);
                $this->assertNull($vehicule["status_command"]);
        }
}
