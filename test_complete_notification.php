<?php
require_once 'classes/Authentication.php';
require_once 'classes/Notification.php';
require_once 'classes/resident.class.php';

echo "<h2>Complete Notification System Test</h2>";

try {
    $auth = new Authentication();
    $notification = new Notification();
    $resident = new Resident();

    echo "<h3>1. Testing Email Configuration</h3>";

    // Test email with real data
    $test_recipient = [
        'email' => 'abayosincere11@gmail.com', // Replace with a real email for testing
        'contact' => '0723527270',
        'full_name' => 'John Doe'
    ];

    $test_service = [
        'service_type' => 'Certificate of Residency',
        'certificate_number' => 'TEST-001',
        'date' => date('Y-m-d'),
        'generated_date' => date('Y-m-d H:i:s')
    ];

    echo "<p>Testing email to: {$test_recipient['email']}</p>";

    $emailResult = $notification->sendServiceEmail(
        $test_recipient['email'],
        $test_recipient['full_name'],
        $test_service,
        'ready'
    );

    if ($emailResult) {
        echo "<p style='color: green;'>✓ Email sent successfully!</p>";
    } else {
        echo "<p style='color: red;'>✗ Email failed to send.</p>";
    }

    echo "<h3>2. Testing SMS Configuration</h3>";

    echo "<p>Testing SMS to: {$test_recipient['contact']}</p>";

    $smsResult = $notification->sendServiceSMS(
        $test_recipient['contact'],
        $test_recipient['full_name'],
        $test_service,
        'ready'
    );

    if ($smsResult) {
        echo "<p style='color: green;'>✓ SMS logged successfully!</p>";
    } else {
        echo "<p style='color: red;'>✗ SMS failed.</p>";
    }

    echo "<h3>3. Testing Complete Notification System</h3>";

    $notificationResult = $notification->sendServiceNotifications(
        $test_recipient,
        $test_service,
        'ready'
    );

    echo "<p>Email sent: " . ($notificationResult['email_sent'] ? 'Yes' : 'No') . "</p>";
    echo "<p>SMS sent: " . ($notificationResult['sms_sent'] ? 'Yes' : 'No') . "</p>";

    echo "<h3>4. Testing Database Operations</h3>";

    // Test creating a system notification
    $systemNotificationResult = $notification->createSystemNotification(
        1, // Test resident ID
        'certificate_residency',
        'Certificate Ready',
        'Your certificate is ready for collection.'
    );

    if ($systemNotificationResult) {
        echo "<p style='color: green;'>✓ System notification created successfully!</p>";
    } else {
        echo "<p style='color: red;'>✗ System notification failed.</p>";
    }

    // Test getting unread notifications
    $unreadNotifications = $notification->getUnreadNotifications(1);
    echo "<p>Unread notifications found: " . count($unreadNotifications) . "</p>";

    echo "<h3>5. Summary</h3>";
    echo "<p><strong>Email Configuration:</strong> " . ($emailResult ? 'Working' : 'Not Working') . "</p>";
    echo "<p><strong>SMS Configuration:</strong> " . ($smsResult ? 'Logged (API not configured)' : 'Not Working') . "</p>";
    echo "<p><strong>Database Operations:</strong> " . ($systemNotificationResult ? 'Working' : 'Not Working') . "</p>";

    if ($emailResult && $smsResult && $systemNotificationResult) {
        echo "<p style='color: green; font-weight: bold;'>🎉 All notification system components are working!</p>";
        echo "<p><strong>Next Steps:</strong></p>";
        echo "<ul>";
        echo "<li>Configure AfricasTalking API credentials for real SMS</li>";
        echo "<li>Test with real resident data from the database</li>";
        echo "<li>Verify notifications appear in the resident dashboard</li>";
        echo "</ul>";
    } else {
        echo "<p style='color: orange; font-weight: bold;'>⚠️ Some components need attention.</p>";
    }

} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>