<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>
<style>
    /* Styles pour la navbar */
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

h1,
h2 {
  margin-top: 20px;
  text-align: center;
}

form {
  margin-top: 20px;
  width: 60%; /* Agrandir le formulaire */
  margin: 0 auto; /* Centrer le formulaire */
}

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

input[type="number"],
select {
  width: 100%;
  height: 40px;
  box-sizing: border-box;
  border:1px solid #333;xxxxxx  
  padding: 5px;
  font-size: 16px;
  margin-bottom: 10Px; /* Ajouter un espace de 10 pixels en bas */
  appearance: textfield; /* Afficher l'input number comme un champ de texte */
  margin-top:%;
}

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none; /* Désactiver les boutons de défilement */
  margin: 0; /* Retirer la marge par défaut */
}

input[type="submit"] {
  width: 50%;
  height: 40px;
  box-sizing: border-box;
  padding: 5px;
  font-size: 16px;
  background-color: black; /* Couleur de fond */
  color: #fff; /* Couleur du texte */
  border: none;
  cursor: pointer;
  display: block;
  margin: 0 auto; /* Centrer le bouton */
}

input[type="submit"]:hover {
  background-color: black; /* Couleur de fond au survol */
}
.retour-button {
        background-color: black;
         color: #fff; 
         font-size: 18px;
          border-radius: 20px;
           text-decoration: none;
            padding: 10px 20px;
             border: none; 
             position:absolute;
             top:15%;
             left:%;
}

