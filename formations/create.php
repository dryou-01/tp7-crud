<?php require_once '../database/connexion.php'; ?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><title>Ajouter une formation</title>
<link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<header><a href="../index.php">Accueil</a><a href="../formations/index.php">Formations</a><a href="../etudiants/index.php">Étudiants</a><a href="../modules/index.php">Modules</a></header>
<main>
<?php
$erreur = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $duree = (int) ($_POST['duree_mois'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    if ($titre === '' || $duree <= 0) {
        $erreur = 'Le titre et une durée positive sont obligatoires.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO formations (titre, duree_mois, description) VALUES (?, ?, ?)");
        $stmt->execute([$titre, $duree, $description]);
        header('Location: index.php');
        exit;
    }
}
?>
<h1>Ajouter une formation</h1>
<?php if ($erreur): ?><div class="erreur"><?= h($erreur) ?></div><?php endif; ?>
<form method="POST">
  <label>Titre</label><input type="text" name="titre" required value="<?= h($_POST['titre'] ?? '') ?>">
  <label>Durée (mois)</label><input type="number" name="duree_mois" min="1" required value="<?= h($_POST['duree_mois'] ?? '') ?>">
  <label>Description</label><textarea name="description" rows="3"><?= h($_POST['description'] ?? '') ?></textarea>
  <br><br><button class="btn" type="submit">Enregistrer</button> <a class="btn btn-sec" href="index.php">Annuler</a>
</form>
</main></body></html>
