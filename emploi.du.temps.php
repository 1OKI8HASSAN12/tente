<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "notres";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $nomUtilisateur = $_POST["nom_utilisateur"];
    $motDePasse = $_POST["mot_de_passe"];

    // Requête pour vérifier les informations d'identification de l'étudiant
    $query = "SELECT * FROM etudiants WHERE nom_utilisateur = '$nomUtilisateur' AND mot_de_passe = '$motDePasse'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // L'étudiant est authentifié, récupérer ses points
        $row = $result->fetch_assoc();
        $etudiantId = $row["id"];

        $queryPoints = "SELECT heure, lundi, mardi, mercredi, jeudi, vendredi, samedi FROM points WHERE classe_id = (SELECT classe_id FROM etudiants WHERE id = $etudiantId)";
        $resultPoints = $conn->query($queryPoints);

        if ($resultPoints->num_rows > 0) {
            // Afficher les points
            echo "<h3>Points de l'étudiant :</h3>";
            echo "<table>";
            echo "<tr>";
            echo "<th>Heure</th>";
            echo "<th>Lundi</th>";
            echo "<th>Mardi</th>";
            echo "<th>Mercredi</th>";
            echo "<th>Jeudi</th>";
            echo "<th>Vendredi</th>";
            echo "<th>Samedi</th>";
            echo "</tr>";

            while ($rowPoints = $resultPoints->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $rowPoints["heure"] . "</td>";
                echo "<td>" . $rowPoints["lundi"] . "</td>";
                echo "<td>" . $rowPoints["mardi"] . "</td>";
                echo "<td>" . $rowPoints["mercredi"] . "</td>";
                echo "<td>" . $rowPoints["jeudi"] . "</td>";
                echo "<td>" . $rowPoints["vendredi"] . "</td>";
                echo "<td>" . $rowPoints["samedi"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Aucun point trouvé pour cet étudiant.";
        }
    } else {
        echo "Identifiants incorrects.";
    }
}

$conn->close();
?>


