<?php
// Connexion à la base de données
$connexion = new PDO("mysql:host=localhost;dbname=notres", "root", "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomUtilisateur = $_POST['nom_utilisateur'];
    $motDePasse = $_POST['mot_de_passe'];

    // Vérification dans la table Etudiants
    $etudiant = $connexion->prepare("SELECT * FROM etudiants WHERE nom_utilisateur = :nomUtilisateur AND mot_de_passe = :motDePasse");
    $etudiant->bindParam(':nomUtilisateur', $nomUtilisateur);
    $etudiant->bindParam(':motDePasse', $motDePasse);
    $etudiant->execute();

    if ($etudiant->rowCount() > 0) {
        // Les informations d'identification sont valides
        $etudiantData = $etudiant->fetch();
        $etudiantId = $etudiantData['id'];
        header("Location: bienvenue.php?etudiant=$etudiantId"); // Redirection vers bienvenue.php avec le paramètre "etudiant"
        exit();
    } else {
        // Les informations d'identification sont incorrectes
        $messageErreur = "<h3> Nom d'utilisateur ou mot de passe incorrect.</h3>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Authentification Étudiant</title>
</head>

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
        h3{
            text-align:center;
        }
        h1 {
            margin-top: 20px;
            text-align:center;
        }
        form {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 55%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 70%;
    max-width: 350px;
    height: 320px;
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

form:hover {
    transform: translate(-50%, -50%) scale(1.05);
}



input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    border-radius: 3px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    margin-bottom: 10px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

input[type="submit"] {
    width: 100%;
    padding: 15px;
    border: none;
    background-color: #4CAF50;
    color: #fff;
    cursor: pointer;
    border-radius: 3px;
    font-size: 16px;
    transition: background-color 0.3s ease;
    margin-top: 10px;
}

input[type="submit"]:hover {
    background-color: #45a049;
}
h2{
    text-align:center;
    position:absolute;
    top:85%;
    left:43%;
    right: 43%;
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
                <a href="authentification.e.php" class="text-xl hover:text-cyan-500 duration-500 text-white">Administrateur</a> <!-- Ajout de la classe text-white -->
            </li>
            
        </ul>
    </nav>
    <h1>Authentification Étudiant</h1>

    <?php if (isset($messageErreur)) : ?>
        <p><?php echo $messageErreur; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="nom_utilisateur">Nom d'utilisateur :</label>
        <input type="text" name="nom_utilisateur" id="nom_utilisateur" required>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe" required>

        <input type="submit" value="Se connecter">
        
    </form>
    <h2>oki hassan  | mohammed</h2>
    <script>
        function Menu(e){
            let list = document.querySelector('ul');
            e.name === 'menu' ? (e.name = "close",list.classList.add('top-[80px]') , list.classList.add('opacity-100')) :( e.name = "menu" ,list.classList.remove('top-[80px]'),list.classList.remove('opacity-100'))
        }
    </script>
</body>
</html>
