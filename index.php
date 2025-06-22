<?php
error_reporting(E_ALL ^ E_WARNING);

if (!isset($_SESSION)) {
    $showdate = date("Y-m-d");
    date_default_timezone_set('Asia/Manila');
    $showtime = date("h:i:a");
    $_SESSION['storedate'] = $showdate;
    $_SESSION['storetime'] = $showdate;
    session_start();
}

//include('autoloader.php');
require('classes/Authentication.php');
$auth = new Authentication();
$auth->login();


?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <title>Cell Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>

    <style>
    body {
        background-color: #00405B;
    }

    .card {
        border-radius: 1rem;
    }
    </style>
</head>

<body class="d-flex flex-column h-100">

    <main class="flex-shrink-0">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-light text-dark">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4">

                                <h2 class="fw-bold mb-2 text-uppercase">Cell Management System</h2>
                                <p class="text-dark-50 mb-5">case study nyarutarama cell.</p>

                                <form method="post">
                                    <div class="form-outline form-white mb-4">
                                        <input type="email" name="email" id="typeEmailX"
                                            class="form-control form-control-lg" placeholder="Email" required />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" name="password" id="typePasswordX"
                                            class="form-control form-control-lg" placeholder="Password" required />
                                    </div>

                                    <div class="form-check d-flex justify-content-start mb-4">
                                        <input class="form-check-input" type="checkbox"
                                            onclick="togglePasswordVisibility()" id="showPasswordCheck" />
                                        <label class="form-check-label" for="showPasswordCheck">
                                            Show Password
                                        </label>
                                    </div>

                                    <button class="btn btn-primary btn-lg px-5 w-100" type="submit"
                                        name="login">Login</button>
                                </form>
                            </div>

                            <hr>

                            <div>
                                <p class="mb-0">Haven't registered yet?
                                    <a href="resident_registration.php" class="text-dark-50 fw-bold">Create Account</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer mt-auto py-3 bg-primary text-white text-center">
        <div class="container">
            <span>Copyright &copy;
                <script>
                document.write(new Date().getFullYear())
                </script> Cell Management System. All Rights Reserved.
            </span>
        </div>
    </footer>

    <script>
    function togglePasswordVisibility() {
        var x = document.getElementById("typePasswordX");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>