.retour-button:hover {
  background-color: black;
}
.success-message {
  text-align: center;
  margin-top: ;
  font-size: 18px;
  color: green;
}
.error-message {
  text-align: center;
  margin-top: 20px;
  font-size: 18px;
  color: red;
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
                <a href="#" class="text-xl hover:text-cyan-500 duration-500 text-white">profil</a> <!-- Ajout de la classe text-white -->
            </li>
            <li class="mx-4 my-6 md:my-0">
                <a href="authentification.e.php" class="text-xl hover:text-cyan-500 duration-500 text-white">Déconnexion</a> <!-- Ajout de la classe text-white -->
            </li>
            
        </ul>
    </nav>

    <?php
// Connexion à la base de données
$connexion = new PDO("mysql:host=localhost;dbname=notres", "root", "");

// Vérification de la présence de l'ID de l'étudiant dans l'URL
if (isset($_GET['etudiantId'])) {
    $etudiantId = $_GET['etudiantId'];

    // Récupération des informations sur l'étudiant
    $etudiant = $connexion->prepare("SELECT * FROM Etudiants WHERE id = :etudiantId");
    $etudiant->bindParam(':etudiantId', $etudiantId);
    $etudiant->execute();

    if ($etudiant->rowCount() > 0) {
        $etudiantInfo = $etudiant->fetch();
        $etudiantNom = $etudiantInfo['nom'];
        $etudiantPrenom = $etudiantInfo['prenom'];

        // Affichage des informations sur l'étudiant
        echo "<h1>Étudiant : $etudiantNom $etudiantPrenom</h1>";
        ?>
        <a href='evaluation.php?ecole=1&classeId=<?php echo $etudiantId; ?>'>
            <button class="retour-button">Retour</button>
        </a>
        <?php
    }

    // Vérification si le formulaire de saisie des notes a été soumis
    if (isset($_POST['cours'], $_POST['note'], $_POST['note_examen'])) {
        $coursId = $_POST['cours'];
        $note = $_POST['note'];
        $noteExamen = $_POST['note_examen'];

        // Vérification si le cours existe dans la table des cours
        $existingCours = $connexion->prepare("SELECT id FROM Cours WHERE id = :coursId");
        $existingCours->bindParam(':coursId', $coursId);
        $existingCours->execute();

        if ($existingCours->rowCount() > 0) {
            // Vérification si la note existe déjà pour cet étudiant et ce cours
            $existingNote = $connexion->prepare("SELECT id FROM Notes WHERE etudiant_id = :etudiantId AND cours_id = :coursId");
            $existingNote->bindParam(':etudiantId', $etudiantId);
            $existingNote->bindParam(':coursId', $coursId);
            $existingNote->execute();

            if ($existingNote->rowCount() > 0) {
                // La note existe déjà, on met à jour la note existante
                $updateNote = $connexion->prepare("UPDATE Notes SET note = :note, note_examen = :noteExamen WHERE etudiant_id = :etudiantId AND cours_id = :coursId");
                $updateNote->bindParam(':note', $note);
                $updateNote->bindParam(':noteExamen', $noteExamen);
                $updateNote->bindParam(':etudiantId', $etudiantId);
                $updateNote->bindParam(':coursId', $coursId);
                $updateNote->execute();
            } else {
                // La note n'existe pas encore, on l'insère dans la base de données
                $insertNote = $connexion->prepare("INSERT INTO Notes (etudiant_id, cours_id, note, note_examen) VALUES (:etudiantId, :coursId, :note, :noteExamen)");
                $insertNote->bindParam(':etudiantId', $etudiantId);
                $insertNote->bindParam(':coursId', $coursId);
                $insertNote->bindParam(':note', $note);
                $insertNote->bindParam(':noteExamen', $noteExamen);
                $insertNote->execute();
            }

            echo "<div class='success-message'>Les notes ont été enregistrées avec succès.</div>";

        } else {
            echo "Le cours sélectionné n'existe pas.";
        }
    }

    // Fonction pour récupérer les cours disponibles
    function getCours($connexion)
    {
        $cours = $connexion->query("SELECT * FROM Cours")->fetchAll(PDO::FETCH_ASSOC);
        return $cours;
    }

    // Récupération des cours disponibles
    $cours = getCours($connexion);

    if (count($cours) > 0) {
        ?>
        <form method='POST'>
            <select name='cours'>
                <option value=''>Sélectionnez un cours</option>
                <?php
                foreach ($cours as $cour) {
                    $courId = $cour['id'];
                    $courNom = $cour['nom'];
                    echo "<option value='$courId'>$courNom</option>";
                }
                ?>
            </select>
            <input type='number' name='note' placeholder='Note'>
            <input type='number' name='note_examen' placeholder='Note Examen'>
            <input type='submit' value='Enregistrer'>
        </form>

        <!-- Affichage de la table des notes de l'étudiant -->
        <h2>Table des notes</h2>
        <?php
        $notes = $connexion->prepare("SELECT Cours.id AS cours_id, Cours.nom AS cours_nom, Notes.note, Notes.note_examen FROM Notes INNER JOIN Cours ON Notes.cours_id = Cours.id WHERE Notes.etudiant_id = :etudiantId");
        $notes->bindParam(':etudiantId', $etudiantId);
        $notes->execute();

        if ($notes->rowCount() > 0) {
            ?>
            <table>
                <tr>
                    <th>Cours</th>
                    <th>Note</th>
                    <th>Note Examen</th>
                    <th>Actions</th>
                </tr>
                <?php
                while ($note = $notes->fetch()) {
                    $coursId = $note['cours_id'];
                    $coursNom = $note['cours_nom'];
                    $noteValue = $note['note'];
                    $noteExamenValue = $note['note_examen'];
                    echo "<tr>";
                    echo "<td>$coursNom</td>";
                    echo "<td>$noteValue</td>";
                    echo "<td>$noteExamenValue</td>";
                    echo "<td>";
                    echo "<a href='modifier-note.php?etudiantId=$etudiantId&coursId=$coursId'>Modifier</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <?php
        } else {
            echo "Aucune note enregistrée pour cet étudiant.";
        }
    } else {
        echo "Aucun cours disponible.";
    }

} else {
    // L'étudiant avec l'ID fourni n'existe pas
    echo "L'étudiant sélectionné n'existe pas.";
}
?>

<script>
        function Menu(e){
            let list = document.querySelector('ul');
            e.name === 'menu' ? (e.name = "close",list.classList.add('top-[80px]') , list.classList.add('opacity-100')) :( e.name = "menu" ,list.classList.remove('top-[80px]'),list.classList.remove('opacity-100'))
        }
    </script>
</body>
</html>
