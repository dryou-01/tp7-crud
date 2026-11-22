<?php
$host = 'localhost';
$dbname = 'tp7_crud';
$user = 'root';
$password = ''; // XAMPP : mot de passe vide par défaut

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Échappement HTML (protection XSS)
function h($valeur)
{
    return htmlspecialchars((string) $valeur, ENT_QUOTES, 'UTF-8');
}
