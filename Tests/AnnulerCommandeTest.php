<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_annul_commande.php';

class AnnulerCommandeTest extends TestCase
{

        private PDO $pdo;

        //connexion à la base de donnée

        protected function setUp(): void
        {

                $port = getenv('DB_TEST_PORT') ?: '3307';
                $user = getenv('DB_TEST_USER') ?: 'root';
                $password = getenv('DB_TEST_PASSWORD') ?: '';

                $this->pdo = new PDO("mysql:host=127.0.0.1;port=$port;dbname=locachat_test;charset=utf8mb4", $user, $password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                //néttoyage des tables
                $this->pdo->exec("DELETE FROM table_statu_command");
                $this->pdo->exec("DELETE FROM documents_upload");
                $this->pdo->exec("DELETE FROM table_commandes");
                $this->pdo->exec("DELETE FROM vehicule");
                $this->pdo->exec("DELETE FROM users");
        }


        public function testAnnuleCommandeValide(): void
        {

                //insertion données de test
                $this->pdo->exec("
INSERT INTO users(id, numero_client, nom, prenom,email, pseudo, pwd_hash, role)
VALUES
(4, 'TEST007', 'Mrtes', 'John', 'mrjohn@orange.fr', 'mrtess', 'john', 'client')
");

                $user_id = 4;

                $this->pdo->exec("
INSERT INTO vehicule(id, marque, modele, type_offre, statut, status_command) VALUES
(1,'Peugeot', '208','achat','reserve', 'commande Validée')
");

                $car_id = 1;

                $this->pdo->exec("
INSERT INTO table_commandes (id, user_id, car_id, order_type) VALUES
(10, 4, 1,'achat')
");

                $commande_id = 10;


                $this->pdo->exec("
INSERT INTO table_statu_command ( numero_command, commande_id, user_id, nom, prenom, email, type_offre, status_command, code_status_command ) VALUES
('CMD2026', 10, 4, 'Mrtes', 'John', 'mrjohn@orange.fr', 'achat', 'Commande Validée' , '2')
");

                $numero_command = 'CMD2026';

                //appel à la fonction d'annulation
                $res_annul = annulerCommande($this->pdo, $user_id, $numero_command);

                $this->assertTrue($res_annul);


                //Vérification du nouveau statu de la commande

                $stmt = $this->pdo->prepare("SELECT code_status_command
FROM table_statu_command
WHERE commande_id = :commande_id");

                $stmt->execute([':commande_id' => $commande_id]);
                $code_status = $stmt->fetchColumn();

                //vérifie si la commande est annulé
                $this->assertEquals('4', $code_status);
                //verification du statut du vehicule
                $stmt = $this->pdo->prepare("
SELECT statut
FROM vehicule
WHERE id = :car_id
");

                $stmt->execute([':car_id' => $car_id]);
                $statut_vehicule = $stmt->fetchColumn();

                // Vérifie que le véhicule est disponible
                $this->assertEquals('disponible', $statut_vehicule);
        }

        //test de commande non valide

        public function testAnnuleCommandeNonValide(): void
        {

                // insertion d'un user dans la table
                $this->pdo->exec("INSERT INTO users(id, numero_client, nom, prenom,email, pseudo, pwd_hash, role)
VALUES
(4, 'TEST007', 'Mrtes', 'John', 'mrjohn@orange.fr', 'mrtess', 'john', 'client')
");

                $user_id = 4;

                // insertion d'un vehicule
                $this->pdo->exec("
INSERT INTO vehicule(id, marque, modele, type_offre, statut, status_command) VALUES
(1,'Peugeot', '208','achat','reserve', 'commande en attente')
");

                $car_id = 1;

                // insertion de la commande
                $this->pdo->exec("
INSERT INTO table_commandes (id, user_id, car_id, order_type) VALUES
(10, 4, 1,'achat')
");

                $commande_id = 10;

                // insertion statut de la commande
                $this->pdo->exec("
INSERT INTO table_statu_command ( numero_command, commande_id, user_id, nom, prenom, email, type_offre, status_command, code_status_command ) VALUES
('CMD2026', 10, 4, 'Mrtes', 'John', 'mrjohn@orange.fr', 'achat', 'Réservation en cours' , '1')
");

                $numero_command = 'CMD2026';

                //appel fonction annule commande
                $res_annul = annulerCommande($this->pdo, $user_id, $numero_command);

                $this->assertFalse($res_annul);



                //verification que la commande reste en attente

                $stmt = $this->pdo->prepare("
                SELECT code_status_command FROM table_statu_command
                WHERE commande_id = :commande_id");

             

                $stmt->execute([':commande_id' => $commande_id]);
                
                $code_status =$stmt->fetchColumn();

//statut toujours a 1?
                $this->assertEquals('1', $code_status);

                // vérifie que le véhicule reste reservé


                $stmt =  $this->pdo->prepare("SELECT statut FROM vehicule
                WHERE id = :car_id");

                 $stmt->execute([':car_id' => $car_id]);

                $statut_vehicule = $stmt->fetchColumn();
                $this->assertEquals('reserve', $statut_vehicule);

        }

        //test de verif de la fonction annulCommande accessible
        public function testFonctionAnnulCommand(): void
        {
                $this->assertTrue(function_exists('annulerCommande'));
        }
}
