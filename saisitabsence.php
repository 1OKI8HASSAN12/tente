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
<?php
// Start the session
session_start();

// Rest of your code...
?>
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

    h1 {
        text-align: center;
        margin-top: 30px;
        margin-bottom:60px;
    }

    /* Styles pour le formulaire de saisie */
form {
    margin-top: 20px;
    display: flex;
    flex-direction: column; /* Ajout de la propriété pour aligner les champs en colonne */
    align-items: center;
    margin-bottom: 50px;
    color:black;
    background-color: transparent; /* Ajout de la propriété pour rendre le formulaire transparent */
}

input[type="text"],
input[type="date"] {
    margin-bottom: 20px; /* Augmentation de la marge pour plus d'espace entre les champs */
    padding: 10px; /* Augmentation de la taille du padding pour un aspect plus spacieux */
    background-color:#ccc;
    width: 300px; /* Augmentation de la largeur des champs */
}

input[type="submit"] {
    padding: 10px 16px; /* Ajustement du padding du bouton */
    background-color: black;
    color: white;
    border: none;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

h2 {
    text-align: center;
    margin-bottom: 30px;
}

    /* Styles pour le tableau des absences */
    table {
        margin-top: 15px;
        border-collapse: collapse;
        width: 100%;
        width: 800px; /* Augmenter la largeur de la table */
        margin: 0 auto; /* Aligner la table au centre */
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
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
        top: 12%;
        left: 0%;
    }
    table{
        width:100%;
    }
    
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
                <a href="evaluation.php" class="text-xl hover:text-cyan-500 duration-500 text-white">profil</a> <!-- Ajout de la classe text-white -->
            </li>
            <li class="mx-4 my-6 md:my-0">
                <a href="authentification.php" class="text-xl hover:text-cyan-500 duration-500 text-white">deconnexion</a> <!-- Ajout de la classe text-white -->
            </li>
            
        </ul>
    </nav>
    <?php
require_once("connexion.php");

// Vérification de la présence des paramètres dans l'URL
if (isset($_GET['etudiantId']) && isset($_GET['classeId'])) {
    $etudiantId = $_GET['etudiantId'];
    $classeId = $_GET['classeId'];

    // Récupération des informations sur l'étudiant
    $etudiant = $connexion->prepare("SELECT * FROM etudiants WHERE id = :etudiantId");
    $etudiant->bindParam(':etudiantId', $etudiantId);
    $etudiant->execute();

    if ($etudiant->rowCount() > 0) {
        $etudiantInfo = $etudiant->fetch();
        $etudiantNom = $etudiantInfo['nom'];
        $etudiantPrenom = $etudiantInfo['prenom'];
        ?>
        <button class="retour-button"><a href='evaluation.php?classeId=<?php echo $classeId; ?>' class="button-link">Retour</a></button>
        <h1>Saisie de l'absence de <?php echo $etudiantNom . " " . $etudiantPrenom; ?></h1>
        <form method='POST'>
            <input type='hidden' name='etudiantId' value='<?php echo $etudiantId; ?>'>
            <input type='hidden' name='classeId' value='<?php echo $classeId; ?>'>
            <input type='text' name='heure' placeholder='Heure' required>
            <input type='date' name='date' required>
            <input type='text' name='motif' placeholder='Motif'>
            <input type='submit' value='Enregistrer'>
        </form>
        <?php

        // Vérification si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $etudiantId = isset($_POST['etudiantId']) ? $_POST['etudiantId'] : null;
            $classeId = isset($_POST['classeId']) ? $_POST['classeId'] : null;
            $heure = isset($_POST['heure']) ? $_POST['heure'] : null;
            $date = isset($_POST['date']) ? $_POST['date'] : null;
            $motif = isset($_POST['motif']) ? $_POST['motif'] : null;
        
          
        

            // Insertion de l'absence dans la base de données
            $insertAbsence = $connexion->prepare("INSERT INTO absence (heure, etudiant_id, classe_id, date_absence, motif) VALUES (:heure, :etudiantId, :classeId, :dateAbsence, :motif)");
            $insertAbsence->bindParam(':heure', $heure);
            $insertAbsence->bindParam(':etudiantId', $etudiantId);
            $insertAbsence->bindParam(':classeId', $classeId);
            $insertAbsence->bindParam(':dateAbsence', $date);
            $insertAbsence->bindParam(':motif', $motif);
            $insertAbsence->execute();

            echo "L'absence a été enregistrée avec succès.";
        }

        // Affichage des absences de l'étudiant
        $absences = $connexion->prepare("SELECT heure, date_absence, motif, id FROM absence WHERE etudiant_id = :etudiantId");
        $absences->bindParam(':etudiantId', $etudiantId);
        $absences->execute();

        if ($absences->rowCount() > 0) {
            ?>
            <h2>Absences de <?php echo $etudiantNom . " " . $etudiantPrenom; ?></h2>
            <table>
                <tr>
                    <th>Heure</th>
                    <th>Date</th>
                    <th>Motif</th>
                    <th>Action</th>
                </tr>
                <?php while ($absence = $absences->fetch()) : ?>
                    <tr>
                        <td><?php echo $absence['heure']; ?></td>
                        <td><?php echo $absence['date_absence']; ?></td>
                        <td><?php echo $absence['motif']; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="absenceId" value="<?php echo $absence['id']; ?>">
                                <input type="submit" value="Supprimer" class="delete-button">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <?php
        } else {
            echo "Aucune absence enregistrée pour le moment.";
        }

        // Code de suppression
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['absenceId'])) {
            $absenceId = $_POST['absenceId'];

            // Suppression de l'absence correspondante dans la base de données
            $supprimerAbsence = $connexion->prepare("DELETE FROM absence WHERE id = :absenceId");
            $supprimerAbsence->bindParam(':absenceId', $absenceId);
            $supprimerAbsence->execute();

            echo "L'absence a été supprimée avec succès.";
        }
    } else {
        echo "Étudiant introuvable.";
    }
} else {
    echo "Paramètres invalides.";
}
?>

<script>
        function Menu(e){
            let list = document.querySelector('ul');
            e.name === 'menu' ? (e.name = "close",list.classList.add('top-[80px]') , list.classList.add('opacity-100')) :( e.name = "menu" ,list.classList.remove('top-[80px]'),list.classList.remove('opacity-100'))
        }
    </script>