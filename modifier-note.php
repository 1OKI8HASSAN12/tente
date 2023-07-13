<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <style>
       .navbar {
            overflow: hidden;
            background-color: black;
        }
        
        .navbar a {
            float: left;
            color: #fff;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
            border: none;
        }
        
        .navbar a:hover {
            background-color: #333;
            color: black;
        }
        .icon-link {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            color: #4CAF50;
            text-decoration: none;
            margin-bottom: 10px;
            margin-top:20px;
        }

        .icon-link i {
            margin-right: 5px;
         }
       
    </style>
</head>
<body>
    <!-- Navbar -->
<nav class="navbar p-5 bg-black shadow md:flex md:items-center md:justify-between">
        <div class="flex justify-between items-center">
            <span class="text-2xl font-[Poppins] cursor-pointer text-white">
                Toumai
            </span>
        
            <span class="text-3xl cursor-pointer mx-2 md:hidden block text-white"> <!-- Ajout de la classe text-white -->
                <ion-icon name="menu" onclick="Menu(this)"></ion-icon>
            </span>
        </div>
        
        <ul class="md:flex md:items-center z-[-1] md:z-auto md:static absolute bg-black w-full left-0 md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 opacity-0 top-[-400px] transition-all ease-in duration-500">
            <li class="mx-4 my-6 md:my-0">
                <a href="evaluation.php" class="text-xl hover:text-cyan-500 duration-500 text-white">profil</a> <!-- Ajout de la classe text-white -->
            </li>
            <li class="mx-4 my-6 md:my-0">
                <a href="authentification.php" class="text-xl hover:text-cyan-500 duration-500 text-white">deconnexion</a> <!-- Ajout de la classe text-white -->
            </li>
            
        </ul>
    </nav>
<!-- Connexion à la base de données -->
<?php
$connexion = new PDO("mysql:host=localhost;dbname=notres", "root", "");
?>

<!-- Vérification de la présence des ID de l'étudiant et du cours dans l'URL -->
<?php if (isset($_GET['etudiantId'], $_GET['coursId'])): ?>
    <?php
    $etudiantId = $_GET['etudiantId'];
    $coursId = $_GET['coursId'];

    // Récupération des informations sur l'étudiant
    $etudiant = $connexion->prepare("SELECT * FROM Etudiants WHERE id = :etudiantId");
    $etudiant->bindParam(':etudiantId', $etudiantId);
    $etudiant->execute();

    if ($etudiant->rowCount() > 0):
        $etudiantInfo = $etudiant->fetch();
        $etudiantNom = $etudiantInfo['nom'];
        $etudiantPrenom = $etudiantInfo['prenom'];

        // Récupération des informations sur le cours
        $cours = $connexion->prepare("SELECT * FROM Cours WHERE id = :coursId");
        $cours->bindParam(':coursId', $coursId);
        $cours->execute();

        if ($cours->rowCount() > 0):
            $coursInfo = $cours->fetch();
            $coursNom = $coursInfo['nom'];
            ?>
            <style>
                

table {
  margin: 20px auto;
  border-collapse: collapse;
  width: 60%; /* Agrandir la table */
}

th,
td {
  padding: 8px;
  border: 1px solid #ccc;
}

th {
  background-color: #333;
  color: #fff;
}

td {
  text-align: center;
}

a {
  text-decoration: none;
}
                .button {
                    background-color: black;
                    color: white;
                    padding: 8px 16px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 20px;
                    width:30%;
                    margin: 20px auto;
                    cursor: pointer;
                    border-radius: 4px;
                    position:absolute;
                    left:36%;
                    
                }
                .button:hover {
                    background-color: black;
                }
                
                .retour-button {
        background-color: black;
         color: #fff; 
         font-size: 30px;
         
          border-radius: 20px;
           text-decoration: none;
            padding: 10px 20px;
             border: none; 
             
}

.retour-button:hover {
  background-color: black;
}
@media screen and (min-width: 768px) {
    .retour-button {
        position: absolute;
        top: 18%;
        left: 0%;
    }
}

@media screen and (max-width: 767px) {
    .retour-button {
        width:30%;
        position: absolute;
        top: 40%;
        left: 36%;

    }
}
.success-message {
  text-align: center;
  margin-top: ;
  font-size: 18px;
  color: green;
}
            </style>
<a href='etudiants.php?etudiantId=<?php echo $etudiantId; ?>'>
    <button class="retour-button">Retour</button>
</a>


            <!-- Affichage du titre de la page -->
            <h1>Modifier la note de l'étudiant <?php echo $etudiantNom . ' ' . $etudiantPrenom; ?> pour le cours <?php echo $coursNom; ?></h1>

            <!-- Vérification si le formulaire de modification de note a été soumis -->
            <?php if (isset($_POST['note'], $_POST['note_examen'])): ?>
                <?php
                $note = $_POST['note'];
                $noteExamen = $_POST['note_examen'];

                // Mise à jour de la note dans la base de données
                $updateNote = $connexion->prepare("UPDATE Notes SET note = :note, note_examen = :noteExamen WHERE etudiant_id = :etudiantId AND cours_id = :coursId");
                $updateNote->bindParam(':note', $note);
                $updateNote->bindParam(':noteExamen', $noteExamen);
                $updateNote->bindParam(':etudiantId', $etudiantId);
                $updateNote->bindParam(':coursId', $coursId);
                $updateNote->execute();

                echo "<div class='success-message'>Les notes ont été enregistrées avec succès.</div>";
                ?>
            <?php endif; ?>

            <!-- Récupération de la note actuelle de l'étudiant pour le cours -->
            <?php
            $noteActuelle = $connexion->prepare("SELECT note, note_examen FROM Notes WHERE etudiant_id = :etudiantId AND cours_id = :coursId");
            $noteActuelle->bindParam(':etudiantId', $etudiantId);
            $noteActuelle->bindParam(':coursId', $coursId);
            $noteActuelle->execute();

            if ($noteActuelle->rowCount() > 0):
                $noteInfo = $noteActuelle->fetch();
                $noteValue = $noteInfo['note'];
                $noteExamenValue = $noteInfo['note_examen'];
                ?>

                <!-- Affichage du formulaire de modification de note -->
                <form method='POST'>
                    <table>
                        <tr>
                            <th>Cours</th>
                            <th>Note</th>
                            <th>Note Examen</th>
                        </tr>
                        <tr>
                            <td><?php echo $coursNom; ?></td>
                            <td><input type='number' name='note' value='<?php echo $noteValue; ?>' placeholder='Note' required></td>
                            <td><input type='number' name='note_examen' value='<?php echo $noteExamenValue; ?>' placeholder='Note Examen' required></td>
                        </tr>
                    </table>
                    <br>
                    <input type='submit' class='button' value='Enregistrer'>
                </form>

            <?php else: ?>
                Aucune note enregistrée pour cet étudiant et ce cours.
            <?php endif; ?>

        <?php else: ?>
            Le cours sélectionné n'existe pas.
        <?php endif; ?>

    <?php else: ?>
        L'étudiant sélectionné n'existe pas.
    <?php endif; ?>

<?php else: ?>
    Aucun étudiant ou cours sélectionné.
<?php endif; ?>

<script>
        function Menu(e){
            let list = document.querySelector('ul');
            e.name === 'menu' ? (e.name = "close",list.classList.add('top-[80px]') , list.classList.add('opacity-100')) :( e.name = "menu" ,list.classList.remove('top-[80px]'),list.classList.remove('opacity-100'))
        }
    </script>
</body>
</html>
