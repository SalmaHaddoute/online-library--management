<?php
session_start();

// Vérification de la session et redirection si non connecté
if (!isset($_SESSION['connected']) || $_SESSION['connected']!== true) {
    header("Location: log.php"); // Redirige vers la page de connexion
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "g_bibio";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if first_name is set in the session
    if (!isset($_SESSION['first_name'])) {
        echo "Erreur: first_name is not set in the session";
        exit();
    }

    $first_name = $_SESSION['first_name'];

    // Récupération des informations de l'utilisateur
    $stmt = $conn->prepare("SELECT * FROM admins WHERE first_name = :first_name");
    $stmt->bindParam(':first_name', $first_name);
    $stmt->execute();
    $admins = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if admins is not empty
    if (empty($admins)) {
        echo "Erreur: no admin found with first_name $first_name";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $new_password = $_POST['password'];

        // Prépare la requête SQL pour la mise à jour
        if (!empty($new_password)) {
            $password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE admins SET first_name = :first_name, last_name = :last_name, email = :email, telephone = :telephone, password = :password WHERE first_name = :first_name");
            $stmt->bindParam(':password', $password);
        } else {
            $stmt = $conn->prepare("UPDATE admins SET first_name = :first_name, last_name = :last_name, email = :email, telephone = :telephone WHERE first_name = :first_name");
        }

        // Bind des paramètres et exécution de la requête
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->execute();

        // Redirection vers une page de confirmation ou autre
        header("Location: booktable.php?first_name=$first_name"); // Vous pouvez rediriger vers une page de profil mise à jour
        exit();
    }

} catch (PDOException $e) {
    echo "Erreur: ". $e->getMessage();
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account</title>
    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #080710;
            height: 1000px;
        }
        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }
        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }
        .shape:first-child {
            background: linear-gradient(
                #1845ad,
                #23a2f6
            );
            left: -80px;
            top: -80px;
        }
        .shape:last-child {
            background: linear-gradient(
                to right,
                #ff512f,
                #f09819
            );
            right: -60px;
            bottom: -70px;
        }
        form {
            height: 670px;
            width: 450px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            margin-top: 3%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }
        form * {
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }
        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
            font-family: 'Courier New', Courier, monospace;
        }
        label {
            display: block;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 500;
        }
        input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }
        ::placeholder {
            color: #e5e5e5;
        }
        button {
            width: 160px;
            margin-left: 90px;
            margin-top: 2%;
            height: 30px;
            background-color: white;
            color: #080710;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Courier New', Courier, monospace;
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <?php if (!empty($admins)) {?>
    <form action="editacc.php" method="post">
        <h3>Update Account</h3>
        <input type="hidden" name="first_name" value="<?php echo htmlspecialchars($admins['first_name']);?>" id="first_name" >
        <!-- Prénom -->
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($admins['first_name']);?>" id="first_name">
        <!-- Nom -->
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($admins['last_name']);?>" id="last_name">
        <!-- Email -->
        <label for="email">Email</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($admins['email']);?>" id="email">
        <!-- Téléphone -->
        <label for="telephone">Telephone</label>
        <input type="number" name="telephone" value="<?php echo htmlspecialchars($admins['telephone']);?>" id="telephone">
        <!-- Mot de passe (optionnel) -->
        <label for="password">New Password</label>
        <input type="password" name="password" placeholder="Enter new password" id="password">
        <button type="submit" name="submit">Update</button>
    </form>
<?php } else {?>
    <p>No admin found with fname <?php echo $fname;?></p>
<?php }?>