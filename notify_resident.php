<?php
require_once 'classes/Authentication.php';
require_once 'classes/Notification.php';
require_once 'classes/resident.class.php';

$auth = new Authentication();
$notification = new Notification();
$resident = new Resident();

// Check if admin is logged in
$auth->validate_admin();
$userdetails = $auth->get_userdata();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_type = $_POST['service_type'] ?? '';
    $id_resident = $_POST['id_resident'] ?? '';
    $certificate_id = $_POST['certificate_id'] ?? '';

    if (empty($service_type) || empty($id_resident) || empty($certificate_id)) {
        echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
        exit;
    }

    // Get resident data
    $resident_data = $resident->get_single_resident($id_resident);
    if (!$resident_data) {
        echo json_encode(['success' => false, 'message' => 'Resident not found']);
        exit;
    }

    // Prepare recipient data
    $recipient_data = [
        'email' => $resident_data['email'],
        'contact' => $resident_data['contact'],
        'full_name' => $resident_data['fname'] . ' ' . $resident_data['mi'] . ' ' . $resident_data['lname']
    ];

    // Get service data based on type
    $service_data = [];
    switch ($service_type) {
        case 'certificate_residency':
            $service_data = [
                'service_type' => 'Certificate of Residency',
                'certificate_number' => $certificate_id,
                'date' => date('Y-m-d'),
                'generated_date' => date('Y-m-d H:i:s')
            ];
            $notification_type = 'certificate_residency';
            $table = 'tbl_rescert';
            $id_field = 'id_rescert';
            break;

        case 'certificate_indigency':
            $service_data = [
                'service_type' => 'Certificate of Indigency',
                'certificate_number' => $certificate_id,
                'date' => date('Y-m-d'),
                'generated_date' => date('Y-m-d H:i:s')
            ];
            $notification_type = 'certificate_indigency';
            $table = 'tbl_indigency';
            $id_field = 'id_indigency';
            break;

        case 'clearance':
            $service_data = [
                'service_type' => 'Nyarutarama Clearance',
                'certificate_number' => $certificate_id,
                'date' => date('Y-m-d'),
                'generated_date' => date('Y-m-d H:i:s')
            ];
            $notification_type = 'clearance';
            $table = 'tbl_clearance';
            $id_field = 'id_clearance';
            break;

        case 'business_permit':
            $service_data = [
                'service_type' => 'Business Permit',
                'certificate_number' => $certificate_id,
                'date' => date('Y-m-d'),
                'generated_date' => date('Y-m-d H:i:s')
            ];
            $notification_type = 'business_permit';
            $table = 'tbl_bspermit';
            $id_field = 'id_bspermit';
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid service type']);
            exit;
    }

    // Send notifications
    $notification_result = $notification->sendServiceNotifications($recipient_data, $service_data, 'ready');

    // Create system notification
    $title = $service_data['service_type'] . ' Ready';
    $message = "Your {$service_data['service_type']} is ready for collection at Nyarutarama Cell Office.";
    $notification->createSystemNotification($id_resident, $notification_type, $title, $message);

    // Update notification status in database
    $generated_by = '';
    if (isset($userdetails['fname']) && isset($userdetails['lname'])) {
        $generated_by = $userdetails['fname'] . ' ' . $userdetails['lname'];
    } elseif (isset($userdetails['username'])) {
        $generated_by = $userdetails['username'];
    } else {
        $generated_by = 'Admin';
    }

    $notification->updateServiceNotificationStatus($table, $id_field, $certificate_id, $generated_by);

    $response = [
        'success' => true,
        'message' => 'Notification sent successfully',
        'email_sent' => $notification_result['email_sent'],
        'sms_sent' => $notification_result['sms_sent']
    ];

    echo json_encode($response);
    exit;
}

// If not POST request, show error
echo json_encode(['success' => false, 'message' => 'Invalid request method']);
exit;
?>