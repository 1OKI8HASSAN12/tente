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
        h2{
            text-align:center;
            margin-bottom:20px;
           
        }
        .classe-title {
    text-align: center;
    font-size: 24px;
    color: #333;
    margin-top: 20px;
    margin-bottom:45px;
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
        <button class="retour-button"><a href='evaluation.php?classeId=<?php echo $classeId; ?>' class="button-link">Retour</a></button>
        <h1 class="classe-title">Classe : <?php echo $nomClasse; ?></h1>
        <?php
    }
    
    // Récupération des étudiants de la classe
    $etudiants = $connexion->prepare("SELECT * FROM etudiants WHERE classe_id = :classeId");
    $etudiants->bindParam(':classeId', $classeId);
    $etudiants->execute();

    if ($etudiants->rowCount() > 0) {
        ?>
        <h2>Liste des étudiants</h2>
        <ul style="display: flex; flex-direction:column; justify-content: center; align-items: center;">
            <?php while ($etudiant = $etudiants->fetch()) :
                $etudiantId = $etudiant['id'];
                $etudiantNom = $etudiant['nom'];
                $etudiantPrenom = $etudiant['prenom'];
                ?>
                <li>
                    <a href='saisitabsence.php?etudiantId=<?php echo $etudiantId; ?>&classeId=<?php echo $classeId; ?>'>
                        <?php echo $etudiantNom . " " . $etudiantPrenom; ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
        <?php
    } else {
        echo "Aucun étudiant dans cette classe.";
    }
} else {
    echo "Classe introuvable.";
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