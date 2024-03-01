<?php
$fn	= new Fonksiyonlar();
$vt = new VeriTabani();


/* SEG dosyalarından gelen mesaj */
if( array_key_exists( 'sonuclar', $_SESSION ) ) {
	$mesaj								= $_SESSION[ 'sonuclar' ][ 'mesaj' ];
	$mesaj_turu							= $_SESSION[ 'sonuclar' ][ 'hata' ] ? 'kirmizi' 	: 'yesil';
	unset( $_SESSION[ 'sonuclar' ] );
	echo "<script>mesajVer('$mesaj', '$mesaj_turu')</script>";
}


$islem					= array_key_exists( 'islem'		         ,$_REQUEST ) ? $_REQUEST[ 'islem' ]				: 'ekle';
$personel_id			= array_key_exists( 'personel_id' ,$_REQUEST ) ? $_REQUEST[ 'personel_id' ]	: 0;
$birim_id				= array_key_exists( 'birim_id' ,$_REQUEST ) ? $_REQUEST[ 'birim_id' ]	: 0;
$sayfa_id				= array_key_exists( 'sayfa_id' ,$_REQUEST ) ? $_REQUEST[ 'sayfa_id' ]	: 0;
$birim_adi				= array_key_exists( 'birim_adi' ,$_REQUEST ) ? $_REQUEST[ 'birim_adi' ]	: "";
$sayfa_adi				= array_key_exists( 'sayfa_adi' ,$_REQUEST ) ? $_REQUEST[ 'sayfa_adi' ]	: "";
$birim_id = 1;
$_REQUEST['birim_id'] = 1;
if( $_SESSION[ 'kullanici_turu' ] == "personel"  ){
	if( $personel_id != $_SESSION[ 'kullanici_id' ] )
		$personel_id		= "";
}

$satir_renk					= $personel_id > 0	? 'table-warning'						: '';
$kaydet_buton_yazi			= $personel_id > 0	? 'Güncelle'							: 'Kaydet';
$kaydet_buton_cls			= $personel_id > 0	? 'btn btn-warning btn-sm pull-right'	: 'btn btn-success btn-sm pull-right';
$kaydet_buton_yetki_islem	= $personel_id > 0	? 'guncelle'									: 'kaydet';



include "_modul/birim_agaci_getir.php";

$SQL_birim_sayfalari_getir = <<< SQL
SELECT
	bs.*
	,bsd.dil_id
	,bsd.adi
	,bsd.sayfa_id
	,bsd.aktif
FROM 
	tb_birim_sayfalari AS bs
LEFT JOIN tb_birim_sayfalari_dil AS bsd ON bs.id = bsd.sayfa_id AND bsd.dil_id = 1
WHERE 
	bs.birim_id = ? AND bsd.dil_id = 1
ORDER BY bs.sira
SQL;

$SQL_sayfa_bilgileri = <<< SQL
SELECT
	bs.*
	,bsd.dil_id
	,bsd.adi
	,bsd.sayfa_id
	,bsd.aktif
FROM 
	tb_birim_sayfalari AS bs
LEFT JOIN tb_birim_sayfalari_dil AS bsd ON bs.id = bsd.sayfa_id
WHERE 
	bs.id = ?
SQL;

$SQL_sayfa_icerik_bilgileri = <<< SQL
SELECT 
	*
FROM 
	tb_birim_sayfa_icerikleri
WHERE 
	sayfa_id = ?
SQL;

$SQL_sayfa_icerik_tabs = <<< SQL
SELECT 
	*
FROM 
	tb_birim_sayfa_icerikleri_tabs
WHERE 
	sayfa_id = ? AND dil_id = ?
ORDER BY sira
SQL;

$SQL_sayfa_icerik_tabs_tek = <<< SQL
SELECT 
	*
FROM 
	tb_birim_sayfa_icerikleri_tabs
WHERE 
	id = ?
SQL;

$SQL_sayfa_icerik_sss = <<< SQL
SELECT 
	*
FROM 
	tb_birim_sayfa_icerikleri_sss
WHERE 
	sayfa_id = ? AND dil_id = ?
ORDER BY sira
SQL;

$SQL_sayfa_icerik_sss_tek = <<< SQL
SELECT 
	*
FROM 
	tb_birim_sayfa_icerikleri_sss
WHERE 
	id 				= ?
SQL;

$SQL_sayfa_icerik_personel = <<< SQL
SELECT 
	*
FROM 
	tb_birim_sayfa_icerikleri_personeller
WHERE 
	sayfa_id 				= ?
SQL;

$SQL_sayfa_icerik_personel_tek = <<< SQL
SELECT 
	*
FROM 
	tb_birim_sayfa_icerikleri_personeller
WHERE 
	id 				= ?
SQL;

$SQL_birim_bilgileri = <<< SQL
SELECT 
	*
FROM 
	tb_birim_agaci
WHERE 
	id = ?
SQL;

$SQL_gorevler = <<< SQL
SELECT 
	*
FROM 
	tb_gorev_kategorileri
SQL;

