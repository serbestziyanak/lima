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


$satir_renk				= $id > 0	? 'table-warning'						: '';
$kaydet_buton_yazi		= $id > 0	? ' Güncelle'							: ' Kaydet';
$kaydet_buton_cls		= $id > 0	? 'btn btn-success btn-sm pull-right'	: 'btn btn-success btn-sm pull-right';

$SQL_tum_fuarlar = <<< SQL
SELECT 
	f.*
    ,fd.fuar_id
    ,fd.dil_id
    ,fd.adi
    ,b.adi as bolge_adi
    ,u.adi as ulke_adi
    ,s.adi as sehir_adi
    ,fad.adi as fuar_alani_adi
    ,CONCAT(pb.kodu," - ",pb.sembol) as para_birimi
FROM 
	tb_fuarlar AS f
LEFT JOIN tb_fuarlar_dil AS fd ON f.id = fd.fuar_id
LEFT JOIN tb_diller AS dil ON dil.id = fd.dil_id
LEFT JOIN tb_bolgeler AS b ON b.id = f.bolge_id
LEFT JOIN tb_ulkeler As u ON u.id = f.ulke_id
LEFT JOIN tb_sehirler AS s ON s.id = f.sehir_id
LEFT JOIN tb_fuar_alanlari AS fa ON fa.id = f.fuar_alani_id
LEFT JOIN tb_fuar_alanlari_dil AS fad ON fa.id = fad.fuar_alani_id AND fad.dil_id=1
LEFT JOIN tb_para_birimleri AS pb ON pb.id = f.para_birimi_id
WHERE fd.dil_id = 1
SQL;


$SQL_tek_fuar_oku = <<< SQL
SELECT 
	 f.*
    ,fd.fuar_id
    ,fd.dil_id
    ,fd.adi
    ,fd.aciklama
    ,fd.nerede_kalmali
    ,fd.ne_yemeli
    ,fd.diger_notlar
FROM 
	tb_fuarlar AS f
LEFT JOIN tb_fuarlar_dil AS fd ON f.id = fd.fuar_id
LEFT JOIN tb_diller AS dil ON dil.id = fd.dil_id
WHERE f.id = ?
SQL;

$SQL_diller = <<< SQL
SELECT
	*
FROM 
	tb_diller
WHERE aktif = 1
ORDER BY sira
SQL;

$SQL_lima_personelleri = <<< SQL
SELECT 
	 *
FROM 
	tb_sistem_kullanici
SQL;

$SQL_bolgeler = <<< SQL
SELECT 
	 *
FROM 
	tb_bolgeler
SQL;

$SQL_ulkeler = <<< SQL
SELECT 
	 *
FROM 
	tb_ulkeler
WHERE
    bolge_id = ?
SQL;

$SQL_sehirler = <<< SQL
SELECT 
	 *
FROM 
	tb_sehirler
WHERE
    ulke_id = ?
SQL;

$SQL_para_birimleri = <<< SQL
SELECT 
	 *
FROM 
	tb_para_birimleri
SQL;

$SQL_fuar_tanimlari = <<< SQL
SELECT 
	 ft.*
     ,ftd.dil_id
     ,ftd.adi
FROM 
	tb_fuar_tanimlari AS ft
LEFT JOIN tb_fuar_tanimlari_dil AS ftd ON ft.id = ftd.fuar_tanim_id
LEFT JOIN tb_diller AS dil ON dil.id = ftd.dil_id
WHERE ftd.dil_id = 1
SQL;

$SQL_fuar_alanlari = <<< SQL
SELECT 
	 fa.*
     ,fad.dil_id
     ,fad.adi
FROM 
	tb_fuar_alanlari AS fa
LEFT JOIN tb_fuar_alanlari_dil AS fad ON fa.id = fad.fuar_alani_id
LEFT JOIN tb_diller AS dil ON dil.id = fad.dil_id
WHERE fad.dil_id = 1
SQL;

$SQL_galeri = <<< SQL
SELECT 
	*
FROM 
	tb_fuar_galeri
WHERE 
	fuar_id = ? 
SQL;

@$diller 		        = $vt->select( $SQL_diller, array(  ) )[ 2 ];
$fuarlar		        = $vt->select( $SQL_tum_fuarlar, array( ) )[ 2 ];
@$tek_fuarlar 	        = $vt->select( $SQL_tek_fuar_oku, array( $id ) )[ 2 ];
$lima_personelleri		= $vt->select( $SQL_lima_personelleri, array( ) )[ 2 ];
$bolgeler          		= $vt->select( $SQL_bolgeler, array( ) )[ 2 ];
$para_birimleri		    = $vt->select( $SQL_para_birimleri, array( ) )[ 2 ];
$fuar_tanimlari		    = $vt->select( $SQL_fuar_tanimlari, array( ) )[ 2 ];
$fuar_alanlari		    = $vt->select( $SQL_fuar_alanlari, array( ) )[ 2 ];

// var_dump($tek_fuarler);
foreach( $tek_fuarlar as $result ){
    if( $result['dil_id'] == 1 ){
        $default_kayit = $result;
    }
    $hidden_kayitlar[] = $result;
}

