<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "g_bibio";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $new_password = $_POST['password'];

        // Prepare SQL statement based on whether password is provided or not
        if (!empty($new_password)) {
            $password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE admins SET fname = :fname, lname = :lname, email = :email, telephone = :telephone, password = :password WHERE id = :id");
            $stmt->bindParam(':password', $password);
        } else {
            $stmt = $conn->prepare("UPDATE admins SET fname = :fname, lname = :lname, email = :email, telephone = :telephone WHERE id = :id");
        }

        // Bind parameters and execute SQL update
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->execute();

        // Redirect to profile update success page or original page
        header("Location: booktable.php?id=$id");
        exit();
    } else {
        // Redirect if not a POST request
        header("Location: update_account.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Erreur: " . $e->getMessage();
    exit();
}?>
