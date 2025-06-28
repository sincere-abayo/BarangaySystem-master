<?php
/**
 * Check available residents in the database
 */

require_once 'classes/resident.class.php';

$resident = new Resident();

echo "<h2>Checking Available Residents in Database</h2>";

// Get all residents
$connection = $resident->openConn();
$stmt = $connection->prepare("SELECT id_resident, fname, lname, mi, email, contact FROM tbl_resident LIMIT 10");
$stmt->execute();
$residents = $stmt->fetchAll();

if ($residents) {
    echo "<p style='color: green;'>✓ Found " . count($residents) . " residents in database</p>";

    echo "<h3>Available Residents:</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Contact</th><th>Status</th></tr>";

    foreach ($residents as $res) {
        $name = $res['fname'] . ' ' . $res['mi'] . ' ' . $res['lname'];
        $email = $res['email'] ?? 'NOT SET';
        $contact = $res['contact'] ?? 'NOT SET';

        $email_status = !empty($email) && $email !== 'NOT SET' ? '✓' : '✗';
        $contact_status = !empty($contact) && $contact !== 'NOT SET' ? '✓' : '✗';

        echo "<tr>";
        echo "<td>" . $res['id_resident'] . "</td>";
        echo "<td>" . htmlspecialchars($name) . "</td>";
        echo "<td>" . htmlspecialchars($email) . "</td>";
        echo "<td>" . htmlspecialchars($contact) . "</td>";
        echo "<td>Email: $email_status | Contact: $contact_status</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Find a resident with valid email and contact
    $valid_resident = null;
    foreach ($residents as $res) {
        if (
            !empty($res['email']) && !empty($res['contact']) &&
            $res['email'] !== 'NOT SET' && $res['contact'] !== 'NOT SET'
        ) {
            $valid_resident = $res;
            break;
        }
    }

    if ($valid_resident) {
        echo "<h3>Testing with Valid Resident (ID: " . $valid_resident['id_resident'] . ")</h3>";

        // Test notification with this resident
        require_once 'classes/Notification.php';
        $notification = new Notification();

        $recipient_data = [
            'email' => $valid_resident['email'],
            'contact' => $valid_resident['contact'],
            'full_name' => $valid_resident['fname'] . ' ' . $valid_resident['mi'] . ' ' . $valid_resident['lname']
        ];

        $service_data = [
            'service_type' => 'Certificate of Residency',
            'certificate_number' => 'TEST-001',
            'date' => date('Y-m-d'),
            'generated_date' => date('Y-m-d H:i:s')
        ];

        echo "<h4>Recipient Data:</h4>";
        echo "<pre>" . print_r($recipient_data, true) . "</pre>";

        echo "<h4>Service Data:</h4>";
        echo "<pre>" . print_r($service_data, true) . "</pre>";

        echo "<h4>Sending Test Notification...</h4>";

        $notification_result = $notification->sendServiceNotifications($recipient_data, $service_data, 'ready');

        echo "<h4>Notification Result:</h4>";
        echo "<pre>" . print_r($notification_result, true) . "</pre>";

        if ($notification_result['email_sent']) {
            echo "<p style='color: green;'>✓ Email notification sent successfully!</p>";
        } else {
            echo "<p style='color: red;'>✗ Email notification failed!</p>";
        }

        if ($notification_result['sms_sent']) {
            echo "<p style='color: green;'>✓ SMS notification sent successfully!</p>";
        } else {
            echo "<p style='color: red;'>✗ SMS notification failed!</p>";
        }

    } else {
        echo "<p style='color: red;'>✗ No residents found with valid email and contact information!</p>";
        echo "<p><strong>Solution:</strong> Update resident records in the database to include valid email and contact information.</p>";
    }

} else {
    echo "<p style='color: red;'>✗ No residents found in database!</p>";
}
?>