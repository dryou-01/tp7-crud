<?php require_once '../database/connexion.php'; ?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><title>Modifier un étudiant</title>
<link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<header><a href="../index.php">Accueil</a><a href="../formations/index.php">Formations</a><a href="../etudiants/index.php">Étudiants</a><a href="../modules/index.php">Modules</a></header>
<main>
<?php
$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id_etudiant = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$etudiant) { header('Location: index.php'); exit; }

$formations = $pdo->query("SELECT id_formation, titre FROM formations ORDER BY titre")->fetchAll(PDO::FETCH_ASSOC);
$erreur = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $id_formation = (int) ($_POST['id_formation'] ?? 0);
    if ($nom === '' || $prenom === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $id_formation <= 0) {
        $erreur = 'Tous les champs sont obligatoires et l\'email doit être valide.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE etudiants SET nom = ?, prenom = ?, email = ?, id_formation = ? WHERE id_etudiant = ?");
            $stmt->execute([$nom, $prenom, $email, $id_formation, $id]);
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $erreur = 'Cet email existe déjà ou la formation est invalide.';
        }
    }
    $etudiant = array_merge($etudiant, ['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'id_formation' => $id_formation]);
}
?>
<h1>Modifier l'étudiant</h1>
<?php if ($erreur): ?><div class="erreur"><?= h($erreur) ?></div><?php endif; ?>
<form method="POST">
  <label>Nom</label><input type="text" name="nom" required value="<?= h($etudiant['nom']) ?>">
  <label>Prénom</label><input type="text" name="prenom" required value="<?= h($etudiant['prenom']) ?>">
  <label>Email</label><input type="email" name="email" required value="<?= h($etudiant['email']) ?>">
  <label>Formation</label>
  <select name="id_formation" required>
    <?php foreach ($formations as $f): ?>
      <option value="<?= $f['id_formation'] ?>" <?= $etudiant['id_formation'] == $f['id_formation'] ? 'selected' : '' ?>><?= h($f['titre']) ?></option>
    <?php endforeach; ?>
  </select>
  <br><br><button class="btn" type="submit">Mettre à jour</button> <a class="btn btn-sec" href="index.php">Annuler</a>
</form>
</main></body></html>
