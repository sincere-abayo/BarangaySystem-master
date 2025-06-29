<?php
// error reporting
error_reporting(E_ALL ^ E_WARNING);
ini_set('display_errors', 0);
session_start();

// Check if user is logged in
// if (!isset($_SESSION['resident'])) {
//     header("Location: index.php");
//     exit();
// }

require('classes/Authentication.php');
require('classes/BusinessPermit.php');

$auth = new Authentication();
$permit = new BusinessPermit();

$userdetails = $auth->get_userdata();
$permit->create_bspermit();

$requests = $permit->view_bspermit_by_resident($userdetails['id_resident']);
?>

<!DOCTYPE html>

<html>

<head>
    <title> Nyarutarama Management System </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js"
        integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w=="
        crossorigin="anonymous"></script>
    <!-- responsive tags for screen compatibility -->
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- bootstrap css -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- fontawesome icons -->
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>

    <style>
    /* Navbar Buttons */

    .btn1 {
        border-radius: 20px;
        border: none;
        /* Remove borders */
        color: white;
        /* White text */
        font-size: 16px;
        /* Set a font size */
        cursor: pointer;
        /* Mouse pointer on hover */
        margin-left: 23%;
        padding: 8px 22px;
    }

    .btn2 {
        border-radius: 20px;
        border: none;
        /* Remove borders */
        color: white;
        /* White text */
        font-size: 16px;
        /* Set a font size */
        cursor: pointer;
        /* Mouse pointer on hover */
        padding: 8px 22px;
        margin-left: .1%;
    }

    .btn3 {
        border-radius: 20px;
        border: none;
        /* Remove borders */
        color: white;
        /* White text */
        font-size: 16px;
        /* Set a font size */
        cursor: pointer;
        /* Mouse pointer on hover */
        padding: 8px 22px;
        margin-left: .1%;
    }

    .btn4 {
        border-radius: 20px;
        border: none;
        /* Remove borders */
        color: white;
        /* White text */
        font-size: 16px;
        /* Set a font size */
        cursor: pointer;
        /* Mouse pointer on hover */
        padding: 8px 22px;
        margin-left: .1%;
    }

    .btn5 {
        border-radius: 20px;
        border: none;
        /* Remove borders */
        color: white;
        /* White text */
        font-size: 16px;
        /* Set a font size */
        cursor: pointer;
        /* Mouse pointer on hover */
        padding: 8px 22px;
        margin-left: .1%;
    }

    /* Darker background on mouse-over */
    .btn1:hover {
        background-color: RoyalBlue;
        color: black;
    }

    .btn2:hover {
        background-color: RoyalBlue;
        color: black;
    }

    .btn3:hover {
        background-color: RoyalBlue;
        color: black;
    }

    .btn4:hover {
        background-color: RoyalBlue;
        color: black;
    }

    .btn5:hover {
        background-color: RoyalBlue;
        color: black;
    }

    /* Back-to-Top */

    .top-link {
        transition: all 0.25s ease-in-out;
        position: fixed;
        bottom: 0;
        right: 0;
        display: inline-flex;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        margin: 0 3em 3em 0;
        border-radius: 50%;
        padding: 0.25em;
        width: 80px;
        height: 80px;
        background-color: #3661D5;
    }

    .top-link.show {
        visibility: visible;
        opacity: 1;
    }

    .top-link.hide {
        visibility: hidden;
        opacity: 0;
    }

    .top-link svg {
        fill: white;
        width: 24px;
        height: 12px;
    }

    .top-link:hover {
        background-color: #3498DB;
    }

    .top-link:hover svg {
        fill: #000000;
    }

    .screen-reader-text {
        position: absolute;
        clip-path: inset(50%);
        margin: -1px;
        border: 0;
        padding: 0;
        width: 1px;
        height: 1px;
        overflow: hidden;
        word-wrap: normal !important;
        clip: rect(1px, 1px, 1px, 1px);
    }

    .screen-reader-text:focus {
        display: block;
        top: 5px;
        left: 5px;
        z-index: 100000;
        clip-path: none;
        background-color: #eee;
        padding: 15px 23px 14px;
        width: auto;
        height: auto;
        text-decoration: none;
        line-height: normal;
        color: #444;
        font-size: 1em;
        clip: auto !important;
    }

    .container1 {
        background-color: #3498DB;
        height: 342px;
        color: black;
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
    }

    .applybutton {
        width: 100%;
        /* Button ifate 100% y'ubugari bwa container */
        height: 50px;
        /* Button ifate uburebure bwa 50px */
        border-radius: 20px;
        /* Impande zoroheje */
        margin-top: 5%;
        /* Intera iri hejuru ya button */
        margin-bottom: 8%;
        /* Intera iri hepfo ya button */
        font-size: 25px;
        /* Ingano y'inyuguti */
        letter-spacing: 2px;
        /* Intera hagati y'inyuguti */
        display: block;
        /* Buto ifata umwanya wose w'umurongo */
        background-color: #3498db;
        /* Ibara rya button (ubururu) */
        color: white;
        /* Ibara ry'inyuguti kuri button */
        text-align: center;
        /* Inyuguti zibaye hagati muri button */
        border: none;
        /* Ntizigere igira imbibi (border) */
        cursor: pointer;
        /* Umugereka (cursor) ugaragaza ko ari clickable */
        position: relative;
        /* Icyo twongeraho ngo izamurwe hejuru niba hari ibiyihisha */
        z-index: 100;
        /* Tuma iza hejuru y'ibindi bintu byose */
        transition: background-color 0.3s ease;
        /* Umwihariko wo guhindura ibara buhoro */
    }

    .applybutton:hover {
        background-color: #2980b9;
        /* Ibara rihinduka iyo uyerekejeho souris */
    }

    .paa {
        margin-top: 10px;
        position: relative;
        left: -28%;
    }

    .text1 {
        margin-top: 30px;
        font-size: 50px;
    }

    .picture {
        height: 120px;
        width: 120px;
    }

    /* width */
    ::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #888;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .card5 {
        width: 195px;
        height: 210px;
        overflow: auto;
        margin: auto;
        color: white;
    }

    .card4 {
        width: 195px;
        height: 210px;
        overflow: auto;
        margin: auto;
        color: white;
    }

    .card3 {
        width: 195px;
        height: 210px;
        overflow: hidden;
        margin: auto;
        color: white;
    }

    .card2 {
        width: 195px;
        height: 210px;
        overflow: auto;
        margin: auto;
        color: white;
    }

    .card1 {
        width: 195px;
        height: 210px;
        overflow: auto;
        margin: auto;
        color: white;
    }

    a {
        color: white;
    }

    .shfooter .collapse {
        display: inherit;
    }

    @media (max-width:767px) {
        .shfooter ul {
            margin-bottom: 0;
        }

        .shfooter .collapse {
            display: none;
        }

        .shfooter .collapse.show {
            display: block;
        }

        .shfooter .title .fa-angle-up,
        .shfooter .title[aria-expanded=true] .fa-angle-down {
            display: none;
        }

        .shfooter .title[aria-expanded=true] .fa-angle-up {
            display: block;
        }

        .shfooter .navbar-toggler {
            display: inline-block;
            padding: 0;
        }

    }

    .resize {
        text-align: center;
    }

    .resize {
        margin-top: 3rem;
        font-size: 1.25rem;
    }

    /*RESIZESCREEN ANIMATION*/
    .fa-angle-double-right {
        animation: rightanime 1s linear infinite;
    }

    .fa-angle-double-left {
        animation: leftanime 1s linear infinite;
    }

    @keyframes rightanime {
        50% {
            transform: translateX(10px);
            opacity: 0.5;
        }

        100% {
            transform: translateX(10px);
            opacity: 0;
        }
    }

    @keyframes leftanime {
        50% {
            transform: translateX(-10px);
            opacity: 0.5;
        }

        100% {
            transform: translateX(-10px);
            opacity: 0;
        }
    }

    /* Contact Chip */

    .chip {
        display: inline-block;
        padding: 0 25px;
        height: 50px;
        line-height: 50px;
        border-radius: 25px;
        background-color: #2C54C1;
        margin-top: 5px;
    }

    .chip img {
        float: left;
        margin: 0 10px 0 -25px;
        height: 50px;
        width: 50px;
        border-radius: 50%;
    }

    .zoom {
        transition: transform .3s;
    }

    .zoom:hover {
        -ms-transform: scale(1.4);
        /* IE 9 */
        -webkit-transform: scale(1.4);
        /* Safari 3-8 */
        transform: scale(1.4);
    }

    .button-container button:hover {
        background-color: #2980b9;
        /* Ibara rya button iyo umugereka uri hejuru */
    }
    </style>
