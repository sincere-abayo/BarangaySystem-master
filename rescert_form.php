<?php
ini_set('display_errors', 0);
require('classes/Authentication.php');
require('classes/resident.class.php');
require('classes/Certificate.php');

$auth = new Authentication();
$resident = new Resident();
$certificate = new Certificate();

$userdetails = $auth->get_userdata();
$id_resident = $_GET['id_resident'];
$resident_data = $certificate->get_single_certofres($id_resident);
?>
<!DOCTYPE html>
<html id="clearance">
<style>
    @media print {
        .noprint {
            visibility: hidden;
        }
    }

    @page {
        size: auto;
        margin: 4mm;
    }
</style>

<head>
    <meta charset="UTF-8">
    <title>Nyarutarama Information System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="bootstrap/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="bootstrap/css/morris-0.4.3.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="bootstrap/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="./BarangaySystem/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="bootstrap/css/select2.css" rel="stylesheet" type="text/css" />
    <script src="bootstrap/css/jquery-1.12.3.js" type="text/javascript"></script>

</head>

<body class="skin-black">
    <?php include "classes/conn.php"; ?>
    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <!-- Officials and Logo -->
            <div class="col-xs-12 col-sm-4 col-md-3"
                style="background: white; border: 2px solid black; margin-bottom: 20px;">
                <div style="text-align: center; margin-top: 10px;">
                    <img src="icons/beverlylogo.png" alt="Barangay Logo"
                        style="width:90%; max-width:180px; height:auto; display:block; margin:0 auto 20px auto;" />
                </div>
                <div style="margin-top:10px; text-align: center; word-wrap: break-word;">
                    <p style="margin-top: 2em;"><b>Vincent HABIMANA</b><br><span style="font-size:12px;">HEAD OF
                            CELL</span></p>
                    <p>KAG. Mikhos Dungca<br><span style="font-size:12px;">Sports / Law / Ordinance</span></p>
                    <p><span style="font-size:12px;">Public Safety / Peace and Order</span></p>
                    <p>KAG. Eugene Evangelista<br><span style="font-size:12px;">Culture & Arts / Tourism / Womens
                            Sector</span></p>
                    <p>KAG. Kyle Pilapil<br><span style="font-size:12px;">Budget & Finance / Electrification</span></p>
                    <p>KAG. Jr Gapas<br><span style="font-size:12px;">Agriculture / Livelihood / Farmers Sector / PWD
                            Sector</span></p>
                    <p>KAG. Kjell Ibabao<br><span style="font-size:12px;">Health & Sanitation / Education</span></p>
                    <p>KAG. Remedios<br><span style="font-size:12px;">Infrastracture / Labor Sector/ Environment /
                            Beautification</span></p>
                </div>
            </div>
            <!-- Certificate Content -->
            <div class="col-xs-12 col-sm-8 col-md-9" style="background: white; border: 2px solid black; padding: 30px;">
                <div style="text-align:center; margin-bottom: 20px;">
                    <b>
                        Republic of the Rwanda<br>
                        Municipality of Kigali<br>
                        Cell of Nyarutarama<br>
                        <br>
                        Tel. +2507808367343<br><br>
                    </b>
                </div>
                <div style="text-align:center; margin-bottom: 30px;">
                    <span style="font-size: 20px; font-weight: bold;">OFFICE OF THE Nyarutarama</span><br>
                    <span style="font-size: 25px;"><ins>CERTIFICATE OF RESIDENCY</ins></span>
                </div>
                <div style="margin-bottom: 20px;">
                    <p style="font-size: 18px;">TO WHOM IT MAY CONCERN:</p>
                    <p style="text-indent:40px;text-align: justify;">This is to certify that
                        <b><?= $resident_data['lname']; ?>, <?= $resident_data['fname']; ?>
                            <?= $resident_data['mi']; ?></b>,
                        <?= $resident_data['age']; ?> Years Old, <?= $resident_data['nationality']; ?> and a bonafide
                        resident of <?= $resident_data['houseno']; ?> <?= $resident_data['street']; ?>
                        <?= $resident_data['brgy']; ?> <?= $resident_data['municipal']; ?>.
                    </p>
                    <p style="text-indent:40px;text-align: justify;">Further certify that the above-named subject is of
                        good moral character and has no derigatory record in this office, law abiding citizen and
                        reliable.</p>
                    <p style="text-indent:40px;text-align: justify;">This certification is issued upon the request of
                        the above-named party as a supporting document needed for
                        <ins><?= $resident_data['purpose']; ?></ins>.
                    </p>
                    <p style="text-indent:40px;text-align: justify;">Issued this <?= $resident_data['date']; ?> Kigali
                        City. </p>
                </div>
                <div style="margin-top: 60px; margin-bottom: 40px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                        <div>
                            <div style="display: flex; align-items: center; min-height: 40px;">
                                <span style="font-weight: bold; margin-right: 10px;">Signature</span>
                                <span id="signature-underline"
                                    style="font-size:18px; letter-spacing:2px; flex:1; display:inline-block; min-width:180px;">____________</span>
                                <img id="signature-image" src="" alt="Signature"
                                    style="max-width:180px; max-height:60px; display:none; margin-left:10px; background:#fff;" />
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <label style="font-size:18px;">VINCENT HABIMANA</label><br>
                            <label>chief leader Nyarutarama</label>
                        </div>
                    </div>
                </div>
                <!-- Signature Pad Area (hidden on print) -->
                <div class="noprint" style="margin-bottom: 30px;">
                    <label for="signature-pad">Sign here:</label>
                    <div style="border:1px solid #ccc; background:#fff; width: 300px; height: 80px;">
                        <canvas id="signature-pad" width="300" height="80" style="touch-action: none;"></canvas>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="clearSignature()">Clear</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="saveSignature()">Save</button>
                </div>
                <!-- issued at/on -->
                <div style="margin-top: 10px;">
                    <b style="font-size:18px;">Rest. Cert. No. <u> <?= $resident_data['id_rescert'] ?> </u><br>
                        <span>Issued at <u>Nyarutarama</u></span><br>
                        <span>Issued on <u><?= $resident_data['date'] ?></u></span></b>
                </div>
            </div>
        </div>
        <div class="row noprint">
            <div class="col text-center">
                <button class="btn btn-primary" id="printpagebutton" onclick="PrintElem('#clearance')">Print</button>
            </div>
        </div>
    </div>

</body>
<?php

?>


<script>
    function PrintElem(elem) {
        window.print();
    }

    function Popup(data) {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        //mywindow.document.write('<html><head><title>my div</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        //mywindow.document.write('</head><body class="skin-black" >');
        var printButton = document.getElementById("printpagebutton");
        //Set the print button visibility to 'hidden' 
        printButton.style.visibility = 'hidden';
        mywindow.document.write(data);
        //mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();

        printButton.style.visibility = 'visible';
        mywindow.close();

        return true;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
    var canvas = document.getElementById('signature-pad');
    var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgba(255,255,255,0)',
        penColor: 'black'
    });

    function clearSignature() {
        signaturePad.clear();
        document.getElementById('signature-image').style.display = 'none';
        document.getElementById('signature-underline').style.display = 'inline-block';
    }

    function saveSignature() {
        if (!signaturePad.isEmpty()) {
            var dataURL = signaturePad.toDataURL();
            var img = document.getElementById('signature-image');
            img.src = dataURL;
            img.style.display = 'inline-block';
            document.getElementById('signature-underline').style.display = 'none';
        }
    }
</script>

</html>