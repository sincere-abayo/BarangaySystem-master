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
<html lang="en">

<head>
    <title>Peace and Order - Nyarutarama Management System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- External Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/svb.css">
   
</head>

<body>
    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </a>

    <!-- Enhanced Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="resident_homepage.php">
                <i class="fas fa-shield-alt me-2"></i>
                Nyarutarama Information & E-Services Management System
            </a>
            
            <div class="d-flex align-items-center">
                <a href="resident_homepage.php" class="nav-icon" data-bs-toggle="tooltip" title="Home">
                    <i class="fa fa-home fa-lg"></i>
                </a>
                <a href="#reasons" class="nav-icon" data-bs-toggle="tooltip" title="Blotter Reasons">
                    <i class="fa fa-question fa-lg"></i>
                </a>
                <a href="#info" class="nav-icon" data-bs-toggle="tooltip" title="Information">
                    <i class="fa fa-info fa-lg"></i>
                </a>
                <a href="#complain" class="nav-icon" data-bs-toggle="tooltip" title="File Complaint">
                    <i class="fa fa-edit fa-lg"></i>
                </a>
                <a href="#contact" class="nav-icon" data-bs-toggle="tooltip" title="Contact">
                    <i class="fa fa-phone fa-lg"></i>
                </a>

                <div class="dropdown ms-3">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-2"></i>
                        <?= $userdetails['surname']; ?>, <?= $userdetails['firstname']; ?>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="resident_profile.php?id_resident=<?= $userdetails['id_resident']; ?>">
                                <i class="fas fa-user me-2"></i>Personal Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="resident_changepass.php?id_resident=<?= $userdetails['id_resident']; ?>">
                                <i class="fas fa-lock me-2"></i>Change Password
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Peace and Order</h1>
            <p class="hero-subtitle">Ensuring safety and security in our community</p>
        </div>
    </section>

    <!-- Blotter Reasons Section -->
    <section id="reasons" class="section">
        <div class="container">
            <h2 class="section-title">Common Blotter Reasons</h2>
            <div class="reasons-grid">
                <div class="reason-card" onclick="showReasonDetails('Physical Threatening')">
                    <div class="reason-overlay">
                        <i class="fas fa-fist-raised fa-3x"></i>
                        <h3 class="reason-title">Physical Threatening</h3>
                        <p>Intimidation through physical gestures or verbal threats</p>
                    </div>
                </div>
                <div class="reason-card" onclick="showReasonDetails('Domestic Violence')">
                    <div class="reason-overlay">
                        <i class="fas fa-house-damage fa-3x"></i>
                        <h3 class="reason-title">Domestic Violence</h3>
                        <p>Violence or abuse within household relationships</p>
                    </div>
                </div>
                <div class="reason-card" onclick="showReasonDetails('Aggressiveness')">
                    <div class="reason-overlay">
                        <i class="fas fa-angry fa-3x"></i>
                        <h3 class="reason-title">Aggressiveness</h3>
                        <p>Hostile or violent behavior towards others</p>
                    </div>
                </div>
                <div class="reason-card" onclick="showReasonDetails('Sexual Harassment')">
                    <div class="reason-overlay">
                        <i class="fas fa-exclamation-triangle fa-3x"></i>
                        <h3 class="reason-title">Sexual Harassment</h3>
                        <p>Unwelcome sexual advances or conduct</p>
                    </div>
                </div>
                <div class="reason-card" onclick="showReasonDetails('Psychological Abuse')">
                    <div class="reason-overlay">
                        <i class="fas fa-brain fa-3x"></i>
                        <h3 class="reason-title">Psychological Abuse</h3>
                        <p>Mental or emotional abuse causing distress</p>
                    </div>
                </div>
                <div class="reason-card" onclick="showReasonDetails('Emotional Abuse')">
                    <div class="reason-overlay">
                        <i class="fas fa-heart-broken fa-3x"></i>
                        <h3 class="reason-title">Emotional Abuse</h3>
                        <p>Behavior that harms emotional well-being</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information Section -->
    <section id="info" class="section" style="background: white;">
        <div class="container">
            <h2 class="section-title">Blotter Information</h2>
            <div class="info-cards">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3>How to File a Blotter?</h3>
                    <p><strong>Step 1:</strong> Fill out the complete form in our system with accurate information.</p>
                    <p><strong>Step 2:</strong> Verify all information and provide supporting evidence.</p>
                    <p><strong>Step 3:</strong> Submit your complaint and wait for approval and scheduling.</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>What is a Nyarutarama Blotter?</h3>
                    <p>A Nyarutarama blotter is an official record of incidents, complaints, and disputes within the community. It serves as the first step in resolving conflicts and maintaining peace and order.</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h3>Purpose of Blotter</h3>
                    <p>The blotter maintains written records of arrests and occurrences, documenting facts about incidents and charges to ensure proper handling of community disputes and legal matters.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Apply Section -->
