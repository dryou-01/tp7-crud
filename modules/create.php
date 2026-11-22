<?php require_once '../database/connexion.php'; ?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><title>Ajouter un module</title>
<link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<header><a href="../index.php">Accueil</a><a href="../formations/index.php">Formations</a><a href="../etudiants/index.php">Étudiants</a><a href="../modules/index.php">Modules</a></header>
<main>
<?php
$formations = $pdo->query("SELECT id_formation, titre FROM formations ORDER BY titre")->fetchAll(PDO::FETCH_ASSOC);
$erreur = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $intitule = trim($_POST['intitule'] ?? '');
    $volume = (int) ($_POST['volume_horaire'] ?? 0);
    $id_formation = (int) ($_POST['id_formation'] ?? 0);
    if ($intitule === '' || $volume <= 0 || $id_formation <= 0) {
        $erreur = 'Tous les champs sont obligatoires (volume horaire positif).';
    } else {
        $stmt = $pdo->prepare("INSERT INTO modules (intitule, volume_horaire, id_formation) VALUES (?, ?, ?)");
        $stmt->execute([$intitule, $volume, $id_formation]);
        header('Location: index.php');
        exit;
    }
}
?>
<h1>Ajouter un module</h1>
<?php if ($erreur): ?><div class="erreur"><?= h($erreur) ?></div><?php endif; ?>
<form method="POST">
  <label>Intitulé</label><input type="text" name="intitule" required value="<?= h($_POST['intitule'] ?? '') ?>">
  <label>Volume horaire (h)</label><input type="number" name="volume_horaire" min="1" required value="<?= h($_POST['volume_horaire'] ?? '') ?>">
  <label>Formation</label>
  <select name="id_formation" required>
    <option value="">-- Choisir une formation --</option>
    <?php foreach ($formations as $f): ?>
      <option value="<?= $f['id_formation'] ?>" <?= (($_POST['id_formation'] ?? '') == $f['id_formation']) ? 'selected' : '' ?>><?= h($f['titre']) ?></option>
    <?php endforeach; ?>
  </select>
  <br><br><button class="btn" type="submit">Enregistrer</button> <a class="btn btn-sec" href="index.php">Annuler</a>
</form>
</main></body></html>
