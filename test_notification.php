<?php
/**
 * Test script for notification system
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'classes/Authentication.php';
require_once 'classes/Notification.php';
require_once 'classes/resident.class.php';

$auth = new Authentication();
$notification = new Notification();
$resident = new Resident();

// Check if admin is logged in
$auth->validate_admin();

echo "<h2>Testing Notification System</h2>";

// Test data
$test_recipient = [
    'email' => 'test@example.com', // Replace with a real email for testing
    'contact' => '0780123456', // Replace with a real phone number for testing
    'full_name' => 'John Doe'
];

$test_service = [
    'service_type' => 'Certificate of Residency',
    'certificate_number' => 'TEST-001',
    'date' => date('Y-m-d'),
    'generated_date' => date('Y-m-d H:i:s')
];

echo "<h3>Test Configuration:</h3>";
echo "<p><strong>Recipient Email:</strong> " . $test_recipient['email'] . "</p>";
echo "<p><strong>Recipient Phone:</strong> " . $test_recipient['contact'] . "</p>";
echo "<p><strong>Recipient Name:</strong> " . $test_recipient['full_name'] . "</p>";
echo "<p><strong>Service Type:</strong> " . $test_service['service_type'] . "</p>";
echo "<p><strong>Certificate Number:</strong> " . $test_service['certificate_number'] . "</p>";

echo "<h3>Testing Email Notification:</h3>";
$email_result = $notification->sendServiceEmail(
    $test_recipient['email'],
    $test_recipient['full_name'],
    $test_service,
    'ready'
);

if ($email_result) {
    echo "<p style='color: green;'>✓ Email sent successfully!</p>";
} else {
    echo "<p style='color: red;'>✗ Email failed to send. Check error logs.</p>";
}

echo "<h3>Testing SMS Notification:</h3>";
$sms_result = $notification->sendServiceSMS(
    $test_recipient['contact'],
    $test_recipient['full_name'],
    $test_service,
    'ready'
);

if ($sms_result) {
    echo "<p style='color: green;'>✓ SMS sent successfully!</p>";
} else {
    echo "<p style='color: red;'>✗ SMS failed to send. Check error logs.</p>";
}

echo "<h3>Testing Combined Notifications:</h3>";
$combined_result = $notification->sendServiceNotifications($test_recipient, $test_service, 'ready');

echo "<p><strong>Email Result:</strong> " . ($combined_result['email_sent'] ? 'Success' : 'Failed') . "</p>";
echo "<p><strong>SMS Result:</strong> " . ($combined_result['sms_sent'] ? 'Success' : 'Failed') . "</p>";

echo "<h3>Configuration Check:</h3>";
echo "<p><strong>Gmail SMTP:</strong> smtp.gmail.com:587</p>";
echo "<p><strong>Gmail Username:</strong> infofonepo@gmail.com</p>";
echo "<p><strong>AfricasTalking Username:</strong> Iot_project</p>";
echo "<p><strong>SMS Sender ID:</strong> NYARUTARAMA</p>";

echo "<hr>";
echo "<p><em>Note: Replace the test email and phone number with real ones to test actual delivery.</em></p>";
echo "<p><em>Check your server's error logs for detailed error messages if notifications fail.</em></p>";
?>