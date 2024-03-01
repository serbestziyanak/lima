<?php
$fn	= new Fonksiyonlar();
$vt = new VeriTabani();

/* SEG dosyalarından gelen mesaj */
if( array_key_exists( 'sonuclar', $_SESSION ) ) {
	$mesaj								= $_SESSION[ 'sonuclar' ][ 'mesaj' ];
	$mesaj_turu							= $_SESSION[ 'sonuclar' ][ 'hata' ] ? 'kirmizi' : 'yesil';
	unset( $_SESSION[ 'sonuclar' ] );
	echo "<script>mesajVer('$mesaj', '$mesaj_turu')</script>";
}


$islem	= array_key_exists( 'islem', $_REQUEST ) ? $_REQUEST[ 'islem' ]	 : 'ekle';
$id    	= array_key_exists( 'id'	,$_REQUEST ) ? $_REQUEST[ 'id' ]	 : 0;
$personel_id				= array_key_exists( 'personel_id' ,$_REQUEST ) ? $_REQUEST[ 'personel_id' ]	: $_SESSION[ 'kullanici_id' ];


$satir_renk				= $id > 0	? 'table-warning'						: '';
$kaydet_buton_yazi		= $id > 0	? 'Güncelle'							: 'Kaydet';
$kaydet_buton_cls		= $id > 0	? 'btn btn-warning btn-sm pull-right'	: 'btn btn-success btn-sm pull-right';

$SQL_tum_personel_calisma_yeri_bilgileri = <<< SQL
SELECT
	 pab.*
     ,eoy.adi       AS egitim_ogretim_yili
	 ,b.adi         AS birim_adi
	 ,b.adi_kz      AS birim_adi_kz
	 ,b.adi_en      AS birim_adi_en
	 ,b.adi_ru      AS birim_adi_ru
	 ,ba.adi         AS bilimsel_alan
	 ,ba.adi_kz      AS bilimsel_alan_kz
	 ,ba.adi_en      AS bilimsel_alan_en
	 ,ba.adi_ru      AS bilimsel_alan_ru
	 ,pn.adi         AS personel_nitelik
	 ,pn.adi_kz      AS personel_nitelik_kz
	 ,pn.adi_en      AS personel_nitelik_en
	 ,pn.adi_ru      AS personel_nitelik_ru
	 ,akt.adi         AS akademik_kadro_tipi
	 ,akt.adi_kz      AS akademik_kadro_tipi_kz
	 ,akt.adi_en      AS akademik_kadro_tipi_en
	 ,akt.adi_ru      AS akademik_kadro_tipi_ru
	 ,ikt.adi         AS idari_kadro_tipi
	 ,ikt.adi_kz      AS idari_kadro_tipi_kz
	 ,ikt.adi_en      AS idari_kadro_tipi_en
	 ,ikt.adi_ru      AS idari_kadro_tipi_ru
	 ,ad.adi         AS akademik_derece
	 ,ad.adi_kz      AS akademik_derece_kz
	 ,ad.adi_en      AS akademik_derece_en
	 ,ad.adi_ru      AS akademik_derece_ru
	 ,au.adi         AS akademik_unvan
	 ,au.adi_kz      AS akademik_unvan_kz
	 ,au.adi_en      AS akademik_unvan_en
	 ,au.adi_ru      AS akademik_unvan_ru
	 ,ht.adi         AS hizmet_turu
	 ,ht.adi_kz      AS hizmet_turu_kz
	 ,ht.adi_en      AS hizmet_turu_en
	 ,ht.adi_ru      AS hizmet_turu_ru
	 ,it.adi         AS istihdam_turu
	 ,it.adi_kz      AS istihdam_turu_kz
	 ,it.adi_en      AS istihdam_turu_en
	 ,it.adi_ru      AS istihdam_turu_ru
FROM
	tb_personel_calisma_yeri_bilgileri AS pab
LEFT JOIN tb_egitim_ogretim_yillari AS eoy ON eoy.id = pab.egitim_ogretim_yili_id
LEFT JOIN tb_birim_agaci AS b ON b.id = pab.birim_id
LEFT JOIN tb_personel_nitelikleri AS pn ON pn.id = pab.personel_nitelik_id
LEFT JOIN tb_akademik_kadro_tipleri AS akt ON akt.id = pab.akademik_kadro_tipi_id
LEFT JOIN tb_idari_kadro_tipleri AS ikt ON ikt.id = pab.idari_kadro_tipi_id
LEFT JOIN tb_akademik_dereceler AS ad ON ad.id = pab.akademik_derece_id
LEFT JOIN tb_akademik_unvanlar AS au ON au.id = pab.akademik_unvan_id
LEFT JOIN tb_istihdam_turleri AS it ON it.id = pab.istihdam_turu_id
LEFT JOIN tb_hizmet_turleri AS ht ON ht.id = pab.hizmet_turu_id
LEFT JOIN tb_bilimsel_alanlar AS ba ON ba.id = pab.bilimsel_alan_id
WHERE 
    pab.personel_id = ?
