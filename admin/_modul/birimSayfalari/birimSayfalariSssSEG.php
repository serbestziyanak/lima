<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

$islem				= array_key_exists( 'islem', $_REQUEST )	? $_REQUEST[ 'islem' ]	: 'ekle';
$id				 	= array_key_exists( 'id', $_REQUEST ) 		? $_REQUEST[ 'id' ] 	: 0;
$sayfa_id		 	= array_key_exists( 'sayfa_id', $_REQUEST ) ? $_REQUEST[ 'sayfa_id' ] 	: 0;
$birim_id 			= array_key_exists( 'birim_id', $_REQUEST ) 	? $_REQUEST[ 'birim_id' ] : 0;
$birim_adi 			= array_key_exists( 'birim_adi', $_REQUEST ) 	? $_REQUEST[ 'birim_adi' ] : "";
$sayfa_adi 			= array_key_exists( 'sayfa_adi', $_REQUEST ) 	? $_REQUEST[ 'sayfa_adi' ] : "";
$dil	 			= array_key_exists( 'sss_dil', $_REQUEST ) 	? $_REQUEST[ 'sss_dil' ] : "";
$dil	 			= $dil == "_tr" ? "" : $dil;

var_dump($_REQUEST);
// exit;


$SQL_ekle = <<< SQL
INSERT INTO
	tb_birim_sayfa_icerikleri_sss
SET
	 baslik		= ?
	,birim_id		= ?
	,sayfa_id		= ?
	,dil_id		= ?
	,icerik		= ?
    ,sira = ?
SQL;

$SQL_max_sira = <<< SQL
SELECT max(sira) as max_sira from  tb_birim_sayfa_icerikleri_sss where birim_id = ? and sayfa_id = ? and dil_id = ?
SQL;
@$yeni_sira = $vt->selectSingle($SQL_max_sira, array( $birim_id, $sayfa_id, $_REQUEST['dil_id'] ) )[ 2 ]['max_sira'] + 1;



$SQL_guncelle = <<< SQL
UPDATE
	tb_birim_sayfa_icerikleri_sss
SET
	 baslik		= ?
	,icerik		= ?
WHERE
	id = ?
SQL;

$SQL_sil = <<< SQL
DELETE FROM
	tb_birim_sayfa_icerikleri_sss
WHERE
	id = ?
SQL;

$SQL_siralama_guncelle = <<< SQL
UPDATE
	tb_birim_sayfa_icerikleri_sss
SET
	sira = ?
WHERE
	birim_id = ? and sayfa_id = ? and id = ?
SQL;

$degerler = array();

echo '<pre>';
echo $_REQUEST[ "ogretim_elemani_id" ];

print_r($_REQUEST);
$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );
switch( $islem ) {
	case 'sss_ekle':
		$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
			 $_REQUEST[	'sss_baslik' ]
			,$_REQUEST[	'birim_id' ]
			,$_REQUEST[	'sayfa_id' ]
			,$_REQUEST[	'dil_id' ]
			,$_REQUEST[	'sss_icerik' ]
			,$yeni_sira
		) );
		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
		}


	break;
	case 'sss_guncelle':
		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
			 $_REQUEST[	'sss_baslik' ]
			,$_REQUEST[	'sss_icerik' ]
			,$_REQUEST[ 'sss_id' ]
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
		}

	break;
	case 'sss_sil':
		$sorgu_sonuc = $vt->delete( $SQL_sil, array(
			 $_REQUEST[	'sss_id' ]
		) );
		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt silinirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
		}

	break;
	case 'sira_guncelle':
        $siralar = $_REQUEST['siralar'.$_REQUEST['dil_id' ]];
        foreach( $siralar as $key=>$value ){
            $sira= $key+1;
            $id = $value;
            $sorgu_sonuc = $vt->update( $SQL_siralama_guncelle, array(
                    $sira
                    ,$_REQUEST[	'birim_id' ]
                    ,$_REQUEST[	'sayfa_id' ]
                    ,$id
            ) );
        }
		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
		}

	break;

}


$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $birim_sayfa_id;
header( "Location:../../index.php?modul=birimSayfalari&birim_id=$birim_id&birim_adi=$birim_adi&sayfa_id=$sayfa_id&sayfa_adi=$sayfa_adi&aktif_tab=$_REQUEST[aktif_tab]");
?>