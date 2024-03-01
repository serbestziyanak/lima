<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../plugins/PHPMailer/src/Exception.php';
require '../../plugins/PHPMailer/src/PHPMailer.php';
require '../../plugins/PHPMailer/src/SMTP.php';


include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

function sifreureteci(){
 $karakterler = "1234567890abcdefghijKLMNOPQRSTuvwxyzABCDEFGHIJklmnopqrstUVWXYZ0987654321";
 $sifre = '';
 for($i=0;$i<8;$i++)                    //Oluşturulacak şifrenin karakter sayısı 8'dir.
 {
  $sifre .= $karakterler{rand() % 72};    //$karakterler dizisinden ilk 72 karakter kullanılacak, yani hepsi.
 }
 return $sifre;                            //Oluşturulan şifre gönderiliyor.
}

echo sifreureteci();
echo "<pre>";
var_dump($_REQUEST);
echo "</pre>";
// exit; 

$islem				= array_key_exists( 'islem', $_REQUEST )		? $_REQUEST[ 'islem' ]		: 'ekle';
$personel_id		= array_key_exists( 'personel_id', $_REQUEST )	? $_REQUEST[ 'personel_id' ]	: 0;
$dil	 			= array_key_exists( 'dil', $_REQUEST ) 	? $_REQUEST[ 'dil' ] : "";
$dil	 			= $dil == "_tr" ? "" : $dil;

$SQL_guncelle = <<< SQL
UPDATE
	tb_personeller
SET
	 sifre = ?
WHERE
	id = ?
SQL;

$SQL_tek_personel_oku = <<< SQL
SELECT 
	*
FROM 
	tb_personeller 
WHERE 
	aktif = 1 AND in_no  = ? AND email = ?  
SQL;


$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'sifre_guncelle':
        $personel_varmi = $vt->selectSingle( $SQL_tek_personel_oku, array( $_REQUEST[ "in_no" ], $_REQUEST[ "email" ] ) )[2];
        $yeni_sifre = sifreureteci();
        if( $personel_varmi['email'] != "" ){
            var_dump($personel_varmi);
            $email_content ="Yeni Şifreniz: ".$yeni_sifre;
            $subject = "Şifre Sıfırlama.";
            $to_email = $personel_varmi['email'];

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

                $sorgu_sonuc = $vt->update( $SQL_guncelle, array(
                    md5($yeni_sifre)
                    ,$personel_varmi['id']
                ) );

                if( $sorgu_sonuc[ 0 ] ){
                    $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu' . $sorgu_sonuc[ 1 ] );
                }else{
                    $___islem_sonuc = array( 'hata' => false, 'mesaj' => 'Yeni şifreniz eposta adresinize gönderilmiştir.', 'id' => $sorgu_sonuc[ 2 ] );
                }
            } catch (Exception $e) {
                $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => "Mesaj gönderilemedi. Posta Hatası: {$mail->ErrorInfo}" );
            }

        }else{
            $___islem_sonuc = array( 'hata' => true, 'mesaj' => 'Girdiğiniz bilgilere ait kullanıcı bulunamadı.' . $sorgu_sonuc[ 1 ] );
        }
	break;
}
$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $personel_id;
header( "Location:../../index.php?modul=sifremiUnuttum");
?>