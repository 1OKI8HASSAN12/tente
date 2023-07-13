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
        .icon-link {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            color: black;
            text-decoration: none;
            margin-bottom: 10px;
            margin-top:20px;
        }
        h1{
            position:absolute;
            top:20%;
            font-size:24px;
        }
        h2{
            position:absolute;
            top:26%;
            font-size:24px;
            margin-bottom:30px;
        }
        h3{
            position:absolute;
            top:32%;
            font-size:23px;
            
        }

        .icon-link i {
            margin-right: 5px;
        }
        @media screen and (max-width: 767px){
            h1{
            position:absolute;
            top:20%;
            left:30%;
            color:black;
            font-size:23px;
        }
        h2{
            position:absolute;
            top:26%;
            left:30%;
            color:black;
            font-size:23px;
        }
        h3{
            position:absolute;
            top:30%;
            left:34%;
            color:black;
            font-size:40px;
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
                <a href="#" class="text-xl hover:text-cyan-500 duration-500 text-white"></a> <!-- Ajout de la classe text-white -->
            </li>
            <li class="mx-4 my-6 md:my-0">
                <a href="authentification.e.php" class="text-xl hover:text-cyan-500 duration-500 text-white">Deconnexion</a> <!-- Ajout de la classe text-white -->
            </li>
            
        </ul>
    </nav>

    <?php
// Connexion à la base de données
$connexion = new PDO("mysql:host=localhost;dbname=notres", "root", "");

// Vérifier si l'étudiant est connecté avec le paramètre "etudiant" dans l'URL
if (isset($_GET['etudiant'])) {
    $etudiantId = $_GET['etudiant'];

    // Vérification dans la table Etudiants
    $etudiant = $connexion->prepare("SELECT * FROM etudiants WHERE id = :etudiantId");
    $etudiant->bindParam(':etudiantId', $etudiantId);
    $etudiant->execute();

    if ($etudiant->rowCount() > 0) {
        // L'étudiant est connecté
        $etudiantData = $etudiant->fetch();
        $etudiantNom = $etudiantData['nom'];

        // Afficher le lien vers l'emploi du temps avec icône
        echo "<h1><a class='icon-link' href='emploi_temps.php?etudiant=$etudiantId'><i class='fas fa-calendar-alt'></i>Voir l'emploi du temps</a></h1>";

        // Afficher le lien vers les notes avec icône
        echo "<h2><a class='icon-link' href='notes.php?etudiant=$etudiantId'><i class='fas fa-clipboard'></i>Voir les notes</a></h2>";

        // Afficher le lien vers les absences avec icône
        echo "<h3><a class='icon-link' href='etudiant.absence.php?etudiant=$etudiantId'><i class='fas fa-clock'></i>Voir les absences</a></h3>";
    } else {
        // Erreur: Étudiant introuvable
        echo "Étudiant introuvable.";
    }
} else {
    // Redirection vers la page d'authentification
    header("Location: authentifier.php");
    exit();
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