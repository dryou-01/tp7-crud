<?php
require_once '../database/connexion.php';
$id = (int) ($_GET['id'] ?? 0);

// Règle : on ne supprime pas une formation qui a encore des étudiants
$stmt = $pdo->prepare("SELECT COUNT(*) FROM etudiants WHERE id_formation = ?");
$stmt->execute([$id]);
if ($stmt->fetchColumn() > 0) {
    header('Location: index.php?erreur=' . urlencode("Suppression impossible : des étudiants sont inscrits dans cette formation."));
    exit;
}

// Les modules de la formation sont supprimés automatiquement (ON DELETE CASCADE)
$stmt = $pdo->prepare("DELETE FROM formations WHERE id_formation = ?");
$stmt->execute([$id]);
header('Location: index.php');
exit;
