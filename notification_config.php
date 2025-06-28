<?php
/**
 * Notification System Configuration
 * 
 * This file contains the default settings for the notification system.
 * You can modify these values and run the setup script to configure your system.
 */

// Database configuration (if not already configured)
$db_config = [
    'host' => 'localhost',
    'username' => 'bmis',
    'password' => '',
    'database' => 'root'
];

// Email Configuration (SMTP)
$email_config = [
    'smtp_host' => 'smtp.gmail.com', // or your SMTP server
    'smtp_port' => 587,
    'smtp_username' => 'infofonepo@gmail.com',
    'smtp_password' => 'zaoxwuezfjpglwjb', // Use app password for Gmail
    'smtp_encryption' => 'tls', // or 'ssl'
    'admin_email' => 'admin@gmail.com',
    'system_name' => 'Nyarutarama Cell Management System'
];

// SMS Configuration (AfricasTalking)
$sms_config = [
    'africastalking_username' => 'Iot_project',
    'africastalking_api_key' => 'atsk_6ccbe2174a56e50490d59c73c1f7177fc02e47c2cdecb5343b67e6680bc321677b10c4bd',
    'sms_sender_id' => 'CELL' // or your approved sender ID
];

// Notification Settings
$notification_config = [
    'email_enabled' => '1', // 1 = enabled, 0 = disabled
    'sms_enabled' => '1',   // 1 = enabled, 0 = disabled
];

// Instructions for setup:
echo "=== NOTIFICATION SYSTEM SETUP ===\n\n";
echo "1. Update the configuration values above\n";
echo "2. Run the database setup script: php setup_notifications.php\n";
echo "3. Test the notification system\n\n";

echo "=== EMAIL SETUP ===\n";
echo "For Gmail:\n";
echo "- Enable 2-factor authentication\n";
echo "- Generate an App Password\n";
echo "- Use the App Password as smtp_password\n\n";

echo "For other providers:\n";
echo "- Use your SMTP server details\n";
echo "- Ensure SMTP is enabled on your hosting\n\n";

echo "=== SMS SETUP ===\n";
echo "1. Sign up at https://africastalking.com\n";
echo "2. Get your API key and username\n";
echo "3. Request a sender ID (optional)\n";
echo "4. Add credit to your account\n\n";

echo "=== TESTING ===\n";
echo "After setup, test the system by:\n";
echo "1. Generating a certificate as admin\n";
echo "2. Clicking the 'Notify' button\n";
echo "3. Checking if email/SMS is received\n\n";
?>