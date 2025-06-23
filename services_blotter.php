<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('classes/Authentication.php');
require('classes/resident.class.php');
require('classes/Blotter.php');

$auth = new Authentication();
$resident = new Resident();
$blotter = new Blotter();

$userdetails = $auth->get_userdata();
$blotter->create_blotter();
$resident_data = $resident->get_single_resident($userdetails['id_resident']);
$blotters = $blotter->view_blotter_by_resident($userdetails['id_resident']);
?>

<!DOCTYPE html>

<html>

<head>
    <title>Peace and Order - Nyarutarama Management System</title>
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
        .hero-section {
            position: relative;
            width: 100%;
            height: 350px;
            background: url('icons/Blotter/blotter2.png') center center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .hero-title {
            position: relative;
            z-index: 2;
            color: #fff;
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 2px 2px 8px #000;
            letter-spacing: 4px;
        }

        .carousel-item img {
            max-height: 220px;
            object-fit: cover;
            border-radius: 15px;
            margin: 0 auto;
        }

        .carousel-caption {
            background: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            padding: 0.5rem 1rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .info-card .card-header {
            background: #3498db;
            color: #fff;
            font-size: 1.1rem;
        }

        .info-card .card-body {
            min-height: 120px;
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

        .narrative-cell {
            max-width: 250px;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .blotter-photo-thumb {
            max-width: 80px;
            max-height: 80px;
            border-radius: 10px;
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
        <a class="navbar-brand" href="resident_homepage.php">Nyarutarama Information & E-Services Management System</a>
        <a href="resident_homepage.php" data-toggle="tooltip" title="Home" class="btn1 bg-primary"><i
                class="fa fa-home fa-lg"></i></a>
        <a href="#reasons" data-toggle="tooltip" title="Blotter Reason" class="btn5 bg-primary"><i
                class="fa fa-question fa-lg"></i></a>
        <a href="#info" data-toggle="tooltip" title="Blotter Information" class="btn4 bg-primary"><i
                class="fa fa-info fa-lg"></i></a>
        <a href="#complain" data-toggle="tooltip" title="Registration" class="btn3 bg-primary"><i
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

    <!-- Under Navbar -->

    <div class="container-fluid container1">
        <img src="icons/Blotter/blotter2.png" alt="Nature" style="width:100%; height: 400px;">
        <div class="text-block text-center taytel">
            <h1 style="font-size: 100px; letter-spacing: 5px;">Peace and Order</h1>
        </div>
    </div>

    <div id="down3"></div>

    <br>
    <br>
    <br>

    <!-- Slideshow -->

    <div class="container container2">
        <h1 style="text-align:center">Blotter Reason</h1>
        <hr style="background-color: black;">



        <div class="caption-container">
            <p id="caption"></p>
        </div>

        <div class="row">
            <div class="column">
                <img class="demo cursor picture1" src="icons/Blotter/blotter3.jpg" style="width:100%"
                    onclick="currentSlide(1)" alt="Physical Threatening">
            </div>
            <div class="column">
                <img class="demo cursor picture1" src="icons/Blotter/blotter4.jpg" style="width:100%"
                    onclick="currentSlide(2)" alt="Domestic Violence">
            </div>
            <div class="column">
                <img class="demo cursor picture1" src="icons/Blotter/blotter5.jpg" style="width:100%"
                    onclick="currentSlide(3)" alt="Aggresiveness">
            </div>
            <div class="column">
                <img class="demo cursor picture1" src="icons/Blotter/blotter6.jpg" style="width:100%"
                    onclick="currentSlide(4)" alt="Sexual Harassment">
            </div>
            <div class="column">
                <img class="demo cursor picture1" src="icons/Blotter/blotter7.jpg" style="width:100%"
                    onclick="currentSlide(5)" alt="Psychological Abuse">
            </div>
            <div class="column">
                <img class="demo cursor picture1" src="icons/Blotter/blotter8.jpg" style="width:100%"
                    onclick="currentSlide(6)" alt="Emotional Abuse">
            </div>
        </div>
    </div>

    <div id="down2"></div>

    <br>
    <br>
    <br>

    <div class="container container3">
        <h1 style="text-align:center">Blotter Information</h1>
        <hr style="background-color: black;">

        <br>

        <div class="row">
            <div class="col">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front bg-primary">
                            <br>
                            <br>
                            <i class="fas fa-question-circle fa-4x"></i>
                            <br>
                            <br>
                            <h2>How can I file a Nyarutarama Blotter?</h2>
                        </div>
                        <div class="flip-card-back bg-info" style="font-size: 15px;">
                            <br>
                            Step 1: Fill-Up the entire form in our system.
                            <br><br>
                            Step 2: Verify all of the information you've been given
                            in our system that we can use to solve your case
                            as quick as possible.
                            <br><br>
                            Step 3: Approve your complain, so we can set a schedule
                            or an appointment to make an agreement on bot sides.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front bg-primary">
                            <br>
                            <br>
                            <i class="fas fa-question-circle fa-4x"></i>
                            <br>
                            <br>
                            <h2>What is Nyarutarama Blotter?</h2>
                        </div>
                        <div class="flip-card-back  bg-info">
                            <br>
                            <h5>The entry in the Nyarutarama blotter merely states that private complainant
                                was embraced ("niyakap") by the accused. This may be attributed to inaccurate
                                reporting or to the victim's incomplete narration of events, whether or not
                                intentionally done.</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front bg-primary">
                            <br>
                            <br>
                            <i class="fas fa-question-circle fa-4x"></i>
                            <br>
                            <br>
                            <h3>What is the purpose of Nyarutarama Blotter?</h3>
                        </div>
                        <div class="flip-card-back  bg-info">
                            <br>
                            <h5>A written record of arrests and other occurrences maintained
                                by the Nyarutarama. The report kept by the Rwanda when a suspect
                                is booked, which involves the written recording of facts about
                                the person's arrest and the charges against him or her.</h5>
                        </div>
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

    <div class="container container4">

        <h1 class="text-center">Complain</h1>

        <hr style="background-color:black;">

        <div class="col">
            <button type="button" class="btn btn-primary applybutton" data-toggle="modal"
                data-target="#exampleModalCenter">
                Apply Form
            </button>
        </div>


        <!-- Modal -->

        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Complain Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->

                    <div class="modal-body">
                        <form method="post" class="was-validated" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="lname">Last name:</label>
                                        <input name="lname" type="text" class="form-control"
                                            value="<?= $resident_data['lname'] ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="fname">First name:</label>
                                        <input name="fname" type="text" class="form-control"
                                            value="<?= $resident_data['fname'] ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="mname">Middle name:</label>
                                        <input name="mi" type="text" class="form-control"
                                            value="<?= $resident_data['mi'] ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col">
                                    <div class="form-group">
                                        <label for="age" class="mtop">Age </label>
                                        <input name="age" type="number" class="form-control"
                                            value="<?= $resident_data['age'] ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="cno">Contact Number:</label>
                                        <input name="contact" type="text" maxlength="11" class="form-control"
                                            value="<?= $resident_data['contact'] ?>" pattern="[0-9]{11}" required>
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
                                            placeholder="Enter House No." value="<?= $resident_data['houseno'] ?>"
                                            required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label> Street: </label>
                                        <input type="text" class="form-control" name="street" placeholder="Enter Street"
                                            value="<?= $resident_data['street'] ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label> Village: </label>
                                        <input type="text" class="form-control" name="brgy" placeholder="Enter Barangay"
                                            value="<?= $resident_data['brgy'] ?>" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label> Municipality: </label>
                                        <input type="text" class="form-control" name="municipal"
                                            placeholder="Enter Municipality" value="<?= $resident_data['municipal'] ?>"
                                            required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <h6>Guidelines for Supporting Evidence Photo:</h6>

                            <p>
                            <ul style="font-size: 15px;">
                                <li>
                                    Good quality photo.
                                </li>
                                <li>
                                    At least 50KB and no more than 50MB.
                                </li>
                                <li>
                                    File Format: JPEG or PNG
                                </li>
                                <li>
                                    Clear and in focus.
                                </li>
                            </ul>
                            </p>

                            <div class="row">
                                <div class="col">
                                    <label>Supporting Evidence Photo:</label>
                                    <div class="custom-file form-group">
                                        <input type="file" onchange="readURL(this);" class="custom-file-input"
                                            id="customFile" name="blot_photo" required>
                                        <label class="custom-file-label" for="customFile">Choose File Photo</label>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col">
                                    <label>Photo Display:</label>
                                    <img id="blah" src="http://placehold.it/470x350" alt="your image" />
                                </div>
                            </div>

                            <hr>

                            <h6>Guidelines for Narrative Report:</h6>

                            <p>
                            <ul style="font-size: 15px;">
                                <li>
                                    Use simple, everyday words rather than complex terminology.
                                </li>
                                <li>
                                    Be specific on your report
                                </li>
                                <li>
                                    Don't use bad words
                                </li>
                                <li>
                                    Clear and Easy to read report
                                </li>
                                <li>
                                    Don't use Emoji or any kind of Symbols.
                                </li>
                            </ul>
                            </p>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="report">Narrative Report:</label>
                                        <textarea class="form-control" rows="5" id="report" name="narrative"
                                            placeholder="Enter Message here" required></textarea>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="paa">
                                    <input name="id_resident" type="hidden"
                                        value="<?= $resident_data['id_resident'] ?>">
                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                    <button type="submit" name="create_blotter" class="btn btn-primary">Save
                                        changes</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->

    <footer id="footer" class="bg-primary text-white d-flex-column text-center">
        <hr class="mt-0">

        <div class="text-center">
            <h1>Services</h1>
            <ul class="list-unstyled list-inline">

                &nbsp;

                <li class="list-inline-item">
                    <a href="#!" class="sbtn btn-large mx-1" title="Documents">
                        <i class="fas fa-file fa-2x"></i>
                    </a>
                </li>

                &nbsp;

                <li class="list-inline-item">
                    <a href="#!" class="sbtn btn-large mx-1" title="Card">
                        <i class="fas fa-id-card fa-2x"></i>
                    </a>
                </li>

                &nbsp;

                <li class="list-inline-item">
                    <a href="#!" class="sbtn btn-large mx-1" title="Friend">
                        <i class="fas fa-user-friends fa-2x"></i>
                    </a>
                </li>

                &nbsp;

                <li class="list-inline-item">
                    <a href="#!" class="sbtn btn-large mx-1" title="Blotter">
                        <i class="fas fa-user-shield fa-2x"></i>
                    </a>
                </li>

                &nbsp;

                <li class="list-inline-item">
                    <a href="#!" class="sbtn btn-large mx-1" title="Contact">
                        <i class="fas fa-phone fa-2x"></i>
                    </a>
                </li>
                </li>
            </ul>
        </div>

        <hr class="mb-0">

        <!--Footer Links-->

        <div class="container text-left text-md-center">
            <div class="row">


            </div>

            <!--/.First column-->

            <hr class="clearfix w-100 d-md-none mb-0">


        </div>

        <!--/.Third column-->

        <hr class="clearfix w-100 d-md-none mb-0">


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
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("demo");
            var captionText = document.getElementById("caption");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            captionText.innerHTML = dots[slideIndex - 1].alt;
        }
    </script>

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(470)
                        .height(350);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

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

    <script src="bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

</body>

</html>