
<?php
session_start();

if (!isset($_SESSION['connected']) || $_SESSION['connected'] !== true) {
    header("Location: log.php");
    exit();
}

$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
body {
            background-color: #080710;
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
            left: -460px;
            top: -30px;
        }
        .shape:last-child {
            background: linear-gradient(
                to right,
                #ff512f,
                #f09819
            );
            right: -360px;
            bottom: -10px;
        }
    nav {
    padding: 1em;
    backdrop-filter: blur(10px);
    text-align: right;
    }

    nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: flex-end;
    }

    nav li {
    margin-right: 20px;
    }

    nav a {
    color: #fff;
    text-decoration: none;
    }

    nav a:hover {
    color: #ccc;
    }

    .dropdown {
    position: relative;
    }

    .dropdown-toggle {
    cursor: pointer;
    }

    .dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background-color: #333;
    border: 1px solid #444;
    padding: 10px;
    display: none;
    }

    .dropdown-menu li {
    margin-bottom: 10px;
    }

    .dropdown-menu li:last-child {
    margin-bottom: 0;
    }

    .dropdown-menu a {
    color: #fff;
    }

    .dropdown-menu a:hover {
    color: #ccc;
    }

    .dropdown:hover .dropdown-menu {
    display: block;
    }
</style>
  </head>

  <body>
  <div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>
<nav>
  <ul>
    <li><a href="home.php">Home</a></li>
    <li><a href="home.php">About us </a></li>
    <li><a href="contact.php">Contact</a></li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle">MY profil <i class="fas fa-caret-down"></i></a>
      <ul class="dropdown-menu">
        <li><a href="editacc.php">Edit profil</a></li>
        <li><a href="newbook.php">add book</a></li>
        <li><a href="log.php">Deconnecte</a></li>
      </ul>
    </li>
  </ul>
</nav>
<div style="margin-left:20% ;font-family: 'Courier New', Courier, monospace;color:#fff" class="welcome-message">
        <h2>Welcome, <?php echo $first_name . ' ' . $last_name; ?></h2>
</div>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "g_bibio";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $recuperer = "SELECT id, name, author, price, edition, type, theme FROM livres";
    $stmt = $conn->prepare($recuperer);
    $stmt->execute();

    $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table class='table' style='margin-top:6%;margin-left:6%;backdrop-filter: blur(10px); color: #ffffff; border-collapse: collapse; width: 90%;'>";
    echo "<thead style='background-color: #343a40; color: #ffffff;'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Auteur</th><th>Prix</th><th>Édition</th><th>Type</th><th>Thème</th><th>Actions</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($livres as $livre) {
        echo "<tr>";
        echo "<td style='padding: 10px;'>". htmlspecialchars($livre['id']). "</td>";
        echo "<td style='padding: 10px;'>". htmlspecialchars($livre['name']). "</td>";
        echo "<td style='padding: 10px;'>". htmlspecialchars($livre['author']). "</td>";
        echo "<td style='padding: 10px;'>". htmlspecialchars($livre['price']). "</td>";
        echo "<td style='padding: 10px;'>". htmlspecialchars($livre['edition']). "</td>";
        echo "<td style='padding: 10px;'>". htmlspecialchars($livre['type']). "</td>";
        echo "<td style='padding: 10px;'>". htmlspecialchars($livre['theme']). "</td>";
        echo "<td class='w-25' style='text-align: center;'>
        <form method='GET' action='edit.php' style='display:inline-block;'>
            <input type='hidden' name='id' value='". htmlspecialchars($livre['id']). "'>
            <button type='submit' name='action' value='edit' style='background-color:#1845ad; color: #ffffff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; height: 25px; font-size: 12px; margin: 0 5px;'><i class='bx bxs-edit-alt'></i>Modifier</button>
        </form>
        <form method='POST' action='delate.php' style='display:inline-block;'>
            <input type='hidden' name='id' value='". htmlspecialchars($livre['id']). "'>
            <button type='submit' name='action' value='delete' style='background-color: #ff512f; color: #ffffff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; height: 25px; font-size: 12px; margin: 0 5px;'><i class='bx bx-message-square-x'></i>Supprimer</button>
        </form>
    </td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

} catch(PDOException $e) {
    echo "Erreur: ". $e->getMessage();
}
$conn = null;
?>
</body>
</html>