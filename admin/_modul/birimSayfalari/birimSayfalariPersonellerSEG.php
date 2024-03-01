<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

$islem				= array_key_exists( 'islem', $_REQUEST )	? $_REQUEST[ 'islem' ]	: 'ekle';
$personel_id		= array_key_exists( 'personel_id', $_REQUEST )	? $_REQUEST[ 'personel_id' ]	: 0;
$sayfa_id		 	= array_key_exists( 'sayfa_id', $_REQUEST ) ? $_REQUEST[ 'sayfa_id' ] 	: 0;
$birim_id 			= array_key_exists( 'birim_id', $_REQUEST ) 	? $_REQUEST[ 'birim_id' ] : 0;
$birim_adi 			= array_key_exists( 'birim_adi', $_REQUEST ) 	? $_REQUEST[ 'birim_adi' ] : "";
$sayfa_adi 			= array_key_exists( 'sayfa_adi', $_REQUEST ) 	? $_REQUEST[ 'sayfa_adi' ] : "";
$dil	 			= array_key_exists( 'personel_dil', $_REQUEST ) 	? $_REQUEST[ 'personel_dil' ] : "";
$dil	 			= $dil == "_tr" ? "" : $dil;

var_dump($_REQUEST);
//exit;


$SQL_ekle = <<< SQL
INSERT INTO
	tb_birim_sayfa_icerikleri_personeller
SET
	 birim_id		= ?
	,sayfa_id		= ?
	,adi$dil		= ?
	,gorev$dil		= ?
	,email			= ?
	,tel			= ?
	,dahili			= ?
	,oda_no			= ?
	,link			= ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
	tb_birim_sayfa_icerikleri_personeller
SET
	 birim_id		= ?
	,sayfa_id		= ?
	,adi$dil		= ?
	,gorev$dil		= ?
	,email			= ?
	,tel			= ?
	,dahili			= ?
	,oda_no			= ?
	,link			= ?
WHERE
	id = ?
SQL;

$SQL_gorev_listesi_guncelle = <<< SQL
UPDATE
	tb_birim_sayfalari
SET
	gorev_kategori_idler		= ?
    ,personeller_gorunecek      = ?
WHERE
	id = ?
SQL;

$SQL_foto_guncelle = <<< SQL
UPDATE
	tb_birim_sayfa_icerikleri_personeller
SET
	 foto		= ?
WHERE
	id = ?
SQL;

$SQL_tek_personel_id_oku = <<< SQL
SELECT 
	*
FROM 
	tb_birim_sayfa_icerikleri_personeller 
WHERE 
	id  		= ?
SQL;

$SQL_sil = <<< SQL
DELETE FROM
	tb_birim_sayfa_icerikleri_personeller
WHERE
	id = ?
SQL;




print_r($_REQUEST);
$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );
switch( $islem ) {
	case 'personel_ekle':
		$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
			 $_REQUEST[	'birim_id' ]
			,$_REQUEST[	'sayfa_id' ]
			,$_REQUEST[	'personel_adi' ]
			,$_REQUEST[	'personel_gorev' ]
			,$_REQUEST[	'personel_email' ]
			,$_REQUEST[	'personel_tel' ]
			,$_REQUEST[	'personel_dahili' ]
			,$_REQUEST[	'personel_oda_no' ]
			,$_REQUEST[	'personel_link' ]
		) );
		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			$son_eklenen_id	= $sorgu_sonuc[ 2 ]; 
			$personel_id = $son_eklenen_id;
			$resim_adi = "personel_".uniqid($personel_id.'_');
			$resim_sonuc = $fn->personelResimYukle( 'input_personel_resim', $resim_adi );
			if( $resim_sonuc[ 0 ] ) {
				$sorgu_sonuc = $vt->update( $SQL_foto_guncelle, array( $resim_sonuc[ 1 ], $son_eklenen_id ) );
			}

		}


	break;
	case 'personel_guncelle':
		$tek_personel_oku = $vt->selectSingle( $SQL_tek_personel_id_oku, array( $personel_id ) ) [ 2 ];
		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
			 $_REQUEST[	'birim_id' ]
			,$_REQUEST[	'sayfa_id' ]
			,$_REQUEST[	'personel_adi' ]
			,$_REQUEST[	'personel_gorev' ]
			,$_REQUEST[	'personel_email' ]
			,$_REQUEST[	'personel_tel' ]
			,$_REQUEST[	'personel_dahili' ]
			,$_REQUEST[	'personel_oda_no' ]
			,$_REQUEST[	'personel_link' ]
			,$personel_id
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			$resim_adi = "personel_".uniqid($personel_id.'_');
			$resim_sonuc = $fn->personelResimYukle( 'input_personel_resim', $resim_adi );
			if( $resim_sonuc[ 0 ] ) {
				$vt->update( $SQL_foto_guncelle, array( $resim_sonuc[ 1 ], $personel_id ) );
				if( $tek_personel_oku['foto'] != "resim_yok.png" ){
					unlink(dirname(__FILE__)."/../../resimler/personel_resimler/".$tek_personel_oku['foto']);
				}
			}

		}

	break;
	case 'gorev_listesi':
		$sorgu_sonuc = $vt->update( $SQL_gorev_listesi_guncelle, array(
			 implode(",", $_REQUEST['gorev_kategori_idler'])
			,$_REQUEST[	'personeller_gorunecek' ]==1 ? 1:0
			,$_REQUEST[	'sayfa_id' ]
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			$resim_adi = "personel_".uniqid($personel_id.'_');
			$resim_sonuc = $fn->personelResimYukle( 'input_personel_resim', $resim_adi );
			if( $resim_sonuc[ 0 ] ) {
				$vt->update( $SQL_foto_guncelle, array( $resim_sonuc[ 1 ], $personel_id ) );
				if( $tek_personel_oku['foto'] != "resim_yok.png" ){
					unlink(dirname(__FILE__)."/../../resimler/personel_resimler/".$tek_personel_oku['foto']);
				}
			}

		}

	break;
	case 'personel_sil':
		$sorgu_sonuc = $vt->delete( $SQL_sil, array(
			 $_REQUEST[	'personel_id' ]
		) );
		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt silinirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			
		}

	break;

}


$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $birim_sayfa_id;
header( "Location:../../index.php?modul=birimSayfalari&birim_id=$birim_id&birim_adi=$birim_adi&sayfa_id=$sayfa_id&sayfa_adi=$sayfa_adi&aktif_tab=$_REQUEST[aktif_tab]");
?>