<section id="complain" class="apply-section">
        <div class="container">
            <h2 class="mb-4">File Your Complaint</h2>
            <p class="mb-4">Ready to file a blotter report? Click the button below to get started.</p>
            <button type="button" class="apply-button" data-bs-toggle="modal" data-bs-target="#complaintModal">
                <i class="fas fa-edit me-2"></i>Apply Form
            </button>
        </div>
    </section>

    <!-- Enhanced Modal -->
  <div class="modal fade" id="complaintModal" tabindex="-1" aria-labelledby="complaintModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="complaintModalLabel">
                        <i class="fas fa-file-alt me-2"></i>Complaint Form
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- FIXED: Added proper form validation classes and structure -->
                    <form method="post" enctype="multipart/form-data" id="complaintForm" class="needs-validation" novalidate>
                        <!-- Personal Information -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">Personal Information</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="lname" class="form-label">Last Name</label>
                                    <input name="lname" type="text" class="form-control" value="<?= $resident_data['lname'] ?>" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="fname" class="form-label">First Name</label>
                                    <input name="fname" type="text" class="form-control" value="<?= $resident_data['fname'] ?>" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="mi" class="form-label">Middle Name</label>
                                    <input name="mi" type="text" class="form-control" value="<?= $resident_data['mi'] ?>" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label for="age" class="form-label">Age</label>
                                    <input name="age" type="number" class="form-control" value="<?= $resident_data['age'] ?>" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="contact" class="form-label">Contact Number</label>
                                    <input name="contact" type="text" maxlength="11" class="form-control" value="<?= $resident_data['contact'] ?>" pattern="[0-9]{11}" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">Address Information</h6>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="houseno" class="form-label">House No.</label>
                                    <input type="text" class="form-control" name="houseno" value="<?= $resident_data['houseno'] ?>" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <div class="col-md-3">
                                    <label for="street" class="form-label">Street</label>
                                    <input type="text" class="form-control" name="street" value="<?= $resident_data['street'] ?>" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <div class="col-md-3">
                                    <label for="brgy" class="form-label">Village</label>
                                    <input type="text" class="form-control" name="brgy" value="<?= $resident_data['brgy'] ?>" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <div class="col-md-3">
                                    <label for="municipal" class="form-label">Municipality</label>
                                    <input type="text" class="form-control" name="municipal" value="<?= $resident_data['municipal'] ?>" required>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Supporting Evidence -->
                        <div class="guidelines">
                            <h6><i class="fas fa-camera me-2"></i>Guidelines for Supporting Evidence Photo</h6>
                            <ul>
                                <li>Good quality photo with clear visibility</li>
                                <li>File size: At least 50KB and no more than 50MB</li>
                                <li>Accepted formats: JPEG or PNG only</li>
                                <li>Image should be clear and in focus</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Supporting Evidence Photo</label>
                            <!-- FIXED: Restored original file input structure -->
                            <div class="input-group">
                                <input type="file" class="form-control" id="customFile" name="blot_photo" onchange="readURL(this);" accept="image/*" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            
                            <!-- FIXED: Restored original image preview -->
                            <div class="mt-3">
                                <label>Photo Display:</label>
                                <img id="blah" src="http://placehold.it/470x350" alt="your image" class="img-fluid" style="max-width: 100%; height: auto;" />
                            </div>
                        </div>

                        <!-- Narrative Report -->
                        <div class="guidelines">
                            <h6><i class="fas fa-pen me-2"></i>Guidelines for Narrative Report</h6>
                            <ul>
                                <li>Use simple, everyday words rather than complex terminology</li>
                                <li>Be specific and detailed in your report</li>
                                <li>Maintain respectful language throughout</li>
                                <li>Write clearly and make it easy to read</li>
                                <li>Avoid using emojis or special symbols</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <label for="narrative" class="form-label">Narrative Report</label>
                            <textarea class="form-control" rows="5" id="report" name="narrative" 
                                placeholder="Enter Message here" required></textarea>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>

                        <!-- FIXED: Restored hidden input -->
                        <input name="id_resident" type="hidden" value="<?= $resident_data['id_resident'] ?>">
                        
                        <!-- FIXED: Moved submit button inside form and modal-footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="create_blotter" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Submit Complaint
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- My Blotter Records Section -->
    <?php if (!empty($blotters)): ?>
    <section class="section">
        <div class="container">
            <h2 class="section-title">My Blotter Records</h2>
            <div class="row">
                <?php foreach ($blotters as $blotter_record): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-file-alt me-2"></i>
                                Blotter #<?= $blotter_record['id_blotter'] ?>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <small class="text-muted">Date Filed:</small>
                                <div><?= date('F j, Y', strtotime($blotter_record['timeapplied'])) ?></div>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Status:</small>
                                <div>
                                    <?php
                                    $status = $blotter_record['status'] ?? 'pending';
                                    $statusClass = '';
                                    switch($status) {
                                        case 'approved': $statusClass = 'status-approved'; break;
                                        case 'rejected': $statusClass = 'status-rejected'; break;
                                        default: $statusClass = 'status-pending';
                                    }
                                    ?>
                                    <span class="status-badge <?= $statusClass ?>">
                                        <?= ucfirst($status) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Narrative:</small>
                                <div class="narrative-preview">
                                    <?= substr($blotter_record['narrative'], 0, 100) ?>
                                    <?= strlen($blotter_record['narrative']) > 100 ? '...' : '' ?>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer bg-light">
                            <!-- <button class="btn btn-sm btn-outline-primary" onclick="viewBlotterDetails(<?= $blotter_record['id_blotter'] ?>)">
                                <i class="fas fa-eye me-1"></i>View Details
                            </button> -->
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!-- Blotter Details Modal -->
    <div class="modal fade" id="blotterDetailsModal" tabindex="-1" aria-labelledby="blotterDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="blotterDetailsModalLabel">
                        <i class="fas fa-file-alt me-2"></i>Blotter Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="blotterDetailsContent">
                        <!-- Content will be loaded here -->
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading blotter details...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                    <button type="button" class="btn btn-primary" id="printBlotter">
                        <i class="fas fa-print me-2"></i>Print
                    </button>
                </div>
            </div>
        </div>
    </div>

<script>
        // FIXED: Restored original image preview function
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

        // FIXED: Bootstrap 5 validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Back to top functionality
        window.addEventListener('scroll', function() {
            const backToTop = document.getElementById('backToTop');
            if (window.pageYOffset > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        document.getElementById('backToTop').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Show reason details
        function showReasonDetails(reason) {
            alert('You selected: ' + reason + '\n\nThis type of incident can be reported through our blotter system. Please use the complaint form to file your report.');
        }

        // View blotter details
        function viewBlotterDetails(blotterId) {
            alert('Viewing details for Blotter #' + blotterId);
        }
    </script>

    <!-- FIXED: Include jQuery for compatibility -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>
