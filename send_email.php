<?php
// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path_to_phpmailer/src/Exception.php';
require 'path_to_phpmailer/src/PHPMailer.php';
require 'path_to_phpmailer/src/SMTP.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

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
        $mail->addAddress($email, $name); // Send email to user

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Thank you for reaching out!';
        $mail->Body    = "Hi $name,<br><br>Thank you for your message:<br>$message<br><br>We will get back to you shortly.<br>Best,<br>Zeeps Team";

        // Send email
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
