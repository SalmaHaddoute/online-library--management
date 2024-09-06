<?php
require('conn.php');

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $password = $_POST['password'];
    $add = "INSERT INTO admins (first_name, last_name, email, telephone, password) VALUES ('$fname', '$lname', '$email', '$telephone', '$password')";

    // Exécution de la requête
    if ($conn->exec($add)) {
        header("Location: newacc.php");
        exit;
    } else {
        echo '<div class="alert alert-danger" role="alert">
            <strong>Erreur :</strong> Une erreur est survenue lors de l\'insertion des données.
        </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>new account</title>
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
<form action="" method="post">
    <h3>Create Here</h3>
    <!-- nom -->
    <label for="fname">First Name</label>
    <input type="text" name="fname" placeholder="Enter your first name" id="fname">
    <!-- prenom -->
    <label for="lname">Last Name</label>
    <input type="text" name="lname" placeholder="Enter your last name" id="lname">
    <!-- email -->
    <label for="email">Email</label>
    <input type="text" name="email" placeholder="email@gmail.com" id="email">
    <!-- telephone -->
    <label for="tel">Telephone</label>
    <input type="number" name="telephone" placeholder="00 00 00 00 00" id="telephone">
    <!-- pays -->
    <label for="password">Password</label>
    <input type="password" name="password" placeholder="Your pass" id="password">
    <button type="submit" name="submit">Create</button>
</form>
</body>
</html>