</head>

<body>

    <!-- Back-to-Top and Back Button -->

    <a data-toggle="tooltip" title="Back-To-Top" class="top-link hide" href="" id="js-top">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 6">
            <path d="M12 6H0l6-6z" />
        </svg>
        <span class="screen-reader-text">Back to top</span>
    </a>

    <!-- Eto yung navbar -->

    <nav class="navbar navbar-dark bg-primary sticky-top">
        <a class="navbar-brand" href="resident_homepage.php" Nyarutarama Information & E-Services Management System</a>
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
                    type="button" data-toggle="dropdown"><?= $userdetails['surname']; ?>,
                    <?= $userdetails['firstname']; ?>
                    <span class="caret" style="margin-left: 2px;"></span>
                </button>
                <ul class="dropdown-menu" style="width: 175px;">
                    <a class="btn" href="resident_profile.php?id_resident=<?= $userdetails['id_resident']; ?>"> <i
                            class="fas fa-user">
                            &nbsp; </i>Personal Profile </a>
                    <a class="btn" href="resident_changepass.php?id_resident=<?= $userdetails['id_resident']; ?>"> <i
                            class="fas fa-lock">&nbsp;</i> Change Password </a>
                    <a class="btn" href="logout.php"> <i class="fas fa-sign-out-alt">&nbsp;</i> Logout </a>
                </ul>
            </div>
    </nav>

    <div class="container-fluid container1">
        <div class="row">
            <div class="col">
                <div class="header">
                    <h1 class="text1">Visitor Registration Form </h1>
                    All individuals visiting the Nyarutarama cell are required to register by filling out a Visitor's
                    Form.
                    <br> This helps maintain safety, proper documentation, and monitoring of entry and exit within the
                    community.
                    <br> Please provide your personal information before proceeding inside. </h5>
                </div>
            </div>

            <br>

        </div>
    </div>
    </div>

    <div id="down3"></div>

    <br>
    <br>
    <br>

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
                <i class="fas fa-id-card fa-7x"></i>

                <br>
                <br>

                <h3>Step 1: Prepare</h3>
                <p>First step is to prepare all of the information that will be needed
                </p>
            </div>

            <div class="col">
                <i class="fas fa-laptop fa-7x"></i>

                <br>
                <br>

                <h3>Step 2: Fill-Up</h3>
                <p>Second step is to Fill-Up the entire form in our system.</p>
            </div>

            <div class="col">
                <i class="fas fa-user-check fa-7x"></i>

                <br>
                <br>

                <h3>Step 3: Assessment</h3>
                <p>Third step is to verify all of the information you've been given
                    in our system </p>
            </div>

            <div class="col">
                <i class="fas fa-file fa-7x"></i>

                <br>
                <br>

                <h3>Step 4: Release</h3>
                <p>Fourth step is for releasing </p>
            </div>
        </div>

        <div id="down2"></div>

        <br>
        <br>
        <br>

        <div class="row">
            <div class="col">
                <h1>Other Details</h1>
                <hr style="background-color: black;">
            </div>
        </div>

        <br>

        <div class="row text2">
            <div class="col">
                <div class="card bg-primary card1">
                    <div class="card-header">
                        <h5> Eligibility <br><br> <i class="fas fa-user-check fa-2x"></i> </h5>
                    </div>
                    <div class="card-body">
                        <ul style="text-align: left; font-size: 16px;">
                            <p class="card-text">
                                <li> Rwandan Resident. </li>
                            </p>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary card2">
                    <div class="card-header">
                        <h5> Validity <br><br> <i class="fas fa-clipboard-check fa-2x"></i> </h5>
                    </div>
                    <div class="card-body">
                        <ul style="text-align: left; font-size: 16px;">
                            <p class="card-text">
                                <li> Your permit is valid for 1 year. </li>
                            </p>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary card3">
                    <div class="card-header">
                        <h5> Fees <br><br> <i class="fas fa-coins fa-2x"></i> </h5>
                    </div>
                    <div class="card-body">
                        <ul style="text-align: justify;">
                            <p class="card-text">
                                <li> 100% Free </li>
                            </p>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary card4">
                    <div class="card-header">
                        <h5 style="font-size: 19.4px;"> Processing Time <br><br> <i class="fas fa-clock fa-2x"></i>
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul style="text-align: justify;">
                            <p class="card-text">
                                <li> Within Working Hours (9:00am - 5:00pm) </li>
                            </p>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary card5">
                    <div class="card-header">
                        <h6> What you need <br><br> <i class="fas fa-file fa-2x"></i> </h6>
                    </div>
                    <div class="card-body">
                        <ul style="text-align: left; font-size: 16px;">
                            <p class="card-text">
                                <li> DTI Business Name Certificate or SEC Registration Certificate </li>
                                <li> Latest Community Tax Certificate (Cedula) </li>
                                <li> Cell Clearance </li>
                                <li> Location Clearance </li>
                                <li> Certificate of Occupancy </li>
                                <li> Building Permit </li>
                                <li> Contract of Lease or Land Title Tax Declaration (whichever is applicable) </li>
                                <li> Picture or Sketch of the Site </li>
                                <li>Fire Safety or Inspection Permit</li>
                                <li> Electrical Inspection Certificate </li>
                                <li>Sanitary Permit</li>
                                <li> Picture or Sketch of the Site </li>
                                <li>Public Liability Insurance</li>
                            </p>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="down1"></div>

    <br>
    <br>
    <br>

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
                        <h5 class="modal-title" id="exampleModalCenterTitle">Resident address</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->

                    <div class="modal-body">
                        <?php if (empty($userdetails['id_resident'])): ?>
                        <div class="alert alert-danger text-center">You must be logged in as a resident to request a
                            business permit.</div>
                        <?php else: ?>
                        <form method="post" class="was-validated">
                            <input type="hidden" name="id_resident"
                                value="<?= htmlspecialchars($userdetails['id_resident']) ?>">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="lname">Last Name:</label>
                                        <input name="lname" type="text" class="form-control"
                                            value="<?= htmlspecialchars($userdetails['surname'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="fname">First Name:</label>
                                        <input name="fname" type="text" class="form-control"
                                            value="<?= htmlspecialchars($userdetails['firstname'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="mi">Middle Name:</label>
                                        <input name="mi" type="text" class="form-control"
                                            value="<?= htmlspecialchars($userdetails['mname'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="bsname">Business Name:</label>
                                        <input name="bsname" type="text" class="form-control"
                                            placeholder="Enter Business Name" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <h6>Business Address:</h6>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>House No:</label>
                                        <input type="text" class="form-control" name="houseno"
                                            placeholder="Enter House No."
                                            value="<?= htmlspecialchars($userdetails['houseno'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Street:</label>
                                        <input type="text" class="form-control" name="street" placeholder="Enter Street"
                                            value="<?= htmlspecialchars($userdetails['street'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Cell:</label>
                                        <input type="text" class="form-control" name="brgy" placeholder="Enter Cell"
                                            value="<?= htmlspecialchars($userdetails['brgy'] ?? '') ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Municipality:</label>
                                        <input type="text" class="form-control" name="municipal"
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
                                        <label for="bsindustry">Business Industry:</label>
                                        <input type="text" name="bsindustry" class="form-control"
                                            placeholder="Enter Business Industry" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="aoe" class="mtop">Area of Establishment (SqM):</label>
                                        <input type="number" name="aoe" class="form-control"
                                            placeholder="Enter your AOE" min="1" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="paa">
                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                    <button name="create_bspermit" type="submit" class="btn btn-primary">Submit
                                        Request</button>
                                </div>
                            </div>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </form>

    <?php if ($requests && count($requests) > 0): ?>
    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <i class="fas fa-briefcase mr-2"></i>
                <h4 class="mb-0">Your Business Permit Requests</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col"><i class="fas fa-building"></i> Business Name</th>
                                <th scope="col"><i class="fas fa-industry"></i> Industry</th>
                                <th scope="col"><i class="fas fa-ruler-combined"></i> Area (SqM)</th>
                                <th scope="col"><i class="fas fa-map-marker-alt"></i> Address</th>
                                <th scope="col"><i class="fas fa-info-circle"></i> Status</th>
                                <th scope="col"><i class="fas fa-calendar"></i> Generated Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requests as $req): ?>
                            <tr>
                                <td><?= htmlspecialchars($req['bsname']) ?></td>
                                <td><?= htmlspecialchars($req['bsindustry']) ?></td>
                                <td>
                                    <span class="badge badge-info px-2 py-1"><?= htmlspecialchars($req['aoe']) ?></span>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <?= htmlspecialchars($req['houseno']) ?>,
                                        <?= htmlspecialchars($req['street']) ?>,
                                        <?= htmlspecialchars($req['brgy']) ?>,
                                        <?= htmlspecialchars($req['municipal']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($req['status'] === 'Generated'): ?>
                                    <span class="badge badge-success px-2 py-1">
                                        <i class="fas fa-check-circle mr-1"></i>Generated
                                    </span>
                                    <?php if ($req['generated_by']): ?>
                                    <br><small class="text-muted">by
                                        <?= htmlspecialchars($req['generated_by']) ?></small>
                                    <?php endif; ?>
                                    <?php else: ?>
                                    <span class="badge badge-warning px-2 py-1">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($req['generated_date']): ?>
                                    <span class="text-success">
                                        <i class="fas fa-calendar-check mr-1"></i>
                                        <?= date('M d, Y', strtotime($req['generated_date'])) ?>
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
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="container mt-5">
        <div class="alert alert-info text-center shadow-sm" role="alert">
            <i class="fas fa-info-circle"></i> You have not submitted any business permit requests yet.
        </div>
    </div>
    <?php endif; ?>
    <!-- Footer -->


    </div>
    </li>
    </ul>
    </div>

    <!--/.Fourth column-->

    </div>
    </div>

    <!--/.Footer Links-->

    <hr class="mb-0">

    <!--Copyright-->

    <div class="py-3 text-center">

        <script>
        document.write(new Date().getFullYear())
        </script>
        BI & ESMS | For Educational Purposes Only
    </div>

    </footer>

    <script>
    // Set a variable for our button element.
    const scrollToTopButton = document.getElementById('js-top');

    // Let's set up a function that shows our scroll-to-top button if we scroll beyond the height of the initial window.
    const scrollFunc = () => {
        // Get the current scroll value
        let y = window.scrollY;

        // If the scroll value is greater than the window height, let's add a class to the scroll-to-top button to show it!
        if (y > 0) {
            scrollToTopButton.className = "top-link show";
        } else {
            scrollToTopButton.className = "top-link hide";
        }
    };

    window.addEventListener("scroll", scrollFunc);

    const scrollToTop = () => {
        // Let's set a variable for the number of pixels we are from the top of the document.
        const c = document.documentElement.scrollTop || document.body.scrollTop;

        // If that number is greater than 0, we'll scroll back to 0, or the top of the document.
        // We'll also animate that scroll with requestAnimationFrame:
        // https://developer.mozilla.org/en-US/docs/Web/API/window/requestAnimationFrame
        if (c > 0) {
            window.requestAnimationFrame(scrollToTop);
            // ScrollTo takes an x and a y coordinate.
            // Increase the '10' value to get a smoother/slower scroll!
            window.scrollTo(0, c - c / 10);
        }
    };

    // When the button is clicked, run our ScrolltoTop function above!
    scrollToTopButton.onclick = function(e) {
        e.preventDefault();
        scrollToTop();
    }
    </script>

    <script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>

    <script>
    $(document).ready(function() {
        // Add smooth scrolling to all links
        $("a").on('click', function(event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function() {

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });
    });
    </script>

    <script src="bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

</body>

</html>