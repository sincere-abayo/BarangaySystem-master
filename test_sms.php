<?php
require_once __DIR__ . '/vendor/autoload.php';

use AfricasTalking\SDK\AfricasTalking;

echo "<h2>Testing AfricasTalking SMS Configuration</h2>";

try {
    // Initialize the SDK
    $username = "Iot_project"; // Use 'sandbox' for testing
    $apiKey = "atsk_6ccbe2174a56e50490d59c73c1f7177fc02e47c2cdecb5343b67e6680bc321677b10c4bd"; // Replace with your actual API key

    $AT = new AfricasTalking($username, $apiKey);

    // Get the SMS service
    $sms = $AT->sms();

    // Use the service
    $result = $sms->send([
        'to' => '+250723527270', // Replace with a real phone number for testing
        'message' => 'Hello from Barangay System! This is a test SMS.'
    ]);

    echo "<p style='color: green;'>✓ SMS sent successfully!</p>";
    echo "<pre>" . print_r($result, true) . "</pre>";

} catch (Exception $e) {
    echo "<p style='color: red;'>✗ SMS Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>AfricasTalking Configuration:</strong></p>";
    echo "<ul>";
    echo "<li>Username: sandbox (for testing)</li>";
    echo "<li>API Key: [Your API Key]</li>";
    echo "<li>Phone Number: +254700000000 (replace with real number)</li>";
    echo "</ul>";
    echo "<p><strong>Note:</strong> You need to:</p>";
    echo "<ul>";
    echo "<li>Sign up for AfricasTalking account</li>";
    echo "<li>Get your API key from the dashboard</li>";
    echo "<li>Replace the API key in the code</li>";
    echo "<li>Use a real phone number for testing</li>";
    echo "</ul>";
}
?>