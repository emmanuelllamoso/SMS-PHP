<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            padding-top: 50px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 50px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .form-group {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container">

        <?php

        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            require_once "database.php";

            $sql = "SELECT * FROM user WHERE email= '$email'";
            $result = $conn->query($sql);


            if ($result->rowCount() > 0) {
                $row = $result->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $row["password"])) { //check if the password matches
                    session_start();
                    $userData = array(
                        'id' => $row["id"],
                        'full_name' => $row['full_name'],
                        'phone' => $row['phone']
                    );
                    $_SESSION["user"] = $userData;
                    header("Location: index.php");
                    die();
                } else {
                    echo
                        "<div class='alert alert-danger'>Password does not match!</div>";
                }
            } else {
                echo
                    "<div class='alert alert-danger'>Email does not match</div>";
            }


        }
        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Enter Email:" id="">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Enter Password">
            </div>
            <div class="form-btn mb-2">
                <input type="submit" value="login" name="login" class="form-control btn btn-primary">
            </div>
        </form>
        <div>
            <p>Don't have account <a href="registration.php"> Register here!</a></p>
        </div>
    </div>
</body>

</html>