<?php
session_start();

if (!isset($_SESSION['connected']) || $_SESSION['connected'] !== true) {
    header("Location: log.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "g_bibio";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $author = $_POST['author'];
        $price = $_POST['price'];
        $edition = $_POST['edition'];
        $type = $_POST['type'];
        $theme = $_POST['theme'];

        $stmt = $conn->prepare("UPDATE livres SET name = :name, author = :author, price = :price, edition = :edition, type = :type, theme = :theme WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':edition', $edition);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':theme', $theme);
        $stmt->execute();

        header("Location: booktable.php");
        exit();
    } else {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM livres WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $livre = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$livre) {
            header("Location: booktable.php");
            exit();
        }
    }
} catch (PDOException $e) {
    echo "Erreur: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
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
            height: 450px;
            width: 700px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
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
        .form-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 4%;
        }
        .form-group label {
            font-size: 16px;
            font-weight: 500;
            width: 48%;
        }
        .form-group input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 9px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }
        ::placeholder {
            color: #e5e5e5d3;
        }
        button {
            width: 160px;
            margin-left: 250px;
            margin-top: 5%;
            height: 55px;
            background-color: white;
            color: #080710;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Courier New', Courier, monospace;
        }
        button:hover{
            background-color: darkgray;
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="form-group">
            <label style="color:#1845ad;" for="name">Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($livre['name']); ?>" id="name">
            <label style="color:#ff512f;" for="author">Author</label>
            <input type="text" name="author" value="<?php echo htmlspecialchars($livre['author']); ?>" id="author">
        </div>
        <div class="form-group">
            <label style="color:#1845ad;" for="price">Price</label>
            <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($livre['price']); ?>" id="price">
            <label style="color:#ff512f;" for="edition">Edition</label>
            <input type="text" name="edition" value="<?php echo htmlspecialchars($livre['edition']); ?>" id="edition">
        </div>
        <div class="form-group">
            <label style="color:#1845ad;" for="type">Type</label>
            <input type="text" name="type" value="<?php echo htmlspecialchars($livre['type']); ?>" id="type">
            <label style="color:#ff512f;" for="theme">Theme</label>
            <input type="text" name="theme" value="<?php echo htmlspecialchars($livre['theme']); ?>" id="theme">
        </div>
        <button type="submit" name="action" value="update">Mettre à jour</button>
    </form>
</body>
</html>
