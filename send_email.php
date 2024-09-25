<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Fetch SMTP password from environment variable (set via GitHub Secrets)
$zoho_password = getenv('ZOHO_PASSWORD');

// Create an instance of PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.zoho.com';                        // Specify Zoho SMTP server
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'noreply@zeeps.me';                 // Your Zoho email
    $mail->Password = $zoho_password;                     // Password from GitHub secret (environment variable)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption
    $mail->Port = 587;                                    // TCP port to connect to Zoho SMTP

    // Recipients
    $mail->setFrom('noreply@zeeps.me', 'Zeeps Mailer');
    $mail->addAddress('evan@dontsp.am');     // You can set this dynamically

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Test Email';
    $mail->Body    = 'This is a test email, don\'t respond';
    $mail->AltBody = 'This is a test email, don\'t respond';  // Plain text version for non-HTML email clients

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
