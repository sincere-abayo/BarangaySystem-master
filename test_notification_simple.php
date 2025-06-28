<?php
require_once 'classes/Notification.php';

echo "<h2>Simple Notification Test</h2>";

try {
    $notification = new Notification();
    
    echo "<p>✓ Notification class instantiated successfully</p>";
    
    // Test email
    $emailResult = $notification->sendServiceEmail(
        'test@example.com',
        'Test User',
        [
            'service_type' => 'Certificate of Residency',
            'certificate_number' => 'TEST-001',
            'generated_date' => date('Y-m-d H:i:s')
        ],
        'ready'
    );
    
    if ($emailResult) {
        echo "<p style='color: green;'>✓ Email sent successfully!</p>";
    } else {
        echo "<p style='color: red;'>✗ Email failed to send.</p>";
    }
    
    // Test SMS
    $smsResult = $notification->sendServiceSMS(
        '0780123456',
        'Test User',
        [
            'service_type' => 'Certificate of Residency',
            'certificate_number' => 'TEST-001'
        ],
        'ready'
    );
    
    if ($smsResult) {
        echo "<p style='color: green;'>✓ SMS logged successfully!</p>";
    } else {
        echo "<p style='color: red;'>✗ SMS failed.</p>";
    }
    
    echo "<p><strong>Test completed successfully!</strong></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace:</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?> 