ORDER BY pab.egitim_ogretim_yili_id DESC
SQL;

$SQL_tek_personel_calisma_yeri_bilgi_oku = <<< SQL
SELECT 
	*
FROM 
	tb_personel_calisma_yeri_bilgileri
WHERE 
	id = ?
SQL;


$SQL_ulkeler = <<< SQL
SELECT
	 *
FROM
	tb_ulkeler
ORDER BY alfa2_kodu
SQL;

$SQL_personel = <<< SQL
SELECT 
	p.*
	,CONCAT( p.adi, ' ', p.soyadi ) AS adi_soyadi
	,CONCAT( p.adi_kz, ' ', p.soyadi_kz ) AS adi_soyadi_kz
	,CONCAT( p.adi_en, ' ', p.soyadi_en ) AS adi_soyadi_en
	,CONCAT( p.adi_ru, ' ', p.soyadi_ru ) AS adi_soyadi_ru
	,ba.adi    as birim_adi
	,ba.adi_kz as birim_adi_kz
	,ba.adi_en as birim_adi_en
	,ba.adi_ru as birim_adi_ru
	,pn.adi    as personel_nitelik_adi
	,pn.adi_kz as personel_nitelik_adi_kz
	,pn.adi_en as personel_nitelik_adi_en
	,pn.adi_ru as personel_nitelik_adi_ru
FROM 
	tb_personeller AS p
LEFT JOIN tb_birim_agaci AS ba ON ba.id = p.birim_id
LEFT JOIN tb_personel_nitelikleri AS pn ON pn.id = p.personel_nitelik_id
WHERE 
    p.id = ?
SQL;

$SQL_egitim_ogretim_yillari = <<< SQL
SELECT
	 *
FROM
	tb_egitim_ogretim_yillari
WHERE aktif = 1
ORDER BY id DESC
SQL;

$SQL_birim_agaci_getir = <<< SQL
SELECT
	*
FROM 
	tb_birim_agaci
SQL;

$SQL_akademik_kadro_tipleri = <<< SQL
SELECT
	*
FROM 
	tb_akademik_kadro_tipleri
SQL;

$SQL_idari_kadro_tipleri = <<< SQL
SELECT
	*
FROM 
	tb_idari_kadro_tipleri
SQL;

$SQL_akademik_dereceler = <<< SQL
SELECT
	*
FROM 
	tb_akademik_dereceler
SQL;

$SQL_akademik_unvanlar = <<< SQL
SELECT
	*
FROM 
	tb_akademik_unvanlar
SQL;

$SQL_istihdam_turleri = <<< SQL
SELECT
	*
FROM 
	tb_istihdam_turleri
SQL;

$SQL_hizmet_turleri = <<< SQL
SELECT
	*
FROM 
	tb_hizmet_turleri
SQL;

$SQL_bilimsel_alanlar = <<< SQL
SELECT
	*
FROM 
	tb_bilimsel_alanlar
SQL;

$SQL_uzmanlik_alanlari = <<< SQL
SELECT
	*
FROM 
	tb_uzmanlik_alanlari
SQL;



$SQL_personel_nitelikleri = <<< SQL
SELECT
	*
FROM 
	tb_personel_nitelikleri
SQL;

$SQL_ust_id_getir = <<< SQL
WITH RECURSIVE ust_kategoriler AS (
    SELECT id, ust_id, adi
    FROM tb_birim_agaci
    WHERE id = ? -- burası istediğiniz başlangıç ID'si
    UNION ALL
    SELECT k.id, k.ust_id, k.adi
    FROM tb_birim_agaci k
    JOIN ust_kategoriler uk ON k.id = uk.ust_id
)
SELECT * FROM ust_kategoriler;
SQL;

$SQL_alt_id_getir = <<< SQL
WITH RECURSIVE alt_kategoriler AS (
    SELECT *
    FROM tb_birim_agaci
    WHERE id = ? -- burası istediğiniz başlangıç ID'si
    UNION ALL
    SELECT k.*
    FROM tb_birim_agaci k
    JOIN alt_kategoriler ak ON k.ust_id = ak.id
)
SELECT * FROM alt_kategoriler;
SQL;


