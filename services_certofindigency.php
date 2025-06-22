<?php
require('classes/Certificate.php');
$certificate = new Certificate();
$certificate->create_certofindigency();

?>

<!DOCTYPE html>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Indigency Form</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js"
        integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w=="
        crossorigin="anonymous"></script>
    <!-- responsive tags for screen compatibility -->
    <link href="../BarangaySystem/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- fontawesome icons -->
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
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
                type="button" data-toggle="dropdown"><?= $userdetails['surname']; ?>, <?= $userdetails['firstname']; ?>
                <span class="caret" style="margin-left: 2px;"></span>
            </button>
            <ul class="dropdown-menu" style="width: 175px;">
                <a class="btn" href="resident_profile.php?id_resident=<?= $userdetails['id_resident']; ?>"> <i
                        class="fas fa-user"> &nbsp; </i>Personal Profile </a>
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
                    <h1 class="text1">Certificate of Indigency</h1>
                    <h5> A Certificate of Indigency or a Certificate of Low Income is a document
                        <br> that are sometimes required by the Rwanda government or a private
                        <br> institution as proof of an individual's financial situation.
                    </h5>
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
                <i class="fas fa-laptop fa-7x"></i>

                <br>
                <br>

                <h3>Step 1: Fill-Up</h3>
                <p>First step is to Fill-Up the entire form in our system.</p>
            </div>

            <div class="col">
                <i class="fas fa-user-check fa-7x"></i>

                <br>
                <br>

                <h3>Step 2: Assessment</h3>
                <p>Second step is to verify all of the information you've been given
                    in our system that we can use to make the information of your document
                    accurately.</p>
            </div>

            <div class="col">
                <i class="fas fa-thumbs-up fa-7x"></i>

                <br>
                <br>

                <h3>Step 3: Approval</h3>
                <p>Third step is to approve your document. Therefore, we dont have an
                    issue when we release your document.</p>
            </div>

            <div class="col">
                <i class="fas fa-file fa-7x"></i>

                <br>
                <br>

                <h3>Step 4: Release</h3>
                <p>Fourth step is for releasing of your document.</p>
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
                        <h5> Client Group <br><br> <i class="fas fa-user-check fa-2x"></i> </h5>
                    </div>
                    <div class="card-body">
                        <ul style="text-align: left; font-size: 16px;">
                            <p class="card-text">
                                <li> Indigent Individuals </li>
                                <li> Families in the Community. </li>
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
                                <li> Valid for Six (6) Months. Not valid without Barangay dry seal </li>
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
                                <li> Within Working Hours (8:00am - 5:00pm) </li>
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
                        <h5 class="modal-title" id="exampleModalCenterTitle">Certificate of Indigency Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->

                    <div class="modal-body">
                        <form method="post" class="was-validated">

                            <div class="row">

                                <div class="col">
                                    <div class="form-group">
                                        <label for="fname">First Name:</label>
                                        <input name="fname" type="text" class="form-control"
                                            placeholder="Enter First Name" value="<?= $userdetails['firstname'] ?>"
                                            required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="mi" class="mtop">Middle Name: </label>
                                        <input name="mi" type="text" class="form-control"
                                            placeholder="Enter Middle Name" value="<?= $userdetails['mname'] ?>"
                                            required>
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
                                            placeholder="Enter Last Name" value="<?= $userdetails['surname'] ?>"
                                            required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label class="mtop">Nationality: </label>
                                        <input type="text" class="form-control" name="nationality"
                                            placeholder="Enter Nationality" value="<?= $userdetails['nationality'] ?>"
                                            required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label> House No: </label>
                                        <input type="text" class="form-control" name="houseno"
                                            placeholder="Enter House No." value="<?= $userdetails['houseno'] ?>"
                                            required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label> Street: </label>
                                        <input type="text" class="form-control" name="street" placeholder="Enter Street"
                                            value="<?= $userdetails['street'] ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label> Village: </label>
                                        <input type="text" class="form-control" name="brgy" placeholder="Enter village"
                                            value="<?= $userdetails['brgy'] ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label> Municipality: </label>
                                        <input type="text" class="form-control" name="municipal"
                                            placeholder="Enter Municipality" value="<?= $userdetails['municipal'] ?>"
                                            required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col">
                                    <div class="form-group">
                                        <label for="purposes">Purposes:</label>
                                        <select class="form-control" name="purpose" id="purposes" required>
                                            <option value="">Choose your Purposes</option>
                                            <option value="Job/Employment">Job/Employment</option>
                                            <option value="Business Establishment">Business Requirement</option>
                                            <option value="Financial Transaction">Financial Transaction</option>
                                            <option value="Scholarship">Scholarship</option>
                                            <option value="Other important transactions.">Other important transactions.
                                            </option>
                                        </select>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>


                                <div class="col">
                                    <div class="form-group">
                                        <label class="mtop">Date: </label>
                                        <input type="date" class="form-control" name="date" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                            </div>


                    </div>



                    <!-- Modal Footer -->

                    <div class="modal-footer">
                        <div class="paa">
                            <input name="id_resident" type="hidden" class="form-control"
                                value="<?= $userdetails['id_resident'] ?>">
                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                            <button name="create_certofindigency" type="submit" class="btn btn-primary">Submit
                                Request</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <br>
    <br>
    <br>

    <!-- Footer -->

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
        scrollToTopButton.onclick = function (e) {
            e.preventDefault();
            scrollToTop();
        }
    </script>

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script>
        $(document).ready(function () {
            // Add smooth scrolling to all links
            $("a").on('click', function (event) {

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
                    }, 800, function () {

                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                } // End if
            });
        });
    </script>

    <script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

</body>

</html>