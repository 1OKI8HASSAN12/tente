<?php
// Connexion à la base de données
$connexion = new PDO("mysql:host=localhost;dbname=notres", "root", "");

// Vérifier si l'étudiant est connecté avec le paramètre "etudiant" dans l'URL
if (isset($_GET['etudiant'])) {
    $etudiantId = $_GET['etudiant'];

    // Récupération des informations sur l'étudiant
    $etudiant = $connexion->prepare("SELECT * FROM etudiants WHERE id = :etudiantId");
    $etudiant->bindParam(':etudiantId', $etudiantId);
    $etudiant->execute();

    if ($etudiant->rowCount() > 0) {
        // L'étudiant est connecté
        $etudiantData = $etudiant->fetch();
        $etudiantNom = $etudiantData['nom'];
        $etudiantPrenom = $etudiantData['prenom'];

        echo "<a href='bienvenue.php?etudiant=$etudiantId'>Retour</a>";
        echo "<h1>Absences de $etudiantNom $etudiantPrenom</h1>";

        // Récupération des absences de l'étudiant
        $absences = $connexion->prepare("SELECT heure, date_absence, motif FROM absence WHERE etudiant_id = :etudiantId");
        $absences->bindParam(':etudiantId', $etudiantId);
        $absences->execute();

        if ($absences->rowCount() > 0) {
            echo "<table>";
            echo "<tr><th>Heure</th><th>Date</th><th>Motif</th></tr>";
            while ($absence = $absences->fetch()) {
                echo "<tr>";
                echo "<td>".$absence['heure']."</td>";
                echo "<td>".$absence['date_absence']."</td>";
                echo "<td>".$absence['motif']."</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Aucune absence enregistrée pour le moment.";
        }
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