$birim_agacilar 		        = $vt->select($SQL_birim_agaci_getir, array(  ) )[ 2 ];
$akademik_kadro_tipleri 		= $vt->select($SQL_akademik_kadro_tipleri, array(  ) )[ 2 ];
$idari_kadro_tipleri 	    	= $vt->select($SQL_idari_kadro_tipleri, array(  ) )[ 2 ];
$akademik_dereceler      		= $vt->select($SQL_akademik_dereceler, array(  ) )[ 2 ];
$akademik_unvanlar 	        	= $vt->select($SQL_akademik_unvanlar, array(  ) )[ 2 ];
$istihdam_turleri 	        	= $vt->select($SQL_istihdam_turleri, array(  ) )[ 2 ];
$personel_nitelikleri 	        = $vt->select($SQL_personel_nitelikleri, array(  ) )[ 2 ];
$hizmet_turleri 	        	= $vt->select($SQL_hizmet_turleri, array(  ) )[ 2 ];
$bilimsel_alanlar 	        	= $vt->select($SQL_bilimsel_alanlar, array(  ) )[ 2 ];
$uzmanlik_alanlari 	        	= $vt->select($SQL_uzmanlik_alanlari, array(  ) )[ 2 ];
$personel_calisma_yeri_bilgileri	    = $vt->select( $SQL_tum_personel_calisma_yeri_bilgileri, array( $personel_id ) )[ 2 ];
$ulkeler                   	    = $vt->select( $SQL_ulkeler, array(  ) )[ 2 ];
$egitim_ogretim_yillari         = $vt->select( $SQL_egitim_ogretim_yillari, array(  ) )[ 2 ];
@$tek_personel_calisma_yeri_bilgi 	= $vt->selectSingle( $SQL_tek_personel_calisma_yeri_bilgi_oku, array( $id ) )[ 2 ];
@$tek_personel                  = $vt->selectSingle( $SQL_personel, array( $personel_id ) )[ 2 ];

$ust_idler					= $vt->select( $SQL_ust_id_getir, array( $tek_personel_calisma_yeri_bilgi['birim_id'] ) )[ 2 ];
$alt_idler					= $vt->select( $SQL_alt_id_getir, array( $tek_personel_calisma_yeri_bilgi['birim_id'] ) )[ 2 ];

foreach($ust_idler as $ust_id) 
	$ust_id_dizi[] = $ust_id['ust_id'];

foreach($alt_idler as $alt_id) 
	$alt_id_dizi[] = $alt_id['ust_id'];

if( $tek_personel[ "foto" ] == "resim_yok.png" or $tek_personel[ "foto" ] == "" )
    $personel_foto = $tek_personel[ "cinsiyet" ]."resim_yok.png";
else
    $personel_foto = $tek_personel[ "foto" ];




?>



