<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../admin/plugins/PHPMailer/src/Exception.php';
require '../admin/plugins/PHPMailer/src/PHPMailer.php';
require '../admin/plugins/PHPMailer/src/SMTP.php';
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
        $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $subject = trim($name)." - ".trim($_POST["subject"]);
        $number = trim($_POST["number"]);
        $message = nl2br(trim($_POST["message"]));
        $to_email = filter_var(trim($_POST["to_email"]), FILTER_SANITIZE_EMAIL);

        $email_content = "<b>Name:</b> $name<br>";
        $email_content .= "<b>Subject:</b> $subject<br>";
        $email_content .= "<b>Email:</b> $email<br>";
        $email_content .= "<b>Tel:</b> <a href='tel:$number'>$number</a><br>";
        $email_content .= "<hr><b>Message:</b><br>$message<br><hr>";
        $email_content .= "<b><a href='mailto:$email'>Cevap yazmak için tıklayınız...</a><br>";

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

            $mail->addAddress($to_email);
            $mail->CharSet = "utf-8";

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $email_content;
            $mail->Send();

            echo "Posta başarıyla gönderildi!";
        } catch (Exception $e) {
            echo "Mesaj gönderilemedi. Posta Hatası: {$mail->ErrorInfo}";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
