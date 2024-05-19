<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.office365.com';                   //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'app-mx-vidanta@mapfre.net';            //SMTP username
    $mail->Password   = '27mHnRftuKeMlX3';                      //SMTP password
    $mail->SMTPSecure = 'tls';                                  //Enable TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('app-mx-vidanta@mapfre.net', 'Vidanta');
    $mail->addAddress('afelipef7@gmail.com', 'Felipe Arroyo');  //Add a recipient

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'Asunto testttt';
    $mail->Body    = 'Este es un cuerpo de mensaje en HTML <b>en negrita!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'El correo fue enviado correctamente';
} catch (Exception $e) {
    echo "El mensaje no pudo ser enviado. Error del correo: {$mail->ErrorInfo}";
}
?>
