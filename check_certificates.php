<?php
require_once 'classes/conn.php';

echo "<h2>Checking Available Certificates in Database</h2>";

// Get all certificates
$stmt = $conn->prepare("SELECT id_rescert, id_resident, fname, lname, date, notification_sent FROM tbl_rescert LIMIT 10");
$stmt->execute();
$certificates = $stmt->fetchAll();

if ($certificates) {
    echo "<p style='color: green;'>✓ Found " . count($certificates) . " certificates in database</p>";

    echo "<h3>Available Certificates:</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Certificate ID</th><th>Resident ID</th><th>Name</th><th>Date</th><th>Notification Sent</th></tr>";

    foreach ($certificates as $cert) {
        $name = $cert['fname'] . ' ' . $cert['lname'];
        $notificationStatus = $cert['notification_sent'] ? 'Yes' : 'No';
        echo "<tr>";
        echo "<td>{$cert['id_rescert']}</td>";
        echo "<td>{$cert['id_resident']}</td>";
        echo "<td>{$name}</td>";
        echo "<td>{$cert['date']}</td>";
        echo "<td>{$notificationStatus}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>✗ No certificates found in database</p>";
}
?>