$SQL_sayfalar_ust_id_getir = <<< SQL
WITH RECURSIVE ust_kategoriler AS (
    SELECT bs.id, bs.ust_id, bsd.adi
    FROM tb_birim_sayfalari as bs
		LEFT JOIN tb_birim_sayfalari_dil as bsd ON bsd.sayfa_id = bs.id AND bsd.dil_id = 1
    WHERE bs.id = 45 -- burası istediğiniz başlangıç ID'si
    UNION ALL
    SELECT k.id, k.ust_id, bsd2.adi
    FROM tb_birim_sayfalari k
		LEFT JOIN tb_birim_sayfalari_dil as bsd2 ON bsd2.sayfa_id = k.id AND bsd2.dil_id = 1
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
$alt_idler					= $vt->select( $SQL_alt_id_getir, array( $tek_personel['birim_id'] ) )[ 2 ];

$sayfa_ust_idler			= $vt->select( $SQL_sayfalar_ust_id_getir, array( $sayfa_id ) )[ 2 ];
foreach($sayfa_ust_idler as $ust_id) 
	$sayfa_ust_id_dizi[] = $ust_id['ust_id'];

foreach($alt_idler as $alt_id) 
	$alt_id_dizi[] = $alt_id['ust_id'];

$SQL_galeri = <<< SQL
SELECT 
	*
FROM 
	tb_sayfa_galeri
WHERE 
	sayfa_id = ? 
SQL;

$SQL_diller = <<< SQL
SELECT
	*
FROM 
	tb_diller
WHERE aktif = 1
ORDER BY sira
SQL;

@$diller 		        = $vt->select( $SQL_diller, array(  ) )[ 2 ];
@$galeri     		= $vt->select( $SQL_galeri, array( $sayfa_id ) )[ 2 ];
@$gorevler       		= $vt->select($SQL_gorevler, array(  ) )[ 2 ];
@$birim_sayfalari 		= $vt->select($SQL_birim_sayfalari_getir, array( $birim_id ) )[ 2 ];
@$birim_bilgileri 		= $vt->selectSingle($SQL_birim_bilgileri, array( $birim_id ) )[ 2 ];
@$sayfa_bilgileri 		= $vt->select($SQL_sayfa_bilgileri, array( $sayfa_id ) )[ 2 ];
@$sayfa_tablari 		= $vt->select($SQL_sayfa_icerik_tabs, array( $sayfa_id ) )[ 2 ];
@$sayfa_sssler	 		= $vt->select($SQL_sayfa_icerik_sss, array( $sayfa_id ) )[ 2 ];
@$sayfa_personeller		= $vt->select($SQL_sayfa_icerik_personel, array( $sayfa_id ) )[ 2 ];
@$tek_tab 				= $vt->selectSingle($SQL_sayfa_icerik_tabs_tek, array( $_REQUEST['tab_id'] ) )[ 2 ];
@$tek_sss 				= $vt->selectSingle($SQL_sayfa_icerik_sss_tek, array( $_REQUEST['sss_id'] ) )[ 2 ];
@$tek_personel			= $vt->selectSingle($SQL_sayfa_icerik_personel_tek, array( $_REQUEST['personel_id'] ) )[ 2 ];


foreach( $sayfa_bilgileri as $result ){
    if( $result['dil_id'] == 1 ){
        $sayfa_bilgileri = $result;
    }
    $hidden_kayitlar[] = $result;
}
//var_dump($sayfa_tablari);

@$sayfa_icerik_bilgileri = $vt->select( $SQL_sayfa_icerik_bilgileri, array( $sayfa_id ) )[ 2 ];	

foreach( $sayfa_icerik_bilgileri as $result ){
    if( $result['dil_id'] == 1 ){
        $sayfa_icerik_bilgileri = $result;
    }
    $hidden_kayitlar_icerik[] = $result;
}

if( $sayfa_id > 0 ){
	$islem = "icerik_guncelle";
}
		



?>

<div class="modal fade" id="sil_onay">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?php echo dil_cevir( "Dikkat!", $dizi_dil, $sistem_dil ); ?></h4>
			</div>
			<div class="modal-body">
				<p><?php echo dil_cevir( "Bu kaydı silmek istediğinize emin misiniz?", $dizi_dil, $sistem_dil ); ?></p>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dil_cevir( "İptal", $dizi_dil, $sistem_dil ); ?></button>
				<a class="btn btn-danger btn-evet"><?php echo dil_cevir( "Evet", $dizi_dil, $sistem_dil ); ?></a>
			</div>
		</div>
	</div>
</div>


<script>
	/* Kayıt silme onay modal açar. */
	$( '#sil_onay' ).on( 'show.bs.modal', function( e ) {
		$( this ).find( '.btn-evet' ).attr( 'href', $( e.relatedTarget ).data( 'href' ) );
	} );
</script>



	<!--birim_sayfa EKLEME MODALI-->
	<div class="modal fade" id="kategori_ekle" modul= 'birimSayfalari' yetki_islem='duzenle' >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-success text-white">
					<h3 class="card-title"><?php echo dil_cevir( "Yeni Sayfa Ekle", $dizi_dil, $sistem_dil ); ?></h3>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form class="form-horizontal" action = "_modul/birimSayfalari/birimSayfalariSEG.php" method = "POST">
					<div class="modal-body">
						<input type="hidden" id="yeni_kategori_ust_id"  name="ust_id">
						<input type="hidden" id="kategori_birim_id"  name="birim_id">
						<input type="hidden" name="dil_id" value="1">
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Üst Sayfa", $dizi_dil, $sistem_dil ); ?></label>
							<input required type="text" class="form-control" id="kategori_ad"  autocomplete="off" disabled>
						</div>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?> (TR)</label>
							<input required type="text" class="form-control" name ="adi"  autocomplete="off" >
						</div>
						<div class="form-group">
							<label  class="control-label"><?php echo dil_cevir( "Kategori Mi?", $dizi_dil, $sistem_dil ); ?> </label>
							<div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-focused bootstrap-switch-animate bootstrap-switch-off" >
								<div class="bootstrap-switch-container" >
									<input type="checkbox" name="kategori" data-bootstrap-switch="" data-off-color="danger" data-on-text="Kategori" data-off-text="Değil" data-on-color="success">
								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-success" data-dismiss="modal"><?php echo dil_cevir( "İptal", $dizi_dil, $sistem_dil ); ?></button>
						<button  modul= 'birimSayfalari' yetki_islem='kaydet' type="submit" class="btn btn-danger"><?php echo dil_cevir( "Kaydet", $dizi_dil, $sistem_dil ); ?></button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<!--birim_sayfa -->
	<!-- <div class="modal fade" id="kategori_duzenle" modul= 'birimSayfalari' yetki_islem='duzenle' >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-warning">
					<h4 class="card-title"><?php echo dil_cevir( "Sayfa Düzenle", $dizi_dil, $sistem_dil ); ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form class="form-horizontal" action = "_modul/birimSayfalari/birimSayfalariSEG.php" method = "POST">
					<div class="modal-body">
						<input type="hidden" id="islem" name="islem">
						<input type="hidden" id="birim_sayfa_id" name="id">
						<input type="hidden" id="birim_id_duzenle" name="birim_id">
						<?php 
						foreach( $hidden_kayitlar as $hidden_kayit ){ 
							foreach( array_keys($hidden_kayit) as $anahtar ){
						?>
						<input type="hidden"  id="<?php echo $anahtar."_".$hidden_kayit['dil_id'];  ?>" value="<?php echo htmlentities($hidden_kayit[$anahtar]);  ?>">
						<?php }} ?>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
							<select class="form-control select2" name = "dil_id" required onchange="dil_degistir_sayfa_duzenle(this);">
								<option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
								<?php foreach( $diller AS $result ){ ?>
								<option value="<?php echo $result["id"] ?>" <?php if( $sayfa_bilgileri['dil_id'] == $result["id"] ) echo "selected"; ?> ><?php echo $result["adi".$dil] ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></label>
							<input required type="text" class="form-control" name ="adi"  autocomplete="off" id="kategori_ad_duzenle">
						</div>
						<div class="form-group">
							<label  class="control-label"><?php echo dil_cevir( "Kategori Mi?", $dizi_dil, $sistem_dil ); ?> </label>
							<div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-focused bootstrap-switch-animate bootstrap-switch-off" >
								<div class="bootstrap-switch-container" >
									<input type="checkbox" name="kategori" id="kategori_mi" data-bootstrap-switch="" data-off-color="danger" data-on-text="Kategori" data-off-text="Değil" data-on-color="success">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo dil_cevir( "İptal", $dizi_dil, $sistem_dil ); ?></button>
						<button  modul= 'birimSayfalari' yetki_islem='duzenle' type="submit" class="btn btn-success"><?php echo dil_cevir( "Güncelle", $dizi_dil, $sistem_dil ); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div> -->



<section class="content">
	<div class="container-fluid">
		<div class="row">
			<?php if( !isset($_REQUEST['birim_id']) ){ ?>
			<div class="col-md-3 p-0">
				<div class="card card-secondary">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Birimler", $dizi_dil, $sistem_dil ); ?></h3>
					</div>
					<div class="card-body p-0">
						<?php if( ( $_SESSION['super']*1 < 1 ) and ( strlen($_SESSION['birim_idler']) == 0 ) ){ ?>
							<h3 class="card-title"><?php echo dil_cevir( "Yetkili olduğunuz bir birim bulunamadı.", $dizi_dil, $sistem_dil ); ?></h3>
						<?php } ?>
						<div class="overflow-auto" style="height:600px;">
							<table class="table table-sm table-hover text-sm">
							<tbody>
								<?php
								//var_dump($birim_sayfalari);

									if( count( $birim_agaclari ) ) 
										echo kategoriListele3($url_modul, $birim_agaclari,0,0, $vt, $ogrenci_id, $sistem_dil, $birim_idler);
									

								?>
							</tbody>
							</table>
						</div>

					</div>

				</div>
			</div>
			<?php }else{ ?>
			<div class="col-md-3 p-0">
				<div class="card card-secondary">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Birim Sayfaları", $dizi_dil, $sistem_dil ); ?></h3>		
                        <div class = "card-tools">
                            <a href="?modul=<?php echo $modul_kisa_ad;?>" type="button" class="btn btn-tool"><i class="fas fa-arrow-left"></i> <?php echo dil_cevir( "Birimler", $dizi_dil, $sistem_dil ); ?></a>
                        </div>
					</div>
					<div class="card-body p-1">
						<div class="overflow-auto" style="height:600px;">
							<table class="table table-sm table-hover text-sm">
							<tbody>
								<tr >
									<td class="bg-dark p-1">
										<?php echo dil_cevir( "Sayfalar", $dizi_dil, $sistem_dil ); ?>
										<a  modul= 'birimSayfalari' yetki_islem='kategori-ekle' href='#' class='btn btn-success float-right btn-xs KategoriEkle' data-id = "0" data-kategori_ad ='Ana Kategori' data-birim_id ='<?php echo $birim_id; ?>' data-modal='kategori_ekle'><?php echo dil_cevir( "Sayfa Ekle", $dizi_dil, $sistem_dil ); ?></a>
									</td>
								</tr>	
								<?php
								//var_dump($birim_sayfalari);
									function kategoriListele4( $kategoriler, $parent = 0, $renk = 0,$vt, $birim_id, $birim_adi, $sistem_dil, $sayfa_id, $dizi_dil, $sayfa_ust_id_dizi){
										$sayfa_ekle_button = dil_cevir( 'Sayfa Ekle', $dizi_dil, $sistem_dil );
										$duzenle_button = dil_cevir( 'Düzenle', $dizi_dil, $sistem_dil );
										$sil_button = dil_cevir( 'Sil', $dizi_dil, $sistem_dil );
										$icerik_duzenle_button = dil_cevir( 'İçerik Düzenle', $dizi_dil, $sistem_dil );
										$alt_menu_sayisi = 0;
										foreach ($kategoriler as $key => $val) {
											if ($val['ust_id']*1 === $parent*1) {
												$alt_menu_sayisi++;
											}
										}


										$sistem_dil2 = $sistem_dil == "_tr" ? "" : $sistem_dil ;
										$adi = "adi".$sistem_dil2;

										if( $_SESSION[ 'kullanici_turu' ] == "ogrenci" ){
											$degerlendirme_ekle_class = "";
										}else{
											$degerlendirme_ekle_class = "degerlendirmeEkle";
										}
										$html = "<tr class='expandable-body'>
														<td>
															<div class='p-0'>
																<table class='table table-hover'>
																	<tbody>";

										foreach ($kategoriler as $kategori){
											if( $birim_id == 1 and $kategori['ust_id'] != 0 ){
												$icerik_duzenle_menu = "<a modul= 'birimSayfalari' yetki_islem='icerik_duzenle' class='dropdown-item bg-primary text-white' href='index.php?modul=birimSayfalari&birim_id=$birim_id&birim_adi=$birim_adi&sayfa_id=$kategori[id]&sayfa_adi=$kategori[$adi]'><i class='fas fa-edit text-white'></i> $icerik_duzenle_button</a>";
											}else{
												$icerik_duzenle_menu = "<a modul= 'birimSayfalari' yetki_islem='icerik_duzenle' class='dropdown-item bg-primary text-white' href='index.php?modul=birimSayfalari&birim_id=$birim_id&birim_adi=$birim_adi&sayfa_id=$kategori[id]&sayfa_adi=$kategori[$adi]'><i class='fas fa-edit text-white'></i> $icerik_duzenle_button</a>";
												//$icerik_duzenle_menu = "";
											}
											
											if( $kategori[$adi] == "" )
												$turkce_ad_ekle = "<i>(".$kategori['adi'].")</i>";
											else
												$turkce_ad_ekle = "";

											if( $kategori['ust_id'] == $parent ){
												if( $kategori['sira'] == 1 )
													$yukari_buton = "";
												else
													$yukari_buton = "<a href='_modul/birimSayfalari/birimSayfalariSEG.php?islem=sira_eksi&id=$kategori[id]&ust_id=$kategori[ust_id]&birim_id=$birim_id&sira=$kategori[sira]' class='btn btn-secondary btn-xs'><i class='fas fa-arrow-up'></i></a>";
												
												if( $kategori['sira'] == $alt_menu_sayisi )
													$asagi_buton = "";
												else
													$asagi_buton = "<a href='_modul/birimSayfalari/birimSayfalariSEG.php?islem=sira_arti&id=$kategori[id]&ust_id=$kategori[ust_id]&birim_id=$birim_id&sira=$kategori[sira]' class='btn btn-secondary btn-xs'><i class='fas fa-arrow-down'></i></a>";

												if( $parent == 0 ) {
													$renk = 1;
												} 
												if( $kategori['id'] == $sayfa_id )
													$secili_class = "bg-warning";
												else
													$secili_class = "";

												if( $kategori['kategori'] == 0){
													$html .= "
															<tr>
																<td class=' bg-renk7 $secili_class p-1' >
																	$yukari_buton
																	$asagi_buton
																	<b>$kategori[sira])</b> $kategori[$adi]$turkce_ad_ekle
																	<div class='btn-group float-right'>
																		<button type='button' class='btn btn-dark btn-xs dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' >
																			İşlem
																		</button>
																		<div class='dropdown-menu p-0'>
																			<a modul= 'birimSayfalari' yetki_islem='duzenle' href='#' id='$kategori[id]' data-id='$kategori[id]' class='dropdown-item modalAc bg-warning' data-birim_id = '$birim_id' data-kategori_ad_duzenle='$kategori[adi]' data-kategori_ad_duzenle_kz='$kategori[adi_kz]' data-kategori_ad_duzenle_en='$kategori[adi_en]' data-kategori_ad_duzenle_ru='$kategori[adi_ru]' data-modal='kategori_duzenle' data-islem='guncelle' data-kategori='$kategori[kategori]'><i class='fas fa-pencil-alt text-white'></i> <span class='text-white'>$duzenle_button</span></a>
																			<button modul= 'birimSayfalari' yetki_islem='sil' class='dropdown-item bg-danger' data-href='_modul/birimSayfalari/birimSayfalariSEG.php?islem=sil&id=$kategori[id]&sira=$kategori[sira]&ust_id=$kategori[ust_id]&birim_id=$birim_id' data-toggle='modal' data-target='#sil_onay'><i class='fas fa-trash-alt'></i> $sil_button</button>
																			<a modul= 'birimSayfalari' yetki_islem='icerik_duzenle' class='dropdown-item bg-primary' href='index.php?modul=birimSayfalari&birim_id=$birim_id&birim_adi=$birim_adi&sayfa_id=$kategori[id]&sayfa_adi=$kategori[$adi]'><i class='fas fa-edit text-white'></i> $icerik_duzenle_button</a>
																		</div>
																	</div>											
																	
																</td>
															</tr>";									

												}
												if( $kategori['kategori'] == 1 ){
                                                    if (in_array($kategori['id'], $sayfa_ust_id_dizi))
                                                        $agac_acik = "true";
                                                    else
                                                        $agac_acik = "false";
                                            
														$html .= "
																<tr data-widget='expandable-table' aria-expanded='$agac_acik' class='border-0'>
																	<td class='bg-renk$renk $secili_class p-1'>
																	$yukari_buton
																	$asagi_buton
																	<b>$kategori[sira])</b> $kategori[$adi]$turkce_ad_ekle
																		<div class='btn-group float-right'>
																			<button type='button' class='btn btn-dark btn-xs dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' >
																				İşlem
																			</button>
																			<div class='dropdown-menu p-0'>
																				<a modul= 'birimSayfalari' yetki_islem='kategori-ekle' href='#' class='dropdown-item KategoriEkle bg-success' data-birim_id = '$birim_id' id='$kategori[id]' data-id='$kategori[id]' data-kategori_ad ='$kategori[$adi]' data-ders_id='$kategori[ders_id]' data-modal='kategori_ekle' onclick='event.stopPropagation();' ><i class='fas fa-plus'></i> $sayfa_ekle_button</a>
																				<a modul= 'birimSayfalari' yetki_islem='duzenle' href='#' id='$kategori[id]' data-birim_id = '$birim_id' data-id='$kategori[id]' data-ders_id='$kategori[ders_id]' class='dropdown-item modalAc bg-warning text-white' data-kategori_ad_duzenle='$kategori[adi]' data-kategori_ad_duzenle_kz='$kategori[adi_kz]' data-kategori_ad_duzenle_en='$kategori[adi_en]' data-kategori_ad_duzenle_ru='$kategori[adi_ru]' data-modal='kategori_duzenle' data-islem='guncelle' data-kategori ='$kategori[kategori]' onclick='event.stopPropagation();' ><i class='fas fa-pencil-alt text-white'></i> <span class='text-white'>$duzenle_button</span></a>
																				<button modul= 'birimSayfalari' yetki_islem='sil' class='dropdown-item bg-danger' data-href='_modul/birimSayfalari/birimSayfalariSEG.php?islem=sil&id=$kategori[id]&sira=$kategori[sira]&ust_id=$kategori[ust_id]&birim_id=$birim_id' data-toggle='modal' data-target='#sil_onay' onclick='$(#sil_onay).modal();event.stopPropagation();' ><i class='fas fa-trash-alt'></i> $sil_button</button>
																				$icerik_duzenle_menu
																			</div>
																		</div>											
																	<i class='expandable-table-caret fas fa-caret-right fa-fw'></i>
																	</td>
																</tr>
															";								
														$renk++;
														$html .= kategoriListele4($kategoriler, $kategori['id'],$renk, $vt, $birim_id, $birim_adi, $sistem_dil, $sayfa_id, $dizi_dil, $sayfa_ust_id_dizi);
														
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
									if( count( $birim_sayfalari ) ) 
										echo kategoriListele4($birim_sayfalari,0,0, $vt, $birim_id,$birim_adi, $sistem_dil, $sayfa_id, $dizi_dil, $sayfa_ust_id_dizi);
									

								?>
							</tbody>
							</table>

						</div>

					</div>

				</div>
			</div>
			<?php } ?>
			<div class="col-md-9">
            <div class="card card-olive card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                  <li class="pt-2 px-3"><h3 class="card-title"><?php echo $birim_adi." / ".$sayfa_adi ?></h3></li>
                  <li class="nav-item">
                    <a class="nav-link <?php if( !isset($_REQUEST['aktif_tab']) or $_REQUEST['aktif_tab'] == "custom-tabs-two-sayfa" ) echo "active"; ?>" id="custom-tabs-two-sayfa-tab" data-toggle="pill" href="#custom-tabs-two-sayfa" role="tab" aria-controls="custom-tabs-two-sayfa" aria-selected="true"><?php echo dil_cevir( "Sayfa Bilgileri", $dizi_dil, $sistem_dil ); ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if( $_REQUEST['aktif_tab'] == "custom-tabs-two-home" ) echo "active"; ?>" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true"><?php echo dil_cevir( "İçerik", $dizi_dil, $sistem_dil ); ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if( $_REQUEST['aktif_tab'] == "custom-tabs-two-profile" ) echo "active"; ?>" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false"><?php echo dil_cevir( "Tabs", $dizi_dil, $sistem_dil ); ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if( $_REQUEST['aktif_tab'] == "custom-tabs-two-messages" ) echo "active"; ?>" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false"><?php echo dil_cevir( "Acordion", $dizi_dil, $sistem_dil ); ?></a>
                  </li>
                  <!-- <li class="nav-item">
                    <a class="nav-link <?php if( $_REQUEST['aktif_tab'] == "custom-tabs-two-settings" ) echo "active"; ?>" id="custom-tabs-two-settings-tab" data-toggle="pill" href="#custom-tabs-two-settings" role="tab" aria-controls="custom-tabs-two-settings" aria-selected="false"><?php echo dil_cevir( "Personeller", $dizi_dil, $sistem_dil ); ?></a>
                  </li> -->
                  <li class="nav-item">
                    <a class="nav-link <?php if( $_REQUEST['aktif_tab'] == "custom-tabs-two-galeri" ) echo "active"; ?>" id="custom-tabs-two-galeri-tab" data-toggle="pill" href="#custom-tabs-two-galeri" role="tab" aria-controls="custom-tabs-two-galeri" aria-selected="false"><?php echo dil_cevir( "Galeri", $dizi_dil, $sistem_dil ); ?></a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                  <div class="tab-pane fade <?php if( !isset($_REQUEST['aktif_tab'])  or $_REQUEST['aktif_tab'] == "custom-tabs-two-sayfa" ) echo "show active"; ?>" id="custom-tabs-two-sayfa" role="tabpanel" aria-labelledby="custom-tabs-two-sayfa-tab">
					<form class="form-horizontal" action = "_modul/birimSayfalari/birimSayfalariSEG.php" method = "POST" enctype="multipart/form-data">
					<?php if( $sayfa_id > 0 ){ ?>

					<div class="card-body">
						<input type="hidden" id="islem" name="islem" value="guncelle">
						<input type="hidden" id="birim_sayfa_id" name="id" value="<?php echo $sayfa_bilgileri[ "id" ]; ?>">
						<input type="hidden" id="birim_id_duzenle" name="birim_id" value="<?php echo $sayfa_bilgileri[ "birim_id" ]; ?>">
						<input type = "hidden" name = "aktif_tab" value = "custom-tabs-two-sayfa">
						<?php 
						foreach( $hidden_kayitlar as $hidden_kayit ){ 
							foreach( array_keys($hidden_kayit) as $anahtar ){
						?>
						<input type="hidden"  id="<?php echo $anahtar."_".$hidden_kayit['dil_id'];  ?>" value="<?php echo htmlentities($hidden_kayit[$anahtar]);  ?>">
						<?php }} ?>
						<div class="form-group">
							<label  class="control-label"><?php echo dil_cevir( "Kategori Mi?", $dizi_dil, $sistem_dil ); ?> </label>
							<div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-focused bootstrap-switch-animate bootstrap-switch-off" >
								<div class="bootstrap-switch-container" >
									<input type="checkbox" name="kategori" id="kategori_mi" <?php if( $sayfa_bilgileri[ "kategori" ] == 1 ) echo "checked"; ?> data-bootstrap-switch="" data-off-color="danger" data-on-text="Kategori" data-off-text="Değil" data-on-color="success">
								</div>
							</div>
						</div>
						<div class="form-group clearfix">
							<div class="icheck-primary d-inline">
								<input type="checkbox" id="checkboxPrimary2" name="harici" <?php if( $sayfa_bilgileri[ "harici" ] == 1 ) echo "checked"; ?> >
								<label for="checkboxPrimary2">
									<?php echo dil_cevir( "Harici Sayfa", $dizi_dil, $sistem_dil ); ?>
								</label>
								<small class="form-text text-muted"><?php echo dil_cevir( "Menüde görünmeyecek sayfalar için işaretlenmelidir.", $dizi_dil, $sistem_dil ); ?></small>
							</div>
						</div>
						<div class="form-group clearfix">
							<div class="icheck-secondary d-inline">
								<input type="checkbox" id="link_check" name="link" onclick="link_aktif(this);" <?php if( $sayfa_bilgileri[ "link" ] == 1 ) echo "checked"; ?> >
								<label for="link_check">
									<?php echo dil_cevir( "Link", $dizi_dil, $sistem_dil ); ?>
								</label>
							</div>
						</div>
						<div class="form-group">
							<input required type="text" id="link_yonlendirme" placeholder="Link" class="form-control form-control-sm" name ="link_url" value = "<?php echo $sayfa_bilgileri[ "link_url" ]; ?>"  autocomplete="off" <?php if( $sayfa_bilgileri[ "link" ] == 1 ) echo "";else echo " disabled "; if( $islem == "icerik_ekle" and $sayfa_bilgileri[ "link" ] != 1 ) echo " disabled ";  ?>>
							<small class="form-text text-muted"><?php echo dil_cevir( "Bu alana Link eklenirse menü bu linke yönlendirilecektir.", $dizi_dil, $sistem_dil ); ?></small>
						</div>

						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
							<select class="form-control select2" name = "dil_id" required onchange="dil_degistir_sayfa_duzenle(this);">
								<option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
								<?php foreach( $diller AS $result ){ ?>
								<option value="<?php echo $result["id"] ?>" <?php if( $sayfa_bilgileri['dil_id'] == $result["id"] ) echo "selected"; ?> ><?php echo $result["adi".$dil] ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group clearfix">
							<div class="icheck-success d-inline">
								<input type="checkbox" id="aktif" name="aktif" <?php if( $sayfa_bilgileri[ "aktif" ] == 1 ) echo "checked";?> >
								<label for="aktif">
									<?php echo dil_cevir( "Aktif", $dizi_dil, $sistem_dil ); ?>
								</label>
								<small class="form-text text-muted"><?php echo dil_cevir( "İşaretlenmezse Sayfa Yayınlanmaz", $dizi_dil, $sistem_dil ); ?></small>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></label>
							<input required type="text" class="form-control" name ="adi" value="<?php echo $sayfa_bilgileri[ "adi" ]; ?>"  autocomplete="off" id="kategori_ad_duzenle">
						</div>

					</div>

					<div class="card-footer">
						<button modul= 'birimSayfalari' yetki_islem="<?php echo $kaydet_buton_yetki_islem; ?>" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo $kaydet_buton_yazi; ?></button>
					</div>
					<?php }else{ ?>
						<div class="text-center" style="height:600px;">
							<br>
							<?php if( $birim_id > 0 ){ ?>
							<h2> <?php echo dil_cevir( "Lütfen Sayfa Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
							<?php }else{ ?>
							<h2> <?php echo dil_cevir( "Lütfen Birim Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
							<?php } ?>
							<br>
							<div class="spinner-grow text-primary " role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-secondary" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-success" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-danger" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-warning" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-info" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-dark" role="status">
							<span class="sr-only">Loading...</span>
							</div>
						</div>
					<?php } ?>

					</form>


                  </div>
                  <div class="tab-pane fade <?php if( $_REQUEST['aktif_tab'] == "custom-tabs-two-home" ) echo "show active"; ?>" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
					<form class="form-horizontal" action = "_modul/birimSayfalari/birimSayfalariSEG.php" method = "POST" enctype="multipart/form-data">
					<?php if( $sayfa_id > 0 ){ ?>

					<div class="card-body">
						<?php 
						foreach( $hidden_kayitlar_icerik as $hidden_kayit ){ 
							foreach( array_keys($hidden_kayit) as $anahtar ){
						?>
						<input type="hidden"  id="<?php echo $anahtar."_".$hidden_kayit['dil_id'];  ?>" value="<?php echo htmlentities($hidden_kayit[$anahtar]);  ?>">
						<?php }} ?>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
							<select class="form-control select2" name = "dil_id" required onchange="dil_degistir(this);">
								<option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
								<?php foreach( $diller AS $result ){ ?>
								<option value="<?php echo $result["id"] ?>" <?php if( $sayfa_bilgileri['dil_id'] == $result["id"] ) echo "selected"; ?> ><?php echo $result["adi".$dil] ?></option>
								<?php } ?>
							</select>
						</div>

						<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
						<input type = "hidden" name = "birim_id" value = "<?php echo $birim_id; ?>">
						<input type = "hidden" name = "sayfa_id" value = "<?php echo $sayfa_id; ?>">
						<input type = "hidden" name = "birim_adi" value = "<?php echo $birim_adi; ?>">
						<input type = "hidden" name = "sayfa_adi" value = "<?php echo $sayfa_adi; ?>">
						<input type = "hidden" name = "sayfa_aktif" value = "<?php echo $sayfa_bilgileri[ "aktif" ]; ?>">
						<input type = "hidden" name = "sayfa_aktif_kz" value = "<?php echo $sayfa_bilgileri[ "aktif_kz" ]; ?>">
						<input type = "hidden" name = "sayfa_aktif_en" value = "<?php echo $sayfa_bilgileri[ "aktif_en" ]; ?>">
						<input type = "hidden" name = "sayfa_aktif_ru" value = "<?php echo $sayfa_bilgileri[ "aktif_ru" ]; ?>">
						<input type = "hidden" name = "aktif_tab" value = "custom-tabs-two-home">
						<br><h5 class="float-right text-olive"><?php echo dil_cevir( "Sayfa İçeriği", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
						
						<?php  
						if( $birim_bilgileri['kategori'] == 0 and $sayfa_bilgileri['kisa_ad'] == "programin-amaci" ){
						?>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Foto", $dizi_dil, $sistem_dil ); ?></label>
							<input type="file" name="foto" class="" ><br>
							<input type="hidden" name="foto_eski" value="<?php echo $sayfa_icerik_bilgileri[ 'foto' ]; ?>">
							<small class="text-muted"><?php echo dil_cevir( "Eklediğiniz görsel 950 x 520 boyutlarında olmalıdır.", $dizi_dil, $sistem_dil ); ?> </small>
						</div>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Var olan görsel", $dizi_dil, $sistem_dil ); ?></label><br>
							<img src="resimler/programlar/<?php echo $sayfa_icerik_bilgileri[ 'foto' ]; ?>" width="200">
						</div>

						<?php } ?>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?></label>
							<input type="text" placeholder="Başlık" class="form-control form-control-sm" name ="baslik" id ="baslik" value = "<?php echo $sayfa_icerik_bilgileri[ "baslik" ]; ?>"  autocomplete="off">
						</div>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "İçerik", $dizi_dil, $sistem_dil ); ?></label>
							<style>
								.ck-editor__editable_inline:not(.ck-comment__input *) {
									height: 600px;
									overflow-y: auto;
								}
							</style>
							<textarea id="editor" style="display:none;" name="icerik"  >
							<?php echo $sayfa_icerik_bilgileri[ "icerik" ]; ?>
							</textarea>
						</div>
					</div>

					<div class="card-footer">
						<button modul= 'birimSayfalari' yetki_islem="<?php echo $kaydet_buton_yetki_islem; ?>" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo $kaydet_buton_yazi; ?></button>
					</div>
					<?php }else{ ?>
						<div class="text-center" style="height:600px;">
							<br>
							<?php if( $birim_id > 0 ){ ?>
							<h2> <?php echo dil_cevir( "Lütfen Sayfa Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
							<?php }else{ ?>
							<h2> <?php echo dil_cevir( "Lütfen Birim Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
							<?php } ?>
							<br>
							<div class="spinner-grow text-primary " role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-secondary" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-success" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-danger" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-warning" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-info" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-dark" role="status">
							<span class="sr-only">Loading...</span>
							</div>
						</div>
					<?php } ?>

					</form>


                  </div>
                  <div class="tab-pane fade  <?php if( $_REQUEST['aktif_tab'] == "custom-tabs-two-profile" ) echo "show active"; ?>" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
					<?php if( $sayfa_id > 0 ){ ?>

					<div class="row">
						<div class="col-md-12">
							<div class="card card-secondary">
								<div class="card-header">
									<h3 class="card-title"><?php echo dil_cevir( "Tab Sayfalar", $dizi_dil, $sistem_dil ); ?></h3>
									<div class = "card-tools">
										<button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
										<a id = "yeni_duyuru" data-toggle = "tooltip" title = "Yeni Ekle" href = "?modul=birimSayfalari&islem=tab_ekle&birim_id=<?php echo $birim_id; ?>&sayfa_id=<?php echo $sayfa_id; ?>&birim_adi=<?php echo $birim_adi; ?>&aktif_tab=custom-tabs-two-profile" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
									</div>
								</div>
                                <form class="form-horizontal" action = "_modul/birimSayfalari/birimSayfalariTabsSEG.php" method = "POST" enctype="multipart/form-data">
								<input type="hidden" name="islem" value="sira_guncelle">
                                <input type = "hidden" name = "sayfa_id" value = "<?php echo $sayfa_id; ?>">
                                <input type = "hidden" name = "birim_id" value = "<?php echo $birim_id; ?>">
                                <input type = "hidden" name = "birim_adi" value = "<?php echo $birim_adi; ?>">
                                <input type = "hidden" name = "aktif_tab" value = "custom-tabs-two-profile">
                                <div class="card-body">
									<div class="form-group">
										<label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
										<select class="form-control select2" name = "dil_id" required onchange="dil_degistir_tab(this);">
											<?php foreach( $diller AS $result ){ ?>
											<option value="<?php echo $result["id"] ?>" <?php if( $tek_tab['dil_id'] == $result["id"] ) echo "selected"; ?> ><?php echo $result["adi".$dil] ?></option>
											<?php } ?>
										</select>
									</div>

									<?php foreach( $diller as $tab_dil ){ 
										if(  isset( $tek_tab['dil_id'] )  ){
											if( $tek_tab['dil_id'] != $tab_dil['id'] )
												$gizli_tab = "d-none";
											else
												$gizli_tab = "";
										}else{
											if( $tab_dil['id'] != 1 ) 
												$gizli_tab = "d-none";
											else
												$gizli_tab = "";
										}
									
									?>
                                    <ul class="todo-list tabliste <?php echo $gizli_tab; ?>" id="liste<?php echo $tab_dil['id']; ?>" data-widget="todo-list">
                                    <?php 
                                        $sayi = 0; 
                                        $dil = $sistem_dil == "_tr" ? "" : $sistem_dil ;
										@$sayfa_tablari 		= $vt->select($SQL_sayfa_icerik_tabs, array( $sayfa_id, $tab_dil['id'] ) )[ 2 ];
                                        foreach( $sayfa_tablari AS $sayfa_tab ) { 
                                            $sayi++;
                                    ?>
                                        <li>
                                            <input type="hidden" name="siralar<?php echo $tab_dil[ 'id' ]; ?>[]" value="<?php echo $sayfa_tab[ 'id' ]; ?>">
                                            <!-- drag handle -->
                                            <span class="handle">
                                                <i class="fas fa-ellipsis-v text-primary"></i>
                                                <i class="fas fa-ellipsis-v text-primary"></i>
                                            </span>
                                            <!-- checkbox -->
                                            <!-- <small class="badge badge-secondary"> <?php echo $sayi; ?> </small> -->
                                            <!-- todo text -->
                                            <span class="text"><?php echo $sayfa_tab[ 'baslik'.$dil ]; ?></span>
                                            <!-- General tools such as edit or delete-->
                                            <div class="tools">
                                                <a modul = 'birimSayfalari' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=birimSayfalari&islem=tab_guncelle&tab_id=<?php echo $sayfa_tab[ 'id' ]; ?>&birim_id=<?php echo $birim_id; ?>&sayfa_id=<?php echo $sayfa_id; ?>&birim_adi=<?php echo $birim_adi; ?>&aktif_tab=custom-tabs-two-profile" >
                                                    <i class="fas fa-edit text-white"></i>
                                                </a>
												<button type="button" modul= 'birimSayfalari' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/birimSayfalari/birimSayfalariTabsSEG.php?islem=tab_sil&tab_id=<?php echo $sayfa_tab[ 'id' ]; ?>&birim_id=<?php echo $birim_id; ?>&sayfa_id=<?php echo $sayfa_id; ?>&birim_adi=<?php echo $birim_adi; ?>&aktif_tab=custom-tabs-two-profile" data-toggle="modal" data-target="#sil_onay">                                               
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </li>

                                        <?php } ?> 
                                    </ul>
									<?php } ?> 
								</div>
                                <div class="card-footer clearfix">
                                    <button type="submit" class="btn btn-primary btn-sm float-left" ><i class="fas fa-sort-amount-down-alt"></i> <?php echo dil_cevir( "Sıralamayı Kaydet", $dizi_dil, $sistem_dil ); ?> <i class="fas fa-save"></i></button>
                                </div>
                                </form>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card <?php if( $id == 0 ) echo 'card-secondary' ?>">
								<div class="card-header p-2">
									<ul class="nav nav-pills tab-container">
										<?php if( $id > 0 ) { ?>
											<h6 style = 'font-size: 1rem;'> &nbsp;&nbsp;&nbsp; <?php echo dil_cevir( "Tab Sayfa Düzenle", $dizi_dil, $sistem_dil ); ?></h6>
										<?php } else { ?>

											<h6 style = 'font-size: 1rem;'> &nbsp;&nbsp;&nbsp; <?php echo dil_cevir( "Tab Sayfa Ekle", $dizi_dil, $sistem_dil ); ?></h6>
										<?php	}
										?>
										
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<!-- GENEL BİLGİLER -->
										<div class="tab-pane active" id="_genel">
											<?php if( $birim_id > 0 ){ ?>
											<div class="alert alert-success" role="alert">
											Şu anda <b><?php echo $birim_adi ?></b> için işlem yapmaktasınız. Birimi değiştirmek için <a href="?modul=birimSayfalari" class="alert-link">tıklayınız.</a>
											</div>		
											<?php } ?>						
											<form id="tab_form" class="form-horizontal" action = "_modul/birimSayfalari/birimSayfalariTabsSEG.php" method = "POST" enctype="multipart/form-data">

												<input type = "hidden" name = "islem" value = "<?php if( $_REQUEST['islem']=="tab_guncelle" ) echo "tab_guncelle"; else echo "tab_ekle"; ?>" >
												<input type = "hidden" name = "tab_id" value = "<?php echo $_REQUEST['tab_id']; ?>">
												<input type = "hidden" name = "sayfa_id" value = "<?php echo $sayfa_id; ?>">
												<input type = "hidden" name = "birim_id" value = "<?php echo $birim_id; ?>">
												<input type = "hidden" name = "birim_adi" value = "<?php echo $birim_adi; ?>">
												<input type = "hidden" id="tab_dil_hidden" name = "dil_id" value = "<?php echo $tek_tab[ "dil_id" ]>0 ? $tek_tab[ "dil_id" ] : "1"; ?>">
												<input type = "hidden" name = "aktif_tab" value = "custom-tabs-two-profile">
												<div class="form-group">
													<label class="control-label"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?></label>
													<input type="text" class="form-control" id ="tab_baslik" name ="tab_baslik" value = "<?php echo $tek_tab[ "baslik" ]; ?>"  autocomplete="off">
												</div>
												<div class="form-group">
													<label class="control-label"><?php echo dil_cevir( "İçerik", $dizi_dil, $sistem_dil ); ?></label>
													<style>
													.ck-editor__editable_inline:not(.ck-comment__input *) {
														height: 600px;
														overflow-y: auto;
													}
													</style>
													<textarea id="tab_editor" style="display:none" name="tab_icerik">
													<?php echo @$tek_tab[ "icerik" ]; ?>
													</textarea>
												</div>

												<div class="card-footer">
													<?php if( $birim_id >0 ){ ?>
													<button modul= 'birimSayfalari' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
													<?php } ?>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php }else{ ?>
						<div class="text-center" style="height:600px;">
							<br>
							<?php if( $birim_id > 0 ){ ?>
							<h2> <?php echo dil_cevir( "Lütfen Sayfa Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
							<?php }else{ ?>
							<h2> <?php echo dil_cevir( "Lütfen Birim Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
							<?php } ?>
							<br>
							<div class="spinner-grow text-primary " role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-secondary" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-success" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-danger" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-warning" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-info" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-dark" role="status">
							<span class="sr-only">Loading...</span>
							</div>
						</div>
					<?php } ?>


                  </div>
                  <div class="tab-pane fade  <?php if( $_REQUEST['aktif_tab'] == "custom-tabs-two-messages" ) echo "show active"; ?>" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
					<?php if( $sayfa_id > 0 ){ ?>

					<div class="row">
						<div class="col-md-12">
							<div class="card card-secondary">
								<div class="card-header">
									<h3 class="card-title"><?php echo dil_cevir( "Accordion İçerikler", $dizi_dil, $sistem_dil ); ?></h3>
									<div class = "card-tools">
										<button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
										<a id = "yeni_duyuru" data-toggle = "tooltip" title = "Yeni Ekle" href = "?modul=birimSayfalari&islem=sss_ekle&birim_id=<?php echo $birim_id; ?>&sayfa_id=<?php echo $sayfa_id; ?>&birim_adi=<?php echo $birim_adi; ?>&aktif_tab=custom-tabs-two-messages" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
									</div>
								</div>
                                <form class="form-horizontal" action = "_modul/birimSayfalari/birimSayfalariSssSEG.php" method = "POST" enctype="multipart/form-data">
								<input type="hidden" name="islem" value="sira_guncelle">
                                <input type = "hidden" name = "sayfa_id" value = "<?php echo $sayfa_id; ?>">
                                <input type = "hidden" name = "birim_id" value = "<?php echo $birim_id; ?>">
                                <input type = "hidden" name = "birim_adi" value = "<?php echo $birim_adi; ?>">
                                <input type = "hidden" name = "aktif_tab" value = "custom-tabs-two-messages">
                                <div class="card-body">
									<div class="form-group">
										<label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
										<select class="form-control select2" name = "dil_id" required onchange="dil_degistir_sss(this);">
											<?php foreach( $diller AS $result ){ ?>
											<option value="<?php echo $result["id"] ?>" <?php if( $tek_sss['dil_id'] == $result["id"] ) echo "selected"; ?> ><?php echo $result["adi".$dil] ?></option>
											<?php } ?>
										</select>
									</div>
									<?php foreach( $diller as $sss_dil ){ 
										if(  isset( $tek_sss['dil_id'] )  ){
											if( $tek_sss['dil_id'] != $sss_dil['id'] )
												$gizli_sss = "d-none";
											else
												$gizli_sss = "";
										}else{
											if( $sss_dil['id'] != 1 ) 
												$gizli_sss = "d-none";
											else
												$gizli_sss = "";
										}
									?>
                                    <ul class="todo-list sssliste <?php echo $gizli_sss; ?>" id="sssliste<?php echo $sss_dil['id']; ?>" data-widget="todo-list">
                                    <?php 
                                        $sayi = 0; 
                                        $dil = $sistem_dil == "_tr" ? "" : $sistem_dil ;
										@$sayfa_sssler 		= $vt->select($SQL_sayfa_icerik_sss, array( $sayfa_id, $sss_dil['id'] ) )[ 2 ];
										//var_dump($sayfa_sssler);
                                        foreach( $sayfa_sssler AS $sayfa_sss ) { 
                                            $sayi++;
                                    ?>
                                        <li>
                                            <input type="hidden" name="siralar<?php echo $sss_dil['id']; ?>[]" value="<?php echo $sayfa_sss[ 'id' ]; ?>">
                                            <!-- drag handle -->
                                            <span class="handle">
                                                <i class="fas fa-ellipsis-v text-primary"></i>
                                                <i class="fas fa-ellipsis-v text-primary"></i>
                                            </span>
                                            <!-- checkbox -->
                                            <!-- <small class="badge badge-secondary"> <?php echo $sayi; ?> </small> -->
                                            <!-- todo text -->
                                            <span class="text"><?php echo $sayfa_sss[ 'baslik'.$dil ]; ?></span>
                                            <!-- General tools such as edit or delete-->
                                            <div class="tools">
                                                <a modul = 'birimSayfalari' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=birimSayfalari&islem=sss_guncelle&sss_id=<?php echo $sayfa_sss[ 'id' ]; ?>&birim_id=<?php echo $birim_id; ?>&sayfa_id=<?php echo $sayfa_id; ?>&birim_adi=<?php echo $birim_adi; ?>&aktif_tab=custom-tabs-two-messages" >
                                                    <i class="fas fa-edit text-white"></i>
                                                </a>
												<button type="button" modul= 'birimSayfalari' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/birimSayfalari/birimSayfalariSssSEG.php?islem=sss_sil&sss_id=<?php echo $sayfa_sss[ 'id' ]; ?>&birim_id=<?php echo $birim_id; ?>&sayfa_id=<?php echo $sayfa_id; ?>&birim_adi=<?php echo $birim_adi; ?>&aktif_tab=custom-tabs-two-messages" data-toggle="modal" data-target="#sil_onay">                                               
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </li>

                                        <?php } ?> 
                                    </ul>
									<?php } ?>
								</div>
                                <div class="card-footer clearfix">
                                    <button type="submit" class="btn btn-primary btn-sm float-left" ><i class="fas fa-sort-amount-down-alt"></i> <?php echo dil_cevir( "Sıralamayı Kaydet", $dizi_dil, $sistem_dil ); ?> <i class="fas fa-save"></i></button>
                                </div>
                                </form>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card <?php if( $id == 0 ) echo 'card-secondary' ?>">
								<div class="card-header p-2">
									<ul class="nav nav-pills tab-container">
										<?php if( $id > 0 ) { ?>
											<h6 style = 'font-size: 1rem;'> &nbsp;&nbsp;&nbsp; <?php echo dil_cevir( "Accordion İçerik Düzenle", $dizi_dil, $sistem_dil ); ?></h6>
										<?php } else { ?>

											<h6 style = 'font-size: 1rem;'> &nbsp;&nbsp;&nbsp; <?php echo dil_cevir( "Accordion İçerik Ekle", $dizi_dil, $sistem_dil ); ?></h6>
										<?php	}
										?>
										
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<!-- GENEL BİLGİLER -->
										<div class="tab-pane active" id="_genel">
											<?php if( $birim_id > 0 ){ ?>
											<div class="alert alert-success" role="alert">
											Şu anda <b><?php echo $birim_adi ?></b> için işlem yapmaktasınız. Birimi değiştirmek için <a href="?modul=birimSayfalari" class="alert-link">tıklayınız.</a>
											</div>		
											<?php } ?>						
											<form id="sss_form" class="form-horizontal" action = "_modul/birimSayfalari/birimSayfalariSssSEG.php" method = "POST" enctype="multipart/form-data">

												<input type = "hidden" name = "islem" value = "<?php if( $_REQUEST['islem']=="sss_guncelle" ) echo "sss_guncelle"; else echo "sss_ekle"; ?>" >
												<input type = "hidden" name = "sss_id" value = "<?php echo $_REQUEST['sss_id']; ?>">
												<input type = "hidden" name = "sayfa_id" value = "<?php echo $sayfa_id; ?>">
												<input type = "hidden" name = "birim_id" value = "<?php echo $birim_id; ?>">
												<input type = "hidden" name = "birim_adi" value = "<?php echo $birim_adi; ?>">
												<input type = "hidden" id="sss_dil_hidden" name = "dil_id" value = "<?php echo $tek_sss[ "dil_id" ]>0 ? $tek_sss[ "dil_id" ] : "1"; ?>">
												<input type = "hidden" name = "aktif_tab" value = "custom-tabs-two-messages">
												<div class="form-group">
													<label class="control-label"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?></label>
													<input type="text" class="form-control" id ="sss_baslik" name ="sss_baslik" value = "<?php echo $tek_sss[ "baslik" ]; ?>"  autocomplete="off">
												</div>
												<div class="form-group">
													<label class="control-label"><?php echo dil_cevir( "İçerik", $dizi_dil, $sistem_dil ); ?></label>
													<style>
													.ck-editor__editable_inline:not(.ck-comment__input *) {
														height: 600px;
														overflow-y: auto;
													}
													</style>
													<textarea id="sss_editor" style="display:none" name="sss_icerik">
													<?php echo @$tek_sss[ "icerik" ]; ?>
													</textarea>
												</div>

												<div class="card-footer">
													<?php if( $birim_id >0 ){ ?>
													<button modul= 'birimSayfalari' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
													<?php } ?>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php }else{ ?>
						<div class="text-center" style="height:600px;">
							<br>
							<?php if( $birim_id > 0 ){ ?>
							<h2> <?php echo dil_cevir( "Lütfen Sayfa Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
							<?php }else{ ?>
							<h2> <?php echo dil_cevir( "Lütfen Birim Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
							<?php } ?>
							<br>
							<div class="spinner-grow text-primary " role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-secondary" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-success" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-danger" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-warning" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-info" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-dark" role="status">
							<span class="sr-only">Loading...</span>
							</div>
						</div>
					<?php } ?>




                  </div>
                  <div class="tab-pane fade  <?php if( $_REQUEST['aktif_tab'] == "custom-tabs-two-settings" ) echo "show active"; ?>" id="custom-tabs-two-settings" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab">
					<?php if( $sayfa_id > 0 ){ ?>

					<div class="row">
						<div class="col-md-12">
							<div class="card card-secondary">
								<div class="card-header">
									<h3 class="card-title"><?php echo dil_cevir( "Göreve Göre Personel", $dizi_dil, $sistem_dil ); ?></h3>
								</div>
								<div class="card-body">
                                    <form id="personel_form" class="form-horizontal" action = "_modul/birimSayfalari/birimSayfalariPersonellerSEG.php" method = "POST" enctype="multipart/form-data">
                                        <input type="hidden" name="islem" value="gorev_listesi">
                                        <input type = "hidden" name = "birim_id" value = "<?php echo $birim_id; ?>">
                                        <input type = "hidden" name = "sayfa_id" value = "<?php echo $sayfa_id; ?>">
                                        <input type = "hidden" name = "birim_adi" value = "<?php echo $birim_adi; ?>">
                                        <input type = "hidden" name = "sayfa_adi" value = "<?php echo $sayfa_adi; ?>">
                                        <input type = "hidden" name = "aktif_tab" value = "custom-tabs-two-settings">
                                        <div class="form-group">
                                            <label  class="control-label">Görev Listesi</label>
                                                <select   class="form-control select2"  multiple="multiple" name = "gorev_kategori_idler[]">
                                                        <option>Seçiniz</option>
                                                    <?php foreach( $gorevler AS $gorev ) { 
                                                            $gorevler2 = explode(",", $sayfa_bilgileri[ 'gorev_kategori_idler' ]);
                                                    ?>
                                                        <option value = "<?php echo $gorev[ 'id' ]; ?>" <?php if( in_array($gorev[ 'id' ], $gorevler2) ) echo 'selected'?>><?php echo $gorev[ 'adi'.$dil ]?></option>
                                                    <?php } ?>
                                                </select>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" value="1" id="personeller_gorunecek" name="personeller_gorunecek" <?php if( $sayfa_bilgileri[ "personeller_gorunecek" ] == 1 ) echo "checked"; ?> >
                                                <label for="personeller_gorunecek">
                                                    <?php echo dil_cevir( "Bu sayfada birim personelleri listelenecek.", $dizi_dil, $sistem_dil ); ?>
                                                </label>
                                            </div>
                                        </div>

                                        <button modul= 'birimSayfalari' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
                                    </form>

								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card card-secondary">
								<div class="card-header">
									<h3 class="card-title"><?php echo dil_cevir( "Personeller", $dizi_dil, $sistem_dil ); ?></h3>
									<div class = "card-tools">
										<button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
										<a id = "yeni_duyuru" data-toggle = "tooltip" title = "Yeni Duyuru Ekle" href = "?modul=birimSayfalari&islem=personel_ekle&birim_id=<?php echo $birim_id; ?>&sayfa_id=<?php echo $sayfa_id; ?>&birim_adi=<?php echo $birim_adi; ?>&aktif_tab=custom-tabs-two-settings" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
									</div>
								</div>
								<div class="card-body">
									<table id="tbl_personeller" class="table table-bordered table-hover table-sm" width = "100%" >
										<thead>
											<tr>
												<th style="width: 15px">#</th>
												<th><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?></th>
												<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
												<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$sayi = 1; 
												$dil = $sistem_dil == "_tr" ? "" : $sistem_dil ;
												foreach( $sayfa_personeller AS $sayfa_personel ) { 
											?>
											<tr oncontextmenu="fun();" class ="duyuru-Tr <?php if( $sayfa_personel[ 'id' ] == $id ) echo $satir_renk; ?>" data-id="<?php echo $sayfa_personel[ 'id' ]; ?>">
												<td><?php echo $sayi++; ?></td>
												<td><?php echo $sayfa_personel[ 'adi'.$dil ]; ?></td>
												<td align = "center">
													<a modul = 'birimSayfalari' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=birimSayfalari&islem=personel_guncelle&personel_id=<?php echo $sayfa_personel[ 'id' ]; ?>&birim_id=<?php echo $birim_id; ?>&sayfa_id=<?php echo $sayfa_id; ?>&birim_adi=<?php echo $birim_adi; ?>&aktif_tab=custom-tabs-two-settings" >
														<?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
													</a>
												</td>
												<td align = "center">
													<button modul= 'birimSayfalari' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/birimSayfalari/birimSayfalariPersonellerSEG.php?islem=personel_sil&personel_id=<?php echo $sayfa_personel[ 'id' ]; ?>&birim_id=<?php echo $birim_id; ?>&sayfa_id=<?php echo $sayfa_id; ?>&birim_adi=<?php echo $birim_adi; ?>&aktif_tab=custom-tabs-two-settings" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card <?php if( $id == 0 ) echo 'card-secondary' ?>">
								<div class="card-header p-2">
									<ul class="nav nav-pills tab-container">
										<?php if( $id > 0 ) { ?>
											<h6 style = 'font-size: 1rem;'> &nbsp;&nbsp;&nbsp; <?php echo dil_cevir( "Personel Düzenle", $dizi_dil, $sistem_dil ); ?></h6>
										<?php } else { ?>

											<h6 style = 'font-size: 1rem;'> &nbsp;&nbsp;&nbsp; <?php echo dil_cevir( "Personel Ekle", $dizi_dil, $sistem_dil ); ?></h6>
										<?php	}
										?>
										
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<!-- GENEL BİLGİLER -->
										<div class="tab-pane active" id="_genel">
											<?php if( $birim_id > 0 ){ ?>
											<div class="alert alert-success" role="alert">
											Şu anda <b><?php echo $birim_adi ?></b> için işlem yapmaktasınız. Birimi değiştirmek için <a href="?modul=birimSayfalari" class="alert-link">tıklayınız.</a>
											</div>		
											<?php } ?>						
											<form id="personel_form" class="form-horizontal" action = "_modul/birimSayfalari/birimSayfalariPersonellerSEG.php" method = "POST" enctype="multipart/form-data">
												<?php foreach( array_keys($tek_personel) as $anahtar ){ ?>
												<input type="hidden"  name="personel_<?php echo $anahtar;  ?>_hidden" value='<?php echo $tek_personel[$anahtar];  ?>'>
												<?php } ?>
												<div class="form-group">
													<label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
													<select class="form-control" name = "personel_dil" id="personel_dil" required onchange="dil_degistir_personel(this);">
														<option value="_tr" <?php if( $_REQUEST['dil'] == "" ) echo "selected"; ?> >Türkçe</option>
														<option value="_kz" <?php if( $_REQUEST['dil'] == "_kz" ) echo "selected"; ?> >қазақ</option>
														<option value="_en" <?php if( $_REQUEST['dil'] == "_en" ) echo "selected"; ?> >English</option>
														<option value="_ru" <?php if( $_REQUEST['dil'] == "_ru" ) echo "selected"; ?> >Россия</option>
													</select>
												</div>

												<input type = "hidden" name = "islem" value = "<?php if( $_REQUEST['islem']=="personel_guncelle" ) echo "personel_guncelle"; else echo "personel_ekle"; ?>" >
												<input type = "hidden" name = "personel_id" value = "<?php echo $_REQUEST['personel_id']; ?>">
												<input type = "hidden" name = "sayfa_id" value = "<?php echo $sayfa_id; ?>">
												<input type = "hidden" name = "birim_id" value = "<?php echo $birim_id; ?>">
												<input type = "hidden" name = "birim_adi" value = "<?php echo $birim_adi; ?>">
												<input type = "hidden" name = "aktif_tab" value = "custom-tabs-two-settings">
												<?php
													if( $_REQUEST['islem'] == "personel_guncelle" ){
														$resim_src = "resimler/personel_resimler/".$tek_personel[ "foto" ];
													}else{
														$resim_src = "resimler/resim_yok.png";
													}
												?>
												<div class="text-center">
													<img class="img-fluid img-circle img-thumbnail mw-100"
														style="width:120px; cursor:pointer;"
														src="<?php echo $resim_src; ?>" 
														alt="User profile picture"
														id = "personel_kullanici_resim">
												</div>
												<p class="text-muted text-center"><?php echo dil_cevir( "Fotoğraf değiştirmek için fotoğrafa tıklayınız", $dizi_dil, $sistem_dil ); ?></p>	
												<input type="file" id="gizli_input_file" name = "input_personel_resim" style = "display:none;" name = "resim" accept="image/gif, image/jpeg, image/png"  onchange="resimOnizle(this)"; />
												<div class="row">
													<div class="form-group col-6">
														<label class="control-label"><?php echo dil_cevir( "Adı Soyadı", $dizi_dil, $sistem_dil ); ?></label>
														<input required type="text" class="form-control" id ="personel_adi" name ="personel_adi" value = "<?php echo $tek_personel[ "adi" ]; ?>"  >
													</div>
													<div class="form-group col-6">
														<label class="control-label"><?php echo dil_cevir( "Görev", $dizi_dil, $sistem_dil ); ?></label>
														<input required type="text" class="form-control" id ="personel_gorev" name ="personel_gorev" value = "<?php echo $tek_personel[ "gorev" ]; ?>">
													</div>
												</div>
												<div class="row">
													<div class="form-group col-6">
														<label class="control-label"><?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?></label>
														<input required type="email" class="form-control" id ="personel_email" name ="personel_email" value = "<?php echo $tek_personel[ "email" ]; ?>"  >
													</div>
													<div class="form-group col-3">
														<label class="control-label"><?php echo dil_cevir( "Tel", $dizi_dil, $sistem_dil ); ?></label>
														<input type="tel" class="form-control" id ="personel_tel" name ="personel_tel" value = "<?php echo $tek_personel[ "tel" ]; ?>"  >
													</div>
													<div class="form-group col-3">
														<label class="control-label"><?php echo dil_cevir( "Dahili", $dizi_dil, $sistem_dil ); ?></label>
														<input type="text" class="form-control" id ="personel_dahili" name ="personel_dahili" value = "<?php echo $tek_personel[ "dahili" ]; ?>"  >
													</div>
												</div>
												<div class="row">
													<div class="form-group col-6">
														<label class="control-label"><?php echo dil_cevir( "Oda No", $dizi_dil, $sistem_dil ); ?></label>
														<input type="text" class="form-control" name ="personel_oda_no" value = "<?php echo $tek_personel[ "oda_no" ]; ?>"  >
													</div>
													<div class="form-group col-6">
														<label class="control-label"><?php echo dil_cevir( "URL", $dizi_dil, $sistem_dil ); ?></label>
														<input type="text" class="form-control" name ="personel_link" value = "<?php echo $tek_personel[ "link" ]; ?>">
													</div>
												</div>


												<div class="card-footer">
													<?php if( $birim_id >0 ){ ?>
													<button modul= 'birimSayfalari' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
													<?php } ?>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php }else{ ?>
						<div class="text-center" style="height:600px;">
							<br>
							<?php if( $birim_id > 0 ){ ?>
							<h2> <?php echo dil_cevir( "Lütfen Sayfa Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
							<?php }else{ ?>
							<h2> <?php echo dil_cevir( "Lütfen Birim Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
							<?php } ?>
							<br>
							<div class="spinner-grow text-primary " role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-secondary" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-success" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-danger" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-warning" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-info" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-dark" role="status">
							<span class="sr-only">Loading...</span>
							</div>
						</div>
					<?php } ?>




                  </div>
                  <div class="tab-pane fade  <?php if( $_REQUEST['aktif_tab'] == "custom-tabs-two-galeri" ) echo "show active"; ?>" id="custom-tabs-two-galeri" role="tabpanel" aria-labelledby="custom-tabs-two-galeri-tab">
					<?php if( $sayfa_id > 0 ){ ?>

					<div class="row">
						<div class="col-md-12">
								<form class="form-horizontal" action = "_modul/birimSayfalari/birimSayfalariGaleriSEG.php" method = "POST" enctype="multipart/form-data">
                                    <input type = "hidden" name = "islem" value = "galeri_ekle" >
                                    <input type = "hidden" name = "birim_id" value = "<?php echo $birim_id; ?>">
                                    <input type = "hidden" name = "sayfa_id" value = "<?php echo $sayfa_id; ?>">
                                    <input type = "hidden" name = "birim_adi" value = "<?php echo $birim_adi; ?>">
                                    <input type = "hidden" name = "sayfa_adi" value = "<?php echo $sayfa_adi; ?>">
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
                                                <a href="resimler/sayfalar/buyuk/<?php echo $foto_galeri['foto']; ?>" data-toggle="lightbox" data-title="" data-gallery="gallery">
                                                    <img class="card-img-top" src="resimler/sayfalar/kucuk/<?php echo $foto_galeri['foto']; ?>" style="object-fit: cover; height: 250px;"   alt="white sample"/>
                                                </a>

                                                <div class="card-footer">
                                                    <button type="button" modul= 'sayfalar' yetki_islem="sil" class="btn btn-danger foto_sil" data-url="_modul/birimSayfalari/birimSayfalariGaleriSEG.php" data-islem="foto_sil" data-foto="<?php echo $foto_galeri['foto']; ?>" data-sayfa_id="<?php echo $sayfa_id; ?>" data-foto_id="<?php echo $foto_galeri['id']; ?>" >
                                                    <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php 
                                        }
                                    ?>   
                                    </div>
									<div class="card-footer">
										<?php if( $birim_id >0 ){ ?>
										<button modul= 'sayfalar' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
										<?php } ?>
									</div>
								</form>

						</div>
					</div>
					<?php }else{ ?>
						<div class="text-center" style="height:600px;">
							<br>
							<?php if( $birim_id > 0 ){ ?>
							<h2> <?php echo dil_cevir( "Lütfen Sayfa Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
							<?php }else{ ?>
							<h2> <?php echo dil_cevir( "Lütfen Birim Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
							<?php } ?>
							<br>
							<div class="spinner-grow text-primary " role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-secondary" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-success" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-danger" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-warning" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-info" role="status">
							<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-dark" role="status">
							<span class="sr-only">Loading...</span>
							</div>
						</div>
					<?php } ?>




                  </div>

                </div>
              </div>
              <!-- /.card -->
            </div>

				<!--div class="card card-olive" id = "card_personeller">
					<div class="card-header">
						<h3 class="card-title"><?php echo $birim_adi." / ".$sayfa_adi ?></h3>
					</div>

					<form class="form-horizontal" action = "_modul/birimSayfalari/birimSayfalariSEG.php" method = "POST" enctype="multipart/form-data">
					<?php if( $sayfa_id > 0 ){ ?>

					<div class="card-body">
						<?php foreach( array_keys($sayfa_icerik_bilgileri) as $anahtar ){ ?>
						<input type="hidden"  name="<?php echo $anahtar;  ?>" value="<?php echo htmlentities($sayfa_icerik_bilgileri[$anahtar]);  ?>">
						<?php } ?>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
							<select class="form-control" name = "dil" id="dil" required onchange="dil_degistir(this);">
								<option value="_tr" <?php if( $_REQUEST['dil'] == "" ) echo "selected"; ?> >Türkçe</option>
								<option value="_kz" <?php if( $_REQUEST['dil'] == "_kz" ) echo "selected"; ?> >қазақ</option>
								<option value="_en" <?php if( $_REQUEST['dil'] == "_en" ) echo "selected"; ?> >English</option>
								<option value="_ru" <?php if( $_REQUEST['dil'] == "_ru" ) echo "selected"; ?> >Россия</option>
							</select>
						</div>

						<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
						<input type = "hidden" name = "birim_id" value = "<?php echo $birim_id; ?>">
						<input type = "hidden" name = "sayfa_id" value = "<?php echo $sayfa_id; ?>">
						<input type = "hidden" name = "birim_adi" value = "<?php echo $birim_adi; ?>">
						<input type = "hidden" name = "sayfa_adi" value = "<?php echo $sayfa_adi; ?>">
						<h5 class="float-left text-olive"><?php echo dil_cevir( "Sayfa Ayarları", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
						<div class="card card-body">
							<div class="form-group clearfix">
								<div class="icheck-success d-inline">
									<input type="checkbox" id="checkboxPrimary1" name="aktif" <?php if( $sayfa_bilgileri[ "aktif" ] == 1 ) echo "checked";?> >
									<label for="checkboxPrimary1">
										<?php echo dil_cevir( "Aktif", $dizi_dil, $sistem_dil ); ?>
									</label>
									<small class="form-text text-muted"><?php echo dil_cevir( "İşaretlenmezse Sayfa Yayınlanmaz", $dizi_dil, $sistem_dil ); ?></small>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="icheck-primary d-inline">
									<input type="checkbox" id="checkboxPrimary2" name="harici" <?php if( $sayfa_bilgileri[ "harici" ] == 1 ) echo "checked"; ?> >
									<label for="checkboxPrimary2">
										<?php echo dil_cevir( "Harici Sayfa", $dizi_dil, $sistem_dil ); ?>
									</label>
									<small class="form-text text-muted"><?php echo dil_cevir( "Menüde görünmeyecek sayfalar için işaretlenmelidir.", $dizi_dil, $sistem_dil ); ?></small>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="icheck-secondary d-inline">
									<input type="checkbox" id="link_check" name="link" onclick="link_aktif(this);" <?php if( $sayfa_bilgileri[ "link" ] == 1 ) echo "checked"; ?> >
									<label for="link_check">
										<?php echo dil_cevir( "Link", $dizi_dil, $sistem_dil ); ?>
									</label>
								</div>
							</div>
							<div class="form-group">
								<input required type="text" id="link_yonlendirme" placeholder="Link" class="form-control form-control-sm" name ="link_url" value = "<?php echo $sayfa_bilgileri[ "link_url" ]; ?>"  autocomplete="off" <?php if( $sayfa_bilgileri[ "link" ] == 1 ) echo "";else echo " disabled "; if( $islem == "icerik_ekle" and $sayfa_bilgileri[ "link" ] != 1 ) echo " disabled ";  ?>>
								<small class="form-text text-muted"><?php echo dil_cevir( "Bu alana Link eklenirse menü bu linke yönlendirilecektir.", $dizi_dil, $sistem_dil ); ?></small>
							</div>

						</div>
						<br><h5 class="float-right text-olive"><?php echo dil_cevir( "Sayfa İçeriği", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
						
						<?php  
						if( $birim_bilgileri['kategori'] == 0 and $sayfa_bilgileri['kisa_ad'] == "programin-amaci" ){
						?>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Foto", $dizi_dil, $sistem_dil ); ?></label>
							<input type="file" name="foto" class="" ><br>
							<input type="hidden" name="foto_eski" value="<?php echo $sayfa_icerik_bilgileri[ 'foto' ]; ?>">
							<small class="text-muted"><?php echo dil_cevir( "Eklediğiniz görsel 950 x 520 boyutlarında olmalıdır.", $dizi_dil, $sistem_dil ); ?> </small>
						</div>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Var olan görsel", $dizi_dil, $sistem_dil ); ?></label><br>
							<img src="resimler/programlar/<?php echo $sayfa_icerik_bilgileri[ 'foto' ]; ?>" width="200">
						</div>

						<?php } ?>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?></label>
							<input type="text" placeholder="Başlık" class="form-control form-control-sm" name ="baslik" id ="baslik" value = "<?php echo $sayfa_icerik_bilgileri[ "baslik" ]; ?>"  autocomplete="off">
						</div>
						<div class="form-group">
							<label class="control-label"><?php echo dil_cevir( "İçerik", $dizi_dil, $sistem_dil ); ?></label>
							<style>
								.ck-editor__editable_inline:not(.ck-comment__input *) {
									height: 600px;
									overflow-y: auto;
								}
							</style>
							<textarea id="editor" style="display:none" name="icerik"  >
							<?php echo $sayfa_icerik_bilgileri[ "icerik" ]; ?>
							</textarea>
						</div>
					</div>

					<div class="card-footer">
						<button modul= 'birimSayfalari' yetki_islem="<?php echo $kaydet_buton_yetki_islem; ?>" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo $kaydet_buton_yazi; ?></button>
					</div>
                        <?php }else{ ?>
                            <div class="text-center" style="height:600px;">
								<br>
								<?php if( $birim_id > 0 ){ ?>
                                <h2> <?php echo dil_cevir( "Lütfen Sayfa Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
								<?php }else{ ?>
                                <h2> <?php echo dil_cevir( "Lütfen Birim Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
								<?php } ?>
                                <br>
                                <div class="spinner-grow text-primary " role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-secondary" role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-success" role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-danger" role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-warning" role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-info" role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-dark" role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        <?php } ?>

					</form>

				</div-->
			</div>
		</div>
	</div>
</section>
<?php include "editor.php"; ?>

	<script>
		function link_aktif(eleman){
			if(eleman.checked)
				document.getElementById("link_yonlendirme").disabled = false;
			else
				document.getElementById("link_yonlendirme").disabled = true;
		}
        $('.soru').summernote();

		$( '#sil_onay' ).on( 'show.bs.modal', function( e ) {
			event.stopPropagation();
			$( this ).find( '.btn-evet' ).attr( 'href', $( e.relatedTarget ).data( 'href' ) );
		} );
		
	    $('.KategoriEkle').on("click", function(e) { 
	        var ust_id      = $(this).data("id");
	        var birim_id	= $(this).data("birim_id");
	        var kategori_ad = $(this).data("kategori_ad");
	        var modal 		= $(this).data("modal");

	        document.getElementById("yeni_kategori_ust_id").value 	 = ust_id;
	        document.getElementById("kategori_ad").value = kategori_ad;
	        document.getElementById("kategori_birim_id").value = birim_id;
	        $('#'+ modal).modal( "show" );
	    });
		
		$('.modalAc').on("click", function(e) { 
			var modal 		= $(this).data("modal");
			var kategori_ad = $(this).data("kategori_ad_duzenle");
			var modal 		= $(this).data("modal");
			var kategori 	= $(this).data("kategori");
			var islem 		= $(this).data("islem");
			var birim_sayfa_id = $(this).data("id");
			var birim_id = $(this).data("birim_id");

			if ( kategori == 1 ) {
				$( "[id='kategori_mi']" ).bootstrapSwitch( 'state', true, true);
			}else{
				$( "[id='kategori_mi']" ).bootstrapSwitch( 'state', false, false);
			}

			document.getElementById("birim_sayfa_id").value 		= birim_sayfa_id;
			document.getElementById("kategori_ad_duzenle").value 	= kategori_ad;
			document.getElementById("birim_id_duzenle").value 		= birim_id;
			document.getElementById("islem").value 					= islem;
		        
		    $('#'+ modal).modal( "show" );
	    });

		$('.gorevli').on("click", function(e) { 
	        var id 	        = $(this).data("id");
	        var data_islem  = $(this).data("islem");
	        var data_url    = $(this).data("url");
	        var data_modul  = $(this).data("modul");
	        var div         = $(this).data("div");
	        $("#"+div).empty();
	        $.post(data_url, { islem : data_islem, id : id, modul : data_modul }, function (response) {
	            $("#"+div).append(response);
	            $('#gorevliEkleModal').modal( "show" )
	        });
	    });
	    function dersSecimi(ders_id){
			var  url 		= window.location;
			var origin		= url.origin;
			var path		= url.pathname;
			var search		= (new URL(document.location)).searchParams;
			var modul   	= search.get('modul');
			var ders_id  	= "&ders_id="+ders_id;
			
			window.location.replace(origin + path+'?modul='+modul+''+ders_id);
		}


	</script>


<script type="text/javascript">
	var simdi = new Date(); 
	//var simdi="11/25/2015 15:58";
	$(function () {
		$('#dogum_tarihi').datetimepicker({
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
		$('#ise_baslama_tarihi').datetimepicker({
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
		$('#sozlesme_baslama_tarihi').datetimepicker({
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
		$('#sozlesme_bitis_tarihi').datetimepicker({
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
		$('#tez_tarihi').datetimepicker({
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

// ESC tuşuna basınca formu temizle
document.addEventListener( 'keydown', function( event ) {
	if( event.key === "Escape" ) {
		document.getElementById( 'yeni_ogretim_elemanlari' ).click();
	}
});

var tbl_tablar = $( "#tbl_tablar" ).DataTable( {
	"responsive": true, "lengthChange": true, "autoWidth": true,
	"stateSave": true,
	"pageLength" : 25,
	//"buttons": ["excel", "pdf", "print","colvis"],

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
} ).buttons().container().appendTo('#tbl_tablar_');

var tbl_sssler = $( "#tbl_sssler" ).DataTable( {
	"responsive": true, "lengthChange": true, "autoWidth": true,
	"stateSave": true,
	"pageLength" : 25,
	//"buttons": ["excel", "pdf", "print","colvis"],

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
} ).buttons().container().appendTo('#tbl_sssler_');

var tbl_personeller = $( "#tbl_personeller" ).DataTable( {
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
} ).buttons().container().appendTo('#tbl_personeller_wrapper .col-md-6:eq(0)');



$('#card_personeller').on('maximized.lte.cardwidget', function() {
	var tbl_personeller = $( "#tbl_personeller" ).DataTable();
	var column = tbl_personeller.column(  tbl_personeller.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_personeller.column(  tbl_personeller.column.length - 2 );
	column.visible( ! column.visible() );
});

$('#card_personeller').on('minimized.lte.cardwidget', function() {
	var tbl_personeller = $( "#tbl_personeller" ).DataTable();
	var column = tbl_personeller.column(  tbl_personeller.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_personeller.column(  tbl_personeller.column.length - 2 );
	column.visible( ! column.visible() );
} );


</script>
        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("tab_editor"), {
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
            })
			.then( tab_editor => {
				window.tab_editor = tab_editor;
                tab_editor.execute( 'imageStyle', { value: 'alignCenter' } );
			});
        </script>
        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("sss_editor"), {
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
            })
			.then( sss_editor => {
				window.sss_editor = sss_editor;
                sss_editor.execute( 'imageStyle', { value: 'alignCenter' } );
			});
        </script>
	<script>
		var select = document.getElementById('dil');
		var select2 = document.getElementById('tab_dil');
		var select3 = document.getElementById('sss_dil');
		<?php if( isset($_REQUEST['dil'] )){ ?>
			select.value = "<?php echo $_REQUEST['dil'];  ?>";
			select2.value = "<?php echo $_REQUEST['dil'];  ?>";
			select3.value = "<?php echo $_REQUEST['dil'];  ?>";
		<?php }else{ ?>
			select.value = "<?php echo $sistem_dil;  ?>";
			select2.value = "<?php echo $sistem_dil;  ?>";
			select3.value = "<?php echo $sistem_dil;  ?>";
		<?php } ?>

		<?php if( isset($_REQUEST['sistem_dil'] )){ ?>
			select.value = "<?php echo $_REQUEST['sistem_dil'];  ?>";
			select2.value = "<?php echo $_REQUEST['sistem_dil'];  ?>";
			select3.value = "<?php echo $_REQUEST['sistem_dil'];  ?>";
		<?php } ?>

		select.dispatchEvent(new Event('change'));

		function dil_degistir(eleman){
			var dil_id = eleman.value;
			<?php if( $islem == "icerik_guncelle" ){ ?>
				document.getElementById("baslik").value = (document.getElementById("baslik_"+dil_id)) ? document.getElementById("baslik_"+eleman.value).value : "";

				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				window.editor.data.set((document.getElementById("icerik_"+dil_id)) ? document.getElementById("icerik_"+eleman.value).value : "");

				//(document.getElementsByName("icerik"+dil)[0].value);
			<?php } ?>
		}
		function dil_degistir_tab(eleman){
			$(".tabliste").addClass("d-none");
			$("#liste"+eleman.value).removeClass("d-none");
			$("#tab_dil_hidden").val(eleman.value);
		}
		function dil_degistir_sss(eleman){
			$(".sssliste").addClass("d-none");
			$("#sssliste"+eleman.value).removeClass("d-none");
			$("#sss_dil_hidden").val(eleman.value);
		}
		function dil_degistir_personel(eleman){
			//alert("<?php echo $islem; ?>");
			if( eleman.value == "_tr" ) dil = ""; else dil = eleman.value;
				document.getElementById("personel_adi").value = document.getElementById("personel_form").elements.namedItem("personel_adi"+dil+"_hidden").value;
				document.getElementById("personel_gorev").value = document.getElementById("personel_form").elements.namedItem("personel_gorev"+dil+"_hidden").value;
				document.getElementById("personel_email").value = document.getElementById("personel_form").elements.namedItem("personel_email"+dil+"_hidden").value;
				document.getElementById("personel_tel").value = document.getElementById("personel_form").elements.namedItem("personel_tel"+dil+"_hidden").value;
				document.getElementById("personel_dahili").value = document.getElementById("personel_form").elements.namedItem("personel_dahili"+dil+"_hidden").value;

		}
        function dil_degistir_sayfa_duzenle(eleman){
            var dil_id = eleman.value;


			if( document.getElementById("aktif_"+dil_id) && document.getElementById("aktif_"+dil_id).value == "1" )
				document.getElementById("aktif").checked = true;
			else
				document.getElementById("aktif").checked = false;

			document.getElementById("kategori_ad_duzenle").value = (document.getElementById("adi_"+dil_id)) ? document.getElementById("adi_"+eleman.value).value : "";
				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				//window.editor.data.set(document.getElementsByName("icerik"+dil)[0].value);
		}


	</script>
<script>
/* Kullanıcı resmine tıklayınca file nesnesini tetikle*/
$( function() {
	$( "#personel_kullanici_resim" ).click( function() {
		$( "#gizli_input_file" ).trigger( 'click' );
	});
});

/* Seçilen resim önizle */
function resimOnizle( input ) {
	if ( input.files && input.files[ 0 ] ) {
		var reader = new FileReader();
		reader.onload = function ( e ) {
			$( '#personel_kullanici_resim' ).attr( 'src', e.target.result );
		};
		reader.readAsDataURL( input.files[ 0 ] );
	}
}
</script>
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