<?php
require_once("connexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['absenceId'])) {
    $absenceId = $_POST['absenceId'];

    // Suppression de l'absence correspondante dans la base de données
    $supprimerAbsence = $connexion->prepare("DELETE FROM absence WHERE id = :absenceId");
    $supprimerAbsence->bindParam(':absenceId', $absenceId);
    $supprimerAbsence->execute();

    echo "L'absence a été supprimée avec succès.";
} else {
    echo "Erreur lors de la suppression de l'absence.";
}

if ($absences->rowCount() > 0):
    ?>
    <h2>Absences de <?php echo $etudiantNom . " " . $etudiantPrenom; ?></h2>
    <table>
        <tr>
            <th>Heure</th>
            <th>Date</th>
            <th>Motif</th>
            <th>Action</th>
        </tr>
        <?php while ($absence = $absences->fetch()): ?>
            <tr>
                <td><?php echo $absence['heure']; ?></td>
                <td><?php echo $absence['date_absence']; ?></td>
                <td><?php echo $absence['motif']; ?></td>
                <td>
                    <form method="POST" action="supprimer_absence.php">
                        <input type="hidden" name="absenceId" value="<?php echo $absence['id']; ?>">
                        <button type="submit" class="delete-button">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <?php
else:
    echo "Aucune absence enregistrée pour le moment.";
endif;
