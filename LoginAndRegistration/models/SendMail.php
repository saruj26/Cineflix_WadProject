<?php

use PHPMailer\Exception;
use PHPMailer\PHPMailer;

class SendMail
{
    public function sendMailMessage($receiverMail, $receiverName, $subject, $message)
    {
        require '../PHPMailer/Exception.php';
        require '../PHPMailer/PHPMailer.php';
        require '../PHPMailer/SMTP.php';
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rentitv001@gmail.com';
            $mail->Password = 'yvsz mzhh drzf kmkv';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('rentitv001@gmail.com', 'Movie System');
            $mail->addAddress($receiverMail, $receiverName);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = "<p> Dear " . $receiverName . "</p>";
            $mail->Body .= $message;
            $mail->send();

        } catch (Exception $e) {
            $message = "Message could not be sent. ";
        }
        return true;
    }
}