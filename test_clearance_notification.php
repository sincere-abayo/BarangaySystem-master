<?php
require_once 'classes/Authentication.php';
require_once 'classes/Notification.php';
require_once 'classes/resident.class.php';

echo "<h2>Testing Barangay Clearance Notification System</h2>";

try {
    $auth = new Authentication();
    $notification = new Notification();
    $resident = new Resident();

    // Test with a real clearance ID from your database
    $test_clearance_id = 1; // Use a real clearance ID from your database
    $test_resident_id = 24; // Use a valid resident ID from the database

    echo "<h3>1. Testing Clearance Data Retrieval</h3>";

    // Get resident data
    $resident_data = $resident->get_single_resident($test_resident_id);

    if ($resident_data) {
        echo "<p style='color: green;'>✓ Resident found!</p>";
        echo "<h4>Resident Details:</h4>";
        echo "<ul>";
        echo "<li><strong>Name:</strong> " . $resident_data['fname'] . ' ' . $resident_data['lname'] . "</li>";
        echo "<li><strong>Email:</strong> " . $resident_data['email'] . "</li>";
        echo "<li><strong>Contact:</strong> " . $resident_data['contact'] . "</li>";
        echo "</ul>";
    } else {
        echo "<p style='color: red;'>✗ Resident not found!</p>";
        exit;
    }

    echo "<h3>2. Testing Notification System</h3>";

    // Test data for clearance notification
    $clearance_data = [
        'service_type' => 'Barangay Clearance',
        'certificate_number' => 'CLR-' . $test_clearance_id,
        'date' => date('Y-m-d'),
        'generated_date' => date('Y-m-d H:i:s')
    ];

    // Test email notification
    echo "<h4>Testing Email Notification:</h4>";
    $emailResult = $notification->sendServiceEmail(
        $resident_data['email'],
        $resident_data['fname'] . ' ' . $resident_data['lname'],
        $clearance_data,
        'ready'
    );

    if ($emailResult) {
        echo "<p style='color: green;'>✓ Email sent successfully to " . $resident_data['email'] . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Email failed to send.</p>";
    }

    // Test SMS notification
    echo "<h4>Testing SMS Notification:</h4>";
    $smsResult = $notification->sendServiceSMS(
        $resident_data['contact'],
        $resident_data['fname'] . ' ' . $resident_data['lname'],
        $clearance_data,
        'ready'
    );

    if ($smsResult) {
        echo "<p style='color: green;'>✓ SMS sent successfully to " . $resident_data['contact'] . "</p>";
    } else {
        echo "<p style='color: red;'>✗ SMS failed to send.</p>";
    }

    echo "<h3>3. Testing Database Update</h3>";

    // Test updating notification status in database
    $updateResult = $notification->updateServiceNotificationStatus(
        'tbl_clearance',
        'id_clearance',
        $test_clearance_id,
        'Admin Test'
    );

    if ($updateResult) {
        echo "<p style='color: green;'>✓ Database updated successfully</p>";
    } else {
        echo "<p style='color: red;'>✗ Database update failed</p>";
    }

    echo "<h3>4. Summary</h3>";
    echo "<p><strong>Email Sent:</strong> " . ($emailResult ? 'Yes' : 'No') . "</p>";
    echo "<p><strong>SMS Sent:</strong> " . ($smsResult ? 'Yes' : 'No') . "</p>";
    echo "<p><strong>Database Updated:</strong> " . ($updateResult ? 'Yes' : 'No') . "</p>";

    if ($emailResult && $smsResult && $updateResult) {
        echo "<p style='color: green; font-weight: bold;'>🎉 All tests passed! Barangay clearance notification system is working correctly.</p>";
    } else {
        echo "<p style='color: orange; font-weight: bold;'>⚠️ Some tests failed. Please check the configuration.</p>";
    }

} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>