<?php
// Connexion à la base de données
$connexion = new PDO("mysql:host=localhost;dbname=notres", "root", "");

// Vérification de la présence de l'ID de l'étudiant dans l'URL
if (isset($_GET['etudiantId'])) {
    $etudiantId = $_GET['etudiantId'];

    // Récupération des informations sur l'étudiant
    $etudiant = $connexion->prepare("SELECT * FROM Etudiants WHERE id = :etudiantId");
    $etudiant->bindParam(':etudiantId', $etudiantId);
    $etudiant->execute();

    if ($etudiant->rowCount() > 0) {
        $etudiantInfo = $etudiant->fetch();
        $etudiantNom = $etudiantInfo['nom'];
        $etudiantPrenom = $etudiantInfo['prenom'];

        // Affichage des informations sur l'étudiant
        echo "<h1>Étudiant : $etudiantNom $etudiantPrenom</h1>";
        echo "<a href='evaluation.php?ecole=1&classeId=$etudiantId'>Retour</a>";
        // Vérification si le formulaire de saisie des notes a été soumis
        if (isset($_POST['cours'], $_POST['note'], $_POST['note_examen'])) {
            $coursId = $_POST['cours'];
            $note = $_POST['note'];
            $noteExamen = $_POST['note_examen'];

            // Vérification si le cours existe dans la table des cours
            $existingCours = $connexion->prepare("SELECT id FROM Cours WHERE id = :coursId");
            $existingCours->bindParam(':coursId', $coursId);
            $existingCours->execute();

            if ($existingCours->rowCount() > 0) {
                // Vérification si la note existe déjà pour cet étudiant et ce cours
                $existingNote = $connexion->prepare("SELECT id FROM Notes WHERE etudiant_id = :etudiantId AND cours_id = :coursId");
                $existingNote->bindParam(':etudiantId', $etudiantId);
                $existingNote->bindParam(':coursId', $coursId);
                $existingNote->execute();

                if ($existingNote->rowCount() > 0) {
                    // La note existe déjà, on met à jour la note existante
                    $updateNote = $connexion->prepare("UPDATE Notes SET note = :note, note_examen = :noteExamen WHERE etudiant_id = :etudiantId AND cours_id = :coursId");
                    $updateNote->bindParam(':note', $note);
                    $updateNote->bindParam(':noteExamen', $noteExamen);
                    $updateNote->bindParam(':etudiantId', $etudiantId);
                    $updateNote->bindParam(':coursId', $coursId);
                    $updateNote->execute();
                } else {
                    // La note n'existe pas encore, on l'insère dans la base de données
                    $insertNote = $connexion->prepare("INSERT INTO Notes (etudiant_id, cours_id, note, note_examen) VALUES (:etudiantId, :coursId, :note, :noteExamen)");
                    $insertNote->bindParam(':etudiantId', $etudiantId);
                    $insertNote->bindParam(':coursId', $coursId);
                    $insertNote->bindParam(':note', $note);
                    $insertNote->bindParam(':noteExamen', $noteExamen);
                    $insertNote->execute();
                }

                echo "Les notes ont été enregistrées avec succès.";
            } else {
                echo "Le cours sélectionné n'existe pas.";
            }
        }

        // Fonction pour récupérer les cours disponibles
        function getCours($connexion) {
            $cours = $connexion->query("SELECT * FROM Cours")->fetchAll(PDO::FETCH_ASSOC);
            return $cours;
        }

        // Récupération des cours disponibles
        $cours = getCours($connexion);

        if (count($cours) > 0) {
            echo "<form method='POST'>";
            echo "<select name='cours'>";
            echo "<option value=''>Sélectionnez un cours</option>";
            foreach ($cours as $cour) {
                $courId = $cour['id'];
                $courNom = $cour['nom'];
                echo "<option value='$courId'>$courNom</option>";
            }
            echo "</select>";

            echo "<input type='number' name='note' placeholder='Note' required>";
            echo "<input type='number' name='note_examen' placeholder='Note Examen' required>";
            echo "<input type='submit' value='Enregistrer'>";
            echo "</form>";

            // Affichage de la table des notes de l'étudiant
            echo "<h2>Table des notes</h2>";
            $notes = $connexion->prepare("SELECT Cours.id AS cours_id, Cours.nom AS cours_nom, Notes.note, Notes.note_examen FROM Notes INNER JOIN Cours ON Notes.cours_id = Cours.id WHERE Notes.etudiant_id = :etudiantId");
            $notes->bindParam(':etudiantId', $etudiantId);
            $notes->execute();

            if ($notes->rowCount() > 0) {
                echo "<form method='POST' action='enregistrer-notes.php'>";
                echo "<table>";
                echo "<tr><th>Cours</th><th>Note</th><th>Note Examen</th><th>Actions</th></tr>";
                while ($note = $notes->fetch()) {
                    $coursId = $note['cours_id'];
                    $coursNom = $note['cours_nom'];
                    $noteValue = $note['note'];
                    $noteExamenValue = $note['note_examen'];
                    echo "<tr>";
                    echo "<td>$coursNom</td>";
                    echo "<td><input type='number' name='note_$coursId' value='$noteValue'></td>";
                    echo "<td><input type='number' name='note_examen_$coursId' value='$noteExamenValue'></td>";
                    echo "<td>";
                    echo "<a href='effacer-note.php?etudiantId=$etudiantId&coursId=$coursId'>Effacer</a>";
                    echo "</td>";
                    echo "</tr>";
                 }
                echo "</table>";
                echo "<input type='hidden' name='etudiantId' value='$etudiantId'>";
                echo "<input type='submit' value='Enregistrer les notes'>";
                echo "</form>";
            } else {
                echo "Aucune note enregistrée pour cet étudiant.";
            }
        } else {
            echo "Aucun cours disponible.";
        }

    } else {
        // L'étudiant avec l'ID fourni n'existe pas
        echo "L'étudiant sélectionné n'existe pas.";
    }
} else {
    // L'ID de l'étudiant n'a pas été fourni dans l'URL
    echo "Aucun étudiant sélectionné.";
}
?>
