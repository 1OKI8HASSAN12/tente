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
        h1{
            text-align:center;
            margin-top:30px;
        }
    /* Styles pour la table */
    table {
        width: 50%;
        margin: 90px auto; /* Alignement au centre avec la marge automatique */
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        padding: 10px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    td {
        font-size: 14px;
        border-left: 1px solid #ddd; /* Ajout de trait vertical à gauche */
        border-right: 1px solid #ddd; /* Ajout de trait vertical à droite */
    }

    td:first-child {
        border-left: none; /* Suppression du trait vertical à gauche pour la première colonne */
    }

    td:last-child {
        border-right: none; /* Suppression du trait vertical à droite pour la dernière colonne */
    }

    tr:first-child td {
        border-top: 1px solid #ddd; /* Ajout de trait horizontal pour la première ligne */
    }

    td.blank-cell {
        background-color: #f8f8f8;
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
        top: 15%;
        left: 0%;
    }
}

@media screen and (max-width: 767px) {
    .retour-button {
        position: absolute;
        top: 70%;
        left: 39%;
    }
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
                <a href="bienvenue.php" class="text-xl hover:text-cyan-500 duration-500 text-white">PROFIL</a> <!-- Ajout de la classe text-white -->
            </li>
            <li class="mx-4 my-6 md:my-0">
                <a href="authentification.php" class="text-xl hover:text-cyan-500 duration-500 text-white">Déconnexion</a> <!-- Ajout de la classe text-white -->
            </li>
            
        </ul>
    </nav>
    <?php
    // Connexion à la base de données
    $connexion = new PDO("mysql:host=localhost;dbname=notres", "root", "");
    
    // Vérification de l'étudiant spécifié
    if (isset($_GET['etudiant'])) {
        $etudiantId = $_GET['etudiant'];
    
        // Récupérer les informations de l'étudiant
        $etudiant = $connexion->prepare("SELECT * FROM etudiants WHERE id = :etudiantId");
        $etudiant->bindParam(':etudiantId', $etudiantId);
        $etudiant->execute();
    
        if ($etudiant->rowCount() > 0) {
            // L'étudiant existe
            $etudiantData = $etudiant->fetch();
            $etudiantNom = $etudiantData['nom'];
            $etudiantPrenom = $etudiantData['prenom'];
            ?>
            <a href='bienvenue.php?etudiant=<?php echo $etudiantId; ?>'>
                <button class="retour-button">Retour</button>
            </a>
            <?php
        
        
    
            // Récupérer la classe de l'étudiant
            $classeId = $etudiantData['classe_id'];
    
            // Récupérer le nom de la classe
            $classe = $connexion->prepare("SELECT nom FROM classes WHERE id = :classeId");
            $classe->bindParam(':classeId', $classeId);
            $classe->execute();
    
            if ($classe->rowCount() > 0) {
                $classeNom = $classe->fetchColumn();
    
                // Récupérer l'emploi du temps de la classe
                $emploiTemps = $connexion->prepare("SELECT * FROM emploi_temps WHERE classe_id = :classeId");
                $emploiTemps->bindParam(':classeId', $classeId);
                $emploiTemps->execute();
    
                // Afficher l'emploi du temps de l'étudiant
                echo "<h1>Emploi du temps - $etudiantNom $etudiantPrenom </h1>";
    
                if ($emploiTemps->rowCount() > 0) {
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Heure / Jour</th>";
                    echo "<th>Lundi</th>";
                    echo "<th>Mardi</th>";
                    echo "<th>Mercredi</th>";
                    echo "<th>Jeudi</th>";
                    echo "<th>Vendredi</th>";
                    echo "<th>Samedi</th>";
                    echo "</tr>";
                    while ($row = $emploiTemps->fetch()) {
                        echo "<tr>";
                        echo "<td>{$row['heure']}</td>";
                        echo "<td>{$row['matiere_lundi']}</td>";
                        echo "<td>{$row['matiere_mardi']}</td>";
                        echo "<td>{$row['matiere_mercredi']}</td>";
                        echo "<td>{$row['matiere_jeudi']}</td>";
                        echo "<td>{$row['matiere_vendredi']}</td>";
                        echo "<td>{$row['matiere_samedi']}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Aucun emploi du temps disponible pour cette classe.</p>";
                }
            } else {
                // Erreur: Classe introuvable
                echo "Classe introuvable.";
            }
        } else {
            // Erreur: Étudiant introuvable
            echo "Étudiant introuvable.";
        }
    } else {
        // Erreur: ID d'étudiant non spécifié dans l'URL
        echo "ID d'étudiant non spécifié dans l'URL.";
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
</body>
</html>
