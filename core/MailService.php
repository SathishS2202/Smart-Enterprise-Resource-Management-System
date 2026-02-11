namespace Core;

<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public static function send($from, $to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';   // e.g., Gmail SMTP
        $mail->SMTPAuth   = true;
        $mail->Username = 'sathishs2202@gmail.com';
        $mail->Password = 'iegaktnuladdhjsm';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('sathishs2202@gmail.com', 'SERMS');
        $mail->addAddress($to);

            $mail->Subject = $subject;
            $mail->Body    = $body;
            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }
}
