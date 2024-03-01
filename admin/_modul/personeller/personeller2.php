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


$islem						= array_key_exists( 'islem'		         ,$_REQUEST ) ? $_REQUEST[ 'islem' ]				: 'ekle';
$personel_id				= array_key_exists( 'personel_id' ,$_REQUEST ) ? $_REQUEST[ 'personel_id' ]	: 0;

if( $_SESSION[ 'kullanici_turu' ] == "personel" and $_SESSION['rol_id'] == 1 ){
	if( $personel_id != $_SESSION[ 'kullanici_id' ] )
		$personel_id		= "";
}

$satir_renk					= $personel_id > 0	? 'table-warning'						: '';
$kaydet_buton_yazi			= $personel_id > 0	? 'Güncelle'							: 'Kaydet';
$kaydet_buton_cls			= $personel_id > 0	? 'btn btn-warning btn-sm pull-right'	: 'btn btn-success btn-sm pull-right';
$kaydet_buton_yetki_islem	= $personel_id > 0	? 'guncelle'									: 'kaydet';

$where="WHERE aktif = 1 ";
if( $_SESSION['super'] != 1 and $_SESSION['rol_id'] != 1 )
$where = "AND birim_id IN (".$_SESSION[ 'birim_idler' ].")";
//echo $_SESSION['birim_idler'];

$SQL_tum_personeller = <<< SQL
SELECT 
	p.*
	,CONCAT( p.adi, ' ', p.soyadi ) AS adi_soyadi
	,ba.adi as birim_adi
FROM 
	tb_personeller AS p
LEFT JOIN tb_birim_agaci AS ba ON ba.id = p.birim_id
$where
ORDER BY p.adi ASC
SQL;

$SQL_tum_personeller2 = <<< SQL
SELECT 
	p.*,
	CONCAT( p.adi, ' ', p.soyadi ) AS adi_soyadi
FROM 
	tb_personeller AS p
WHERE 
	p.id = ? AND aktif = 1
ORDER BY p.adi ASC
SQL;



$SQL_tek_personel_oku = <<< SQL
SELECT 
	*
FROM 
	tb_personeller
WHERE 
	id 				= ? AND
	aktif 			= 1 
SQL;

/*Üniversiteye Ait uzmanlik Dalını Listele*/
$SQL_uzmanlik_dallari = <<< SQL
SELECT
	*
FROM
	tb_uzmanlik_dallari
WHERE
	aktif 		  	= 1
SQL;

$SQL_uyruklar = <<< SQL
SELECT
	 *
FROM
	tb_uyruklar
ORDER BY sira
SQL;

$SQL_kan_gruplari = <<< SQL
SELECT
	 *
FROM
	tb_kan_gruplari
ORDER BY sira
SQL;

$SQL_egitim_duzeyleri = <<< SQL
SELECT
	 *
FROM
	tb_egitim_duzeyleri
ORDER BY sira
SQL;

$SQL_unvanlar = <<< SQL
SELECT
	 *
FROM
	tb_unvanlar
ORDER BY sira
SQL;

$SQL_personel_nitelikleri = <<< SQL
SELECT
	 *
FROM
	tb_personel_nitelikleri
SQL;

$SQL_personel_turleri = <<< SQL
SELECT
	 *
FROM
	tb_personel_turleri
SQL;

$SQL_birim_agaci_getir = <<< SQL
SELECT
	*
FROM 
	tb_birim_agaci
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

@$birim_agacilar 		= $vt->select($SQL_birim_agaci_getir, array(  ) )[ 2 ];
$uyruklar				= $vt->select( $SQL_uyruklar, array(  ) )[ 2 ];
$kan_gruplari			= $vt->select( $SQL_kan_gruplari, array(  ) )[ 2 ];
$egitim_duzeyleri		= $vt->select( $SQL_egitim_duzeyleri, array(  ) )[ 2 ];
$unvanlar				= $vt->select( $SQL_unvanlar, array(  ) )[ 2 ];
$personel_nitelikleri	= $vt->select( $SQL_personel_nitelikleri, array(  ) )[ 2 ];
$personel_turleri		= $vt->select( $SQL_personel_turleri, array(  ) )[ 2 ];




