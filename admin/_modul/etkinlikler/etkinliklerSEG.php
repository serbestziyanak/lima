<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

// echo "<pre>";
// var_dump($_REQUEST);
// echo "</pre>";
// exit;


if( isset($_FILES["foto"]) ){
	list($genislik, $yukseklik) = getimagesize($_FILES["foto"]["tmp_name"]);
	if( $genislik != 555 or $yukseklik != 320 ){
	//$_SESSION[ 'sonuclar' ] = array( 'hata' => true, 'mesaj' => 'Hata : Görsel boyutlaru 555x320 olmalıdır!', 'id' => 0 );
	//header( "Location:../../index.php?modul=etkinlikler&birim_id=".$_REQUEST['birim_id']."&birim_adi=".$_REQUEST['birim_adi']);
	//exit;
	}
}

$islem	= array_key_exists( 'islem', $_REQUEST )		? $_REQUEST[ 'islem' ]		: 'ekle';
$id		= array_key_exists( 'id', $_REQUEST )	? $_REQUEST[ 'id' ]	: 0;
$dil	 			= array_key_exists( 'dil', $_REQUEST ) 	? $_REQUEST[ 'dil' ] : "";
$dil	 			= $dil == "_tr" ? "" : $dil;

if( $_REQUEST[ 'tarih' ] == '' ) $tarih = NULL;
else $tarih = date( 'Y-m-d H:i', strtotime( $_REQUEST[ 'tarih' ] ) );
 
$SQL_ekle = <<< SQL
INSERT INTO
	tb_etkinlikler
SET
	 baslik$dil		= ?
	,tarih		= ?
	,icerik$dil		= ?
	,yeri$dil		= ?
	,birim_id	= ?
	,dil_id	= ?
	,foto	= ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
	tb_etkinlikler
SET
	 baslik$dil		= ?
	,tarih		= ?
	,icerik$dil		= ?
	,yeri$dil		= ?
	,birim_id	= ?
	,dil_id	= ?
WHERE
	id = ?
SQL;

$SQL_foto_guncelle = <<< SQL
UPDATE
	tb_etkinlikler
SET
	 foto		= ?
WHERE
	id = ?
SQL;

$SQL_sil = <<< SQL
DELETE FROM
	tb_etkinlikler
WHERE
	id = ?
SQL;

$SQL_galeri_ekle = <<< SQL
INSERT INTO
	tb_etkinlik_galeri
SET
	 etkinlik_id		= ?
	,foto   		= ?
SQL;

$SQL_foto_sil = <<< SQL
DELETE FROM
	tb_etkinlik_galeri
WHERE
	id = ?
SQL;

$SQL_galeri = <<< SQL
SELECT 
	*
FROM 
	tb_etkinlik_galeri
WHERE 
	etkinlik_id = ? 
SQL;


