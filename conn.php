<?php
// Informations de connexion
$host = 'localhost';
$dbname = 'g_bibio';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie !";
} catch (PDOException $e) {
    // Gestion des erreurs
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
