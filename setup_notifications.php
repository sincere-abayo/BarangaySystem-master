<?php
/**
 * Notification System Setup Script
 * 
 * This script will help you set up the notification system by:
 * 1. Creating the notification tables
 * 2. Inserting default settings
 * 3. Testing the configuration
 */

require_once 'classes/Database.php';

echo "=== NOTIFICATION SYSTEM SETUP ===\n\n";

// Step 1: Create notification tables
echo "Step 1: Creating notification tables...\n";

$db = new Database();
$connection = $db->openConn();

// Create notifications table
$createNotificationsTable = "
CREATE TABLE IF NOT EXISTS tbl_notifications (
    id_notification INT(11) NOT NULL AUTO_INCREMENT,
    id_resident INT(11) NOT NULL,
    notification_type ENUM('certificate_residency', 'certificate_indigency', 'clearance', 'business_permit') NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    read_date DATETIME NULL,
    PRIMARY KEY (id_notification),
    INDEX idx_resident (id_resident),
    INDEX idx_type (notification_type),
    INDEX idx_read (is_read)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

// Create notification settings table
$createSettingsTable = "
CREATE TABLE IF NOT EXISTS tbl_notification_settings (
    id_setting INT(11) NOT NULL AUTO_INCREMENT,
    setting_name VARCHAR(100) NOT NULL,
    setting_value TEXT NOT NULL,
    description TEXT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_setting),
    UNIQUE KEY unique_setting (setting_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

try {
    $connection->exec($createNotificationsTable);
    echo "✓ Notifications table created successfully\n";

    $connection->exec($createSettingsTable);
    echo "✓ Settings table created successfully\n";
} catch (PDOException $e) {
    echo "✗ Error creating tables: " . $e->getMessage() . "\n";
    exit(1);
}

// Step 2: Insert default settings
echo "\nStep 2: Inserting default settings...\n";

$defaultSettings = [
    ['email_enabled', '1', 'Enable email notifications'],
    ['sms_enabled', '1', 'Enable SMS notifications'],
    ['smtp_host', 'smtp.gmail.com', 'SMTP server hostname'],
    ['smtp_port', '587', 'SMTP server port'],
    ['smtp_username', 'your_email@gmail.com', 'SMTP username'],
    ['smtp_password', 'your_app_password', 'SMTP password'],
    ['smtp_secure', 'tls', 'SMTP encryption (tls/ssl)'],
    ['admin_email', 'admin@nyarutarama.com', 'Admin email address'],
    ['system_name', 'Nyarutarama Cell Management System', 'System name for notifications'],
    ['africas_talking_username', 'your_africastalking_username', 'AfricasTalking username'],
    ['africas_talking_api_key', 'your_africastalking_api_key', 'AfricasTalking API key'],
    ['sms_sender_id', 'NYARUTARAMA', 'SMS sender ID']
];

$insertSetting = $connection->prepare("
    INSERT INTO tbl_notification_settings (setting_name, setting_value, description) 
    VALUES (?, ?, ?) 
    ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)
");

foreach ($defaultSettings as $setting) {
    try {
        $insertSetting->execute($setting);
        echo "✓ Setting '{$setting[0]}' inserted/updated\n";
    } catch (PDOException $e) {
        echo "✗ Error inserting setting '{$setting[0]}': " . $e->getMessage() . "\n";
    }
}

// Step 3: Test configuration
echo "\nStep 3: Testing configuration...\n";

try {
    // Test database connection
    $testConnection = $db->openConn();
    echo "✓ Database connection test successful\n";

    // Test settings loading
    $settings = $testConnection->query("SELECT COUNT(*) FROM tbl_notification_settings")->fetchColumn();
    echo "✓ Settings loaded successfully ({$settings} settings found)\n";

    // Test notifications table
    $notifications = $testConnection->query("SELECT COUNT(*) FROM tbl_notifications")->fetchColumn();
    echo "✓ Notifications table accessible ({$notifications} notifications found)\n";

} catch (Exception $e) {
    echo "✗ Configuration test failed: " . $e->getMessage() . "\n";
}

echo "\n=== SETUP COMPLETE ===\n\n";
echo "Next steps:\n";
echo "1. Update the notification settings in the database with your actual values\n";
echo "2. Configure your SMTP settings for email notifications\n";
echo "3. Configure your AfricasTalking credentials for SMS notifications\n";
echo "4. Test the notification system by generating a certificate and clicking 'Notify'\n\n";

echo "To update settings, you can:\n";
echo "- Use phpMyAdmin to edit tbl_notification_settings\n";
echo "- Or create an admin interface to manage settings\n";
echo "- Or manually update the database with your credentials\n\n";

echo "Example SQL to update settings:\n";
echo "UPDATE tbl_notification_settings SET setting_value = 'your_actual_value' WHERE setting_name = 'smtp_username';\n";
echo "UPDATE tbl_notification_settings SET setting_value = 'your_actual_value' WHERE setting_name = 'africas_talking_api_key';\n\n";

echo "Setup completed successfully!\n";
?>