// if( $_SESSION[ 'kullanici_turu' ] == "personel" ){
// 	$personeller					= $vt->select( $SQL_tum_personeller2, array( $_SESSION[ 'kullanici_id'] ) )[ 2 ];
// }else{
// 	$personeller					= $vt->select( $SQL_tum_personeller, array(  ) )[ 2 ];
// }

$personeller					= $vt->select( $SQL_tum_personeller, array(  ) )[ 2 ];
$uzmanlik_dallari			= $vt->select( $SQL_uzmanlik_dallari, array(  ) )[ 2 ];
@$tek_personel				= $vt->select( $SQL_tek_personel_oku, array( $personel_id ) )[ 2 ][ 0 ];		
$ust_idler					= $vt->select( $SQL_ust_id_getir, array( $tek_personel['birim_id'] ) )[ 2 ];
$alt_idler					= $vt->select( $SQL_alt_id_getir, array( $tek_personel['birim_id'] ) )[ 2 ];

foreach($ust_idler as $ust_id) 
	$ust_id_dizi[] = $ust_id['ust_id'];

foreach($alt_idler as $alt_id) 
	$alt_id_dizi[] = $alt_id['ust_id'];

//var_dump($ust_id_dizi);
?>

<div class="modal fade" id="sil_onay">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?php echo dil_cevir( "Lütfen Dikkat", $dizi_dil, $sistem_dil ); ?></h4>
			</div>
			<div class="modal-body">
				<p><?php echo dil_cevir( "Bu kaydı silmek istediğinize emin misiniz?", $dizi_dil, $sistem_dil ); ?></p>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dil_cevir( "Hayır", $dizi_dil, $sistem_dil ); ?></button>
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


