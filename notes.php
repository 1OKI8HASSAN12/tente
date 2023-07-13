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
        h1{
            text-align:center;
            margin-top:30px;
        }
        /* Styles pour le tableau des notes */
table {
  width: 50%;
  margin: 20px auto;
  border-collapse: collapse;
}

table th,
table td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
  border-right: 1px solid #ddd;
}

table th {
  background-color: #f2f2f2;
}

table tr:nth-child(even) {
  background-color: #f9f9f9;
}

table tr:hover {
  background-color: #f5f5f5;
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
        top: 60%;
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
                <a href="bienvenue.php" class="text-xl hover:text-cyan-500 duration-500 text-white">profil</a> <!-- Ajout de la classe text-white -->
            </li>
            <li class="mx-4 my-6 md:my-0">
                <a href="authentification.php" class="text-xl hover:text-cyan-500 duration-500 text-white">deconnexion</a> <!-- Ajout de la classe text-white -->
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

    
            // Récupérer les notes de l'étudiant
            $notes = $connexion->prepare("SELECT * FROM notes WHERE etudiant_id = :etudiantId");
            $notes->bindParam(':etudiantId', $etudiantId);
            $notes->execute();
    
            // Afficher les notes de l'étudiant
            echo "<h1>Mes notes - $etudiantNom $etudiantPrenom</h1>";
            
            if ($notes->rowCount() > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>Cours</th>";
                echo "<th>Note</th>";
                echo "<th>Note d'examen</th>";
                echo "</tr>";
                while ($note = $notes->fetch()) {
                    $coursId = $note['cours_id'];
                    $cours = $connexion->prepare("SELECT nom FROM cours WHERE id = :coursId");
                    $cours->bindParam(':coursId', $coursId);
                    $cours->execute();
                    $coursName = $cours->fetchColumn();
    
                    echo "<tr>";
                    echo "<td>{$coursName}</td>";
                    echo "<td>{$note['note']}</td>";
                    echo "<td>{$note['note_examen']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Aucune note disponible.</p>";
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
