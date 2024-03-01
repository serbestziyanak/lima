<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

$islem				= array_key_exists( 'islem', $_REQUEST )			? $_REQUEST[ 'islem' ]			: 'ekle';
$id					= array_key_exists( 'id', $_REQUEST )	? $_REQUEST[ 'id' ]	: 0;


$iletisim_personel_idler = implode(",", $_REQUEST[ 'iletisim_personel_idler' ]);
$katildigi_fuar_idler = implode(",", $_REQUEST[ 'katildigi_fuar_idler' ]);


$SQL_ekle = <<< SQL
INSERT INTO
	tb_firmalar
SET
    adi						    = ?
    ,sektor_id				    = ?
    ,ulke_id					= ?
    ,sehir_id					= ?
    ,sabit_tel					= ?
    ,email						= ?
    ,web						= ?
    ,vergi_dairesi				= ?
    ,vergi_no					= ?
    ,adres						= ?
    ,iletisim_personel_idler	= ?
    ,katildigi_fuar_idler		= ?
    ,notlar						= ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
	tb_firmalar
SET
    adi						    = ?
    ,sektor_id				    = ?
    ,ulke_id					= ?
    ,sehir_id					= ?
    ,sabit_tel					= ?
    ,email						= ?
    ,web						= ?
    ,vergi_dairesi				= ?
    ,vergi_no					= ?
    ,adres						= ?
    ,iletisim_personel_idler	= ?
    ,katildigi_fuar_idler		= ?
    ,notlar						= ?
WHERE
	id = ?
SQL;

$SQL_sil = <<< SQL
DELETE FROM
	tb_firmalar
WHERE
	id = ?
SQL;

$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'ekle':
		$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
			 $_REQUEST[	'adi' ]
			,$_REQUEST[	'sektor_id' ]
			,$_REQUEST[	'ulke_id' ]
			,$_REQUEST[	'sehir_id' ]
			,$_REQUEST[	'sabit_tel' ]
			,$_REQUEST[	'email' ]
			,$_REQUEST[	'web' ]
			,$_REQUEST[	'vergi_dairesi' ]
			,$_REQUEST[	'vergi_no' ]
			,$_REQUEST[	'adres' ]
			,$iletisim_personel_idler
			,$katildigi_fuar_idler
			,$_REQUEST[	'notlar' ]
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			$son_eklenen_id	= $sorgu_sonuc[ 2 ]; 
		}	
	break;
	case 'guncelle':
		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
			 $_REQUEST[	'adi' ]
			,$_REQUEST[	'sektor_id' ]
			,$_REQUEST[	'ulke_id' ]
			,$_REQUEST[	'sehir_id' ]
			,$_REQUEST[	'sabit_tel' ]
			,$_REQUEST[	'email' ]
			,$_REQUEST[	'web' ]
			,$_REQUEST[	'vergi_dairesi' ]
			,$_REQUEST[	'vergi_no' ]
			,$_REQUEST[	'adres' ]
			,$iletisim_personel_idler
			,$katildigi_fuar_idler
			,$_REQUEST[	'notlar' ]
			,$id
		) );
		
		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			$son_eklenen_id	= $sorgu_sonuc[ 2 ]; 
		}	
	break;
	case 'sil':
		$sorgu_sonuc = $vt->delete( $SQL_sil, array( $id ) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			$son_eklenen_id	= $sorgu_sonuc[ 2 ]; 
		}	

	break;
}
$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $id;
header( "Location:../../index.php?modul=firmalar" );
?>