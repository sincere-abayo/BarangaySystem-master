<?php
/**
 * Test script to simulate sending a notification
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== TESTING NOTIFICATION SENDING ===\n\n";

// Simulate POST data
$_POST['service_type'] = 'certificate_residency';
$_POST['id_resident'] = '25'; // Jun Trinidad
$_POST['certificate_id'] = '111112'; // Valid certificate ID

try {
    // Include the notification handler
    require_once 'classes/Authentication.php';
    require_once 'classes/Notification.php';
    require_once 'classes/resident.class.php';

    $auth = new Authentication();
    $notification = new Notification();
    $resident = new Resident();

    // Check if admin is logged in (skip for testing)
    // $auth->validate_admin();
    // $userdetails = $auth->get_userdata();

    $service_type = $_POST['service_type'] ?? '';
    $id_resident = $_POST['id_resident'] ?? '';
    $certificate_id = $_POST['certificate_id'] ?? '';

    if (empty($service_type) || empty($id_resident) || empty($certificate_id)) {
        echo "Error: Missing required parameters\n";
        exit;
    }

    // Get resident data
    $resident_data = $resident->get_single_resident($id_resident);
    if (!$resident_data) {
        echo "Error: Resident not found\n";
        exit;
    }

    echo "Resident found: " . $resident_data['fname'] . " " . $resident_data['lname'] . "\n";

    // Prepare recipient data
    $recipient_data = [
        'email' => $resident_data['email'],
        'contact' => $resident_data['contact'],
        'full_name' => $resident_data['fname'] . ' ' . $resident_data['mi'] . ' ' . $resident_data['lname']
    ];

    echo "Recipient data:\n";
    echo "- Email: " . ($recipient_data['email'] ?: 'Not provided') . "\n";
    echo "- Contact: " . ($recipient_data['contact'] ?: 'Not provided') . "\n";
    echo "- Name: " . $recipient_data['full_name'] . "\n\n";

    // Get service data
    $service_data = [
        'service_type' => 'Certificate of Residency',
        'certificate_number' => $certificate_id,
        'date' => date('Y-m-d'),
        'generated_date' => date('Y-m-d H:i:s')
    ];

    echo "Service data:\n";
    echo "- Type: " . $service_data['service_type'] . "\n";
    echo "- Certificate ID: " . $service_data['certificate_number'] . "\n";
    echo "- Date: " . $service_data['date'] . "\n\n";

    // Send notifications
    echo "Sending notifications...\n";
    $notification_result = $notification->sendServiceNotifications($recipient_data, $service_data, 'ready');

    echo "Notification results:\n";
    echo "- Email sent: " . ($notification_result['email_sent'] ? 'Yes' : 'No') . "\n";
    echo "- SMS sent: " . ($notification_result['sms_sent'] ? 'Yes' : 'No') . "\n\n";

    // Create system notification
    $title = $service_data['service_type'] . ' Ready';
    $message = "Your {$service_data['service_type']} is ready for collection at Nyarutarama Cell Office.";
    $system_notification = $notification->createSystemNotification($id_resident, 'certificate_residency', $title, $message);

    echo "System notification created: " . ($system_notification ? 'Yes' : 'No') . "\n";

    // Update notification status in database
    $status_updated = $notification->updateServiceNotificationStatus('tbl_rescert', 'id_rescert', $certificate_id, 'Test Admin');

    echo "Database status updated: " . ($status_updated ? 'Yes' : 'No') . "\n\n";

    echo "=== TEST COMPLETED SUCCESSFULLY ===\n";

} catch (Exception $e) {
    echo "\n=== TEST FAILED ===\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>