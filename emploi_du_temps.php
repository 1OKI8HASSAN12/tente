<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
    <title>Document</title>
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
    <?php
require_once("connexion.php");

// Vérification de la présence de l'ID de la classe dans l'URL

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
        <button class="retour-button"><a href='evaluation.php?ecole=&classeId=<?php echo $classeId; ?>' class="button-link">Retour</a></button>
        <h1>Classe : <?php echo $nomClasse; ?></h1>
    <?php
    }
    

        // Affichage du formulaire de mise à jour
        echo "<h2>Vous pouvez modifier l'emploi du temps</h2>";
        $emploiTemps = $connexion->prepare("SELECT * FROM emploi_temps WHERE classe_id = :classeId");
        $emploiTemps->bindParam(':classeId', $classeId);
        $emploiTemps->execute();

        if ($emploiTemps->rowCount() > 0) {
            echo "<form method='POST'>";
            echo "<table id='emploiTable'>";
            echo "<tr><th></th>"; // Cellule vide pour le coin supérieur gauche
            echo "<th class='jourColumn'>Lundi</th>";
            echo "<th class='jourColumn'>Mardi</th>";
            echo "<th class='jourColumn'>Mercredi</th>";
            echo "<th class='jourColumn'>Jeudi</th>";
            echo "<th class='jourColumn'>Vendredi</th>";
            echo "<th class='jourColumn'>Samedi</th></tr>";
            while ($row = $emploiTemps->fetch()) {
                $id = $row['id'];
                $heure = $row['heure'];
                $matiereLundi = $row['matiere_lundi'];
                $matiereMardi = $row['matiere_mardi'];
                $matiereMercredi = $row['matiere_mercredi'];
                $matiereJeudi = $row['matiere_jeudi'];
                $matiereVendredi = $row['matiere_vendredi'];
                $matiereSamedi = $row['matiere_samedi'];

                echo "<tr id='row_$id'>";
                echo "<td>$heure</td>";
                echo "<td><input type='text' name='matiere_lundi_$id' value='$matiereLundi'></td>";
                echo "<td><input type='text' name='matiere_mardi_$id' value='$matiereMardi'></td>";
                echo "<td><input type='text' name='matiere_mercredi_$id' value='$matiereMercredi'></td>";
                echo "<td><input type='text' name='matiere_jeudi_$id' value='$matiereJeudi'></td>";
                echo "<td><input type='text' name='matiere_vendredi_$id' value='$matiereVendredi'></td>";
                echo "<td><input type='text' name='matiere_samedi_$id' value='$matiereSamedi'></td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<div style='margin-top: 10px; text-align: center;'>";
            echo "<input type='submit' value='Enregistrer' style='background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;'>";
            echo "</div>";
            echo "</form>";

            // Vérification si le formulaire a été soumis
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'matiere_lundi_') === 0) {
                        $emploiId = substr($key, strlen('matiere_lundi_'));
                        $matiere = $_POST[$key];

                        // Mise à jour de l'emploi du temps pour la colonne Lundi
                        $updateEmploi = $connexion->prepare("UPDATE emploi_temps SET matiere_lundi = :matiere WHERE id = :emploiId");
                        $updateEmploi->bindParam(':matiere', $matiere);
                        $updateEmploi->bindParam(':emploiId', $emploiId);
                        $updateEmploi->execute();
                    } elseif (strpos($key, 'matiere_mardi_') === 0) {
                        $emploiId = substr($key, strlen('matiere_mardi_'));
                        $matiere = $_POST[$key];

                        // Mise à jour de l'emploi du temps pour la colonne Mardi
                        $updateEmploi = $connexion->prepare("UPDATE emploi_temps SET matiere_mardi = :matiere WHERE id = :emploiId");
                        $updateEmploi->bindParam(':matiere', $matiere);
                        $updateEmploi->bindParam(':emploiId', $emploiId);
                        $updateEmploi->execute();
                    } elseif (strpos($key, 'matiere_mercredi_') === 0) {
                        $emploiId = substr($key, strlen('matiere_mercredi_'));
                        $matiere = $_POST[$key];

                        // Mise à jour de l'emploi du temps pour la colonne Mercredi
                        $updateEmploi = $connexion->prepare("UPDATE emploi_temps SET matiere_mercredi = :matiere WHERE id = :emploiId");
                        $updateEmploi->bindParam(':matiere', $matiere);
                        $updateEmploi->bindParam(':emploiId', $emploiId);
                        $updateEmploi->execute();
                    } elseif (strpos($key, 'matiere_jeudi_') === 0) {
                        $emploiId = substr($key, strlen('matiere_jeudi_'));
                        $matiere = $_POST[$key];

                        // Mise à jour de l'emploi du temps pour la colonne Jeudi
                        $updateEmploi = $connexion->prepare("UPDATE emploi_temps SET matiere_jeudi = :matiere WHERE id = :emploiId");
                        $updateEmploi->bindParam(':matiere', $matiere);
                        $updateEmploi->bindParam(':emploiId', $emploiId);
                        $updateEmploi->execute();
                    } elseif (strpos($key, 'matiere_vendredi_') === 0) {
                        $emploiId = substr($key, strlen('matiere_vendredi_'));
                        $matiere = $_POST[$key];

                        // Mise à jour de l'emploi du temps pour la colonne Vendredi
                        $updateEmploi = $connexion->prepare("UPDATE emploi_temps SET matiere_vendredi = :matiere WHERE id = :emploiId");
                        $updateEmploi->bindParam(':matiere', $matiere);
                        $updateEmploi->bindParam(':emploiId', $emploiId);
                        $updateEmploi->execute();
                    } elseif (strpos($key, 'matiere_samedi_') === 0) {
                        $emploiId = substr($key, strlen('matiere_samedi_'));
                        $matiere = $_POST[$key];

                        // Mise à jour de l'emploi du temps pour la colonne Samedi
                        $updateEmploi = $connexion->prepare("UPDATE emploi_temps SET matiere_samedi = :matiere WHERE id = :emploiId");
                        $updateEmploi->bindParam(':matiere', $matiere);
                        $updateEmploi->bindParam(':emploiId', $emploiId);
                        $updateEmploi->execute();
                    }
                }
            }
        } else {
            echo "Aucune donnée d'emploi du temps trouvée pour cette classe.";
        }
    } else {
        echo "Classe introuvable.";
    }

