<?php require_once 'database/connexion.php'; ?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><title>Centre de formation</title>
<link rel="stylesheet" href="assets/css/style.css"></head>
<body>
<header><a href="index.php">Accueil</a></header>
<main>
<h1>Gestion du centre de formation</h1>
<p>Choisissez un espace de gestion :</p>
<div class="cartes">
  <div class="carte"><h2>Formations</h2><a class="btn" href="formations/index.php">Gérer les formations</a></div>
  <div class="carte"><h2>Étudiants</h2><a class="btn" href="etudiants/index.php">Gérer les étudiants</a></div>
  <div class="carte"><h2>Modules</h2><a class="btn" href="modules/index.php">Gérer les modules</a></div>
</div>
</main></body></html>
