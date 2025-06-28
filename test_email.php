<?php
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

echo "<h2>Testing Gmail SMTP Configuration</h2>";

try {
    $mail = new PHPMailer(true);

    // Enable debug output
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->Debugoutput = 'html';

    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'infofonepo@gmail.com';
    $mail->Password = 'zaoxwuezfjpglwjb';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Additional SMTP settings for better reliability
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    // Recipients
    $mail->setFrom('infofonepo@gmail.com', 'Test System');
    $mail->addAddress('abayosincere11@gmail.com', 'abayo User');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from Barangay System';
    $mail->Body = '<h1>Test Email</h1><p>This is a test email to verify SMTP configuration.</p>';

    echo "<p>Attempting to send email...</p>";

    if ($mail->send()) {
        echo "<p style='color: green;'>✓ Email sent successfully!</p>";
    } else {
        echo "<p style='color: red;'>✗ Email failed to send.</p>";
    }

} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>SMTP Configuration:</strong></p>";
    echo "<ul>";
    echo "<li>Host: smtp.gmail.com</li>";
    echo "<li>Port: 587</li>";
    echo "<li>Username: infofonepo@gmail.com</li>";
    echo "<li>Security: STARTTLS</li>";
    echo "</ul>";
    echo "<p><strong>Troubleshooting Tips:</strong></p>";
    echo "<ul>";
    echo "<li>Check if the Gmail app password is still valid</li>";
    echo "<li>Verify that 2-factor authentication is enabled on the Gmail account</li>";
    echo "<li>Check if 'Less secure app access' is enabled (if not using app password)</li>";
    echo "<li>Verify network connectivity to smtp.gmail.com:587</li>";
    echo "</ul>";
}
?>