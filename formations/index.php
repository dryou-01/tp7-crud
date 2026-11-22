<?php require_once '../database/connexion.php'; ?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><title>Formations</title>
<link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<header><a href="../index.php">Accueil</a><a href="../formations/index.php">Formations</a><a href="../etudiants/index.php">Étudiants</a><a href="../modules/index.php">Modules</a></header>
<main>
<h1>Liste des formations</h1>
<?php if (isset($_GET['erreur'])): ?><div class="erreur"><?= h($_GET['erreur']) ?></div><?php endif; ?>
<a class="btn" href="create.php">+ Ajouter une formation</a>
<?php
$formations = $pdo->query("
    SELECT f.*,
        (SELECT COUNT(*) FROM etudiants e WHERE e.id_formation = f.id_formation) AS nb_etudiants,
        (SELECT COUNT(*) FROM modules m WHERE m.id_formation = f.id_formation) AS nb_modules
    FROM formations f ORDER BY f.id_formation
")->fetchAll(PDO::FETCH_ASSOC);
?>
<table>
<tr><th>ID</th><th>Titre</th><th>Durée (mois)</th><th>Étudiants</th><th>Modules</th><th>Actions</th></tr>
<?php foreach ($formations as $f): ?>
<tr>
  <td><?= $f['id_formation'] ?></td>
  <td><?= h($f['titre']) ?></td>
  <td><?= $f['duree_mois'] ?></td>
  <td><?= $f['nb_etudiants'] ?></td>
  <td><?= $f['nb_modules'] ?></td>
  <td>
    <a class="btn btn-edit" href="edit.php?id=<?= $f['id_formation'] ?>">Modifier</a>
    <a class="btn btn-del" href="delete.php?id=<?= $f['id_formation'] ?>" onclick="return confirm('Supprimer cette formation (et ses modules) ?')">Supprimer</a>
  </td>
</tr>
<?php endforeach; ?>
<?php if (!$formations): ?><tr><td colspan="6">Aucune formation.</td></tr><?php endif; ?>
</table>
</main></body></html>
