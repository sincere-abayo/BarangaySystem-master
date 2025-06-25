<?php
error_reporting(E_ALL ^ E_WARNING);
ini_set('display_errors', 0);
require('classes/Authentication.php');
require('classes/Announcement.php');

$auth = new Authentication();
$announcement = new Announcement();

$userdetails = $auth->get_userdata();

$dt = new DateTime("now", new DateTimeZone('Asia/Manila'));
$tm = new DateTime("now", new DateTimeZone('Asia/Manila'));
$cdate = $dt->format('Y/m/d');
$ctime = $tm->format('H');

?>



<script>
function logout() {
    window.location.href = "logout.php";
}

function profile() {
    window.location.href = "resident_profile.php";
}
</script>


<!DOCTYPE html>
<html>

<head>
    <title> nyarutarama Information & E-Services Management System </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- responsive tags for screen compatibility -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- custom css -->
    <link href="customcss/pagestyle.css" rel="stylesheet" type="text/css">
    <!-- bootstrap css -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- fontawesome icons -->
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>



    <style>
    /* Navbar Buttons */
    .carousel-indicators li {
        background-color: #007bff;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .carousel-indicators .active {
        background-color: #0056b3;
    }

    .card-title {
        letter-spacing: 1px;
    }

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
        padding: 12px 22px;
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
        padding: 12px 22px;
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
        padding: 12px 22px;
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

    /* E-Services Zoom */

    .zoom1 {
        transition: transform .3s;
    }

    .zoom1:hover {
        -ms-transform: scale(1.1);
        /* IE 9 */
        -webkit-transform: scale(1.1);
        /* Safari 3-8 */
        transform: scale(1.1);
    }

    /* Footer Style */

    .footerlinks {
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
    </style>

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
        <a class="navbar-brand" href="resident_homepage.php">nyarutarama Information & E-Services Management System</a>
        <a href="#down2" data-toggle="tooltip" title="Announcement" class="btn1 bg-primary"><i
                class="fa fa-bullhorn fa-lg"></i></a>
        <a href="#down1" data-toggle="tooltip" title="E-Services" class="btn2 bg-primary"><i
                class="fa fa-edit fa-lg"></i></a>
        <a href="#down" data-toggle="tooltip" title="Contact" class="btn3 bg-primary"><i
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

    <div id="down2"></div>

    <?php
    $view = $announcement->view_announcement();

    if (is_array($view) && count($view) > 0) { ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div id="announcementCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($view as $idx => $item): ?>
                        <div class="carousel-item <?= $idx === 0 ? 'active' : '' ?>">
                            <div class="card shadow-lg border-0" style="border-left: 8px solid #007bff;">
                                <div class="card-body p-5">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="mr-3" style="font-size:2.5rem; color:#007bff;">
                                            <i class="fas fa-bullhorn"></i>
                                        </span>
                                        <div>
                                            <h4 class="card-title mb-0 font-weight-bold" style="color:#007bff;">
                                                Announcement</h4>
                                            <small class="text-muted">Posted:
                                                <?= htmlspecialchars($item['start_date']) ?></small>
                                        </div>
                                    </div>
                                    <hr>
                                    <p class="card-text announcement-text"
                                        data-original="<?= htmlspecialchars($item['event']) ?>"
                                        style="font-size:1.25rem;">
                                        <?= htmlspecialchars($item['event']) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#announcementCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"
                            style="background-color:#007bff; border-radius:50%;"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#announcementCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"
                            style="background-color:#007bff; border-radius:50%;"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    <ol class="carousel-indicators mt-4">
                        <?php foreach ($view as $idx => $item): ?>
                        <li data-target="#announcementCarousel" data-slide-to="<?= $idx ?>"
                            class="<?= $idx === 0 ? 'active' : '' ?>"></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <?php } else {

    }

    ?>

    <div id="down1"></div>

    <br>

    <section class="heading-section">
        <div class="container text-center">
            <div class="row">
                <div class="col">

                    <br>
                    <br>

                    <div class="header">
                        <h2> Welcome to nyarutama cell management system </h2><bR>
                        <h3> You may select the following services offered below </h3>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <br>

        <div class="container">
            <div class="row title-spacing">
                <div class="col">
                    <h2 class="text-center"> E-Services</h2>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <a href="services_business.php?id_resident=<?= $userdetails['id_resident']; ?>">
                        <div class="zoom1">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img src="icons/ResidentHomepage/busper.png">
                                    <h4> Business </h4>
                                </div>
                            </div>

                        </div>
                </div>
                </a>
            </div>
            <div class="col">
                <a href="services_certofindigency.php?id_resident=<?= $userdetails['id_resident']; ?>">
                    <div class="zoom1">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="icons/ResidentHomepage/indigency.png">
                                <h4> Certificate of Indigency </h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <br>
        <div class="row card-spacing">
            <div class="col">
                <a href="services_certofres.php?id_resident=<?= $userdetails['id_resident']; ?>">
                    <div class="zoom1">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="icons/ResidentHomepage/residency.png">
                                <h4> Certificate of Residency </h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="services_brgyclearance.php?id_resident=<?= $userdetails['id_resident']; ?>">
                    <div class="zoom1">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="icons/ResidentHomepage/clearance.png">
                                <h4> Nyarutarama Clearance </h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="services_blotter.php?id_resident=<?= $userdetails['id_resident']; ?>">
                    <div class="zoom1">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="icons/ResidentHomepage/complain.png">
                                <h4> Peace and Order</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        </div>
    </section>

    <!--/.Third column-->
    <hr class="clearfix w-100 d-md-none mb-0">

    <!--Fourth column-->
    <!-- Improved Contact Us Section -->
    <section id="down" class="my-5 py-4" style="background: #f8f9fa; border-radius: 20px;">
        <div class="container">
            <h3 class="text-center font-weight-bold mb-4" style="color: #2C54C1; letter-spacing: 1px;">Contact Us</h3>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body p-3">
                            <h6 class="font-weight-bold mb-2" style="color:#2C54C1;">Mikhos Dungca</h6>
                            <p class="mb-0" style="font-size:1rem; color:#555;">0780041468</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body p-3">
                            <h6 class="font-weight-bold mb-2" style="color:#2C54C1;">PJ Mendros</h6>
                            <p class="mb-0" style="font-size:1rem; color:#555;">078678895252</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body p-3">
                            <h6 class="font-weight-bold mb-2" style="color:#2C54C1;">Vincent Vilfamat</h6>
                            <p class="mb-0" style="font-size:1rem; color:#555;">078877765557</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>    </section>

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
    <script>
    // Google Translate API (client-side) for announcements
    function translateText(text, targetLang, callback) {
        if (targetLang === 'en') {
            callback(text);
            return;
        }
        // Use Google Translate API v2 (unofficial, for demo)
        $.get('https://translate.googleapis.com/translate_a/single', {
            client: 'gtx',
            sl: 'en',
            tl: targetLang,
            dt: 't',
            q: text
        }, function(data) {
            if (Array.isArray(data)) {
                callback(data[0][0][0]);
            } else {
                callback(text);
            }
        });
    }

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        $('#langSelect').on('change', function() {
            var lang = $(this).val();
            $('.announcement-text').each(function() {
                var $p = $(this);
                var original = $p.data('original');
                if (lang === 'en') {
                    $p.text(original);
                } else {
                    translateText(original, lang, function(translated) {
                        $p.text(translated);
                    });
                }
            });
        });
    });
    </script>



</body>

</html>