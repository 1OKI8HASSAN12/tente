<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
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

/* Votre CSS existant ici */
h1,
h2 {
    text-align: center;
    margin-bottom: 20%;
    font-size:170%;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

div {
    text-align: left;
    margin-bottom: 10px;
}
button .oui{
    text-align:center;
}

span {
    font-weight: bold;
}

select,
input[type="number"] {
    width: 200px;
    padding: 5px;
    margin: 5px;
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

.error {
    color: red;
}

/* Affichage des classes en flex-direction: column; */
.classes {
    display: flex;
    flex-direction: column;
    text-align: center;
    margin-top: 20px; /* Ajout d'une marge en haut */
}

.classes a {
    margin-bottom: 15px;
}
.button-container {
    text-align: center;
}

.oui {
    background-color: black;
    color: #fff;
    font-size: 18px;
    border-radius: 20px;
    text-decoration: none;
    padding: 10px 20px;
    border: none;
    position: absolute;
    top: 18%;
    left: 30%;
}

.button-link {
    color: #fff;
    text-decoration: none;
}

.button-link:hover {
    background-color: black;
}

@media screen and (min-width: 768px){
    .oui {
        left: 5%;
    }
    h1,
h2 {
    text-align: center;
    margin-bottom: 10%;
    font-size:170%;
}
}

    </style>
</head>
<body>
<nav class="navbar p-5 bg-black shadow md:flex md:items-center md:justify-between">
    <div class="flex justify-between items-center">
        <span class="text-2xl font-[Poppins] cursor-pointer text-white">
            Toumai
        </span>

        <span class="text-3xl cursor-pointer mx-2 md:hidden block text-white">
            <ion-icon name="menu" onclick="Menu(this)"></ion-icon>
        </span>
    </div>

    <ul class="md:flex md:items-center z-[-1] md:z-auto md:static absolute bg-black w-full left-0 md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 opacity-0 top-[-400px] transition-all ease-in duration-500">
        <li class="mx-4 my-6 md:my-0">
            <a href="evaluation.php?ecole=<?php echo $ecoleId; ?>" class="text-xl hover:text-cyan-500 duration-500 text-white"></a>
        </li>
        <li class="mx-4 my-6 md:my-0">
            <a href="authentification.e.php" class="text-xl hover:text-cyan-500 duration-500 text-white">Déconnexion</a>
        </li>
    </ul>
</nav>

<?php
session_start();
require_once("connexion.php");
// Vérification de la présence de l'ID de l'école dans l'URL
if (isset($_GET['ecole'])) :
    $ecoleId = $_GET['ecole'];

    // Récupération des informations sur l'école
    $ecole = $connexion->prepare("SELECT * FROM Ecoles WHERE id = :ecoleId");
    $ecole->bindParam(':ecoleId', $ecoleId);
    $ecole->execute();
    
    if ($ecole->rowCount() > 0) :
        $ecoleInfo = $ecole->fetch();
        $nomEcole = $ecoleInfo['nom'];
    ?>
        <div class="button-container">
            <button class="oui">
                <a href='#' class="button-link">Choisissez une classe</a>
            </button>
        </div>
        <h1>Bienvenue à l'école <?php echo $nomEcole; ?></h1>
    <?php
    endif;

    
    
    
    
    

        // Vérification si le formulaire de saisie des notes a été soumis
        if (isset($_POST['etudiant'], $_POST['cours'], $_POST['note'])) :
            $etudiantId = $_POST['etudiant'];
            $coursId = $_POST['cours'];
            $note = $_POST['note'];

            // Vérification si l'étudiant existe dans la table des étudiants
            $existingEtudiant = $connexion->prepare("SELECT id FROM Etudiants WHERE id = :etudiantId");
            $existingEtudiant->bindParam(':etudiantId', $etudiantId);
            $existingEtudiant->execute();

            if ($existingEtudiant->rowCount() > 0) :
                // Vérification si la note existe déjà pour cet étudiant et ce cours
                $existingNote = $connexion->prepare("SELECT id FROM Notes WHERE etudiant_id = :etudiantId AND cours_id = :coursId");
                $existingNote->bindParam(':etudiantId', $etudiantId);
                $existingNote->bindParam(':coursId', $coursId);
                $existingNote->execute();

                if ($existingNote->rowCount() > 0) :
                    // La note existe déjà, on met à jour la note existante
                    $updateNote = $connexion->prepare("UPDATE Notes SET note = :note WHERE etudiant_id = :etudiantId AND cours_id = :coursId");
                    $updateNote->bindParam(':note', $note);
                    $updateNote->bindParam(':etudiantId', $etudiantId);
                    $updateNote->bindParam(':coursId', $coursId);
                    $updateNote->execute();
                else :
                    // La note n'existe pas encore, on l'insère dans la base de données
                    $insertNote = $connexion->prepare("INSERT INTO Notes (etudiant_id, cours_id, note) VALUES (:etudiantId, :coursId, :note)");
                    $insertNote->bindParam(':etudiantId', $etudiantId);
                    $insertNote->bindParam(':coursId', $coursId);
                    $insertNote->bindParam(':note', $note);
                    $insertNote->execute();
                endif;

                echo "La note a été enregistrée avec succès.";
            else :
                echo "L'étudiant sélectionné n'existe pas.";
            endif;
        endif;

        // Fonction pour récupérer les classes d'une école donnée
        function getClasses($ecoleId, $connexion) {
            $classes = $connexion->prepare("SELECT * FROM Classes WHERE ecole_id = :ecoleId");
            $classes->bindParam(':ecoleId', $ecoleId);
            $classes->execute();
            return $classes->fetchAll(PDO::FETCH_ASSOC);
        }

        // Récupération des classes de l'école
        $classes = getClasses($ecoleId, $connexion);

        // Affichage des classes en flex-direction: column;
        ?>
        <div class='classes'>
            <?php foreach ($classes as $classe) :
                $classeId = $classe['id'];
                $classeNom = $classe['nom'];
                ?>
                <a href='evaluation.php?ecole=<?php echo $ecoleId; ?>&classeId=<?php echo $classeId; ?>'><?php echo $classeNom; ?></a>
            <?php endforeach; ?>
        </div>
        <?php

        // Récupération des étudiants de la classe sélectionnée
        if (isset($_GET['classeId'])) :
            $classeId = $_GET['classeId'];
            $etudiants = getEtudiants($classeId, $connexion);

            if (count($etudiants) > 0) :
                ?>
                <form method='POST'>
                    <select name='etudiant'>
                        <option value=''>Sélectionnez un étudiant</option>
                        <?php foreach ($etudiants as $etudiant) :
                            $etudiantId = $etudiant['id'];
                            $etudiantNom = $etudiant['nom'];
                            $etudiantPrenom = $etudiant['prenom'];
                            ?>
                            <option value='<?php echo $etudiantId; ?>'><?php echo $etudiantNom . " " . $etudiantPrenom; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <?php
                    // Récupération des cours disponibles
                    $cours = getCours($connexion);
                    ?>
                    <select name='cours'>
                        <option value=''>Sélectionnez un cours</option>
                        <?php foreach ($cours as $cour) :
                            $courId = $cour['id'];
                            $courNom = $cour['nom'];
                            ?>
                            <option value='<?php echo $courId; ?>'><?php echo $courNom; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <input type='number' name='note' placeholder='Note' required>
                    <input type='submit' value='Enregistrer'>
                </form>
                <?php
            else :
                echo "Aucun étudiant dans cette classe.";
            endif;
        endif;
    else :
        // L'école avec l'ID fourni n'existe pas
        echo "L'école sélectionnée n'existe pas.";
    endif;

    
?>

<script>
        function Menu(e){
            let list = document.querySelector('ul');
            e.name === 'menu' ? (e.name = "close",list.classList.add('top-[80px]') , list.classList.add('opacity-100')) :( e.name = "menu" ,list.classList.remove('top-[80px]'),list.classList.remove('opacity-100'))
        }
    </script>
</body>
</html>