<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">
				<div class="card card-olive" id = "card_personeller">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Personeller", $dizi_dil, $sistem_dil ); ?></h3>
						<div class = "card-tools">
							<button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
							<a modul= 'personeller' yetki_islem="ekle" id = "yeni_ogretim_elemanlari" data-toggle = "tooltip" title = "Yeni Personel Ekle" href = "?modul=personeller&islem=ekle" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
						</div>
					</div>
					<div class="card-body">
						<table id="tbl_personeller" class="table table-bordered table-hover table-sm" width = "100%" >
							<thead>
								<tr>
									<th style="width: 15px">#</th>
									<th><?php echo dil_cevir( "IIN No", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Adı Soyadı", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Birim", $dizi_dil, $sistem_dil ); ?></th>
									<!--th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Profil", $dizi_dil, $sistem_dil ); ?></th-->
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $sayi = 1; foreach( $personeller AS $personel ) { ?>
								<tr oncontextmenu="fun();" class ="ogretim_elemanlari-Tr <?php if( $personel[ 'id' ] == $personel_id ) echo $satir_renk; ?>" data-id="<?php echo $personel[ 'id' ]; ?>">
									<td><?php echo $sayi++; ?></td>
									<td><?php echo $personel[ 'in_no' ]; ?></td>
									<td><?php echo $personel[ 'adi_soyadi' ]; ?></td>
									<td><?php echo $personel[ 'birim_adi' ]; ?></td>
									<!--td align = "center">
										<a modul = 'personeller' yetki_islem="profil_goster" class="text-olive" href = "?modul=personelProfil&personel_id=<?php echo $personel[ 'id' ]; ?>" >
											<h5><i class="fas fa-id-card"></i></h5>
										</a>
									</td-->
									<td align = "center">
										<a modul = 'personeller' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=personeller&islem=guncelle&personel_id=<?php echo $personel[ 'id' ]; ?>" >
											<?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
										</a>
									</td>
									<td align = "center">
										<button modul= 'personeller' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/personeller/personellerSEG.php?islem=sil&personel_id=<?php echo $personel[ 'id' ]; ?>" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card card-secondary">
					<div class="card-header">
							<?php if( $personel_id > 0 ) { ?>
								<h3 class="card-title"><?php echo dil_cevir( "Personel Düzenle", $dizi_dil, $sistem_dil ); ?></h3>
							<?php } else { ?>
								<h3 class='card-title'><?php echo dil_cevir( "Personel Ekle", $dizi_dil, $sistem_dil ); ?></h3>
							<?php 
								}
							?>
							
					</div>
					<form class="form-horizontal" action = "_modul/personeller/personellerSEG.php" method = "POST" enctype="multipart/form-data">
						<div class="card-body">
							<?php foreach( array_keys($tek_personel) as $anahtar ){ ?>
							<input type="hidden"  name="<?php echo $anahtar;  ?>" value="<?php echo htmlentities($tek_personel[$anahtar]);  ?>">
							<?php } ?>

							<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
							<input type = "hidden" name = "personel_id" value = "<?php echo $personel_id; ?>">
							<input type = "hidden" name = "universite_id" value = "<?php echo $_SESSION['universite_id']; ?>">
							<?php
								if( $islem == "guncelle" ){
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
							<h3 class="profile-username text-center"><?php echo $tek_personel[ "adi" ]." ".$tek_personel[ "soyadi" ]; ?></h3>
							<input type="file" id="gizli_input_file" name = "input_personel_resim" style = "display:none;" name = "resim" accept="image/gif, image/jpeg, image/png"  onchange="resimOnizle(this)"; />

							<br><h5 class="float-right text-olive"><?php echo dil_cevir( "Birim", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
								<select class="form-control" name = "dil" id="dil" required onchange="dil_degistir(this);">
									<option value="_tr" <?php if( $_REQUEST['dil'] == "" ) echo "selected"; ?> >Türkçe</option>
									<option value="_kz" <?php if( $_REQUEST['dil'] == "_kz" ) echo "selected"; ?> >қазақ</option>
									<option value="_en" <?php if( $_REQUEST['dil'] == "_en" ) echo "selected"; ?> >English</option>
									<option value="_ru" <?php if( $_REQUEST['dil'] == "_ru" ) echo "selected"; ?> >Россия</option>
								</select>
							</div>

							<div class="form-group ">
								<label  class="control-label"><?php echo dil_cevir( "Birimler", $dizi_dil, $sistem_dil ); ?></label>
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

														if( $kategori['kategori'] == 0){
															$html .= "
																	<tr>
																		<td class=' bg-renk7' >
																				<div class='icheck-success d-inline'>
																					<input type='radio' class='form-control form-control-sm' id='icheck_$kategori[id]' name='birim_id' value='$kategori[id]' $secili required>
																					<label for='icheck_$kategori[id]' onclick='event.stopPropagation();'>
																					$kategori[adi]
																					</label>
																				</div>
																		</td>
																	</tr>";									

														}
														if( $kategori['kategori'] == 1 ){
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
																				$kategori[adi]
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
																					$kategori[adi]
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
												echo kategoriListele3($birim_agacilar,0,0, $vt, $tek_personel[ "birim_id" ], $ust_id_dizi, $sistem_dil);
											

										?>
									</tbody>
									</table>
								</div>
							</div>
							<br><h5 class="float-left text-olive"><?php echo dil_cevir( "Personel Bilgileri", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
							<div class="form-group">
								<label  class="control-label"><?php echo dil_cevir( "Personel Niteliği", $dizi_dil, $sistem_dil ); ?></label>
								<select class="form-control form-control-sm select2" name = "personel_nitelik_id" >
									<option><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
									<?php 
										foreach( $personel_nitelikleri AS $personel_nitelik ){
											echo '<option value="'.$personel_nitelik[ "id" ].'" '.( $tek_personel[ "personel_nitelik_id" ] == $personel_nitelik[ "id" ] ? "selected" : null) .'>'.$personel_nitelik[ "adi" ].'</option>';
										}

									?>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label"><?php echo dil_cevir( "Personel Türü", $dizi_dil, $sistem_dil ); ?></label>
								<select class="form-control form-control-sm select2" name = "personel_turu_id" >
									<option><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
									<?php 
										foreach( $personel_turleri AS $personel_turu ){
											echo '<option value="'.$personel_turu[ "id" ].'" '.( $tek_personel[ "personel_turu_id" ] == $personel_turu[ "id" ] ? "selected" : null) .'>'.$personel_turu[ "adi" ].'</option>';
										}

									?>
								</select>
							</div>
							<br><h5 class="float-left text-olive"><?php echo dil_cevir( "Kişisel Bilgiler", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
							<div class="form-group">
								<label  class="control-label"><?php echo dil_cevir( "Uyruk", $dizi_dil, $sistem_dil ); ?></label>
								<select class="form-control form-control-sm select2" name = "uyruk_id" >
									<option><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
									<?php 
										foreach( $uyruklar AS $uyruk ){
											echo '<option value="'.$uyruk[ "id" ].'" '.( $tek_personel[ "uyruk_id" ] == $uyruk[ "id" ] ? "selected" : null) .'>'.$uyruk[ "adi" ].' ('.$uyruk[ "kisa_ad" ].')</option>';
										}

									?>
								</select>
							</div>

							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "IIN Numarası", $dizi_dil, $sistem_dil ); ?></label>
								<input required type="text" placeholder="IIN Numarası" class="form-control form-control-sm" name ="in_no" value = "<?php echo $tek_personel[ "in_no" ]; ?>"  autocomplete="off">
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Vatandaşlık No", $dizi_dil, $sistem_dil ); ?></label>
								<input  type="text" placeholder="Vatandaşlık No" class="form-control form-control-sm" name ="vatandaslik_no" value = "<?php echo $tek_personel[ "vatandaslik_no" ]; ?>"  autocomplete="off">
							</div>

							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Pasaport No", $dizi_dil, $sistem_dil ); ?></label>
								<input  type="text" placeholder="Pasaport No" class="form-control form-control-sm" name ="pasaport_no" value = "<?php echo $tek_personel[ "pasaport_no" ]; ?>"  autocomplete="off">
							</div>
							<div class="form-group">
								<label  class="control-label"><?php echo dil_cevir( "Ünvan", $dizi_dil, $sistem_dil ); ?></label>
								<select class="form-control form-control-sm select2" name = "unvan_id" required>
									<option><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
									<?php 
										foreach( $unvanlar AS $unvan ){
											echo '<option value="'.$unvan[ "id" ].'" '.( $tek_personel[ "unvan_id" ] == $unvan[ "id" ] ? "selected" : null) .'>'.$unvan[ "adi" ].'</option>';
										}

									?>
								</select>
							</div>

							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></label>
								<input required type="text" placeholder="Adı" class="form-control form-control-sm" id ="adi" name ="adi" value = "<?php echo $tek_personel[ "adi".$dil ]; ?>"  autocomplete="off">
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Soyadı", $dizi_dil, $sistem_dil ); ?></label>
								<input required type="text" placeholder="Soyadı" class="form-control form-control-sm" id ="soyadi" name ="soyadi" value = "<?php echo $tek_personel[ "soyadi" ]; ?>"  autocomplete="off">
							</div>
							<div class="form-group card card-body">
								<label class="control-label"><?php echo dil_cevir( "Cinsiyet", $dizi_dil, $sistem_dil ); ?></label>
								<div class='icheck-danger d-inline '>
									<input type='radio' class='form-control form-control-sm' id='kadin' name='cinsiyet' value="1" <?php if( $tek_personel[ "cinsiyet" ] == 1 ) echo "checked"; ?> >
									<label for='kadin'>
										<?php echo dil_cevir( "Kadın", $dizi_dil, $sistem_dil ); ?>
									</label>
								</div>
								<div class='icheck-primary d-inline'>
									<input type='radio' class='form-control form-control-sm' id='erkek' name='cinsiyet' value="2" <?php if( $tek_personel[ "cinsiyet" ] == 2 ) echo "checked"; ?> >
									<label for='erkek'>
										<?php echo dil_cevir( "Erkek", $dizi_dil, $sistem_dil ); ?>
									</label>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Doğum Tarihi", $dizi_dil, $sistem_dil ); ?></label>
								<div class="input-group date" id="dogum_tarihi" data-target-input="nearest">
									<div class="input-group-append" data-target="#dogum_tarihi" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
									<input  type="text" data-target="#dogum_tarihi" data-toggle="datetimepicker" name="dogum_tarihi" value="<?php if( $tek_personel[ 'dogum_tarihi' ] !='' ){echo date('d.m.Y',strtotime($tek_personel[ 'dogum_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker1"/>
								</div>
							</div>
							<div class="form-group card card-body">
								<label class="control-label"><?php echo dil_cevir( "Medeni Durumu", $dizi_dil, $sistem_dil ); ?></label>
								<div class='icheck-primary d-inline '>
									<input type='radio' class='form-control form-control-sm' id='bekar' name='medeni_durumu' value="1" <?php if( $tek_personel[ "medeni_durumu" ] == 1 ) echo "checked"; ?> >
									<label for='bekar'>
										<?php echo dil_cevir( "Bekar", $dizi_dil, $sistem_dil ); ?>
									</label>
								</div>
								<div class='icheck-primary d-inline'>
									<input type='radio' class='form-control form-control-sm' id='evli' name='medeni_durumu' value="2" <?php if( $tek_personel[ "medeni_durumu" ] == 2 ) echo "checked"; ?> >
									<label for='evli'>
										<?php echo dil_cevir( "Evli", $dizi_dil, $sistem_dil ); ?>
									</label>
								</div>
							</div>

							<div class="form-group">
								<label  class="control-label"><?php echo dil_cevir( "Kan Grubu", $dizi_dil, $sistem_dil ); ?></label>
								<select class="form-control form-control-sm select2" name = "kan_grubu_id" >
									<option><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
									<?php 
										foreach( $kan_gruplari AS $kan_grubu ){
											echo '<option value="'.$kan_grubu[ "id" ].'" '.( $tek_personel[ "kan_grubu_id" ] == $kan_grubu[ "id" ] ? "selected" : null) .'>'.$kan_grubu[ "adi" ].'</option>';
										}

									?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Araç Plaka", $dizi_dil, $sistem_dil ); ?></label>
								<input  type="text" placeholder="Araç Plaka" class="form-control form-control-sm" name ="arac_plaka" value = "<?php echo $tek_personel[ "arac_plaka" ]; ?>"  autocomplete="off">
							</div>
							<br><h5 class="float-right text-olive"><?php echo dil_cevir( "Engel Bilgileri", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
							<div class="form-group card card-body">
								<label class="control-label"><?php echo dil_cevir( "Engel Durumu", $dizi_dil, $sistem_dil ); ?></label>
								<div class='icheck-primary d-inline '>
									<input type='radio' class='form-control form-control-sm' id='engel_yok' name='engel_durumu' value="1" <?php if( $tek_personel[ "engel_durumu" ] == 1 ) echo "checked"; ?> >
									<label for='engel_yok'>
										<?php echo dil_cevir( "Yok", $dizi_dil, $sistem_dil ); ?>
									</label>
								</div>
								<div class='icheck-primary d-inline'>
									<input type='radio' class='form-control form-control-sm' id='engel_var' name='engel_durumu' value="2" <?php if( $tek_personel[ "engel_durumu" ] == 2 ) echo "checked"; ?> >
									<label for='engel_var'>
										<?php echo dil_cevir( "Var", $dizi_dil, $sistem_dil ); ?>
									</label>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Engel Türü", $dizi_dil, $sistem_dil ); ?></label>
								<input  type="text" class="form-control form-control-sm" id ="engel_turu" name ="engel_turu" value = "<?php echo $tek_personel[ "engel_turu" ]; ?>"  autocomplete="off">
							</div>

							<br><h5 class="float-left text-olive"><?php echo dil_cevir( "Eğitim Bilgileri", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
							<div class="form-group">
								<label  class="control-label"><?php echo dil_cevir( "Eğitim Düzeyi", $dizi_dil, $sistem_dil ); ?></label>
								<select class="form-control form-control-sm select2" name = "egitim_duzeyi_id" >
									<option><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
									<?php 
										foreach( $egitim_duzeyleri AS $egitim_duzeyi ){
											echo '<option value="'.$egitim_duzeyi[ "id" ].'" '.( $tek_personel[ "egitim_duzeyi_id" ] == $egitim_duzeyi[ "id" ] ? "selected" : null) .'>'.$egitim_duzeyi[ "adi" ].'</option>';
										}

									?>
								</select>
							</div>

							<br><h5 class="float-right text-olive"><?php echo dil_cevir( "İletişim Bilgileri", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "GSM 1", $dizi_dil, $sistem_dil ); ?></label>
								<input  type="tel" class="form-control form-control-sm" name ="gsm1" value = "<?php echo $tek_personel[ "gsm1" ]; ?>"  data-inputmask='"mask": "+7(999) 999-9999"' data-mask autocomplete="off">
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "GSM 2", $dizi_dil, $sistem_dil ); ?></label>
								<input  type="tel" class="form-control form-control-sm" name ="gsm2" value = "<?php echo $tek_personel[ "gsm2" ]; ?>" placeholder="+90 532 532 3232" autocomplete="off">
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "İş Telefonu", $dizi_dil, $sistem_dil ); ?></label>
								<input  type="tel" class="form-control form-control-sm" name ="is_telefonu" value = "<?php echo $tek_personel[ "is_telefonu" ]; ?>"  data-inputmask='"mask": "+7(999) 999-9999"' data-mask autocomplete="off">
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?></label>
								<input required type="email" class="form-control form-control-sm" name ="email" value = "<?php echo $tek_personel[ "email" ]; ?>"  autocomplete="off">
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Ev Adresi", $dizi_dil, $sistem_dil ); ?></label>
								<textarea id="ev_adresi" name="ev_adresi" class="form-control form-control-sm" ><?php echo $tek_personel[ "ev_adresi" ]; ?></textarea>
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "İş Adresi", $dizi_dil, $sistem_dil ); ?></label>
								<textarea id="is_adresi" name="is_adresi" class="form-control form-control-sm" ><?php echo $tek_personel[ "is_adresi" ]; ?></textarea>
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Oda No", $dizi_dil, $sistem_dil ); ?></label>
								<input type="text"  name="oda_no" class="form-control form-control-sm" value="<?php echo $tek_personel[ "oda_no" ]; ?>">
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Orcid URL", $dizi_dil, $sistem_dil ); ?></label>
								<input type="text" name="orcid" class="form-control form-control-sm" value="<?php echo $tek_personel[ "orcid" ]; ?>">
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Google Scholar URL", $dizi_dil, $sistem_dil ); ?></label>
								<input type="text"  name="scholar" class="form-control form-control-sm" value="<?php echo $tek_personel[ "scholar" ]; ?>">
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Avesis URL", $dizi_dil, $sistem_dil ); ?></label>
								<input type="text"  name="avesis" class="form-control form-control-sm" value="<?php echo $tek_personel[ "avesis" ]; ?>">
							</div>
							<br><h5 class="float-left text-olive"><?php echo dil_cevir( "Sözleşme Bilgileri", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "İşe Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></label>
								<div class="input-group date" id="ise_baslama_tarihi" data-target-input="nearest">
									<div class="input-group-append" data-target="#ise_baslama_tarihi" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
									<input  type="text" data-target="#ise_baslama_tarihi" data-toggle="datetimepicker" name="ise_baslama_tarihi" value="<?php if( $tek_personel[ 'ise_baslama_tarihi' ] !='' ){echo date('d.m.Y',strtotime($tek_personel[ 'ise_baslama_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#ise_baslama_tarihi"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Sözleşme Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></label>
								<div class="input-group date" id="sozlesme_baslama_tarihi" data-target-input="nearest">
									<div class="input-group-append" data-target="#sozlesme_baslama_tarihi" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
									<input  type="text" data-target="#sozlesme_baslama_tarihi" data-toggle="datetimepicker" name="sozlesme_baslama_tarihi" value="<?php if( $tek_personel[ 'sozlesme_baslama_tarihi' ] !='' ){echo date('d.m.Y',strtotime($tek_personel[ 'sozlesme_baslama_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#sozlesme_baslama_tarihi"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Sözleşme Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></label>
								<div class="input-group date" id="sozlesme_bitis_tarihi" data-target-input="nearest">
									<div class="input-group-append" data-target="#sozlesme_bitis_tarihi" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
									<input type="text" data-target="#sozlesme_bitis_tarihi" data-toggle="datetimepicker" name="sozlesme_bitis_tarihi" value="<?php if( $tek_personel[ 'sozlesme_bitis_tarihi' ] !='' ){echo date('d.m.Y',strtotime($tek_personel[ 'sozlesme_bitis_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#sozlesme_bitis_tarihi"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Profil Kısa Açıklama", $dizi_dil, $sistem_dil ); ?></label>
								<textarea id="profil_kisa_aciklama" name="profil_kisa_aciklama" class="form-control form-control-sm" rows="4"><?php echo $tek_personel[ "profil_kisa_aciklama" ]; ?></textarea>
							</div>

                            <div class="card card-olive" >
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo dil_cevir( "Özgeçmiş", $dizi_dil, $sistem_dil ); ?></h3>
                                    <div class = "card-tools">
                                        <button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Özgeçmiş", $dizi_dil, $sistem_dil ); ?></label>
                                        <style>
                                        .ck-editor__editable_inline:not(.ck-comment__input *) {
                                            height: 600px;
                                            overflow-y: auto;
                                        }
                                        </style>

                                        <textarea id="editor" style="display:none" name="ozgecmis">
                                        <?php echo @$tek_personel[ "ozgecmis" ]; ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>

							<br><h5 class="float-right text-olive"><?php echo dil_cevir( "Şifre Değiştir", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Şifre", $dizi_dil, $sistem_dil ); ?></label>
								<input  type="password" minlength="6" class="form-control form-control-sm" name ="sifre" value = "<?php echo $tek_personel[ "sifre" ]; ?>"  autocomplete="off">
							</div>
						</div>
						<div class="card-footer">
							<button modul= 'personeller' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</section>

        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
				ckfinder: {
					uploadUrl: '/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
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
                placeholder: 'İçeriği buraya giriniz.',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
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
                    options: [ 10, 12, 14, 'default', 18, 20, 22 ],
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
                        addTargetToExternalLinks: true,
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
			.then( editor => {
				window.editor = editor;
			});
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
				return "Fakülte Listesi";
			}
		},
		{
			extend	: 'print',
			text	: 'Yazdır',
			exportOptions : {
				columns : ':visible'
			},
			title: function(){
				return "Fakülte Listesi";
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
				
				document.getElementById("adi").value = document.getElementsByName("adi"+dil)[0].value;
				document.getElementById("soyadi").value = document.getElementsByName("soyadi"+dil)[0].value;
				document.getElementById("engel_turu").value = document.getElementsByName("engel_turu"+dil)[0].value;
				document.getElementById("ev_adresi").value = document.getElementsByName("ev_adresi"+dil)[0].value;
				document.getElementById("is_adresi").value = document.getElementsByName("is_adresi"+dil)[0].value;
				document.getElementById("profil_kisa_aciklama").value = document.getElementsByName("profil_kisa_aciklama"+dil)[0].value;
				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				window.editor.data.set(document.getElementsByName("ozgecmis"+dil)[0].value);
			<?php } ?>
		}
	</script>
