<?php

require_once 'Database.php';
require_once __DIR__ . '/../vendor/autoload.php';

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include AfricasTalking SDK
use AfricasTalking\SDK\AfricasTalking;

class Notification extends Database
{
    private $settings = [];
    private $africasTalking;

    public function __construct()
    {
        $this->loadSettings();
        $this->initializeAfricasTalking();
    }

    private function loadSettings()
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT setting_name, setting_value FROM tbl_notification_settings");
        $stmt->execute();
        $settings = $stmt->fetchAll();

        foreach ($settings as $setting) {
            $this->settings[$setting['setting_name']] = $setting['setting_value'];
        }
    }

    private function initializeAfricasTalking()
    {
        // Use the proven AfricasTalking credentials from the user's other project
        $username = "Iot_project";
        $apiKey = "atsk_6ccbe2174a56e50490d59c73c1f7177fc02e47c2cdecb5343b67e6680bc321677b10c4bd";

        try {
            $this->africasTalking = new AfricasTalking($username, $apiKey);
        } catch (Exception $e) {
            error_log("AfricasTalking initialization failed: " . $e->getMessage());
        }
    }

    /**
     * Get HTML email template for service notifications
     */
    private function getServiceEmailTemplate($recipientName, $serviceData, $type = 'ready')
    {
        $currentYear = date('Y');
        $headerColor = '#28a745';
        $headerTitle = $serviceData['service_type'] . ' Ready';
        $mainMessage = "Your {$serviceData['service_type']} is ready for collection at Nyarutarama Cell Office.";

        return <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>{$headerTitle}</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #ffffff;
                }
                .header {
                    background-color: {$headerColor};
                    padding: 30px 20px;
                    color: white;
                    text-align: center;
                    border-radius: 8px 8px 0 0;
                }
                .header h2 {
                    margin: 0;
                    font-size: 28px;
                    font-weight: bold;
                }
                .header p {
                    margin: 5px 0 0 0;
                    font-size: 16px;
                    opacity: 0.9;
                }
                .content {
                    padding: 30px 20px;
                    background-color: #ffffff;
                    border: 1px solid #e0e0e0;
                    border-top: none;
                }
                .service-details {
                    background-color: #f8f9fa;
                    padding: 20px;
                    border-radius: 8px;
                    margin: 20px 0;
                }
                .detail-row {
                    margin-bottom: 10px;
                }
                .detail-label {
                    font-weight: bold;
                    color: #555;
                }
                .footer {
                    text-align: center;
                    padding: 20px;
                    background-color: #f8f9fa;
                    border-top: 1px solid #e0e0e0;
                    border-radius: 0 0 8px 8px;
                }
                .footer p {
                    margin: 5px 0;
                    color: #666;
                    font-size: 14px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>{$headerTitle}</h2>
                    <p>Nyarutarama Cell Management System</p>
                </div>
                <div class="content">
                    <p>Dear {$recipientName},</p>
                    <p>{$mainMessage}</p>
                    
                    <div class="service-details">
                        <div class="detail-row">
                            <span class="detail-label">Service Type:</span> 
                            <span>{$serviceData['service_type']}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Certificate Number:</span> 
                            <span>{$serviceData['certificate_number']}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Date Generated:</span> 
                            <span>{$serviceData['generated_date']}</span>
                        </div>
                    </div>
                    
                    <p><strong>Please bring a valid ID when collecting your document.</strong></p>
                    <p>If you have any questions, please contact the office.</p>
                </div>
                <div class="footer">
                    <p>Nyarutarama Cell Management System</p>
                    <p>&copy; {$currentYear} All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        HTML;
    }

    /**
     * Send email notification for service using PHPMailer
     */
    public function sendServiceEmail($recipientEmail, $recipientName, $serviceData, $type = 'ready')
    {
        try {
            $mail = new PHPMailer(true);

            // Server settings - using the proven Gmail configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'infofonepo@gmail.com';
            $mail->Password = 'zaoxwuezfjpglwjb';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Additional SMTP settings for better reliability
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Recipients
            $mail->setFrom('infofonepo@gmail.com', 'Nyarutarama Cell Management System');
            $mail->addAddress($recipientEmail, $recipientName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $serviceData['service_type'] . ' Ready for Collection';

            // Create email body
            $emailBody = $this->getServiceEmailTemplate($recipientName, $serviceData, $type);
            $mail->Body = $emailBody;
            $mail->AltBody = strip_tags($emailBody);

            $mail->send();
            error_log("Email sent successfully to {$recipientEmail}");
            return true;
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send SMS notification using AfricasTalking
     */
    public function sendServiceSMS($recipientPhone, $recipientName, $serviceData, $type = 'ready')
    {
        try {
            $message = "Dear {$recipientName}, your {$serviceData['service_type']} is ready for collection at Nyarutarama Cell Office. Ref: {$serviceData['certificate_number']}";

            // Format phone number for AfricasTalking (Philippine format: +63XXXXXXXXXX)
            $formattedPhone = $recipientPhone;
            if (!str_starts_with($formattedPhone, '+')) {
                // Remove leading 0 and add +63 for Philippine numbers
                if (str_starts_with($formattedPhone, '0')) {
                    $formattedPhone = '+250' . substr($formattedPhone, 1);
                } else {
                    $formattedPhone = '+' . $formattedPhone;
                }
            }

            // Use the configured AfricasTalking instance
            if ($this->africasTalking) {
                $sms = $this->africasTalking->sms();

                $result = $sms->send([
                    'to' => $formattedPhone,
                    'message' => $message
                ]);

                error_log("SMS sent successfully to {$formattedPhone}: " . json_encode($result));
                return true;
            } else {
                error_log("AfricasTalking not initialized, SMS not sent to {$formattedPhone}");
                return false;
            }

        } catch (Exception $e) {
            error_log("SMS sending failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send all notifications for a service
     */
    public function sendServiceNotifications($recipientData, $serviceData, $type = 'ready')
    {
        $emailSent = false;
        $smsSent = false;

        // Send email if recipient has an email address
        if (!empty($recipientData['email'])) {
            $emailSent = $this->sendServiceEmail(
                $recipientData['email'],
                $recipientData['full_name'],
                $serviceData,
                $type
            );
        }

        // Send SMS if recipient has a phone number
        if (!empty($recipientData['contact'])) {
            $smsSent = $this->sendServiceSMS(
                $recipientData['contact'],
                $recipientData['full_name'],
                $serviceData,
                $type
            );
        }

        return [
            'email_sent' => $emailSent,
            'sms_sent' => $smsSent
        ];
    }

    /**
     * Create system notification
     */
    public function createSystemNotification($id_resident, $notification_type, $title, $message)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("INSERT INTO tbl_notifications (id_resident, notification_type, title, message) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$id_resident, $notification_type, $title, $message]);
    }

    /**
     * Mark notification as read
     */
    public function markNotificationAsRead($id_notification)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("UPDATE tbl_notifications SET is_read = 1, read_date = NOW() WHERE id_notification = ?");
        return $stmt->execute([$id_notification]);
    }

    /**
     * Get unread notifications for a resident
     */
    public function getUnreadNotifications($id_resident)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_notifications WHERE id_resident = ? AND is_read = 0 ORDER BY created_date DESC");
        $stmt->execute([$id_resident]);
        return $stmt->fetchAll();
    }

    /**
     * Update service notification status
     */
    public function updateServiceNotificationStatus($table, $id_field, $id_value, $generated_by = null)
    {
        $connection = $this->openConn();
        $stmt = $connection->prepare("UPDATE {$table} SET notification_sent = 1, notification_date = NOW(), generated_by = ?, generated_date = NOW() WHERE {$id_field} = ?");
        return $stmt->execute([$generated_by, $id_value]);
    }
}