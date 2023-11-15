<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
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
        require_once "database.php";

        if (isset($_POST["Submit"])) {
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];
            $passwordDash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();

            if (empty($fullname) || empty($email) || empty($password) || empty($passwordRepeat) || empty($passwordRepeat)) {
                array_push($errors, "All fields are required");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }
            if (strlen($password) < 8) {
                array_push($errors, "Password must be at least 8 characters long");
            }
            if ($password !== $passwordRepeat) {
                array_push($errors, "Password does not match");
            }

            $sql = "SELECT * FROM user WHERE email = '$email'";
            $result = $conn->query($sql);

            if ($result->rowCount() > 0) {
                array_push($errors, "Email already registered");

            }

            if ($password !== $passwordRepeat) {
                array_push($errors, "Password does not match");
            }

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {

                $stmt = $conn->prepare("INSERT INTO user (full_name, email, password) VALUES (:full_name, :email,
                :password)");

                // Bind parameters
                $stmt->bindParam(':full_name', $fullname);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $passwordDash);
                // Execute the query
                $success = $stmt->execute();

                if ($success) {
                    echo "
                    <div class='alert alert-success'>You are registered successfully.</div>
                    ";
                } else {
                    die("Something went wrong");
                }

            }

        }
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name:" id="">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:" id="">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:" id="">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Confirm password:"
                    id="">
            </div>
            <div class="form-btn mb-2">
                <input type="submit" class="btn btn-primary" value="Register" name="Submit">
            </div>
        </form>
        <div>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>

</html>