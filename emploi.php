<?php require_once("connexion.php"); ?>

<?php
// Vérifier si la classe ID est passé en tant que paramètre GET
if (isset($_GET['classe_id'])) {
    $classeId = $_GET['classe_id'];

    // Récupérer les informations de la classe
    $requeteClasse = $connexion->prepare("SELECT nom FROM classes WHERE id = :classe_id");
    $requeteClasse->bindParam(':classe_id', $classeId, PDO::PARAM_INT);
    $requeteClasse->execute();
    $classe = $requeteClasse->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Saisir Emploi du Temps</title>
</head>
<body>
    <!-- Navbar -->
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
                <a href="evaluation.php" class="text-xl hover:text-cyan-500 duration-500 text-white">profil</a>
            </li>
            <li class="mx-4 my-6 md:my-0">
                <a href="authentification.php" class="text-xl hover:text-cyan-500 duration-500 text-white">deconnexion</a>
            </li>
        </ul>
    </nav>

    <h1>Saisir Emploi du Temps pour la classe <?php echo $classe['nom']; ?></h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données soumises du formulaire
        $heure = $_POST['heure'];
        $matiereLundi = $_POST['matiere_lundi'];
        $matiereMardi = $_POST['matiere_mardi'];
        $matiereMercredi = $_POST['matiere_mercredi'];
        $matiereJeudi = $_POST['matiere_jeudi'];
        $matiereVendredi = $_POST['matiere_vendredi'];
        $matiereSamedi = $_POST['matiere_samedi'];