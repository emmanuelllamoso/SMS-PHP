<?php
include 'C:\Users\Pogi\php\SMS-platform\twilio-balance\balance.php';
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}
$userData = $_SESSION['user'];
$fullName = $userData['full_name'];
$userid = $userData['id'];
$balance = $data['balance'];
$phone = "";
$successMessage = "";
$continue = false;

require_once "database.php";
$sql = "SELECT * FROM sms WHERE user_id = $userid ORDER BY id DESC";
$result = $conn->query($sql);

//Get the row count
$rowCount = $result->rowCount();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
        integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar sticky-top bg-body-tertiary">
        <div class="container-fluid">
            <div class="technology-use justify-content-start">
                <a class="navbar-brand text-bg-warning rounded-circle" style="font-weight: bolder;"
                    href="index.html">PHP-SMS</a>
                <a class="navbar-brand " href="https://getbootstrap.com/">
                    <i class="bi bi-bootstrap"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                            fill="Blue" class="bi bi-bootstrap" viewBox="0 0 16 16">
                            <path
                                d="M5.062 12h3.475c1.804 0 2.888-.908 2.888-2.396 0-1.102-.761-1.916-1.904-2.034v-.1c.832-.14 1.482-.93 1.482-1.816 0-1.3-.955-2.11-2.542-2.11H5.062V12zm1.313-4.875V4.658h1.78c.973 0 1.542.457 1.542 1.237 0 .802-.604 1.23-1.764 1.23H6.375zm0 3.762V8.162h1.822c1.236 0 1.887.463 1.887 1.348 0 .896-.627 1.377-1.811 1.377H6.375z" />
                            <path
                                d="M0 4a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v8a4 4 0 0 1-4 4H4a4 4 0 0 1-4-4V4zm4-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V4a3 3 0 0 0-3-3H4z" />
                        </svg></i>
                </a>

                <a class="navbar-brand " href="https://www.twilio.com/">
                    <img src="data:image/png;base64,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"
                        height="40" alt="twilio">
                </a>

                <a class="navbar-brand " href="https://www.php.net/">
                    <img src="data:image/png;base64,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"
                        height="40" alt="php logo">
                </a>
            </div>

            <div class="balance-credit">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <figure class="figure ">
                            <a href="/edit.php">
                                <?php
                                require_once "database.php";
                                $sql = "SELECT * FROM images WHERE user_id=$userid";
                                $profilePicture = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
                                echo "<img src='profile/$profilePicture[path]' width='100' class='figure-img img-fluid rounded-circle' alt='Profile Image'>";
                                ?>
                            </a>

                            <h3>
                                <?php echo $fullName; ?>
                            </h3>
                            <h5>Balance(USD):
                                <?php echo $balance; ?>
                            </h5>
                        </figure>
                    </div>

                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/index.php">New Message</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/inbox.php">Inbox</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sent.php">SentBox</a>
                            </li>
                        </ul>
                        <form class="d-flex mt-3" role="search">
                            <a class="btn btn-outline-danger" href="/logout.php" type="submit">Logout</a>
                        </form>
                    </div>
                </div>
            </div>

        </div>


        </div>
    </nav>

    <div class="container bg-body-secondary rounded-4 justify-content-center p-4 mt-5" style="width: 500px;">
        <div class="container">
            <h3 class="text-center mb-3">
                Inbox
            </h3>

            <div class="content-message d-flex flex-column overflow-auto ">

                <?php

                if ($rowCount == 0)
                    echo "
          <div clas='ifEmpty'>
            <p class='lead text-center'><em>Empty!</em><p/> 
          </div>";

                // read data of each row        
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "
              <div class='border border-primary rounded p-2 mb-2'>
                <div class=''>
                      <div class='number text-decoration-underline d-flex flex-row justify-content-between'>
                          <h5>$row[phone]</h5>
                          <a class='btn btn-info' href='/index.php?phone=$row[phone]'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-send' viewBox='0 0 16 16'>
                             <path d='M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z'/>
                            </svg>
                          </a>  
                      </div>
                    <div class='message-body'>
                        <p>'$row[messageBody]'
                        </p>
                    </div>
                </div>
              </div> ";
                }
                ?>

            </div>
        </div>
    </div>

</body>

</html>