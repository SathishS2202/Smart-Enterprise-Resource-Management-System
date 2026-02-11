<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public function send($to, $subject, $message)
    {
        require_once __DIR__ . '/../../vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
           $mail->Username = 'sathishs2202@gmail.com';
    $mail->Password = 'iegaktnuladdhjsm';// CHANGE THIS
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom($mail->Username, 'ERMS Admin');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            return $mail->send();

        } catch (Exception $e) {
            return false;
        }
    }
}
