<?php
// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path_to_phpmailer/src/Exception.php';
require 'path_to_phpmailer/src/PHPMailer.php';
require 'path_to_phpmailer/src/SMTP.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);

    // Setup PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com'; // Zoho SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@zeeps.me'; // Your email address
        $mail->Password = getenv('ZOHO_PASSWORD'); // Use GitHub Secrets for this
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('noreply@zeeps.me', 'Zeeps Support');
        $mail->addAddress($email); // Send email to the user

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Test Email from Zeeps';
        $mail->Body    = "Hi there,<br><br>This is a test email from Zeep's noreply system. <br><br>Best regards,<br>Zeeps Team";

        // Send email
        $mail->send();
        echo 'Test email has been sent!';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
