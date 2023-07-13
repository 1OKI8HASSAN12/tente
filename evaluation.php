<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
    h5{
        text-align:center;
        padding: 10px;
        
    }
    h3{
        text-align:center;
    }
    h1, h2 {
        text-align: center;
        margin-bottom: 10%;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        text-align: center;
        font-weight: bold;
        margin: 10px;
    }

    a {
        text-decoration: none;
        color: #333;
    }

    a:hover {
        color: #666;
    }

    .error {
        color: red;
    }

    .link-button {
        padding: 10px 20px;
        background-color: #333;
        color: white;
        border: none;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
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

</style>

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
            <a href="#" class="text-xl hover:text-cyan-500 duration-500 text-white"></a>

            </li>
            <li class="mx-4 my-6 md:my-0">
            
                <a href="authentification.e.php" class="text-xl hover:text-cyan-500 duration-500 text-white">Déconnexion</a> <!-- Ajout de la classe text-white -->
            </li>
            
        </ul>
    </nav>
    <?php
// Connexion à la base de données
$connexion = new PDO("mysql:host=localhost;dbname=notres", "root", "");

// Vérification de la présence de l'ID de la classe dans l'URL
if (isset($_GET['classeId'])) {
    $classeId = $_GET['classeId'];

    // Récupération des informations sur la classe
    $classe = $connexion->prepare("SELECT * FROM classes WHERE id = :classeId");
    $classe->bindParam(':classeId', $classeId);
    $classe->execute();

    if ($classe->rowCount() > 0) {
        $classeInfo = $classe->fetch();
        $nomClasse = $classeInfo['nom'];
        ?>
        <a href='ecole.php?ecole=<?php echo $classeId; ?>' class="retour-button">Retour</a>
        <h5>Classe : <?php echo $nomClasse; ?></h5>
        <?php
    }

    // Vérification du mode de l'administrateur
    if (isset($_GET['mode']) && $_GET['mode'] === 'notes') {
        // Affichage de la liste des étudiants pour remplir leurs notes
        echo "<h2>Liste des étudiants</h2>";
        $etudiants = $connexion->prepare("SELECT * FROM etudiants WHERE classe_id = :classeId");
        $etudiants->bindParam(':classeId', $classeId);
        $etudiants->execute();

        if ($etudiants->rowCount() > 0) {
            echo "<ul>";
            while ($etudiant = $etudiants->fetch()) {
                $etudiantId = $etudiant['id'];
                $etudiantNom = $etudiant['nom'];
                $etudiantPrenom = $etudiant['prenom'];
                echo "<li><a class='icon-link' href='etudiants.php?etudiantId=$etudiantId'><i class='fas fa-user'></i> $etudiantNom $etudiantPrenom</a></li>";
            }
            echo "</ul>";
        } else {
            echo "Aucun étudiant dans cette classe.";
        }
    } elseif (isset($_GET['mode']) && $_GET['mode'] === 'absences') {
        // Lien vers la page de saisie des absences des étudiants
        echo "<h3>Options</h3>";
        echo "<ul>";
        echo "<li><a class='icon-link' href='absence.php?classeId=$classeId'><i class='fas fa-calendar-alt'></i> Saisir les absences des étudiants</a></li>";
        echo "</ul>";
    } elseif (isset($_GET['mode']) && $_GET['mode'] === 'points') {
        // Lien vers la page de saisie des points de la classe (point.php)
        echo "<h3>Options</h3>";
        echo "<ul>";
        echo "<li><a class='icon-link' href='point.php?classeId=$classeId'><i class='fas fa-star'></i> Saisir les points de la classe</a></li>";
        echo "</ul>";
    } else {
        // Affichage du lien vers l'emploi du temps, la saisie des notes, la saisie des absences et la saisie des points
        echo "<h3>Options</h3>";
        echo "<ul>";
        echo "<li><a class='icon-link' href='emploi_du_temps.php?classeId=$classeId'><i class='fas fa-calendar-alt'></i> Gérer l'emploi du temps</a></li>";
        echo "<li><a class='icon-link' href='evaluation.php?classeId=$classeId&mode=notes'><i class='fas fa-edit'></i> Saisir les notes des étudiants</a></li>";
        echo "<li><a class='icon-link' href='absence.php?classeId=$classeId'><i class='fas fa-calendar-alt'></i> Saisir les absences des étudiants</a></li>";
        echo "</ul>";
    }
} else {
    // La classe avec l'ID fourni n'existe pas
    echo "La classe sélectionnée n'existe pas.";
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
