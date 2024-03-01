<?php
include "../_cekirdek/fonksiyonlar.php";


session_start();
$_SESSION[ 'firma_turu' ] = $_POST[ 'firma' ];

$vt = new VeriTabani();

$k	= trim( $_POST[ 'kulad' ] );
$s	= trim( $_POST[ 'sifre' ] );

$SQL_kontrol = <<< SQL
SELECT
	 k.*
	,CASE k.super WHEN 1 THEN "Süper" ELSE r.adi END AS rol_adi
FROM
	view_giris_kontrol AS k
LEFT JOIN
	tb_roller AS r ON k.rol_id = r.id
WHERE
	k.email = ? AND
	k.sifre = ?
LIMIT 1
SQL;

$SQL_aktif_yil = <<< SQL
SELECT
	*
FROM
	tb_egitim_ogretim_yillari
WHERE
	aktif 			   	= 1
LIMIT 1
SQL;

$secretKey  = '6Lf3xW4pAAAAAKg-hjT71lanQ0jXwdKPcF-XEFMl'; 
// Validate reCAPTCHA checkbox 
if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){ 

    // Verify the reCAPTCHA API response 
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']); 
        
    // Decode JSON data of API response 
    $responseData = json_decode($verifyResponse); 
        
    // If the reCAPTCHA API response is valid 
    if($responseData->success){ 
        $sorguSonuc = $vt->selectSingle( $SQL_kontrol, array( $k, md5( $s ) ) );
        if( !$sorguSonuc[ 0 ] ) {
            $kullaniciBilgileri	= $sorguSonuc[ 2 ];
            if( $kullaniciBilgileri[ 'id' ] * 1 > 0 ) {
                $_SESSION[ 'kullanici_id' ]		= $kullaniciBilgileri[ 'id' ];
                $_SESSION[ 'adi' ]				= $kullaniciBilgileri[ 'adi' ];
                $_SESSION[ 'soyadi' ]			= $kullaniciBilgileri[ 'soyadi' ];
                $_SESSION[ 'ad_soyad' ]			= $kullaniciBilgileri[ 'adi' ] . ' ' . $kullaniciBilgileri[ 'soyadi' ];
                $_SESSION[ 'kullanici_resim' ]	= $kullaniciBilgileri[ 'resim' ];
                $_SESSION[ 'rol_id' ]			= $kullaniciBilgileri[ 'rol_id' ];
                $_SESSION[ 'rol_adi' ]			= $kullaniciBilgileri[ 'rol_adi' ];
                $_SESSION[ 'sube_id' ]			= $kullaniciBilgileri[ 'sube_id' ];
                $_SESSION[ 'subeler' ]			= $kullaniciBilgileri[ 'subeler' ];
                $_SESSION[ 'giris' ]			= true;
                $_SESSION[ 'giris_var' ]		= 'evet';
                $_SESSION[ 'yil' ]				= date('Y');
                $_SESSION[ 'super' ]			= $kullaniciBilgileri[ 'super' ];
                $_SESSION[ 'kullanici_turu' ]	= $kullaniciBilgileri[ 'kullanici_turu' ];
                $_SESSION[ 'birim_idler' ]		= $kullaniciBilgileri[ 'birim_idler' ];

                $aktif_yil 						= $vt->selectSingle( $SQL_aktif_yil, array(  ) )[ 2 ];
                $_SESSION[ 'aktif_egitim_ogretim_yili_id' ]		= $aktif_yil[ "id" ];


                // $_SESSION['sistem_dil']				= $_POST[ 'sistem_dil' ];
                $sistem_dil = $_SESSION['sistem_dil'];

            } else {
                $_SESSION[ 'giris_var' ] = 'hayir';
                $_SESSION[ 'giris_hata_mesaj' ] = 'Kullanıcı adı veya şifreniz yanlış.';
            }
        } else {
            $_SESSION[ 'giris_var' ] = 'hayir';
            $_SESSION[ 'giris_hata_mesaj' ] = 'Sorgu hatası.';
        }
    }else{ 
        $_SESSION[ 'giris_var' ] = 'hayir';
        $_SESSION[ 'giris_hata_mesaj' ] = 'Robot verification failed, please try again.'; 
    } 
}else{ 
    $_SESSION[ 'giris_var' ] = 'hayir';
    $_SESSION[ 'giris_hata_mesaj' ] = 'Please check the reCAPTCHA checkbox.'; 
} 
header( "Location: ../index.php?modul=anasayfa" );
?>