<?php
require_once 'classes/Authentication.php';
require_once 'classes/Notification.php';
require_once 'classes/resident.class.php';

echo "<h2>Testing Complete Notification Flow (Simulating Notify Button Click)</h2>";

try {
    $auth = new Authentication();
    $notification = new Notification();
    $resident = new Resident();

    // Simulate the data that would be sent via AJAX
    $service_type = 'certificate_residency';
    $id_resident = 35; // Use a real resident ID from your database
    $certificate_id = 111112; // Use the correct certificate ID from database

    echo "<h3>1. Simulating AJAX Request Data</h3>";
    echo "<p><strong>Service Type:</strong> {$service_type}</p>";
    echo "<p><strong>Resident ID:</strong> {$id_resident}</p>";
    echo "<p><strong>Certificate ID:</strong> {$certificate_id}</p>";

    // Get resident data (same as notify_resident.php)
    $resident_data = $resident->get_single_resident($id_resident);

    if (!$resident_data) {
        echo "<p style='color: red;'>✗ Resident not found!</p>";
        exit;
    }

    echo "<h3>2. Resident Data Retrieved</h3>";
    echo "<p><strong>Name:</strong> {$resident_data['fname']} {$resident_data['lname']}</p>";
    echo "<p><strong>Email:</strong> {$resident_data['email']}</p>";
    echo "<p><strong>Contact:</strong> {$resident_data['contact']}</p>";

    // Get certificate data
    $connection = $notification->openConn();
    $stmt = $connection->prepare("SELECT * FROM tbl_rescert WHERE id_rescert = ?");
    $stmt->execute([$certificate_id]);
    $certificate_data = $stmt->fetch();

    if (!$certificate_data) {
        echo "<p style='color: red;'>✗ Certificate not found!</p>";
        exit;
    }

    echo "<h3>3. Certificate Data Retrieved</h3>";
    echo "<p><strong>Certificate Number:</strong> {$certificate_data['id_rescert']}</p>";
    echo "<p><strong>Date:</strong> {$certificate_data['date']}</p>";

    // Prepare service data
    $serviceData = [
        'service_type' => 'Certificate of Residency',
        'certificate_number' => $certificate_data['id_rescert'],
        'date' => $certificate_data['date'],
        'generated_date' => date('Y-m-d H:i:s')
    ];

    // Prepare recipient data
    $recipientData = [
        'email' => $resident_data['email'],
        'contact' => $resident_data['contact'],
        'full_name' => $resident_data['fname'] . ' ' . $resident_data['lname']
    ];

    echo "<h3>4. Sending Notifications</h3>";

    // Send notifications
    $result = $notification->sendServiceNotifications($recipientData, $serviceData, 'ready');

    echo "<h3>5. Notification Results</h3>";
    echo "<p><strong>Email Sent:</strong> " . ($result['email_sent'] ? '✓ Yes' : '✗ No') . "</p>";
    echo "<p><strong>SMS Sent:</strong> " . ($result['sms_sent'] ? '✓ Yes' : '✗ No') . "</p>";

    if ($result['email_sent'] || $result['sms_sent']) {
        echo "<p style='color: green;'>✓ Notification sent successfully!</p>";

        // Update notification status in database
        $notification->updateServiceNotificationStatus('tbl_rescert', 'id_rescert', $certificate_id, 'Admin');
        echo "<p style='color: green;'>✓ Database updated successfully!</p>";
    } else {
        echo "<p style='color: red;'>✗ Both email and SMS failed to send.</p>";
    }

} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>