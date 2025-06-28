-- Database updates for notification system
-- Run this file to add notification functionality

-- Add notification status columns to existing tables
ALTER TABLE tbl_rescert ADD COLUMN notification_sent TINYINT(1) DEFAULT 0;
ALTER TABLE tbl_rescert ADD COLUMN notification_date DATETIME NULL;
ALTER TABLE tbl_rescert ADD COLUMN generated_by VARCHAR(255) NULL;
ALTER TABLE tbl_rescert ADD COLUMN generated_date DATETIME NULL;

ALTER TABLE tbl_indigency ADD COLUMN notification_sent TINYINT(1) DEFAULT 0;
ALTER TABLE tbl_indigency ADD COLUMN notification_date DATETIME NULL;
ALTER TABLE tbl_indigency ADD COLUMN generated_by VARCHAR(255) NULL;
ALTER TABLE tbl_indigency ADD COLUMN generated_date DATETIME NULL;

ALTER TABLE tbl_clearance ADD COLUMN notification_sent TINYINT(1) DEFAULT 0;
ALTER TABLE tbl_clearance ADD COLUMN notification_date DATETIME NULL;
ALTER TABLE tbl_clearance ADD COLUMN generated_by VARCHAR(255) NULL;
ALTER TABLE tbl_clearance ADD COLUMN generated_date DATETIME NULL;

ALTER TABLE tbl_bspermit ADD COLUMN notification_sent TINYINT(1) DEFAULT 0;
ALTER TABLE tbl_bspermit ADD COLUMN notification_date DATETIME NULL;
ALTER TABLE tbl_bspermit ADD COLUMN generated_by VARCHAR(255) NULL;
ALTER TABLE tbl_bspermit ADD COLUMN generated_date DATETIME NULL;

-- Create notifications table for system notifications
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create notification settings table
CREATE TABLE IF NOT EXISTS tbl_notification_settings (
    id_setting INT(11) NOT NULL AUTO_INCREMENT,
    setting_name VARCHAR(100) NOT NULL,
    setting_value TEXT NOT NULL,
    description TEXT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_setting),
    UNIQUE KEY unique_setting (setting_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default notification settings
INSERT INTO tbl_notification_settings (setting_name, setting_value, description) VALUES
('email_enabled', '1', 'Enable email notifications'),
('sms_enabled', '1', 'Enable SMS notifications'),
('africas_talking_username', 'Iot_project', 'AfricasTalking username'),
('africas_talking_api_key', 'atsk_6ccbe2174a56e50490d59c73c1f7177fc02e47c2cdecb5343b67e6680bc321677b10c4bd', 'AfricasTalking API key'),
('smtp_host', 'smtp.gmail.com', 'SMTP host for email'),
('smtp_username', 'infofonepo@gmail.com', 'SMTP username'),
('smtp_password', 'zaoxwuezfjpglwjb', 'SMTP password'),
('smtp_port', '587', 'SMTP port'),
('smtp_secure', 'tls', 'SMTP security type'),
('system_name', 'Nyarutarama Information & E-Services Management System', 'System name for notifications'),
('admin_email', 'admin@nyarutarama.rw', 'Admin email address');

-- Add indexes for better performance
CREATE INDEX idx_rescert_notification ON tbl_rescert(notification_sent, notification_date);
CREATE INDEX idx_indigency_notification ON tbl_indigency(notification_sent, notification_date);
CREATE INDEX idx_clearance_notification ON tbl_clearance(notification_sent, notification_date);
CREATE INDEX idx_bspermit_notification ON tbl_bspermit(notification_sent, notification_date); 