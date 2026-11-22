<?php require_once '../database/connexion.php'; ?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><title>Modifier un module</title>
<link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<header><a href="../index.php">Accueil</a><a href="../formations/index.php">Formations</a><a href="../etudiants/index.php">Étudiants</a><a href="../modules/index.php">Modules</a></header>
<main>
<?php
$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM modules WHERE id_module = ?");
$stmt->execute([$id]);
$module = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$module) { header('Location: index.php'); exit; }

$formations = $pdo->query("SELECT id_formation, titre FROM formations ORDER BY titre")->fetchAll(PDO::FETCH_ASSOC);
$erreur = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $intitule = trim($_POST['intitule'] ?? '');
    $volume = (int) ($_POST['volume_horaire'] ?? 0);
    $id_formation = (int) ($_POST['id_formation'] ?? 0);
    if ($intitule === '' || $volume <= 0 || $id_formation <= 0) {
        $erreur = 'Tous les champs sont obligatoires (volume horaire positif).';
        $module = array_merge($module, ['intitule' => $intitule, 'volume_horaire' => $volume, 'id_formation' => $id_formation]);
    } else {
        $stmt = $pdo->prepare("UPDATE modules SET intitule = ?, volume_horaire = ?, id_formation = ? WHERE id_module = ?");
        $stmt->execute([$intitule, $volume, $id_formation, $id]);
        header('Location: index.php');
        exit;
    }
}
?>
<h1>Modifier le module</h1>
<?php if ($erreur): ?><div class="erreur"><?= h($erreur) ?></div><?php endif; ?>
<form method="POST">
  <label>Intitulé</label><input type="text" name="intitule" required value="<?= h($module['intitule']) ?>">
  <label>Volume horaire (h)</label><input type="number" name="volume_horaire" min="1" required value="<?= h($module['volume_horaire']) ?>">
  <label>Formation</label>
  <select name="id_formation" required>
    <?php foreach ($formations as $f): ?>
      <option value="<?= $f['id_formation'] ?>" <?= $module['id_formation'] == $f['id_formation'] ? 'selected' : '' ?>><?= h($f['titre']) ?></option>
    <?php endforeach; ?>
  </select>
  <br><br><button class="btn" type="submit">Mettre à jour</button> <a class="btn btn-sec" href="index.php">Annuler</a>
</form>
</main></body></html>