$ulkeler		        = $vt->select( $SQL_ulkeler, array( $default_kayit['bolge_id'] ) )[ 2 ];
$sehirler		        = $vt->select( $SQL_sehirler, array( $default_kayit['ulke_id'] ) )[ 2 ];
@$galeri = $vt->select( $SQL_galeri, array( $id ) )[ 2 ];


if( $_REQUEST['islem'] == "ekle" OR $_REQUEST['islem'] == "guncelle" ){
    $form_class = "";
    $tablo_class = "d-none";
}else{
    $form_class = "d-none";
    $tablo_class = "";
}
?>



<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 <?php echo $tablo_class; ?>" >
				<div class="card card-olive" id = "card_fuarlar">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Fuarlar", $dizi_dil, $sistem_dil ); ?></h3>
						<div class = "card-tools">
							<button type="button" data-toggle = "tooltip" title = "Tam fuar göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
							<a data-toggle = "tooltip" title = "Yeni Kayıt Ekle" href = "?modul=fuarlar&islem=ekle" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
						</div>
					</div>
					<div class="card-body">
						<table id="tbl_fuarlar" class="table table-bordered table-hover table-sm" width = "100%" >
							<thead>
								<tr>
									<th style="width: 15px">#</th>
									<th><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Bölge", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Ülke", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Şehir", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Fuar Alanı", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Para B.", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Web Sitesi", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Top. K.", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "TR K.", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $sayi = 1; foreach( $fuarlar AS $fuar ) { ?>
								<tr oncontextmenu="fun();" class =" <?php if( $fuar[ 'id' ] == $id ) echo $satir_renk; ?>" data-id="<?php echo $fuar[ 'id' ]; ?>">
									<td><?php echo $sayi++; ?></td>
									<td><?php echo $fuar[ 'adi' ]; ?></td>
									<td><?php echo $fuar[ 'bolge_adi' ]; ?></td>
									<td><?php echo $fuar[ 'ulke_adi' ]; ?></td>
									<td><?php echo $fuar[ 'sehir_adi' ]; ?></td>
									<td><?php echo $fuar[ 'fuar_alani_adi' ]; ?></td>
									<td><?php echo $fuar[ 'para_birimi' ]; ?></td>
									<td><?php echo $fuar[ 'fuar_web_sitesi' ]; ?></td>
									<td><?php echo $fuar[ 'toplam_katilimci_sayisi' ]; ?></td>
									<td><?php echo $fuar[ 'turkiyeden_katilimci_sayisi' ]; ?></td>
									<td><span style="display:none;"><?php echo $fuar[ 'baslama_tarihi' ]; ?></span><?php echo $fn->tarihVer( $fuar[ 'baslama_tarihi' ] ); ?></td>
									<td><span style="display:none;"><?php echo $fuar[ 'bitis_tarihi' ]; ?></span><?php echo $fn->tarihVer( $fuar[ 'bitis_tarihi' ] ); ?></td>
									<td align = "center">
										<a modul = 'fuarlar' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=fuarlar&islem=guncelle&id=<?php echo $fuar[ 'id' ]; ?>" >
											<?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
										</a>
									</td>
									<td align = "center">
										<button modul= 'fuarlar' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/fuarlar/fuarlarSEG.php?islem=sil&id=<?php echo $fuar[ 'id' ]; ?>" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-12 <?php echo $form_class; ?>">
				
					<div class="card card-secondary card-tabs">
						<div class="card-header bg-orange p-0 pt-2">
                            <ul class="nav nav-tabs" id="tab-tab" role="tablist">
                                <li class="pt-2 px-3"><h3 class="card-title text-white"><?php echo $default_kayit[ "adi" ]; ?></h3></li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if( !isset($_REQUEST['aktif_tab']) ) echo "active"; ?>" id="tab-home-tab" data-toggle="pill" href="#tab-home" role="tab" aria-controls="tab-home" aria-selected="true"><?php echo dil_cevir( "Ayarlar", $dizi_dil, $sistem_dil ); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if( $_REQUEST['aktif_tab'] == "tab-aciklama" ) echo "active"; ?>" id="tab-aciklama-tab" data-toggle="pill" href="#tab-aciklama" role="tab" aria-controls="tab-aciklama" aria-selected="false"><?php echo dil_cevir( "Açıklama", $dizi_dil, $sistem_dil ); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if( $_REQUEST['aktif_tab'] == "tab-neyemeli" ) echo "active"; ?>" id="tab-neyemeli-tab" data-toggle="pill" href="#tab-neyemeli" role="tab" aria-controls="tab-neyemeli" aria-selected="false"><?php echo dil_cevir( "Ne Yemeli", $dizi_dil, $sistem_dil ); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if( $_REQUEST['aktif_tab'] == "tab-neredekalmali" ) echo "active"; ?>" id="tab-neredekalmali-tab" data-toggle="pill" href="#tab-neredekalmali" role="tab" aria-controls="tab-neredekalmali" aria-selected="false"><?php echo dil_cevir( "Nerede Kalmalı", $dizi_dil, $sistem_dil ); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if( $_REQUEST['aktif_tab'] == "tab-notlar" ) echo "active"; ?>" id="tab-notlar-tab" data-toggle="pill" href="#tab-notlar" role="tab" aria-controls="tab-notlar" aria-selected="false"><?php echo dil_cevir( "Diğer Notlar", $dizi_dil, $sistem_dil ); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if( $_REQUEST['aktif_tab'] == "custom-tabs-two-galeri" ) echo "active"; ?>" id="custom-tabs-two-galeri-tab" data-toggle="pill" href="#custom-tabs-two-galeri" role="tab" aria-controls="custom-tabs-two-galeri" aria-selected="false"><?php echo dil_cevir( "Galeri", $dizi_dil, $sistem_dil ); ?></a>
                                </li>

                            <div class = "card-tools float-right">
                                <a href="?modul=<?php echo $modul_kisa_ad;?>" type="button" class="btn btn-tool"><i class="fas fa-arrow-left"></i> <?php echo dil_cevir( "Fuarlar", $dizi_dil, $sistem_dil ); ?></a>
                            </div>
                            </ul>
						</div>
						<div class="card-body">
                            <div class="tab-content" id="tab-tabContent">
                                <div class="tab-pane fade <?php if( !isset($_REQUEST['aktif_tab']) ) echo "show active"; ?>" id="tab-home" role="tabpanel" aria-labelledby="tab-home-tab">
                                    <form class="form-horizontal" action = "_modul/fuarlar/fuarlarSEG.php" method = "POST" enctype="multipart/form-data">
                                    <?php 
                                    foreach( $hidden_kayitlar as $hidden_kayit ){ 
                                        foreach( array_keys($hidden_kayit) as $anahtar ){
                                    ?>
                                    <input type="hidden"  id="<?php echo $anahtar."_".$hidden_kayit['dil_id'];  ?>" value="<?php echo htmlentities($hidden_kayit[$anahtar]);  ?>">
                                    <?php }} ?>
                                    <input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
                                    <input type = "hidden" name = "id" value = "<?php echo $id; ?>">
                                    <div class="row">
                                        <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
                                            <select class="form-control select2" name = "dil_id" required onchange="dil_degistir(this);">
                                                <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                                <?php foreach( $diller AS $result ){ ?>
                                                <option value="<?php echo $result["id"] ?>" <?php if( $default_kayit['dil_id'] == $result["id"] ) echo "selected"; ?> ><?php echo $result["adi".$dil] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label  class="control-label"><?php echo dil_cevir( "Fuar Tanımı", $dizi_dil, $sistem_dil ); ?></label>
                                            <select required  class="form-control select2"  id = "fuar_tanim_id"  name = "fuar_tanim_id" >
                                                <option value="">Seçiniz...</option>
                                                <?php foreach( $fuar_tanimlari AS $result ) { ?>
                                                    <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( $result[ 'id' ] == $default_kayit[ "fuar_tanim_id" ] ) echo 'selected'?>><?php echo $result[ 'adi' ]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></label>
                                            <input required type="text" class="form-control form-control-sm " id ="adi" name ="adi" value = "<?php echo $default_kayit[ "adi" ]; ?>"  autocomplete="off">
                                        </div>			
                                        <div class="form-group">
                                            <label class="control-label"><?php echo dil_cevir( "Fuar Web Sitesi", $dizi_dil, $sistem_dil ); ?></label>
                                            <input type="text" class="form-control form-control-sm " name ="fuar_web_sitesi" value = "<?php echo $default_kayit[ "fuar_web_sitesi" ]; ?>"  autocomplete="off">
                                        </div>		
                                        </div>
                                        <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo dil_cevir( "Toplam Katılımcı Sayısı", $dizi_dil, $sistem_dil ); ?></label>
                                            <input type="text" class="form-control form-control-sm " name ="toplam_katilimci_sayisi" value = "<?php echo $default_kayit[ "toplam_katilimci_sayisi" ]; ?>"  autocomplete="off">
                                        </div>			
                                        <div class="form-group">
                                            <label class="control-label"><?php echo dil_cevir( "Türkiyeden Katılımcı Sayısı", $dizi_dil, $sistem_dil ); ?></label>
                                            <input type="text" class="form-control form-control-sm " name ="turkiyeden_katilimci_sayisi" value = "<?php echo $default_kayit[ "turkiyeden_katilimci_sayisi" ]; ?>"  autocomplete="off">
                                        </div>		
                                        <div class="form-group istihdam">
                                            <label class="control-label"><?php echo dil_cevir( "Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                            <div class="input-group date" id="baslama_tarihi" data-target-input="nearest">
                                                <div class="input-group-append" data-target="#baslama_tarihi" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                <input  required type="text" data-target="#baslama_tarihi" data-toggle="datetimepicker" id="baslama_tarihi_input" name="baslama_tarihi" value="<?php if( $default_kayit[ 'baslama_tarihi' ] !='' ){echo date('d.m.Y',strtotime($default_kayit[ 'baslama_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input istihdam" data-target="#datetimepicker1"/>
                                            </div>
                                        </div>
                                        <div class="form-group istihdam">
                                            <label class="control-label"><?php echo dil_cevir( "Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                            <div class="input-group date" id="bitis_tarihi" data-target-input="nearest">
                                                <div class="input-group-append" data-target="#bitis_tarihi" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                <input required  type="text" data-target="#bitis_tarihi" data-toggle="datetimepicker" id="bitis_tarihi_input" name="bitis_tarihi" value="<?php if( $default_kayit[ 'bitis_tarihi' ] !='' ){echo date('d.m.Y',strtotime($default_kayit[ 'bitis_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input istihdam" data-target="#datetimepicker1"/>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-lg-3">
                                        <div class="form-group">
                                            <label  class="control-label"><?php echo dil_cevir( "Fuar Sorumluları", $dizi_dil, $sistem_dil ); ?></label>
                                            <select   class="form-control select2"  multiple="multiple" name = "fuar_sorumlu_idler[]" data-close-on-select="true">
                                                <?php foreach( $lima_personelleri AS $result ) { 
                                                        $lima_personelleri2 = explode(",", $default_kayit[ 'fuar_sorumlu_idler' ]);
                                                ?>
                                                    <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( in_array($result[ 'id' ], $lima_personelleri2) ) echo 'selected'?>><?php echo $result[ 'adi' ]." ".$result[ 'soyadi' ]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label  class="control-label"><?php echo dil_cevir( "Bölge", $dizi_dil, $sistem_dil ); ?></label>
                                            <select required  class="form-control select2"  id = "bolge_id"  name = "bolge_id" >
                                                <option value="">Seçiniz...</option>
                                                <?php foreach( $bolgeler AS $result ) { ?>
                                                    <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( $result[ 'id' ] == $default_kayit[ "bolge_id" ] ) echo 'selected'?>><?php echo $result[ 'adi' ]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                            
                                        <div class="form-group" id="ulke_id_select">
                                            <label  class="control-label">Ülke</label>
                                            <select required class="form-control select2" name = "ulke_id" id="ulke_id">
                                                <option value="">Seçiniz...</option>
                                                <?php foreach( $ulkeler AS $result ) { ?>
                                                    <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( $result[ 'id' ] == $default_kayit[ "ulke_id" ] ) echo 'selected'?>><?php echo $result[ 'adi' ]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group" id="sehir_id_select">
                                            <label  class="control-label">Şehir</label>
                                            <select required class="form-control select2" name = "sehir_id" id="sehir_id">
                                                <option value="">Seçiniz...</option>
                                                <?php foreach( $sehirler AS $result ) { ?>
                                                    <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( $result[ 'id' ] == $default_kayit[ "sehir_id" ] ) echo 'selected'?>><?php echo $result[ 'adi' ]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label  class="control-label"><?php echo dil_cevir( "Fuar Alanı", $dizi_dil, $sistem_dil ); ?></label>
                                                <select   class="form-control select2"  id = "fuar_alani_id"  name = "fuar_alani_id" >
                                                    <option value="">Seçiniz...</option>
                                                    <?php foreach( $fuar_alanlari AS $result ) { ?>
                                                        <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( $result[ 'id' ] == $default_kayit[ "fuar_alani_id" ] ) echo 'selected'?>><?php echo $result[ 'adi' ]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label  class="control-label"><?php echo dil_cevir( "Para Birimi", $dizi_dil, $sistem_dil ); ?></label>
                                                <select   class="form-control select2"  id = "para_birimi_id"  name = "para_birimi_id" >
                                                    <option value="">Seçiniz...</option>
                                                    <?php foreach( $para_birimleri AS $result ) { ?>
                                                        <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( $result[ 'id' ] == $default_kayit[ "para_birimi_id" ] ) echo 'selected'?>><?php echo $result[ 'kodu' ]." - ".$result[ 'adi' ]." ( ".$result[ 'sembol' ]." )"; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo dil_cevir( "Büyük Expo Fiyatı", $dizi_dil, $sistem_dil ); ?></label>
                                                <input type="number" step="0.01" class="form-control form-control-sm " id ="buyuk_expo_fiyat" name ="buyuk_expo_fiyat" value = "<?php echo $default_kayit[ "buyuk_expo_fiyat" ]; ?>"  autocomplete="off">
                                            </div>			
                                            <div class="form-group">
                                                <label class="control-label"><?php echo dil_cevir( "Küçük Expo Fiyatı", $dizi_dil, $sistem_dil ); ?></label>
                                                <input type="number" step="0.01" class="form-control form-control-sm " id ="kucuk_expo_fiyat" name ="kucuk_expo_fiyat" value = "<?php echo $default_kayit[ "kucuk_expo_fiyat" ]; ?>"  autocomplete="off">
                                            </div>			
                                            <div class="form-group">
                                                <label class="control-label"><?php echo dil_cevir( "Koli Fiyatı", $dizi_dil, $sistem_dil ); ?></label>
                                                <input type="number" step="0.01" class="form-control form-control-sm " id ="koli_fiyat" name ="koli_fiyat" value = "<?php echo $default_kayit[ "koli_fiyat" ]; ?>"  autocomplete="off">
                                            </div>			
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button modul= 'fuarlar' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span><?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
                                    </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade  <?php if( $_REQUEST['aktif_tab'] == "tab-aciklama" ) echo "show active"; ?>" id="tab-aciklama" role="tabpanel" aria-labelledby="tab-aciklama-tab">
                                    <form class="form-horizontal" action = "_modul/fuarlar/fuarlarAciklamaSEG.php" method = "POST" enctype="multipart/form-data">
                                    <?php 
                                    foreach( $hidden_kayitlar as $hidden_kayit ){ 
                                        foreach( array_keys($hidden_kayit) as $anahtar ){
                                    ?>
                                    <input type="hidden"  id="<?php echo $anahtar."_".$hidden_kayit['dil_id'];  ?>" value="<?php echo htmlentities($hidden_kayit[$anahtar]);  ?>">
                                    <?php }} ?>
                                    <input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
                                    <input type = "hidden" name = "id" value = "<?php echo $id; ?>">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
                                            <select class="form-control select2" name = "dil_id" required onchange="dil_degistir2(this);">
                                                <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                                <?php foreach( $diller AS $result ){ ?>
                                                <option value="<?php echo $result["id"] ?>" <?php if( $default_kayit['dil_id'] == $result["id"] ) echo "selected"; ?> ><?php echo $result["adi".$dil] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>                                    
                                    </div>                                    
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Açıklama", $dizi_dil, $sistem_dil ); ?></label>
                                        <style>
                                        .ck-editor__editable_inline:not(.ck-comment__input *) {
                                            height: 600px;
                                            overflow-y: auto;
                                        }
                                        </style>

                                        <textarea id="editor" style="display:none" name="aciklama"><?php echo @$default_kayit[ "aciklama" ]; ?></textarea>
                                    </div>
                                    <div class="card-footer">
                                        <button modul= 'fuarlar' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span><?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
                                    </div>

                                    </form>
                                    
                                </div>
                                <div class="tab-pane fade  <?php if( $_REQUEST['aktif_tab'] == "tab-neyemeli" ) echo "show active"; ?>" id="tab-neyemeli" role="tabpanel" aria-labelledby="tab-neyemeli-tab">
                                    <form class="form-horizontal" action = "_modul/fuarlar/fuarlarNeYemeliSEG.php" method = "POST" enctype="multipart/form-data">
                                    <?php 
                                    foreach( $hidden_kayitlar as $hidden_kayit ){ 
                                        foreach( array_keys($hidden_kayit) as $anahtar ){
                                    ?>
                                    <input type="hidden"  id="<?php echo $anahtar."_".$hidden_kayit['dil_id'];  ?>" value="<?php echo htmlentities($hidden_kayit[$anahtar]);  ?>">
                                    <?php }} ?>
                                    <input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
                                    <input type = "hidden" name = "id" value = "<?php echo $id; ?>">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
                                            <select class="form-control select2" name = "dil_id" required onchange="dil_degistir3(this);">
                                                <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                                <?php foreach( $diller AS $result ){ ?>
                                                <option value="<?php echo $result["id"] ?>" <?php if( $default_kayit['dil_id'] == $result["id"] ) echo "selected"; ?> ><?php echo $result["adi".$dil] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>                                    
                                    </div>                                    
                                    
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Ne Yemeli", $dizi_dil, $sistem_dil ); ?></label>
                                        <style>
                                        .ck-editor__editable_inline:not(.ck-comment__input *) {
                                            height: 600px;
                                            overflow-y: auto;
                                        }
                                        </style>

                                        <textarea id="editor2" style="display:none" name="ne_yemeli"><?php echo @$default_kayit[ "ne_yemeli" ]; ?></textarea>
                                    </div>
                                    <div class="card-footer">
                                        <button modul= 'fuarlar' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span><?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
                                    </div>

                                    </form>
                                </div>
                                <div class="tab-pane fade  <?php if( $_REQUEST['aktif_tab'] == "tab-neredekalmali" ) echo "show active"; ?>" id="tab-neredekalmali" role="tabpanel" aria-labelledby="tab-neredekalmali-tab">
                                    <form class="form-horizontal" action = "_modul/fuarlar/fuarlarNeredeKalmaliSEG.php" method = "POST" enctype="multipart/form-data">
                                    <?php 
                                    foreach( $hidden_kayitlar as $hidden_kayit ){ 
                                        foreach( array_keys($hidden_kayit) as $anahtar ){
                                    ?>
                                    <input type="hidden"  id="<?php echo $anahtar."_".$hidden_kayit['dil_id'];  ?>" value="<?php echo htmlentities($hidden_kayit[$anahtar]);  ?>">
                                    <?php }} ?>
                                    <input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
                                    <input type = "hidden" name = "id" value = "<?php echo $id; ?>">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
                                            <select class="form-control select2" name = "dil_id" required onchange="dil_degistir4(this);">
                                                <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                                <?php foreach( $diller AS $result ){ ?>
                                                <option value="<?php echo $result["id"] ?>" <?php if( $default_kayit['dil_id'] == $result["id"] ) echo "selected"; ?> ><?php echo $result["adi".$dil] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>                                    
                                    </div>                                    
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Nerede Kalmalı", $dizi_dil, $sistem_dil ); ?></label>
                                        <style>
                                        .ck-editor__editable_inline:not(.ck-comment__input *) {
                                            height: 600px;
                                            overflow-y: auto;
                                        }
                                        </style>

                                        <textarea id="editor3" style="display:none" name="nerede_kalmali"><?php echo @$default_kayit[ "nerede_kalmali" ]; ?></textarea>
                                    </div>
                                    <div class="card-footer">
                                        <button modul= 'fuarlar' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span><?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
                                    </div>

                                    </form>
                                </div>
                                <div class="tab-pane fade  <?php if( $_REQUEST['aktif_tab'] == "tab-notlar" ) echo "show active"; ?>" id="tab-notlar" role="tabpanel" aria-labelledby="tab-notlar-tab">
                                    <form class="form-horizontal" action = "_modul/fuarlar/fuarlarNotlarSEG.php" method = "POST" enctype="multipart/form-data">
                                    <?php 
                                    foreach( $hidden_kayitlar as $hidden_kayit ){ 
                                        foreach( array_keys($hidden_kayit) as $anahtar ){
                                    ?>
                                    <input type="hidden"  id="<?php echo $anahtar."_".$hidden_kayit['dil_id'];  ?>" value="<?php echo htmlentities($hidden_kayit[$anahtar]);  ?>">
                                    <?php }} ?>
                                    <input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
                                    <input type = "hidden" name = "id" value = "<?php echo $id; ?>">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
                                            <select class="form-control select2" name = "dil_id" required onchange="dil_degistir5(this);">
                                                <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                                <?php foreach( $diller AS $result ){ ?>
                                                <option value="<?php echo $result["id"] ?>" <?php if( $default_kayit['dil_id'] == $result["id"] ) echo "selected"; ?> ><?php echo $result["adi".$dil] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>                                    
                                    </div>                                    
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Diğer Notlar", $dizi_dil, $sistem_dil ); ?></label>
                                        <style>
                                        .ck-editor__editable_inline:not(.ck-comment__input *) {
                                            height: 600px;
                                            overflow-y: auto;
                                        }
                                        </style>

                                        <textarea id="editor4" style="display:none" name="diger_notlar"><?php echo @$default_kayit[ "diger_notlar" ]; ?></textarea>
                                    </div>
                                    <div class="card-footer">
                                        <button modul= 'fuarlar' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span><?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
                                    </div>

                                    </form>
                                </div>
                                <div class="tab-pane fade  <?php if( $_REQUEST['aktif_tab'] == "custom-tabs-two-galeri" ) echo "show active"; ?>" id="custom-tabs-two-galeri" role="tabpanel" aria-labelledby="custom-tabs-two-galeri-tab">

                                    <div class="row">
                                        <div class="col-md-12">
                                                <form class="form-horizontal" action = "_modul/fuarlar/fuarlarGaleriSEG.php" method = "POST" enctype="multipart/form-data">
                                                    <input type = "hidden" name = "islem" value = "galeri_ekle" >
                                                    <input type = "hidden" name = "birim_id" value = "<?php echo $birim_id; ?>">
                                                    <input type = "hidden" name = "fuar_id" value = "<?php echo $id; ?>">
                                                    <input type = "hidden" name = "birim_adi" value = "<?php echo $birim_adi; ?>">
                                                    <input type = "hidden" name = "fuar_adi" value = "<?php echo $fuar_adi; ?>">
                                                    <input type = "hidden" name = "aktif_tab" value = "custom-tabs-two-galeri">
                                                    <div id="hidden"></div>
                                                    <div class="form-group pt-4">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card card-default">
                                                                <div class="card-header">
                                                                    <h3 class="card-title"><b><?php echo dil_cevir( "Galeri", $dizi_dil, $sistem_dil ); ?></b> <small><em><?php echo dil_cevir( "Dosyaları sürükle veya Dosya Yükle", $dizi_dil, $sistem_dil ); ?></em> </small></h3>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div id="actions" class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="btn-group w-100">
                                                                        <span class="btn btn-success col fileinput-button">
                                                                            <i class="fas fa-plus"></i>
                                                                            <span>Add files</span>
                                                                        </span>
                                                                        <button type="button" class="btn btn-primary col start">
                                                                            <i class="fas fa-upload"></i>
                                                                            <span>Start upload</span>
                                                                        </button>
                                                                        <button type="reset" class="btn btn-warning col cancel">
                                                                            <i class="fas fa-times-circle"></i>
                                                                            <span>Cancel upload</span>
                                                                        </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 d-flex align-items-center">
                                                                        <div class="fileupload-process w-100">
                                                                        <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                                            <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                    <div class="table table-striped files" id="previews">
                                                                    <div id="template" class="row mt-2">
                                                                        <div class="col-auto">
                                                                            <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
                                                                        </div>
                                                                        <div class="col d-flex align-items-center">
                                                                            <p class="mb-0">
                                                                            <span class="lead" data-dz-name style="font-size:12px;"></span>
                                                                            (<span data-dz-size></span>)
                                                                            </p>
                                                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                                                        </div>
                                                                        <div class="col-2 d-flex align-items-center">
                                                                            <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                                            <div class="progress-bar progress-bar-success deneme" style="width:0%;" data-dz-uploadprogress></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-auto d-flex align-items-center">
                                                                        <div class="btn-group">
                                                                            <button class="btn btn-primary start">
                                                                            <i class="fas fa-upload"></i>
                                                                            <span>Start</span>
                                                                            </button>
                                                                            <button data-dz-remove class="btn btn-warning cancel">
                                                                            <i class="fas fa-times-circle"></i>
                                                                            <span>Cancel</span>
                                                                            </button>
                                                                            <button data-dz-remove class="btn btn-danger delete">
                                                                            <i class="fas fa-trash"></i>
                                                                            <span>Delete</span>
                                                                            </button>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /.card-body -->
                                                                <div class="card-footer">
                                                                </div>
                                                                </div>
                                                                <!-- /.card -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="fotograflar">
                                                    <?php 
                                                        foreach( $galeri as $foto_galeri ){ 
                                                    ?>
                                                        <div class=" col-3">
                                                            <div class="card ">
                                                                <div class="card-body">
                                                                    <a href="resimler/fuarlar/buyuk/<?php echo $foto_galeri['foto']; ?>" data-toggle="lightbox" data-title="" data-gallery="gallery">
                                                                        <img class="card-img-top" src="resimler/fuarlar/kucuk/<?php echo $foto_galeri['foto']; ?>" style="object-fit: cover; height: 250px;"   alt="white sample"/>
                                                                    </a>
                                                                </div>

                                                                <div class="card-footer">
                                                                    <button type="button" modul= 'fuarlar' yetki_islem="sil" class="btn btn-danger foto_sil" data-url="_modul/fuarlar/fuarlarGaleriSEG.php" data-islem="foto_sil" data-foto="<?php echo $foto_galeri['foto']; ?>" data-fuar_id="<?php echo $id; ?>" data-foto_id="<?php echo $foto_galeri['id']; ?>" >
                                                                    <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                    <?php if( $foto_galeri['one_cikan_gorsel'] ){ ?>
                                                                    <button type="button"  class="btn btn-success">
                                                                    Öne Çıkan Görsel
                                                                    </button>
                                                                    <?php }else{ ?>
                                                                    <button type="button" modul= 'fuarlar' yetki_islem="one_cikan_gorsel" class="btn btn-secondary one_cikan_gorsel_yap" data-url="_modul/fuarlar/fuarlarGaleriSEG.php" data-islem="one_cikan_gorsel" data-foto="<?php echo $foto_galeri['foto']; ?>" data-fuar_id="<?php echo $id; ?>" data-foto_id="<?php echo $foto_galeri['id']; ?>" >
                                                                    Öne Çıkan Görsel Yap
                                                                    </button>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php 
                                                        }
                                                    ?>   
                                                    </div>
                                                    <div class="card-footer">
                                                        <button modul= 'fuarlar' yetki_islem="kaydet" type="submit" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> <?php echo dil_cevir( "Galeriyi Kaydet", $dizi_dil, $sistem_dil ); ?></button>
                                                    </div>
                                                </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
			</div>
		</div>
	</div>
</section>
<script>
    $('.foto_sil').on("click", function(e) { 
        var url      = $(this).data("url");
        var foto  = $(this).data("foto");
        var foto_id  = $(this).data("foto_id");
        var islem  = $(this).data("islem");
        var fuar_id  = $(this).data("fuar_id");
        
			$.ajax( {
				 url	: url
				,type	: "post"
				,data	: { 
					 foto_id	: foto_id
					,foto		: foto
					,islem		: islem
					,fuar_id	: fuar_id
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

    $('.one_cikan_gorsel_yap').on("click", function(e) { 
        var url      = $(this).data("url");
        var foto  = $(this).data("foto");
        var foto_id  = $(this).data("foto_id");
        var islem  = $(this).data("islem");
        var fuar_id  = $(this).data("fuar_id");
        
			$.ajax( {
				 url	: url
				,type	: "post"
				,data	: { 
					 foto_id	: foto_id
					,foto		: foto
					,islem		: islem
					,fuar_id	: fuar_id
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
<script type="text/javascript">

        function dil_degistir(eleman){
            var dil_id = eleman.value;
			<?php if( $islem == "guncelle" ){ ?>
				    document.getElementById("adi").value = (document.getElementById("adi_"+dil_id)) ? document.getElementById("adi_"+eleman.value).value : "";
				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				//window.editor.data.set(document.getElementsByName("icerik"+dil)[0].value);
			<?php } ?>
		}

        function dil_degistir2(eleman){
            var dil_id = eleman.value;
			<?php if( $islem == "guncelle" ){ ?>
				window.editor.data.set((document.getElementById("aciklama_"+dil_id)) ? document.getElementById("aciklama_"+eleman.value).value : "");
			<?php } ?>
		}
        function dil_degistir3(eleman){
            var dil_id = eleman.value;
			<?php if( $islem == "guncelle" ){ ?>
				window.editor2.data.set((document.getElementById("ne_yemeli_"+dil_id)) ? document.getElementById("ne_yemeli_"+eleman.value).value : "");
			<?php } ?>
		}
        function dil_degistir4(eleman){
            var dil_id = eleman.value;
			<?php if( $islem == "guncelle" ){ ?>
				window.editor3.data.set((document.getElementById("nerede_kalmali_"+dil_id)) ? document.getElementById("nerede_kalmali_"+eleman.value).value : "");
			<?php } ?>
		}
        function dil_degistir5(eleman){
            var dil_id = eleman.value;
			<?php if( $islem == "guncelle" ){ ?>
				window.editor4.data.set((document.getElementById("diger_notlar_"+dil_id)) ? document.getElementById("diger_notlar_"+eleman.value).value : "");
			<?php } ?>
		}


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

var tbl_fuarlar = $( "#tbl_fuarlar" ).DataTable( {
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
} ).buttons().container().appendTo('#tbl_fuarlar_wrapper .col-md-6:eq(0)');



$('#card_fuarlar').on('maximized.lte.cardwidget', function() {
	var tbl_fuarlar = $( "#tbl_fuarlar" ).DataTable();
	var column = tbl_fuarlar.column(  tbl_fuarlar.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_fuarlar.column(  tbl_fuarlar.column.length - 2 );
	column.visible( ! column.visible() );
});

$('#card_fuarlar').on('minimized.lte.cardwidget', function() {
	var tbl_fuarlar = $( "#tbl_fuarlar" ).DataTable();
	var column = tbl_fuarlar.column(  tbl_fuarlar.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_fuarlar.column(  tbl_fuarlar.column.length - 2 );
	column.visible( ! column.visible() );
} );



</script>
        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
				ckfinder: {
					uploadUrl: 'plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
				},
                toolbar: {
                    items: [
                        'exportPDF','exportWord', '|',
						'ckfinder', 'imageUpload',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'Welcome to CKEditor&nbsp;5!',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
						'Roboto, sans-serif',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [ 10, 12, 14, 16, 18, 20, 22 ],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
						addTargetToExternalLinks: {
                            mode: 'manual',
                            label: 'Open New Tab',
							attributes: {
								target: '_blank'
							}
						},						
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                // The "super-build" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    'CKBox',
                    //'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                    'MathType',
                    // The following features are part of the Productivity Pack and require additional license.
                    'SlashCommand',
                    'Template',
                    'DocumentOutline',
                    'FormatPainter',
                    'TableOfContents',
                    'PasteFromOfficeEnhanced'
                ]
                ,extraAllowedContent: 'i(*)'
            })
			.then( editor => {
				window.editor = editor;
                editor.execute( 'imageStyle', { value: 'alignCenter' } );
			});
        </script>
        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("editor2"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
				ckfinder: {
					uploadUrl: 'plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
				},
                toolbar: {
                    items: [
                        'exportPDF','exportWord', '|',
						'ckfinder', 'imageUpload',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'Welcome to CKEditor&nbsp;5!',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
						'Roboto, sans-serif',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [ 10, 12, 14, 16, 18, 20, 22 ],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
						addTargetToExternalLinks: {
                            mode: 'manual',
                            label: 'Open New Tab',
							attributes: {
								target: '_blank'
							}
						},						
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                // The "super-build" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    'CKBox',
                    //'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                    'MathType',
                    // The following features are part of the Productivity Pack and require additional license.
                    'SlashCommand',
                    'Template',
                    'DocumentOutline',
                    'FormatPainter',
                    'TableOfContents',
                    'PasteFromOfficeEnhanced'
                ]
                ,extraAllowedContent: 'i(*)'
            })
			.then( editor2 => {
				window.editor2 = editor2;
                editor2.execute( 'imageStyle', { value: 'alignCenter' } );
			});
        </script>
        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("editor3"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
				ckfinder: {
					uploadUrl: 'plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
				},
                toolbar: {
                    items: [
                        'exportPDF','exportWord', '|',
						'ckfinder', 'imageUpload',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'Welcome to CKEditor&nbsp;5!',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
						'Roboto, sans-serif',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [ 10, 12, 14, 16, 18, 20, 22 ],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
						addTargetToExternalLinks: {
                            mode: 'manual',
                            label: 'Open New Tab',
							attributes: {
								target: '_blank'
							}
						},						
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                // The "super-build" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    'CKBox',
                    //'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                    'MathType',
                    // The following features are part of the Productivity Pack and require additional license.
                    'SlashCommand',
                    'Template',
                    'DocumentOutline',
                    'FormatPainter',
                    'TableOfContents',
                    'PasteFromOfficeEnhanced'
                ]
                ,extraAllowedContent: 'i(*)'
            })
			.then( editor3 => {
				window.editor3 = editor3;
                editor3.execute( 'imageStyle', { value: 'alignCenter' } );
			});
        </script>        
        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("editor4"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
				ckfinder: {
					uploadUrl: 'plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
				},
                toolbar: {
                    items: [
                        'exportPDF','exportWord', '|',
						'ckfinder', 'imageUpload',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'Welcome to CKEditor&nbsp;5!',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
						'Roboto, sans-serif',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [ 10, 12, 14, 16, 18, 20, 22 ],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
						addTargetToExternalLinks: {
                            mode: 'manual',
                            label: 'Open New Tab',
							attributes: {
								target: '_blank'
							}
						},						
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                // The "super-build" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    'CKBox',
                    //'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                    'MathType',
                    // The following features are part of the Productivity Pack and require additional license.
                    'SlashCommand',
                    'Template',
                    'DocumentOutline',
                    'FormatPainter',
                    'TableOfContents',
                    'PasteFromOfficeEnhanced'
                ]
                ,extraAllowedContent: 'i(*)'
            })
			.then( editor4 => {
				window.editor4 = editor4;
                editor4.execute( 'imageStyle', { value: 'alignCenter' } );
			});
        </script>