<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-9">
                <div class="row">
                    <div class="col-12 ">
                        <div class="card card-danger card-outline" id = "card_personel_calisma_yeri_bilgileri">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="img-fluid img-circle img-thumbnail mw-100"
                                        style="width:120px; cursor:pointer;"
                                        src="resimler/personel_resimler/<?php echo $personel_foto; ?>" 
                                        alt="User profile picture"
                                        id = "personel_kullanici_resim">
                                </div>
                                <h3 class="profile-username text-center text-danger"><?php echo $tek_personel[ "adi".$dil ]." ".$tek_personel[ "soyadi".$dil ]; ?></h3>
                                <p class="text-muted text-center"><?php echo $tek_personel[ "personel_nitelik_adi".$dil ]; ?></p>
                                <a class = "btn btn-sm btn-danger  float-right" href = "?modul=personelDetay&personel_id=<?php echo $personel_id;; ?>" >
                                    <i class="fas fa-arrow-left"></i> <?php echo dil_cevir( "Profile Geri Dön", $dizi_dil, $sistem_dil ); ?>
                                </a>
                                <input type="file" id="gizli_input_file" name = "input_personel_resim" style = "display:none;" name = "resim" accept="image/gif, image/jpeg, image/png"  onchange="resimOnizle(this)"; />
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-olive" id = "card_personel_calisma_yeri_bilgileri">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo dil_cevir( "Asıl Kadro Yerleri", $dizi_dil, $sistem_dil ); ?></h3>
                                <div class = "card-tools">
                                    <button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
                                    <a id = "yeni_fakulte" data-toggle = "tooltip" title = "Add" href = "?modul=personelCalismaYeriBilgileri&islem=ekle&personel_id=<?php echo $personel_id ?>" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="tbl_personel_calisma_yeri_bilgileri" class="table table-bordered table-hover table-sm" width = "100%" >
                                    <thead>
                                        <tr>
                                            <th style="width: 15px">#</th>
                                            <th><?php echo dil_cevir( "Eğitim Öğretim Yılı", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Personel Türü", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Kadro Tipi", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Akademik Derece", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Akademik Ünvan", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Bilimsel Alan", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Uzmanlık Alanları", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></th>
                                            <th data-priority="1"><?php echo dil_cevir( "Aktif", $dizi_dil, $sistem_dil ); ?></th>
                                            <th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
                                            <th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sayi = 1; 
                                        foreach( $personel_calisma_yeri_bilgileri AS $personel_calisma_yeri_bilgi ) { 
                                            $where_uzmanlik_alanlari = " where id in (".$personel_calisma_yeri_bilgi['uzmanlik_alan_idler'].")";
                                            $SQL_personel_uzmanlik_alanlari = <<< SQL
                                            SELECT
                                                *
                                            FROM 
                                                tb_uzmanlik_alanlari
                                            $where_uzmanlik_alanlari
                                            SQL;
                                            $personel_uzmanlik_alanlari = $vt->select($SQL_personel_uzmanlik_alanlari, array(  ) )[ 2 ];
                                            $uzmanlik_alanlari_adi = "";
                                            foreach( $personel_uzmanlik_alanlari as $result ){
                                                $uzmanlik_alanlari_adi .= "<h6><span class='badge badge-secondary'>".$result['kodu']." ".$result['adi']."</span></h6>";
                                            }

                                        ?>
                                        <tr oncontextmenu="fun();" class =" <?php if( $personel_calisma_yeri_bilgi[ 'id' ] == $id ) echo $satir_renk; ?>" data-id="<?php echo $personel_calisma_yeri_bilgi[ 'id' ]; ?>">
                                            <td><?php echo $sayi++; ?></td>
                                            <td><?php echo $personel_calisma_yeri_bilgi[ 'egitim_ogretim_yili' ]; ?></td>
                                            <td><?php echo $personel_calisma_yeri_bilgi[ 'personel_nitelik'.$dil ]; ?></td>
                                            <?php if( $personel_calisma_yeri_bilgi[ 'personel_nitelik_id' ] == 1 OR $personel_calisma_yeri_bilgi[ 'personel_nitelik_id' ] == 3  ){ ?>
                                            <td><?php echo $personel_calisma_yeri_bilgi[ 'akademik_kadro_tipi'.$dil ]; ?></td>
                                            <?php }else{ ?>
                                            <td><?php echo $personel_calisma_yeri_bilgi[ 'idari_kadro_tipi'.$dil ]; ?></td>
                                            <?php } ?>
                                            <td><?php echo $personel_calisma_yeri_bilgi[ 'akademik_derece'.$dil ]; ?></td>
                                            <td><?php echo $personel_calisma_yeri_bilgi[ 'akademik_unvan'.$dil ]; ?></td>
                                            <td><?php echo $personel_calisma_yeri_bilgi[ 'bilimsel_alan'.$dil ]; ?></td>
                                            <td><?php echo $uzmanlik_alanlari_adi; ?></td>
                                            <td><span class="d-none"><?php echo $personel_calisma_yeri_bilgi[ 'baslama_tarihi' ]; ?></span><?php echo $fn->tarihVer( $personel_calisma_yeri_bilgi[ 'baslama_tarihi' ] ); ?></td>
                                            <td><span class="d-none"><?php echo $personel_calisma_yeri_bilgi[ 'bitis_tarihi' ]; ?></span><?php echo $fn->tarihVer( $personel_calisma_yeri_bilgi[ 'bitis_tarihi' ] ); ?></td>
                                            <td class="text-center">
                                                <?php if( $personel_calisma_yeri_bilgi[ 'aktif_calisma_yeri' ] == 1 ){ ?>
                                                    <h6><span class="badge badge-success"><?php echo dil_cevir( "Aktif", $dizi_dil, $sistem_dil ); ?></span></h6>
                                                <?php } ?>
                                            </td>
                                            <td align = "center">
                                                <a modul = 'personelCalismaYeriBilgileri' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=personelCalismaYeriBilgileri&islem=guncelle&personel_id=<?php echo $personel_calisma_yeri_bilgi[ 'personel_id' ]; ?>&id=<?php echo $personel_calisma_yeri_bilgi[ 'id' ]; ?>" >
                                                    <?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
                                                </a>
                                            </td>
                                            <td align = "center">
                                                <button modul= 'personelCalismaYeriBilgileri' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/personelCalismaYeriBilgileri/personelCalismaYeriBilgileriSEG.php?islem=sil&personel_id=<?php echo $personel_calisma_yeri_bilgi[ 'personel_id' ]; ?>&id=<?php echo $personel_calisma_yeri_bilgi[ 'id' ]; ?>" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<div class="col-md-3">
				<form class="form-horizontal" action = "_modul/personelCalismaYeriBilgileri/personelCalismaYeriBilgileriSEG.php" method = "POST" enctype="multipart/form-data">
					<div class="card card-secondary">
						<div class="card-header">
							<h3 class='card-title'><?php echo dil_cevir( "Asıl Kadro Yeri / Düzenle", $dizi_dil, $sistem_dil ); ?></h3>
						</div>
						<div class="card-body">
								<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
								<input type = "hidden" name = "id" value = "<?php echo $id; ?>">
								<input type = "hidden" name = "personel_id" value = "<?php echo $personel_id; ?>">
                                <div class="form-group clearfix">
                                    <div class="icheck-success d-inline">
                                        <input type="checkbox" id="aktif_calisma_yeri" value="1" name="aktif_calisma_yeri" <?php if( $tek_personel_calisma_yeri_bilgi[ "aktif_calisma_yeri" ] == 1 ) echo "checked";?> >
                                        <label for="aktif_calisma_yeri">
                                            <?php echo dil_cevir( "Aktif Çalışma Yeri", $dizi_dil, $sistem_dil ); ?>
                                        </label>
                                        <small class="form-text text-muted"><?php echo dil_cevir( "Şu anda aktif olan çalışma yeri ise işaretleyiniz.", $dizi_dil, $sistem_dil ); ?></small>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label  class="control-label"><?php echo dil_cevir( "Birim", $dizi_dil, $sistem_dil ); ?></label>
                                    <div class="overflow-auto" >
                                        <table class="table table-sm table-hover ">
                                        <tbody>
                                            <?php
                                            //var_dump($birim_agacilar);
                                                function kategoriListele3( $kategoriler, $parent = 0, $renk = 0,$vt, $gelen_birim_id, $ust_id_dizi, $sistem_dil){
                                                    $sistem_dil2 = $sistem_dil == "_tr" ? "" : $sistem_dil ;
                                                    $adi = "adi".$sistem_dil2;

                                                    $html = "<tr class='expandable-body'>
                                                                    <td>
                                                                        <div class='p-0'>
                                                                            <table class='table table-hover'>
                                                                                <tbody>";

                                                    foreach ($kategoriler as $kategori){
                                                        if( $kategori['ust_id'] == $parent ){
                                                            if( $parent == 0 ) {
                                                                $renk = 1;
                                                            } 

                                                            if( $kategori['id'] == $gelen_birim_id  ){
                                                                $secili = "checked";
                                                            }else{
                                                                $secili = "";
                                                            }

                                                            if( $kategori['kategori'] == 0  or $kategori['birim_turu'] == 3 ){
                                                                $html .= "
                                                                        <tr>
                                                                            <td class=' bg-renk7' >
                                                                                    <div class='icheck-success d-inline'>
                                                                                        <input type='radio' class='form-control form-control-sm' id='icheck_$kategori[id]' name='birim_id' value='$kategori[id]' $secili required>
                                                                                        <label for='icheck_$kategori[id]' onclick='event.stopPropagation();'>
                                                                                        $kategori[$adi]
                                                                                        </label>
                                                                                    </div>
                                                                            </td>
                                                                        </tr>";									

                                                            }elseif( $kategori['kategori'] == 1){
                                                                if( in_array($kategori['id'], $ust_id_dizi) )
                                                                    $agac_acik = "true";
                                                                else
                                                                    $agac_acik = "false";

                                                                // if( $kategori['ust_id'] == 0 )
                                                                // 	$agac_acik = "true";
                                                                // else
                                                                // 	$agac_acik = "false";
                                                                if( $kategori['grup'] == 1 ){
                                                                    $html .= "
                                                                            <tr data-widget='expandable-table' aria-expanded='$agac_acik' class='border-0'>
                                                                                <td class='bg-renk$renk'>																
                                                                                    $kategori[$adi]
                                                                                    <i class='expandable-table-caret fas fa-caret-right fa-fw'></i>
                                                                                </td>
                                                                            </tr>
                                                                        ";								
                                                                }else{
                                                                    $html .= "
                                                                            <tr data-widget='expandable-table' aria-expanded='$agac_acik' class='border-0'>
                                                                                <td class='bg-renk$renk'>																
                                                                                    <div class='icheck-success d-inline'>
                                                                                        <input type='radio' class='form-control form-control-sm' id='icheck_$kategori[id]' name='birim_id' value='$kategori[id]' $secili required>
                                                                                        <label for='icheck_$kategori[id]' onclick='event.stopPropagation();'>
                                                                                        </label>
                                                                                    </div>
                                                                                        $kategori[$adi]
                                                                                <i class='expandable-table-caret fas fa-caret-right fa-fw'></i>
                                                                                </td>
                                                                            </tr>
                                                                        ";								

                                                                }
                                                                    $renk++;
                                                                    $html .= kategoriListele3($kategoriler, $kategori['id'],$renk, $vt, $gelen_birim_id, $ust_id_dizi, $sistem_dil);
                                                                    
                                                                    $renk--;
                                                                
                                                            }
                                                        }

                                                    }
                                                    $html .= '
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>';
                                                    return $html;
                                                }
                                                if( count( $birim_agacilar ) ) 
                                                    echo kategoriListele3($birim_agacilar,0,0, $vt, $tek_personel_calisma_yeri_bilgi[ "birim_id" ], $ust_id_dizi, $sistem_dil);
                                                

                                            ?>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Eğitim Öğretim Yılı", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" name = "egitim_ogretim_yili_id" required  >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $egitim_ogretim_yillari AS $egitim_ogretim_yili ){ ?>
                                            <option value="<?php echo $egitim_ogretim_yili[ "id" ]; ?>" <?php echo $tek_personel_calisma_yeri_bilgi[ "egitim_ogretim_yili_id" ] == $egitim_ogretim_yili[ "id" ] ? "selected" : null ?>><?php echo $egitim_ogretim_yili[ "adi" ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Personel Türü", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" id = "personel_nitelik_id" name = "personel_nitelik_id" onchange="kadro_tipi_degistir(this)" required  >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $personel_nitelikleri AS $personel_nitelik ){ ?>
                                            <option value="<?php echo $personel_nitelik[ "id" ]; ?>" <?php echo $tek_personel_calisma_yeri_bilgi[ "personel_nitelik_id" ] == $personel_nitelik[ "id" ] ? "selected" : null ?>><?php echo $personel_nitelik[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group akademik_kadrolar">
                                    <label  class="control-label"><?php echo dil_cevir( "Kadro Tipi", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" id = "akademik_kadro_tipi_id" name = "akademik_kadro_tipi_id" >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $akademik_kadro_tipleri AS $result ){ ?>
                                            <option value="<?php echo $result[ "id" ]; ?>" <?php echo $tek_personel_calisma_yeri_bilgi[ "akademik_kadro_tipi_id" ] == $result[ "id" ] ? "selected" : null ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group idari_kadrolar">
                                    <label  class="control-label"><?php echo dil_cevir( "Kadro Tipi", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" id = "idari_kadro_tipi_id" name = "idari_kadro_tipi_id" >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $idari_kadro_tipleri AS $result ){ ?>
                                            <option value="<?php echo $result[ "id" ]; ?>" <?php echo $tek_personel_calisma_yeri_bilgi[ "idari_kadro_tipi_id" ] == $result[ "id" ] ? "selected" : null ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Akademik Derece", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" name = "akademik_derece_id" >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $akademik_dereceler AS $result ){ ?>
                                            <option value="<?php echo $result[ "id" ]; ?>" <?php echo $tek_personel_calisma_yeri_bilgi[ "akademik_derece_id" ] == $result[ "id" ] ? "selected" : null ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Akademik Unvan", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" name = "akademik_unvan_id" >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $akademik_unvanlar AS $result ){ ?>
                                            <option value="<?php echo $result[ "id" ]; ?>" <?php echo $tek_personel_calisma_yeri_bilgi[ "akademik_unvan_id" ] == $result[ "id" ] ? "selected" : "" ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                        <option value="0" <?php echo $tek_personel_calisma_yeri_bilgi[ "akademik_unvan_id" ] === 0 ? "selected" : "" ?>><?php echo dil_cevir( "Yok", $dizi_dil, $sistem_dil ); ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo dil_cevir( "Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                    <div class="input-group date" id="baslama_tarihi" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#baslama_tarihi" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input  required type="text" data-target="#baslama_tarihi" data-toggle="datetimepicker" name="baslama_tarihi" value="<?php if( $tek_personel_calisma_yeri_bilgi[ 'baslama_tarihi' ] !='' ){echo date('d.m.Y',strtotime($tek_personel_calisma_yeri_bilgi[ 'baslama_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker1"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo dil_cevir( "Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                    <div class="input-group date" id="bitis_tarihi" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#bitis_tarihi" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" data-target="#bitis_tarihi" data-toggle="datetimepicker" name="bitis_tarihi" value="<?php if( $tek_personel_calisma_yeri_bilgi[ 'bitis_tarihi' ] !='' ){echo date('d.m.Y',strtotime($tek_personel_calisma_yeri_bilgi[ 'bitis_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker1"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Bilimsel Alan", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" name = "bilimsel_alan_id" >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $bilimsel_alanlar AS $result ){ ?>
                                            <option value="<?php echo $result[ "id" ]; ?>" <?php echo $tek_personel_calisma_yeri_bilgi[ "bilimsel_alan_id" ] == $result[ "id" ] ? "selected" : null ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Uzmanlık Alanları", $dizi_dil, $sistem_dil ); ?></label>
                                    <select   class="form-control select2"  multiple="multiple" name = "uzmanlik_alan_idler[]">
                                        <?php foreach( $uzmanlik_alanlari AS $result ) { 
                                                $uzmanlik_alanlari2 = explode(",", $tek_personel_calisma_yeri_bilgi[ 'uzmanlik_alan_idler' ]);
                                        ?>
                                            <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( in_array($result[ 'id' ], $uzmanlik_alanlari2) ) echo 'selected'?>><?php echo $result[ 'kodu' ]." - ".$result[ 'adi'.$dil ]?></option>
                                        <?php } ?>
                                    </select>
                                </div>



						</div>
						<div class="card-footer">
							<button modul= 'personelCalismaYeriBilgileri' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
	<script>
		var select_personel_nitelik = document.getElementById('personel_nitelik_id');
		<?php if( isset($_REQUEST['personel_nitelik_id'] )){ ?>
			select_personel_nitelik.value = "<?php echo $_REQUEST['personel_nitelik_id'];  ?>";
		<?php }?>



		select_personel_nitelik.dispatchEvent(new Event('change'));

		function kadro_tipi_degistir(eleman){
			if( eleman.value == "1" ){
				$('.akademik_kadrolar').css('display','block');
				$('.idari_kadrolar').css('display','none');
                $("#akademik_kadro_tipi_id").attr("required","required");
                $("#idari_kadro_tipi_id").removeAttr("required");
                $("#idari_kadro_tipi_id").val('').change();
            }else if( eleman.value == "2" ){
				$('.akademik_kadrolar').css('display','none');
				$('.idari_kadrolar').css('display','block');
                $("#idari_kadro_tipi_id").attr("required","required");
                $("#akademik_kadro_tipi_id").removeAttr("required");
                $("#akademik_kadro_tipi_id").val('').change();
            }else if( eleman.value == "3" ){
				$('.akademik_kadrolar').css('display','block');
				$('.idari_kadrolar').css('display','none');
                $("#akademik_kadro_tipi_id").attr("required","required");
                $("#idari_kadro_tipi_id").removeAttr("required");
                $("#idari_kadro_tipi_id").val('').change();
            }else{
				$('.akademik_kadrolar').css('display','none');
				$('.idari_kadrolar').css('display','none');
                $("#akademik_kadro_tipi_id").removeAttr("required");
                $("#idari_kadro_tipi_id").removeAttr("required");
                $("#akademik_kadro_tipi_id").val('').change();
                $("#idari_kadro_tipi_id").val('').change();
            }
		}
	</script>

<script type="text/javascript">
	var simdi = new Date(); 
	//var simdi="11/25/2015 15:58";
	$(function () {
		$('#baslama_tarihi').datetimepicker({
			//defaultDate: simdi,
			format: 'DD.MM.yyyy',
			icons: {
			time: "far fa-clock",
			date: "fa fa-calendar",
			up: "fa fa-arrow-up",
			down: "fa fa-arrow-down"
			}
		});
	});
	
	$(function () {
		$('#bitis_tarihi').datetimepicker({
			//defaultDate: simdi,
			format: 'DD.MM.yyyy',
			icons: {
			time: "far fa-clock",
			date: "fa fa-calendar",
			up: "fa fa-arrow-up",
			down: "fa fa-arrow-down"
			}
		});
	});

	$(function () {
		$('#belge_tarihi').datetimepicker({
			//defaultDate: simdi,
			format: 'DD.MM.yyyy',
			icons: {
			time: "far fa-clock",
			date: "fa fa-calendar",
			up: "fa fa-arrow-up",
			down: "fa fa-arrow-down"
			}
		});
	});

	

	
</script>

<script type="text/javascript">


var tbl_personel_calisma_yeri_bilgileri = $( "#tbl_personel_calisma_yeri_bilgileri" ).DataTable( {
	"responsive": true, "lengthChange": true, "autoWidth": true,
	"stateSave": true,
	"pageLength" : 25,
	//"buttons": ["excel", "pdf", "print","colvis"],

	buttons : [
		{
			extend	: 'colvis',
			text	: "Alan Seçiniz"
			
		},
		{
			extend	: 'excel',
			text 	: 'Excel',
			exportOptions: {
				columns: ':visible'
			},
			title: function(){
				return "<?php echo dil_cevir( $modul_adi, $dizi_dil, $sistem_dil ); ?>";
			}
		},
		{
			extend	: 'print',
			text	: 'Yazdır',
			exportOptions : {
				columns : ':visible'
			},
			title: function(){
				return "<?php echo dil_cevir( $modul_adi, $dizi_dil, $sistem_dil ); ?>";
			}
		}
	],
	"language": {
		"decimal"			: "",
		"emptyTable"		: "Gösterilecek kayıt yok!",
		"info"				: "Toplam _TOTAL_ kayıttan _START_ ve _END_ arası gösteriliyor",
		"infoEmpty"			: "Toplam 0 kayıttan 0 ve 0 arası gösteriliyor",
		"infoFiltered"		: "",
		"infoPostFix"		: "",
		"thousands"			: ",",
		"lengthMenu"		: "Show _MENU_ entries",
		"loadingRecords"	: "Yükleniyor...",
		"processing"		: "İşleniyor...",
		"search"			: "Ara:",
		"zeroRecords"		: "Eşleşen kayıt bulunamadı!",
		"paginate"			: {
			"first"		: "İlk",
			"last"		: "Son",
			"next"		: "Sonraki",
			"previous"	: "Önceki"
		}
	}
} ).buttons().container().appendTo('#tbl_personel_calisma_yeri_bilgileri_wrapper .col-md-6:eq(0)');



$('#card_personel_calisma_yeri_bilgileri').on('maximized.lte.cardwidget', function() {
	var tbl_personel_calisma_yeri_bilgileri = $( "#tbl_personel_calisma_yeri_bilgileri" ).DataTable();
	var column = tbl_personel_calisma_yeri_bilgileri.column(  tbl_personel_calisma_yeri_bilgileri.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_personel_calisma_yeri_bilgileri.column(  tbl_personel_calisma_yeri_bilgileri.column.length - 2 );
	column.visible( ! column.visible() );
});

$('#card_personel_calisma_yeri_bilgileri').on('minimized.lte.cardwidget', function() {
	var tbl_personel_calisma_yeri_bilgileri = $( "#tbl_personel_calisma_yeri_bilgileri" ).DataTable();
	var column = tbl_personel_calisma_yeri_bilgileri.column(  tbl_personel_calisma_yeri_bilgileri.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_personel_calisma_yeri_bilgileri.column(  tbl_personel_calisma_yeri_bilgileri.column.length - 2 );
	column.visible( ! column.visible() );
} );
</script>
	<script>
		var select = document.getElementById('dil');
		<?php if( isset($_REQUEST['dil'] )){ ?>
			select.value = "<?php echo $_REQUEST['dil'];  ?>";
		<?php }else{ ?>
			select.value = "<?php echo $sistem_dil;  ?>";
		<?php } ?>

		<?php if( isset($_REQUEST['sistem_dil'] )){ ?>
			select.value = "<?php echo $_REQUEST['sistem_dil'];  ?>";
		<?php } ?>

		select.dispatchEvent(new Event('change'));

		function dil_degistir(eleman){
			//alert("<?php echo $islem; ?>");
			if( eleman.value == "_tr" ) dil = ""; else dil = eleman.value;
			<?php if( $islem == "guncelle" ){ ?>
				
				document.getElementById("okul_adi").value = document.getElementsByName("okul_adi"+dil)[0].value;
				document.getElementById("fakulte").value = document.getElementsByName("fakulte"+dil)[0].value;
				document.getElementById("bolum").value = document.getElementsByName("bolum"+dil)[0].value;
				document.getElementById("program").value = document.getElementsByName("program"+dil)[0].value;
				document.getElementById("docentlik_alani").value = document.getElementsByName("docentlik_alani"+dil)[0].value;
				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				// window.editor.data.set(document.getElementsByName("ozgecmis"+dil)[0].value);
			<?php } ?>
		}
	</script>
