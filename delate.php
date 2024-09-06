<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "g_bibio";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $delete = "DELETE FROM livres WHERE id = :id";
        $stmt = $conn->prepare($delete);
        $stmt->execute([':id' => $id]);

        header("Location: booktable.php");
        exit();

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $conn = null;
}
?>
