<?php

namespace App\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Mail\Mailable;

class PHPMailerMail extends Mailable
{
    public function build()
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'vigo4real2016@gmail.com'; // Your SMTP username
        $mail->Password = 'mwwzupkbeiyhvnuo'; // Your SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('vigo4real2016@gmail.com', 'Electrisol');
        $mail->addAddress('danieloluwasegun1000@gmail.com', 'DV');

        $mail->Subject = 'OTP';
        $mail->Body = 'This is a test email sent using PHPMailer in Laravel.';

        return $mail;
    }
}
