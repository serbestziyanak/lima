<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();


// echo "<pre>";
// var_dump($_REQUEST);
// echo "</pre>";
// exit;


$islem				= array_key_exists( 'islem', $_REQUEST )	? $_REQUEST[ 'islem' ]	: 'ekle';
$personel_id		= array_key_exists( 'personel_id', $_REQUEST )	? $_REQUEST[ 'personel_id' ]	: 0;
$sayfa_id		 	= array_key_exists( 'sayfa_id', $_REQUEST ) ? $_REQUEST[ 'sayfa_id' ] 	: 0;
$birim_id 			= array_key_exists( 'birim_id', $_REQUEST ) 	? $_REQUEST[ 'birim_id' ] : 0;
$birim_adi 			= array_key_exists( 'birim_adi', $_REQUEST ) 	? $_REQUEST[ 'birim_adi' ] : "";
$sayfa_adi 			= array_key_exists( 'sayfa_adi', $_REQUEST ) 	? $_REQUEST[ 'sayfa_adi' ] : "";
$dil	 			= array_key_exists( 'dil', $_REQUEST ) 	? $_REQUEST[ 'dil' ] : "";
$dil	 			= $dil == "_tr" ? "" : $dil;

 


$SQL_galeri_ekle = <<< SQL
INSERT INTO
	tb_sayfa_galeri
SET
	 sayfa_id		= ?
	,foto   		= ?
SQL;

$SQL_foto_sil = <<< SQL
DELETE FROM
	tb_sayfa_galeri
WHERE
	id = ?
SQL;

$SQL_galeri = <<< SQL
SELECT 
	*
FROM 
	tb_sayfa_galeri
WHERE 
	sayfa_id = ? 
SQL;

$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'galeri_ekle':

        if( isset( $_REQUEST['galeri'] ) ){
            $galeri_dizin = "../../resimler/sayfalar/";
            foreach( $_REQUEST['galeri'] as $foto ){
                $dosya_adi_buyuk = $galeri_dizin."buyuk/".$foto;
                $dosya_adi_kucuk = $galeri_dizin."kucuk/".$foto;
                $sorgu_sonuc = $vt->insert( $SQL_galeri_ekle, array(
                     $sayfa_id
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
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
		}
	break;
	case 'foto_sil':
        $sorgu_sonuc = $vt->delete( $SQL_foto_sil, array( $_REQUEST['foto_id'] ) );
        if( $sorgu_sonuc[ 0 ] ){
            $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt silinrken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
            
        }else{
            @unlink( "../../resimler/sayfalar/buyuk/".$_REQUEST['foto'] );
            @unlink( "../../resimler/sayfalar/kucuk/".$_REQUEST['foto'] );
        }

        @$galeri = $vt->select( $SQL_galeri, array( $sayfa_id ) )[ 2 ];
        foreach( $galeri as $foto_galeri ){ 
?>
        <div class=" col-3">
            <div class="card ">
                <a href="resimler/sayfalar/buyuk/<?php echo $foto_galeri['foto']; ?>" data-toggle="lightbox" data-title="" data-gallery="gallery">
                    <img class="card-img-top" src="resimler/sayfalar/kucuk/<?php echo $foto_galeri['foto']; ?>" style="object-fit: cover; height: 250px;"   alt="white sample"/>
                </a>

                <div class="card-footer">
                    <button type="button" modul= 'sayfalar' yetki_islem="sil" class="btn btn-danger foto_sil" data-url="_modul/birimSayfalari/birimSayfalariGaleriSEG.php" data-islem="foto_sil" data-foto="<?php echo $foto_galeri['foto']; ?>" data-sayfa_id="<?php echo $foto_galeri['sayfa_id']; ?>" data-foto_id="<?php echo $foto_galeri['id']; ?>" >
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
            var sayfa_id  = $(this).data("sayfa_id");
            
                $.ajax( {
                    url	: url
                    ,type	: "post"
                    ,data	: {
                        foto_id	: foto_id
                        ,foto		: foto
                        ,islem		: islem
                        ,sayfa_id	: sayfa_id
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
header( "Location:../../index.php?modul=birimSayfalari&birim_id=$birim_id&birim_adi=$birim_adi&sayfa_id=$sayfa_id&sayfa_adi=$sayfa_adi&aktif_tab=$_REQUEST[aktif_tab]");
?>