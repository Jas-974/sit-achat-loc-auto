<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <!-- appel au fichier CSS-->
  <link rel="stylesheet" href="styles_page_formulaire_cnxn_creacompte.css">
</head>

<header>
  <!-- Image du logo-->

  <div class="logo">
<<<<<<< HEAD
    <img src="/dev_web_locachat/src/dev/images/logo/logo.png" alt="Logo"
    style="height: 60px; margin-right: 20px; margin-left: 10px; margin-top: 10px;">
=======
    <img src="logo.png" alt="Logo">
>>>>>>> feature/page_detail_vehicule
  </div>


  <!-- contener  qui abrite les boutons Connexion et création de compte-->
  <div class="container_bouton_cnxn_creacompte">
    <ul style="display: flex; justify-content: flex-end; list-style: none; padding: 80px; margin: 0; gap : 10px;">
      
      <li>
        <a href="index.php" class="btn-nav">Accueil</a>
      </li>
      </li>
      <li>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
       <!--  <a href="index.php" class="btn-nav">Recherche de véhicule</a>-->
=======
        <a href="index.php" class="btn-nav">Recherche de véhicule</a>
>>>>>>> feature/page_catalogue_globale
=======
        <a href="index.php" class="btn-nav">Recherche de véhicule</a>
>>>>>>> feature/page_cnxn_crea_compte
=======
       <!--  <a href="index.php" class="btn-nav">Recherche de véhicule</a>-->
>>>>>>> feature/page_detail_vehicule
      </li>
      </li>
    </ul>
  </div>

</header>


<body>

  <div class="box_titre_formulaire_creacompte">
    <p>
    <h1>Creer un compte ou connecter vous si vous avez dèjà un compte</h1>
    </p>
  </div>



  <div class="grande_box_formulaire_cnxn_creacompte">
    <div class="box_body_formulaire_création_compte">
      <div class="box_body_formulaire_création_compte_1">
        <!--formulaire création compte-->
        <form action="creacompte.php" method="post">
          <label for="nom">Nom :</label><br>
          <input type="text" id="nom" name="nom" required><br><br>

          <label for="prenom">Prénom :</label><br>
          <input type="text" id="prenom" name="prenom" required><br><br>

          <label for="email">Email :</label><br>
          <input type="email" id="email" name="email" required><br><br>


          <label for="telephone">téléphone :</label><br>
          <input type="text" id="telephone" name="telephone" required><br><br>

          <label for="date_naissance">Date de naissance:</label><br>
          <input type="date" id="date_naissance" name="date_naissance" required><br><br>

          <label for="permis_b">Numéro de permis B :</label><br>
          <input type="text" id="permis_b" name="permis_b" required><br><br>

          <label for="adresse">Adresse :</label><br>
          <input type="text" size="50" id="adresse" name="adresse" required><br><br>

          <label for="code_postal">Code postal :</label><br>
          <input type="text" id="code_postal" name="code_postal" required><br><br>

          <label for="Pseudo">Pseudo :</label><br>
          <input type="text" id="pseudo" name="pseudo" required><br><br>

          <label for="pwd">Mot de passe* :</label><br>
          <input type="password" id="pwd" name="pwd" required><br><br>

          <label for="confirmation_pwd">Confirmation mot de passe* :</label><br>
          <input type="password" id="confirmation_pwd" name="confirmation_pwd"
            required><br><br>

          <button type="submit"
            style="width: 200px; height: 50px;background-color: #595959; color: white; border: none; border-radius: 10px;">Envoyer</button>
          <!--Fin formulaire-->
        </form>
      </div>
      <div class="box_body_formulaire_création_compte_2">
        <h1>Créer un compte</h1>

      </div>
    </div>
    <!--Formulaire de connexion-->
    <div class="grand_box_formulaire-connexion">
      <div class="box_body_formulaire-connexion">

        <form action="cnxn.php" method="post">
          <label for="email">Email :</label><br>
          <input type="email" id="email" name="email" required><br><br>

          <label for="pwd">Mot de passe* :</label><br>
          <input type="password" id="pwd" name="pwd" required><br><br>
          <button type="submit"
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
            style="width: 200px; height: 50px;background-color: #595959; color: white; border: none; border-radius: 10px;">Connecter</button>
=======
            style="width: 200px; height: 50px;background-color: #595959; color: white; border: none; border-radius: 10px;">Envoyer</button>
>>>>>>> feature/page_catalogue_globale
=======
            style="width: 200px; height: 50px;background-color: #595959; color: white; border: none; border-radius: 10px;">Envoyer</button>
>>>>>>> feature/page_cnxn_crea_compte
=======
            style="width: 200px; height: 50px;background-color: #595959; color: white; border: none; border-radius: 10px;">Envoyer</button>
>>>>>>> feature/page_detail_vehicule
          <!--Fin formulaire-->
        </form>

      </div>
      <div class="box_body_formulaire-connexion_2">
        <p>
        <h1>Connecté vous</h1>
        </p>
      </div>
    </div>



  </div>

<<<<<<< HEAD
=======
  <div class="box_body">
    <div class="gallery">
      <div class="card">
        <img src="voiture 1.png" alt="">
        <p>Ceci est un petit texte sous l'image 0</p>
      </div>

      <div class="card">
        <img src="voiture 2.png" alt="">
        <p>Ceci est un petit texte sous l'image 1</p>
      </div>

      <div class="card">
        <img src="voiture 2.png" alt="">
        <p>Ceci est un petit texte sous l'image 1</p>
      </div>
      <div class="card">
        <img src="voiture 2.png" alt="">
        <p>Ceci est un petit texte sous l'image 1</p>
      </div>
      <div class="card">
        <img src="voiture 2.png" alt="">
        <p>Ceci est un petit texte sous l'image 1</p>
      </div>
      <div class="card">
        <img src="voiture 2.png" alt="">
        <p>Ceci est un petit texte sous l'image 1</p>
      </div>
    </div>
  </div>

>>>>>>> feature/page_detail_vehicule
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