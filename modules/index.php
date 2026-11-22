<?php require_once '../database/connexion.php'; ?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><title>Modules</title>
<link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<header><a href="../index.php">Accueil</a><a href="../formations/index.php">Formations</a><a href="../etudiants/index.php">Étudiants</a><a href="../modules/index.php">Modules</a></header>
<main>
<h1>Liste des modules</h1>
<a class="btn" href="create.php">+ Ajouter un module</a>
<?php
$modules = $pdo->query("
    SELECT m.id_module, m.intitule, m.volume_horaire, f.titre AS formation
    FROM modules m
    INNER JOIN formations f ON m.id_formation = f.id_formation
    ORDER BY f.titre, m.intitule
")->fetchAll(PDO::FETCH_ASSOC);
?>
<table>
<tr><th>ID</th><th>Intitulé</th><th>Volume horaire (h)</th><th>Formation</th><th>Actions</th></tr>
<?php foreach ($modules as $m): ?>
<tr>
  <td><?= $m['id_module'] ?></td>
  <td><?= h($m['intitule']) ?></td>
  <td><?= $m['volume_horaire'] ?></td>
  <td><?= h($m['formation']) ?></td>
  <td>
    <a class="btn btn-edit" href="edit.php?id=<?= $m['id_module'] ?>">Modifier</a>
    <a class="btn btn-del" href="delete.php?id=<?= $m['id_module'] ?>" onclick="return confirm('Supprimer ce module ?')">Supprimer</a>
  </td>
</tr>
<?php endforeach; ?>
<?php if (!$modules): ?><tr><td colspan="5">Aucun module.</td></tr><?php endif; ?>
</table>
</main></body></html>
