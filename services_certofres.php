<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('classes/Authentication.php');
require('classes/Certificate.php');
$auth = new Authentication();
$certificate = new Certificate();
$userdetails = $auth->get_userdata();
$certificate->create_certofres();
$requests = $certificate->view_certofres_by_resident($userdetails['id_resident']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Residency Form</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js"
        integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w=="
        crossorigin="anonymous"></script>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
    <style>
    .container1 {
        background-color: #3498DB;
        color: white;
        padding: 40px 0 20px 0;
        text-align: center;
    }

    .text1 {
        font-size: 2.5rem;
        font-weight: bold;
    }

    .card-header {
        font-size: 1.2rem;
    }

    .applybutton {
        width: 100%;
        height: 50px;
        border-radius: 20px;
        margin-top: 5%;
        margin-bottom: 8%;
        font-size: 25px;
        letter-spacing: 2px;
        background-color: #3498db;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .applybutton:hover {
        background-color: #2980b9;
    }

    .table th,
    .table td {
        vertical-align: middle !important;
    }

    .modal-header {
        background: #3498db;
        color: white;
    }

    .modal-title {
        font-weight: bold;
    }

    .card {
        margin-bottom: 1.5rem;
    }

    .card .fa-2x {
        font-size: 2em;
    }

    .badge-info {
        font-size: 1em;
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-primary sticky-top">
        <a class="navbar-brand" href="resident_homepage.php">Nyarutarama Information & E-Services Management System</a>
        <a href="resident_homepage.php" data-toggle="tooltip" title="Home" class="btn1 bg-primary"><i
                class="fa fa-home fa-lg"></i></a>
        <a href="#down3" data-toggle="tooltip" title="Procedure" class="btn5 bg-primary"><i
                class="fa fa-question fa-lg"></i></a>
        <a href="#down2" data-toggle="tooltip" title="Information" class="btn4 bg-primary"><i
                class="fa fa-info fa-lg"></i></a>
        <a href="#down1" data-toggle="tooltip" title="Registration" class="btn3 bg-primary"><i
                class="fa fa-edit fa-lg"></i></a>
        <a href="#down" data-toggle="tooltip" title="Contact" class="btn2 bg-primary"><i
                class="fa fa-phone fa-lg"></i></a>
        <div class="dropdown ml-auto">
            <button title="Your Account" class="btn btn-primary dropdown-toggle" style="margin-right: 2px;"
                type="button" data-toggle="dropdown">
                <?= $userdetails['surname'] ?? '' ?>, <?= $userdetails['firstname'] ?? '' ?>
                <span class="caret" style="margin-left: 2px;"></span>
            </button>
            <ul class="dropdown-menu" style="width: 175px;">
                <a class="btn" href="resident_profile.php?id_resident=<?= $userdetails['id_resident'] ?? '' ?>"> <i
                        class="fas fa-user"> &nbsp; </i>Personal Profile </a>
                <a class="btn" href="resident_changepass.php?id_resident=<?= $userdetails['id_resident'] ?? '' ?>"> <i
                        class="fas fa-lock">&nbsp;</i> Change Password </a>
                <a class="btn" href="logout.php"> <i class="fas fa-sign-out-alt">&nbsp;</i> Logout </a>
            </ul>
        </div>
    </nav>

    <!-- Hero/Header -->
    <div class="container-fluid container1">
        <div class="row justify-content-center">
            <div class="col text-center">
                <div class="header">
                    <h1 class="text1">Certificate of Residency</h1>
                    <h5>
                        A Certificate of Residency is a document issued by the cell to prove that a person is a
                        resident of a certain area.<br>
                        This is often required for employment, school, or other legal purposes.
                    </h5>
                </div>
                <br>
            </div>
        </div>
    </div>

    <div id="down3"></div>
    <br><br><br>

    <!-- Procedure Section -->
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <h1>Procedure</h1>
                <hr style="background-color: black;">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <i class="fas fa-laptop fa-7x"></i>
                <br><br>
                <h3>Step 1: Fill-Up</h3>
                <p>Fill up the form with your correct information.</p>
            </div>
            <div class="col">
                <i class="fas fa-user-check fa-7x"></i>
                <br><br>
                <h3>Step 2: Assessment</h3>
                <p>We will verify your information for accuracy.</p>
            </div>
            <div class="col">
                <i class="fas fa-thumbs-up fa-7x"></i>
                <br><br>
                <h3>Step 3: Approval</h3>
                <p>Your request will be reviewed and approved by the cell.</p>
            </div>
            <div class="col">
                <i class="fas fa-file fa-7x"></i>
                <br><br>
                <h3>Step 4: Release</h3>
                <p>Claim your Certificate of Residency once approved.</p>
            </div>
        </div>
    </div>

    <div id="down2"></div>
    <br><br><br>

    <!-- Other Details Section -->
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <h1>Other Details</h1>
                <hr style="background-color: black;">
            </div>
        </div>
        <br>
        <div class="row text2">
            <div class="col">
                <div class="card bg-primary card1 text-white">
                    <div class="card-header">
                        <h5> Eligibility <br><br> <i class="fas fa-user-check fa-2x"></i> </h5>
                    </div>
                    <div class="card-body">
                        <ul style="text-align: left; font-size: 16px;">
                            <li> Must be a resident of the cell. </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary card2 text-white">
                    <div class="card-header">
                        <h5> Validity <br><br> <i class="fas fa-clipboard-check fa-2x"></i> </h5>
                    </div>
                    <div class="card-body">
                        <ul style="text-align: left; font-size: 16px;">
                            <li> Valid for 6 months. </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary card3 text-white">
                    <div class="card-header">
                        <h5> Fees <br><br> <i class="fas fa-coins fa-2x"></i> </h5>
                    </div>
                    <div class="card-body">
                        <ul style="text-align: justify;">
                            <li> 100% Free </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary card4 text-white">
                    <div class="card-header">
                        <h5 style="font-size: 19.4px;"> Processing Time <br><br> <i class="fas fa-clock fa-2x"></i>
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul style="text-align: justify;">
                            <li> Within Working Hours (8:00am - 5:00pm) </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="down1"></div>
    <br><br><br>

    <!-- Button trigger modal -->
    <div class="container">
        <h1 class="text-center">Registration</h1>
        <hr style="background-color:black;">
        <div class="col">
            <button type="button" class="btn btn-primary applybutton" data-toggle="modal"
                data-target="#exampleModalCenter">
                Request Form
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Certificate of Residency Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form method="post" class="was-validated" novalidate>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="fname">First Name:</label>
                                        <input name="fname" type="text" class="form-control"
                                            placeholder="Enter First Name"
                                            value="<?= htmlspecialchars($userdetails['firstname'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="mi">Middle Name:</label>
                                        <input name="mi" type="text" class="form-control"
                                            placeholder="Enter Middle Name"
                                            value="<?= htmlspecialchars($userdetails['mname'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="lname">Last Name:</label>
                                        <input name="lname" type="text" class="form-control"
                                            placeholder="Enter Last Name"
                                            value="<?= htmlspecialchars($userdetails['surname'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="age">Age:</label>
                                        <input name="age" type="number" class="form-control" placeholder="Enter Age"
                                            value="<?= htmlspecialchars($userdetails['age'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="nationality">Nationality:</label>
                                        <input name="nationality" type="text" class="form-control"
                                            placeholder="Enter Nationality"
                                            value="<?= htmlspecialchars($userdetails['nationality'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="houseno">House No:</label>
                                        <input name="houseno" type="text" class="form-control"
                                            placeholder="Enter House No."
                                            value="<?= htmlspecialchars($userdetails['houseno'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="street">Street:</label>
                                        <input name="street" type="text" class="form-control" placeholder="Enter Street"
                                            value="<?= htmlspecialchars($userdetails['street'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="brgy">Cell:</label>
                                        <input name="brgy" type="text" class="form-control" placeholder="Enter Cell"
                                            value="<?= htmlspecialchars($userdetails['brgy'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="municipal">Municipality:</label>
                                        <input name="municipal" type="text" class="form-control"
                                            placeholder="Enter Municipality"
                                            value="<?= htmlspecialchars($userdetails['municipal'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="purpose">Purpose:</label>
                                        <input name="purpose" type="text" class="form-control"
                                            placeholder="Enter Purpose" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="date">Date:</label>
                                        <input name="date" type="date" class="form-control" value="<?= date('Y-m-d') ?>"
                                            required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id_resident"
                                value="<?= htmlspecialchars($userdetails['id_resident'] ?? '') ?>">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                <button type="submit" name="create_certofres" class="btn btn-primary">Submit
                                    Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Table of submitted requests -->
    <div class="container">
        <h2 class="text-center">Your Certificate of Residency Requests</h2>
        <?php if (empty($requests)): ?>
        <div class="alert alert-info text-center" role="alert">You have not submitted any Certificate of Residency
            requests yet.</div>
        <?php endif; ?>
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Age</th>
                    <th>Nationality</th>
                    <th>House No</th>
                    <th>Street</th>
                    <th>Cell</th>
                    <th>Municipality</th>
                    <th>Purpose</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Generated Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['lname']) ?></td>
                    <td><?= htmlspecialchars($row['fname']) ?></td>
                    <td><?= htmlspecialchars($row['mi']) ?></td>
                    <td><?= htmlspecialchars($row['age']) ?></td>
                    <td><?= htmlspecialchars($row['nationality']) ?></td>
                    <td><?= htmlspecialchars($row['houseno']) ?></td>
                    <td><?= htmlspecialchars($row['street']) ?></td>
                    <td><?= htmlspecialchars($row['brgy']) ?></td>
                    <td><?= htmlspecialchars($row['municipal']) ?></td>
                    <td><?= htmlspecialchars($row['purpose']) ?></td>
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td>
                        <?php if ($row['status'] === 'Generated'): ?>
                            <span class="badge badge-success px-2 py-1">
                                <i class="fas fa-check-circle mr-1"></i>Generated
                            </span>
                            <?php if ($row['generated_by']): ?>
                                <br><small class="text-muted">by <?= htmlspecialchars($row['generated_by']) ?></small>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="badge badge-warning px-2 py-1">
                                <i class="fas fa-clock mr-1"></i>Pending
                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($row['generated_date']): ?>
                            <span class="text-success">
                                <i class="fas fa-calendar-check mr-1"></i>
                                <?= date('M d, Y', strtotime($row['generated_date'])) ?>
                            </span>
                        <?php else: ?>
                            <span class="text-muted">
                                <i class="fas fa-calendar-times mr-1"></i>
                                Not yet generated
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>
    <script src="bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>
</body>

</html>