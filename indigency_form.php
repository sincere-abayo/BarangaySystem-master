<?php
require('classes/Authentication.php');
require('classes/resident.class.php');
require('classes/Certificate.php');

$auth = new Authentication();
$resident = new Resident();
$certificate = new Certificate();

$userdetails = $auth->get_userdata();
$id_resident = $_GET['id_resident'];
$resident_data = $certificate->get_single_certofindigency($id_resident);
?>
<!DOCTYPE html>
<html lang="en" id="clearance">

<head>
    <meta charset="UTF-8">
    <title>Certificate of Indigency</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.0.2 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="bootstrap/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="bootstrap/css/morris-0.4.3.min.css" rel="stylesheet" type="text/css" />
    <link href="bootstrap/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="bootstrap/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="bootstrap/css/select2.css" rel="stylesheet" type="text/css" />
    <script src="bootstrap/css/jquery-1.12.3.js" type="text/javascript"></script>
    <style>
        @media print {
            .noprint {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .certificate-card {
                box-shadow: none !important;
                border: none !important;
            }
        }

        @page {
            size: auto;
            margin: 4mm;
        }

        .certificate-header {
            text-align: center;
            margin-bottom: 1em;
        }

        .certificate-header img {
            width: 120px;
            height: 100px;
        }

        .certificate-title {
            font-size: 28px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 1em;
        }

        .certificate-content {
            font-size: 18px;
            text-align: justify;
            margin-bottom: 2em;
        }

        .certificate-footer {
            margin-top: 3em;
            text-align: right;
        }

        .certificate-issue {
            margin-top: 3em;
            font-size: 18px;
        }
    </style>
    <script>
        function PrintElem() {
            window.print();
        }
    </script>
</head>

<body class="skin-black">
    <?php include "classes/conn.php"; ?>
    <div class="container" style="margin-top: 2em;">
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-10 col-md-8">
                <div class="card certificate-card"
                    style="padding: 2em; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px;">
                    <div class="certificate-header row">
                        <div class="col-xs-3 text-left">
                            <img src="icons/beverlylogo.png" alt="Logo Left">
                        </div>
                        <div class="col-xs-6">
                            <div style="font-size: 16px;">
                                <b>Republic of the Rwanda<br>
                                    Province of Kigali<br>
                                    Cell Nyarutarama<br>
                                    Tel. +2507826339667</b>
                            </div>
                        </div>
                        <div class="col-xs-3 text-right">
                            <img src="icons/beverlylogo.png" alt="Logo Right">
                        </div>
                    </div>
                    <hr>
                    <div class="certificate-title text-center">
                        CERTIFICATE OF INDIGENCY
                    </div>
                    <div class="certificate-content">
                        <p class="text-center" style="font-size: 20px; font-weight: bold;">TO WHOM IT MAY CONCERN:</p>
                        <p>This is to certify that <b><?= htmlspecialchars($resident_data['lname']); ?>,
                                <?= htmlspecialchars($resident_data['fname']); ?>
                                <?= htmlspecialchars($resident_data['mi']); ?></b>, of legal age,
                            <?= htmlspecialchars($resident_data['nationality']); ?> and a bonafide resident at
                            <?= htmlspecialchars($resident_data['houseno']); ?>
                            <?= htmlspecialchars($resident_data['street']); ?>
                            <?= htmlspecialchars($resident_data['brgy']); ?>
                            <?= htmlspecialchars($resident_data['municipal']); ?>.
                        </p>
                        <p>Further certify that the above named subject is of good moral character and has good
                            community standing, but unfortunately belongs to an indigent family in this Cell.</p>
                        <p>This certification is issued upon the request of the above named party as a requirement
                            needed for <b><u><?= htmlspecialchars($resident_data['purpose']); ?></u></b>.</p>
                    </div>
                    <div class="certificate-footer">
                        <div><b>Mugabo Cloude</b></div>
                        <div>Chief Cell</div>
                    </div>
                    <div class="certificate-issue">
                        <div>Rest. Cert. No. <u><?= htmlspecialchars($resident_data['id_indigency']) ?></u></div>
                        <div>Issued at <u>Nyarutarama</u></div>
                        <div>Issued on <u><?= htmlspecialchars($resident_data['date']) ?></u></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row noprint" style="margin-top: 2em;">
            <div class="col-xs-12 text-center">
                <button class="btn btn-primary" id="printpagebutton" onclick="PrintElem()">Print</button>
            </div>
        </div>
    </div>
</body>

</html>