?>
<style>
    #emploiTable {
  width: 80%;
  margin-left: auto;
  margin-right: auto;
  border-collapse: collapse;
}

#emploiTable th,
#emploiTable td {
  padding: 10px;
  text-align: center;
  border: 1px solid #ccc;
}

#emploiTable th:first-child,
#emploiTable td:first-child {
  width: 20%; /* Ajustez cette valeur selon vos besoins */
}


#emploiTable th {
  background-color: #f2f2f2;
}

#emploiTable .jourColumn {
  background-color: #e6e6e6;
}

#emploiTable input[type="text"] {
  width: 100%;
  box-sizing: border-box;
  opacity: 0.8; /* Ajout de la propriété opacity pour rendre les inputs légèrement transparents */
}

/* Centrer le nom de la classe */
h1 {
    text-align: center;
}

/* Centrer le titre h2 */
h2 {
    text-align: center;
}
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
        top: 65%;
        left: 37%;
    }
    #emploiTable {
  width: 60%;
  margin-left: auto;
  margin-right: auto;
  
  border-collapse: collapse;
}

#emploiTable th,
#emploiTable td {
  padding: 10px;
  text-align: center;
  border: 1px solid #ccc;
}

#emploiTable th:first-child,
#emploiTable td:first-child {
  width: 26%; /* Ajustez cette valeur selon vos besoins */
}
}




</style>
<script>
        function Menu(e){
            let list = document.querySelector('ul');
            e.name === 'menu' ? (e.name = "close",list.classList.add('top-[80px]') , list.classList.add('opacity-100')) :( e.name = "menu" ,list.classList.remove('top-[80px]'),list.classList.remove('opacity-100'))
        }
    </script>
</body>
</html>
