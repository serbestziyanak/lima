<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();
$id		= array_key_exists( 'id' , $_REQUEST ) ? $_REQUEST[ 'id' ] : 0;
$super	= array_key_exists( 'sistem_kullanici_super' , $_REQUEST ) ? 1 : 0; /* Kapalıysa gelmiyor zaten. açıksa da değeri birdir */




$SQL_ekle = <<< SQL
INSERT INTO
	tb_firma_personelleri
SET
     firma_id		= ?
    ,adi			= ?
    ,soyadi			= ?
    ,unvan			= ?
    ,gsm			= ?
    ,sabit_tel		= ?
    ,email			= ?
    ,notlar			= ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
	tb_firma_personelleri
SET
     firma_id		= ?
    ,adi			= ?
    ,soyadi			= ?
    ,unvan			= ?
    ,gsm			= ?
    ,sabit_tel		= ?
    ,email			= ?
    ,notlar			= ?
WHERE
	id = ?
SQL;
 
$SQL_sil = <<< SQL
	DELETE FROM tb_firma_personelleri WHERE id = ?
SQL;



$SQL_resim_guncelle = <<<SQL
UPDATE
	tb_firma_personelleri
SET
	foto = ?
WHERE
	id = ?
SQL;



$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti' );
$vt->islemBaslat();
if( array_key_exists( 'islem', $_REQUEST ) ) {
	switch( $_REQUEST[ 'islem' ] ) {
		case 'ekle':
			$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
				 $_REQUEST[ 'firma_id' ]
				,$_REQUEST[ 'adi' ]
				,$_REQUEST[ 'soyadi' ]
				,$_REQUEST[ 'unvan' ]
				,$_REQUEST[ 'gsm' ]
				,$_REQUEST[ 'sabit_tel' ]
				,$_REQUEST[ 'email' ]
				,$_REQUEST[ 'notlar' ]
			) );
			$resim_sonuc = $fn->personelResimYukle( 'input_sistem_kullanici_resim', $sorgu_sonuc[ 2 ] );
			if( $resim_sonuc[ 0 ] ) {
				$sorgu_sonuc = $vt->update( $SQL_resim_guncelle, array( $resim_sonuc[ 1 ], $sorgu_sonuc[ 2 ] ) );
			}
			if( $sorgu_sonuc[ 0 ] ) $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		break;
		case 'guncelle':
			
            $resim_sonuc = $fn->personelResimYukle( 'input_sistem_kullanici_resim', $id );
            if( $resim_sonuc[ 0 ] ) {
                $vt->update( $SQL_resim_guncelle, array( $resim_sonuc[ 1 ], $id ) );
            }
            $sorgu_sonuc = $vt->update( $SQL_guncelle, array(
				 $_REQUEST[ 'firma_id' ]
				,$_REQUEST[ 'adi' ]
				,$_REQUEST[ 'soyadi' ]
				,$_REQUEST[ 'unvan' ]
				,$_REQUEST[ 'gsm' ]
				,$_REQUEST[ 'sabit_tel' ]
				,$_REQUEST[ 'email' ]
				,$_REQUEST[ 'notlar' ]
                ,$id
            ) );
            if( $sorgu_sonuc[ 0 ] ) $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		break;
		case 'sil':
            $sorgu_sonuc = $vt->delete( $SQL_sil, array( $id ) );
            if( $sorgu_sonuc[ 0 ] ) $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt silinirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		break;
	}
} else {
	$___islem_sonuc = array( 'hata' => true, 'mesaj' => 'İşlem türü gönderilmediğinden dolayı işleminiz iptal edildi' );
}
$vt->islemBitir();
$___islem_sonuc[ 'id' ] = $id;
$_SESSION[ 'sonuclar' ] = $___islem_sonuc;
header("Location:../../index.php?modul=firmaPersonelleri")
?>