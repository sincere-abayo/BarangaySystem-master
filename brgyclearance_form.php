<?php
ini_set('display_errors', 0);
require('classes/Authentication.php');
require('classes/Certificate.php');
require('classes/resident.class.php');
$auth = new Authentication();
$certificate = new Certificate();
$resident_obj = new Resident();
$userdetails = $auth->get_userdata();
$id_clearance = isset($_GET['id_clearance']) ? $_GET['id_clearance'] : null;
$clearance = $id_clearance ? $certificate->get_single_clearance($id_clearance) : false;
if (!$clearance) {
    die('<div style="color:red;text-align:center;margin-top:2em;">Clearance not found. Please check the link or try again.</div>');
}
$resident = $resident_obj->get_single_resident($clearance['id_resident']);
if (!$resident) {
    die('<div style="color:red;text-align:center;margin-top:2em;">Resident not found. Please check the link or try again.</div>');
}
// Certificate details
$cert_no = str_pad($clearance['id_clearance'], 6, '0', STR_PAD_LEFT);
$issued_at = !empty($clearance['brgy']) ? $clearance['brgy'] : 'Not specified';
$issued_on = date('F d, Y');
$full_name = trim($clearance['fname'] . ' ' . $clearance['mi'] . ' ' . $clearance['lname']);
$address = trim($clearance['houseno'] . ', ' . $clearance['street'] . ', ' . $clearance['brgy'] . ', ' . $clearance['municipal']);
$age = $clearance['age'];
$nationality = isset($resident['nationality']) ? $resident['nationality'] : '';
$purpose = $clearance['purpose'];
$status = $clearance['status'];
?>
<!DOCTYPE html>
<html id="clearance">

<head>
    <meta charset="UTF-8">
    <title>Barangay Clearance Certificate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/font-awesome.min.css" rel="stylesheet">
    <style>
        @media print {
            .noprint {
                display: none !important;
            }

            body {
                background: #fff !important;
            }

            #signature-pad-controls {
                display: none !important;
            }
        }

        body {
            background: #f8f9fa;
        }

        .certificate-container {
            max-width: 800px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 2.5rem 2.5rem 2rem 2.5rem;
            position: relative;
        }

        .certificate-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .certificate-title {
            font-size: 2.2rem;
            font-weight: bold;
            letter-spacing: 2px;
            color: #003366;
        }

        .certificate-body {
            font-size: 1.15rem;
            color: #222;
            margin-bottom: 2rem;
        }

        .certificate-footer {
            margin-top: 2.5rem;
            font-size: 1rem;
        }

        .issue-block {
            margin-top: 2.5rem;
            font-size: 1.1rem;
            background: #e9ecef;
            border-radius: 8px;
            padding: 1.2rem 1.5rem;
            display: flex;
            justify-content: space-between;
        }

        .barangay-logo {
            width: 90px;
            position: absolute;
            top: 2.5rem;
            left: 2.5rem;
        }

        .signature-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 2.5rem;
            margin-bottom: 1.5rem;
        }

        .signature-box {
            width: 320px;
            margin: 0 auto 0.5rem auto;
            text-align: center;
        }

        #signature-pad {
            border: 1px solid #888;
            border-radius: 6px;
            background: #fff;
            width: 320px;
            height: 90px;
            margin: 0 auto 0.5rem auto;
            display: block;
            position: relative;
            z-index: 1;
        }

        .sig-label {
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 0.2rem;
        }

        .official-name {
            margin-top: 1.2rem;
            text-align: center;
        }

        @media print {

            #signature-pad,
            #signature-pad-controls,
            .sig-label {
                display: none !important;
            }

            #signature-image {
                display: block !important;
                margin: 0 auto 0.5rem auto !important;
            }
        }
    </style>
</head>

<body>
    <div class="certificate-container" id="printableArea">
        <img src="icons/beverlylogo.png" class="barangay-logo" alt="Barangay Logo">
        <div class="certificate-header">
            <div style="font-size:1.1rem; color:#555;">Republic of the Philippines<br>Municipality of
                Antipolo<br>Province of Metro Manila</div>
            <div class="certificate-title">BARANGAY CLEARANCE</div>
            <div style="font-size:1.1rem; color:#555; margin-top:0.5rem;">Barangay Beverly Hills</div>
        </div>
        <div class="certificate-body">
            <p class="text-center">This is to certify that <strong><?= htmlspecialchars($full_name) ?></strong>,
                <?= htmlspecialchars($age) ?> Years Old, <?= htmlspecialchars($nationality) ?>
                and a bonafide resident of
                <?= htmlspecialchars($address) ?>.
            </p>
            <p class="text-center">Further certify that the above-named subject is of good moral character and has no
                derogatory record in this office, law abiding citizen and reliable.</p>
            <p class="text-center">This certification is issued upon the request of the above-named party as a
                supporting document needed for <ins><?= htmlspecialchars($purpose) ?></ins>.</p>
        </div>
        <div class="issue-block">
            <div><strong>Rest. Cert. No.:</strong> <?= $cert_no ?></div>
            <div><strong>Issued at:</strong> <?= htmlspecialchars($issued_at) ?></div>
            <div><strong>Issued on:</strong> <?= $issued_on ?></div>
        </div>
        <div class="certificate-footer text-end">
            <div class="signature-block text-center">
                <div class="signature-box">
                    <div class="sig-label">Signature</div>
                    <canvas id="signature-pad"></canvas>
                    <img id="signature-image" src="" alt="Signature"
                        style="max-width:180px; max-height:60px; display:none; margin:0 auto 0.5rem auto; background:#fff;" />
                    <div id="signature-pad-controls" class="noprint">
                        <button type="button" class="btn btn-sm btn-secondary" id="clear-signature">Clear</button>
                        <button type="button" class="btn btn-success btn-sm" id="save-signature">Save</button>
                    </div>
                </div>
                <div class="official-name" style="margin-top:1.2rem;">
                    <span
                        style="font-weight:600; font-size:1.1rem; border-top:1px solid #333; padding-top:0.2rem;">VINCENT
                        VILFAMAT</span>
                    <br>
                    <label>Punong Barangay</label>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <button class="btn btn-primary noprint" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.6/dist/signature_pad.umd.min.js"></script>
    <script>
        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: '#fff',
            penColor: 'black',
        });
        // Resize canvas for crisp signature
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext('2d').scale(ratio, ratio);
            signaturePad.clear();
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();
        document.getElementById('clear-signature').addEventListener('click', function () {
            signaturePad.clear();
            document.getElementById('signature-image').style.display = 'none';
            canvas.style.display = 'block';
            document.querySelector('.sig-label').style.display = '';
        });
        document.getElementById('save-signature').addEventListener('click', function () {
            if (!signaturePad.isEmpty()) {
                var dataURL = signaturePad.toDataURL();
                var img = document.getElementById('signature-image');
                img.src = dataURL;
                img.style.display = 'block';
                canvas.style.display = 'none';
                document.querySelector('.sig-label').style.display = 'none';
            }
        });
        // On print, if signature is empty, hide the canvas
        window.onbeforeprint = function () {
            if (signaturePad.isEmpty()) {
                canvas.style.display = 'none';
                document.querySelector('.sig-label').style.display = 'none';
            }
        };
        window.onafterprint = function () {
            canvas.style.display = '';
            document.querySelector('.sig-label').style.display = '';
        };
    </script>
</body>

</html>