$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'ekle':
        if (is_array($_FILES)) {
            $dosya_adi = uniqid().str_replace(" ","",basename($_FILES["foto"]["name"]));
            $target_dir = "../../resimler/etkinlikler/";
            $target_file_buyuk = $target_dir ."buyuk/". $dosya_adi;
            $target_file_kucuk = $target_dir ."kucuk/". $dosya_adi;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file_buyuk);
            copy($target_file_buyuk, $target_file_kucuk);
            $fn->fn_resize($target_file_buyuk, $target_file_buyuk, 1200);
            $fn->fn_resize($target_file_kucuk, $target_file_kucuk, 600);
        }
		$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
			 $_REQUEST[	'baslik' ]
			,$tarih
			,$_REQUEST[	'icerik' ]
			,$_REQUEST[	'yeri' ]
			,$_REQUEST[	'birim_id' ]
			,$_REQUEST[	'dil_id' ]
			,$dosya_adi
		) );
		$id = $sorgu_sonuc[ 2 ]; 

        if( isset( $_REQUEST['galeri'] ) ){
            $galeri_dizin = "../../resimler/etkinlikler/";
            foreach( $_REQUEST['galeri'] as $foto ){
                $dosya_adi_buyuk = $galeri_dizin."buyuk/".$foto;
                $dosya_adi_kucuk = $galeri_dizin."kucuk/".$foto;
                $sorgu_sonuc = $vt->insert( $SQL_galeri_ekle, array(
                     $id
                    ,$foto
                ) );
                copy("../../tmp_galeri/".$foto, $dosya_adi_buyuk);
                $fn->fn_resize($dosya_adi_buyuk, $dosya_adi_buyuk, 1200);
                copy("../../tmp_galeri/".$foto, $dosya_adi_kucuk);
                $fn->fn_resize($dosya_adi_kucuk, $dosya_adi_kucuk, 600);
                unlink( "../../tmp_galeri/".$foto );
            }
        }

		//move_uploaded_file($target_layer, $target_file);
        //exit;
		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
		}
	break;
	case 'guncelle':	
		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
			 $_REQUEST[	'baslik' ]
			,$tarih
			,$_REQUEST[	'icerik' ]
			,$_REQUEST[	'yeri' ]
			,$_REQUEST[	'birim_id' ]
			,$_REQUEST[	'dil_id' ]
			,$id
		) );
 
		if( isset($_FILES["foto"]) and $_FILES["foto"]['size']>0 ){
			$dosya_adi = uniqid().str_replace(" ","",basename($_FILES["foto"]["name"]));
			$target_dir = "../../resimler/etkinlikler/";
            $target_file_buyuk = $target_dir ."buyuk/". $dosya_adi;
            $target_file_kucuk = $target_dir ."kucuk/". $dosya_adi;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file_buyuk);
            copy($target_file_buyuk, $target_file_kucuk);
            $fn->fn_resize($target_file_buyuk, $target_file_buyuk, 1200);
            $fn->fn_resize($target_file_kucuk, $target_file_kucuk, 600);

			$sorgu_sonuc2 = $vt->update( $SQL_foto_guncelle, array(
				 $dosya_adi
				,$id
			) );

		}
        if( isset( $_REQUEST['galeri'] ) ){
            $galeri_dizin = "../../resimler/etkinlikler/";
            foreach( $_REQUEST['galeri'] as $foto ){
                $dosya_adi_buyuk = $galeri_dizin."buyuk/".$foto;
                $dosya_adi_kucuk = $galeri_dizin."kucuk/".$foto;
                $sorgu_sonuc = $vt->insert( $SQL_galeri_ekle, array(
                     $id
                    ,$foto
                ) );
                copy("../../tmp_galeri/".$foto, $dosya_adi_buyuk);
                $fn->fn_resize($dosya_adi_buyuk, $dosya_adi_buyuk, 1200);
                copy("../../tmp_galeri/".$foto, $dosya_adi_kucuk);
                $fn->fn_resize($dosya_adi_kucuk, $dosya_adi_kucuk, 600);
                unlink( "../../tmp_galeri/".$foto );
            }
        }

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] );
		}
	break;
	case 'sil':
		//Silinecek olan tarife giriş yapılan firmaya mı ait oldugu kontrol ediliyor Eger firmaya ait ise silinecektir.
			$sorgu_sonuc = $vt->delete( $SQL_sil, array( $id ) );
			if( $sorgu_sonuc[ 0 ] ) $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt silinrken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
    break;
	case 'foto_sil':
        $sorgu_sonuc = $vt->delete( $SQL_foto_sil, array( $_REQUEST['foto_id'] ) );
        if( $sorgu_sonuc[ 0 ] ){
            $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt silinrken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
            
        }else{
            @unlink( "../../resimler/etkinlikler/buyuk/".$_REQUEST['foto'] );
            @unlink( "../../resimler/etkinlikler/kucuk/".$_REQUEST['foto'] );
        }

        @$galeri = $vt->select( $SQL_galeri, array( $_REQUEST['etkinlik_id'] ) )[ 2 ];
        foreach( $galeri as $foto_galeri ){ 
?>
        <div class=" col-3">
            <div class="card ">
                <a href="resimler/etkinlikler/buyuk/<?php echo $foto_galeri['foto']; ?>" data-toggle="lightbox" data-title="" data-gallery="gallery">
                    <img class="card-img-top" src="resimler/etkinlikler/kucuk/<?php echo $foto_galeri['foto']; ?>" style="object-fit: cover; height: 250px;"   alt="white sample"/>
                </a>

                <div class="card-footer">
                    <button type="button" modul= 'etkinlikler' yetki_islem="sil" class="btn btn-danger foto_sil" data-url="_modul/etkinlikler/etkinliklerSEG.php" data-islem="foto_sil" data-foto="<?php echo $foto_galeri['foto']; ?>" data-etkinlik_id="<?php echo $foto_galeri['etkinlik_id']; ?>" data-foto_id="<?php echo $foto_galeri['id']; ?>" >
                    <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </div>

<?php
        }
?>
    <script>
        $('.foto_sil').on("click", function(e) { 
            var url      = $(this).data("url");
            var foto  = $(this).data("foto");
            var foto_id  = $(this).data("foto_id");
            var islem  = $(this).data("islem");
            var etkinlik_id  = $(this).data("etkinlik_id");
            
                $.ajax( {
                    url	: url
                    ,type	: "post"
                    ,data	: { 
                        foto_id	: foto_id
                        ,foto		: foto
                        ,islem		: islem
                        ,etkinlik_id	: etkinlik_id
                    }
                    ,async		: true
                    ,success	: function( sonuc ) {
                        $( "#fotograflar" ).html( sonuc );
                    }
                    ,error		: function() {
                        alert( "Galeri yüklenemedi" );
                    }
                } );     
        });

    </script>
<?php

    exit;
    break;

}
$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $id;
if( $islem == "sil" )
header( "Location:../../index.php?modul=etkinlikler&birim_id=".$_REQUEST['birim_id']."&birim_adi=".$_REQUEST['birim_adi']);
else
header( "Location:../../index.php?modul=etkinlikler&islem=guncelle&id=".$id."&birim_id=".$_REQUEST['birim_id']."&birim_adi=".$_REQUEST['birim_adi']);
?>