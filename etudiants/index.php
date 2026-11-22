<?php require_once '../database/connexion.php'; ?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><title>Étudiants</title>
<link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<header><a href="../index.php">Accueil</a><a href="../formations/index.php">Formations</a><a href="../etudiants/index.php">Étudiants</a><a href="../modules/index.php">Modules</a></header>
<main>
<h1>Liste des étudiants</h1>
<a class="btn" href="create.php">+ Ajouter un étudiant</a>
<?php
$etudiants = $pdo->query("
    SELECT e.id_etudiant, e.nom, e.prenom, e.email, f.titre AS formation
    FROM etudiants e
    INNER JOIN formations f ON e.id_formation = f.id_formation
    ORDER BY e.nom, e.prenom
")->fetchAll(PDO::FETCH_ASSOC);
?>
<table>
<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Formation</th><th>Actions</th></tr>
<?php foreach ($etudiants as $e): ?>
<tr>
  <td><?= $e['id_etudiant'] ?></td>
  <td><?= h($e['nom']) ?></td>
  <td><?= h($e['prenom']) ?></td>
  <td><?= h($e['email']) ?></td>
  <td><?= h($e['formation']) ?></td>
  <td>
    <a class="btn btn-edit" href="edit.php?id=<?= $e['id_etudiant'] ?>">Modifier</a>
    <a class="btn btn-del" href="delete.php?id=<?= $e['id_etudiant'] ?>" onclick="return confirm('Supprimer cet étudiant ?')">Supprimer</a>
  </td>
</tr>
<?php endforeach; ?>
<?php if (!$etudiants): ?><tr><td colspan="6">Aucun étudiant.</td></tr><?php endif; ?>
</table>
</main></body></html>
