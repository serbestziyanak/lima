<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if (isset($_POST["button_pressed"])) {
    $mail = new PHPMailer(true);

    try {
        //$mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host       = 'smtp.gmail.com';
        $mail->Port       = 465;
        $mail->Username   = 'web@ayu.edu.kz';
        $mail->Password   = 'Ayuweb.6565';
        $mail->From  = "web@ayu.edu.kz";
        $mail->FromName  = "AYU Web Mail";

        $mail->addAddress('serbest.ziyanak@gmail.com');
        $mail->CharSet = "utf-8";

        $mail->isHTML(true);
        $mail->Subject = 'Konu';
        $mail->Body    = "Deneme HTML Mesajı. <b>Kalın ifade ve <i>italik</i> ifade </b><a href='mailto:serbest.ziyanak@gmail.com'>Cevap Yaz</a> ";
        $mail->AltBody = 'HTML olmayan posta istemcileri için düz metin gövdesi';
        $mail->Send();

        echo "Posta başarıyla gönderildi!";
    } catch (Exception $e) {
        echo "Mesaj gönderilemedi. Posta Hatası: {$mail->ErrorInfo}";
    }
}
?>
<html>

<body>
    <h1>Selam</h1>
    <form method="post" action="">
        <input type="submit" value="Send" />
        <input type="hidden" name="button_pressed" value="1" />
    </form>
</body>

</html>