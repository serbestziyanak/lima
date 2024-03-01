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


$islem			= array_key_exists( 'islem'		,$_REQUEST )  ? $_REQUEST[ 'islem' ]	 : 'ekle';
$id    			= array_key_exists( 'id'	,$_REQUEST )  ? $_REQUEST[ 'id' ]	 : 0;
$birim_id		= array_key_exists( 'birim_id' ,$_REQUEST ) ? $_REQUEST[ 'birim_id' ]	: 0;
$birim_adi		= array_key_exists( 'birim_adi' ,$_REQUEST ) ? $_REQUEST[ 'birim_adi' ]	: "";
$birim_id = 1;
$_REQUEST['birim_id'] = 1;
$satir_renk				= $id > 0	? 'table-warning'						: '';
$kaydet_buton_yazi		= $id > 0	? 'Güncelle'							: 'Kaydet';
$kaydet_buton_cls		= $id > 0	? 'btn btn-warning btn-sm pull-right'	: 'btn btn-success btn-sm pull-right';

include "_modul/birim_agaci_getir.php";

$SQL_tum_duyurular = <<< SQL
SELECT 
	h.*
    ,d.adi as dil_adi
FROM 
	tb_duyurular AS h
LEFT JOIN tb_diller AS d ON d.id = h.dil_id 
WHERE 
	birim_id = ?
ORDER BY id DESC
SQL;

$SQL_tek_duyuru_oku = <<< SQL
SELECT 
	*
FROM 
	tb_duyurular
WHERE 
	id = ? 
SQL;


$SQL_birimler = <<< SQL
SELECT 
	*
FROM 
	birimler
Group by f4
SQL;

$SQL_birimler2 = <<< SQL
SELECT 
	*
FROM 
	birimler
WHERE f4 = ?
Group by b4
SQL;

$SQL_birimler3 = <<< SQL
SELECT 
	*
FROM 
	birimler
WHERE f4 = ? and b4 = ? and e4 = ?
Group by p4
SQL;

$SQL_galeri = <<< SQL
SELECT 
	*
FROM 
	tb_duyuru_galeri
WHERE 
	duyuru_id = ? 
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
@$galeri     		= $vt->select( $SQL_galeri, array( $id ) )[ 2 ];
$duyurular			= $vt->select( $SQL_tum_duyurular, 	array( $birim_id ) )[ 2 ];
@$tek_duyuru 		= $vt->selectSingle( $SQL_tek_duyuru_oku, array( $id ) )[ 2 ];

/*
//Hangi birimlere sayfa atılacak.
$SQL_fakulteler = <<< SQL
SELECT
	*
FROM 
	tb_birim_agaci
WHERE id = 378
SQL;


//şablondaki hangi birimin sayfaları kopyalanacak.
$SQL_birim_sayfalari_sablon = <<< SQL
SELECT
	*
FROM 
	tb_birim_sayfalari_sablon
WHERE birim_id = 55 ORDER BY ust_id
SQL;

$SQL_ekle = <<< SQL
INSERT INTO
	tb_birim_sayfalari
SET
	 birim_id = ?
	,ust_id = ?
	,adi = ?
	,kisa_ad = ?
	,kategori = ?
	,sira = ?
	,link = ?
	,link_url = ?
	,harici = ?
	,aktif = ?
	,adi_kz = ?
	,adi_en = ?
	,adi_ru = ?
SQL;


$fakulteler = $vt->select( $SQL_fakulteler, array(  ) )[ 2 ];
$birim_sayfalari_sablon = $vt->select( $SQL_birim_sayfalari_sablon, array(  ) )[ 2 ];
var_dump($fakulteler);

foreach( $fakulteler as $fakulte ){
	foreach( $birim_sayfalari_sablon as $birim_sayfalari_sablon_tek ){
		echo $birim_sayfalari_sablon_tek['adi'];
		if( $birim_sayfalari_sablon_tek['ust_id'] == 0 ){
			$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
				$fakulte['id']
				,$birim_sayfalari_sablon_tek['ust_id']
				,$birim_sayfalari_sablon_tek['adi']
				,$birim_sayfalari_sablon_tek['kisa_ad']
				,$birim_sayfalari_sablon_tek['kategori']
				,$birim_sayfalari_sablon_tek['sira']
				,$birim_sayfalari_sablon_tek['link']
				,$birim_sayfalari_sablon_tek['link_url']
				,$birim_sayfalari_sablon_tek['harici']
				,$birim_sayfalari_sablon_tek['aktif']
				,$birim_sayfalari_sablon_tek['adi_kz']
				,$birim_sayfalari_sablon_tek['adi_en']
				,$birim_sayfalari_sablon_tek['adi_ru']
			) );
			$last_id = $sorgu_sonuc[ 2 ];
			$ust_idler[$birim_sayfalari_sablon_tek['id']] = $last_id;
		}else{
			$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
				$fakulte['id']
				,$ust_idler[$birim_sayfalari_sablon_tek['ust_id']]
				,$birim_sayfalari_sablon_tek['adi']
				,$birim_sayfalari_sablon_tek['kisa_ad']
				,$birim_sayfalari_sablon_tek['kategori']
				,$birim_sayfalari_sablon_tek['sira']
				,$birim_sayfalari_sablon_tek['link']
				,$birim_sayfalari_sablon_tek['link_url']
				,$birim_sayfalari_sablon_tek['harici']
				,$birim_sayfalari_sablon_tek['aktif']
				,$birim_sayfalari_sablon_tek['adi_kz']
				,$birim_sayfalari_sablon_tek['adi_en']
				,$birim_sayfalari_sablon_tek['adi_ru']
			) );
		}
	}
}
*/




/*
$birimler			= $vt->select( $SQL_birimler, 	array( $birim_id ) )[ 2 ];
$fid = 8;
$eid = 1;
$bid = 1;
$pid = 1;
$ust_id = 1;
foreach( $birimler as $birim ){
	$ust_id = 4;
	echo $fid."|".$ust_id."|".$birim['f1']."|".$birim['f2']."|".$birim['f3']."|".$birim['f4']."|".$fn->kisa_ad_ver( $ust_id.' '.$birim[ 'f4' ] )."|1|0<br>";
	$ust_id = $fid;


	$birimler2 = $vt->select( $SQL_birimler2, 	array( $birim['f4'] ) );
	$birim_sayisi = $birimler2[3];
	$birimler2 = $birimler2[2];
		
	foreach( $birimler2 as $birim2 ){
		$fid++;
		echo $fid."|".$ust_id."|".$birim2['b1']."|".$birim2['b2']."|".$birim2['b3']."|".$birim2['b4']."|".$fn->kisa_ad_ver( $ust_id.' '.$birim2['b4'] )."|1|0<br>";
		$ust_id2 = $fid;

		$birimler3 = $vt->select( $SQL_birimler3, 	array( $birim['f4'], $birim2['b4'], "Lisans" ) );
		$birim_sayisi2 = $birimler3[3];
		$birimler3 = $birimler3[2];
		if( $birim_sayisi2>0 ){
			$fid++;
			echo $fid."|".$ust_id2."|Бакалавриат|Бакалавриат|Undergraduate|Lisans|lisans|1|1<br>";
			$ust_id3 = $fid;
			foreach( $birimler3 as $birim3 ){
				$fid++;
				echo $fid."|".$ust_id3."|".$birim3['p1']."|".$birim3['p2']."|".$birim3['p3']."|".$birim3['p4']."|".$fn->kisa_ad_ver( $ust_id3.' '.$birim3['p4'] )."|0|0|".$birim3['program_kodu']."<br>";
			}
		}

		$birimler3 = $vt->select( $SQL_birimler3, 	array( $birim['f4'], $birim2['b4'], "Yüksek Lisans" ) );
		$birim_sayisi2 = $birimler3[3];
		$birimler3 = $birimler3[2];
		if( $birim_sayisi2>0 ){
			$fid++;
			echo $fid."|".$ust_id2."|Магистратура|Магистратура|Master|Yüksek Lisans|yuksek-lisans|1|1<br>";
			$ust_id3 = $fid;
			foreach( $birimler3 as $birim3 ){
				$fid++;
				echo $fid."|".$ust_id3."|".$birim3['p1']."|".$birim3['p2']."|".$birim3['p3']."|".$birim3['p4']."|".$fn->kisa_ad_ver( $ust_id3.' '.$birim3['p4'] )."|0|0|".$birim3['program_kodu']."<br>";
			}
		}

		$birimler3 = $vt->select( $SQL_birimler3, 	array( $birim['f4'], $birim2['b4'], "Doktora" ) );
		$birim_sayisi2 = $birimler3[3];
		$birimler3 = $birimler3[2];
		if( $birim_sayisi2>0 ){
			$fid++;
			echo $fid."|".$ust_id2."|Докторантура|Докторантура|PhD|Doktora|doktora|1|1<br>";
			$ust_id3 = $fid;
			foreach( $birimler3 as $birim3 ){
				$fid++;
				echo $fid."|".$ust_id3."|".$birim3['p1']."|".$birim3['p2']."|".$birim3['p3']."|".$birim3['p4']."|".$fn->kisa_ad_ver( $ust_id3.' '.$birim3['p4'] )."|0|0|".$birim3['program_kodu']."<br>";
			}
		}

		$birimler3 = $vt->select( $SQL_birimler3, 	array( $birim['f4'], $birim2['b4'], "Tıpta Uzmanlık" ) );
		$birim_sayisi2 = $birimler3[3];
		$birimler3 = $birimler3[2];
		if( $birim_sayisi2>0 ){
			$fid++;
			echo $fid."|".$ust_id2."|Резидентура|Резидентура|Medical Specialty|Tıpta Uzmanlık|tipta-uzmanlik|1|1<br>";
			$ust_id3 = $fid;
			foreach( $birimler3 as $birim3 ){
				$fid++;
				echo $fid."|".$ust_id3."|".$birim3['p1']."|".$birim3['p2']."|".$birim3['p3']."|".$birim3['p4']."|".$fn->kisa_ad_ver( $ust_id3.' '.$birim3['p4'] )."|0|0|".$birim3['program_kodu']."<br>";
			}
		}

	}



$fid++;
}
*/

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
			<?php if( !isset($_REQUEST['birim_id']) ){ ?>
			<div class="col-md-4 p-0">
				<div class="card card-secondary">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Birimler", $dizi_dil, $sistem_dil ); ?></h3>
					</div>
					<div class="card-body p-0">
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

			<div class="col-md-4">
				<div class="card card-secondary" id = "card_duyurular">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Duyurular", $dizi_dil, $sistem_dil ); ?></h3>
						<div class = "card-tools">
							<button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
							<a id = "yeni_duyuru" data-toggle = "tooltip" title = "Yeni Duyuru Ekle" href = "?modul=duyurular&islem=ekle&birim_id=<?php echo $birim_id; ?>&birim_adi=<?php echo $birim_adi; ?>" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
						</div>
					</div>
					<div class="card-body">
						<table id="tbl_duyurular" class="table table-bordered table-hover table-sm" width = "100%" >
							<thead>
								<tr>
									<th style="width: 15px">#</th>
									<th><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$sayi = 1; 
									$dil = $sistem_dil == "_tr" ? "" : $sistem_dil ;
									foreach( $duyurular AS $duyuru ) { 
								?>
								<tr oncontextmenu="fun();" class ="duyuru-Tr <?php if( $duyuru[ 'id' ] == $id ) echo $satir_renk; ?>" data-id="<?php echo $duyuru[ 'id' ]; ?>">
									<td><?php echo $sayi++; ?></td>
									<td><?php echo $duyuru[ 'dil_adi'.$dil ]; ?></td>
									<td><?php echo $duyuru[ 'baslik'.$dil ]; ?></td>
									<td align = "center">
										<a modul = 'duyurular' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=duyurular&islem=guncelle&id=<?php echo $duyuru[ 'id' ]; ?>&birim_id=<?php echo $birim_id; ?>&birim_adi=<?php echo $birim_adi; ?>" >
											<?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
										</a>
									</td>
									<td align = "center">
										<button modul= 'duyurular' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/duyurular/duyurularSEG.php?islem=sil&id=<?php echo $duyuru[ 'id' ]; ?>&birim_id=<?php echo $birim_id; ?>&birim_adi=<?php echo $birim_adi; ?>" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php } ?>
			<div class="col-md-8">
				<div class="card <?php if( $id == 0 ) echo 'card-secondary' ?>">
					<div class="card-header p-2">
						<ul class="nav nav-pills tab-container">
							<?php if( $id > 0 ) { ?>
								<h6 style = 'font-size: 1rem;'> &nbsp;&nbsp;&nbsp; <?php echo dil_cevir( "Duyuru Düzenle", $dizi_dil, $sistem_dil ); ?></h6>
							<?php } else { ?>

								<h6 style = 'font-size: 1rem;'> &nbsp;&nbsp;&nbsp; <?php echo dil_cevir( "Duyuru Ekle", $dizi_dil, $sistem_dil ); ?></h6>
							<?php	}
							?>
							
						</ul>
					</div>
					<div class="card-body">
						<?php if( $birim_id > 0 ){ ?>
						<div class="tab-content">
							<!-- GENEL BİLGİLER -->
							<div class="tab-pane active" id="_genel">
								<form class="form-horizontal" action = "_modul/duyurular/duyurularSEG.php" method = "POST" enctype="multipart/form-data">
									<?php foreach( array_keys($tek_duyuru) as $anahtar ){ ?>
									<input type="hidden"  name="<?php echo $anahtar;  ?>" value="<?php echo htmlentities($tek_duyuru[$anahtar]);  ?>">
									<?php } ?>
									<div class="form-group">
										<label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
										<select class="form-control select2" name = "dil_id" required>
											<?php foreach( $diller AS $result ){ ?>
											<option value="<?php echo $result["id"] ?>" <?php if( $tek_duyuru['dil_id'] == $result["id"] ) echo "selected"; ?> ><?php echo $result["adi".$dil] ?></option>
											<?php } ?>
										</select>
									</div>

									<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
									<input type = "hidden" name = "id" value = "<?php echo $id; ?>">
									<input type = "hidden" name = "birim_id" value = "<?php echo $birim_id; ?>">
									<input type = "hidden" name = "birim_adi" value = "<?php echo $birim_adi; ?>">
                                    
									<div class="form-group">
										<label class="control-label"><?php echo dil_cevir( "Foto", $dizi_dil, $sistem_dil ); ?></label>
										<input type="file" name="foto" class="" ><br>
										<small class="text-muted"><?php echo dil_cevir( "Eklediğiniz görsel 1000x600 boyutlarında olmalıdır.", $dizi_dil, $sistem_dil ); ?> </small>
									</div>
									<?php if( $islem == "guncelle" ){ ?>
									<div class="form-group">
										<label class="control-label"><?php echo dil_cevir( "Var olan görsel", $dizi_dil, $sistem_dil ); ?></label><br>
										<img src="resimler/duyurular/kucuk/<?php echo $tek_duyuru[ 'foto' ]; ?>" width="200">
									</div>
									<?php } ?>
									<div class="form-group">
										<label class="control-label"><?php echo dil_cevir( "Tarih", $dizi_dil, $sistem_dil ); ?></label>
										<div class="input-group date" id="tarih" data-target-input="nearest">
											<div class="input-group-append" data-target="#tarih" data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
											<input required type="text" data-target="#tarih" data-toggle="datetimepicker" name="tarih" value="<?php if( $tek_duyuru[ 'tarih' ] !='' ){echo date('d.m.Y',strtotime($tek_duyuru[ 'tarih' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker1"/>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?></label>
										<input required type="text" class="form-control" id ="baslik" name ="baslik" value = "<?php echo $tek_duyuru[ "baslik" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group">
										<label class="control-label"><?php echo dil_cevir( "İçerik", $dizi_dil, $sistem_dil ); ?></label>
										<style>
										.ck-editor__editable_inline:not(.ck-comment__input *) {
											height: 600px;
											overflow-y: auto;
										}
										</style>

										<textarea id="editor" style="display:none" name="icerik"><?php echo @$tek_duyuru[ "icerik" ]; ?></textarea>
									</div>
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
                                    if( $islem == "guncelle" ){
                                        foreach( $galeri as $foto_galeri ){ 
                                    ?>
                                        <div class=" col-3">
                                            <div class="card ">
                                                <a href="resimler/duyurular/buyuk/<?php echo $foto_galeri['foto']; ?>" data-toggle="lightbox" data-title="" data-gallery="gallery">
                                                    <img class="card-img-top" src="resimler/duyurular/kucuk/<?php echo $foto_galeri['foto']; ?>" style="object-fit: cover; height: 250px;"   alt="white sample"/>
                                                </a>

                                                <div class="card-footer">
                                                    <button type="button" modul= 'duyurular' yetki_islem="sil" class="btn btn-danger foto_sil" data-url="_modul/duyurular/duyurularSEG.php" data-islem="foto_sil" data-foto="<?php echo $foto_galeri['foto']; ?>" data-duyuru_id="<?php echo $foto_galeri['duyuru_id']; ?>" data-foto_id="<?php echo $foto_galeri['id']; ?>" >
                                                    <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php 
                                        }
                                    } 
                                    ?>   
                                    </div>
									<div class="card-footer">
										<?php if( $birim_id >0 ){ ?>
										<button modul= 'duyurular' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
										<?php } ?>
									</div>
								</form>
							</div>
						</div>
                        <?php }else{ ?>
                            <div class="text-center" style="height:600px;">
                                <h2> <?php echo dil_cevir( "Lütfen Birim Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
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
		</div>
	</div>
</section>
<?php include "editor.php"; ?>

<script type="text/javascript">
	var simdi = new Date(); 
	$(function () {
		$('#tarih').datetimepicker({
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

var tbl_duyurular = $( "#tbl_duyurular" ).DataTable( {
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
} ).buttons().container().appendTo('#tbl_duyurular_wrapper .col-md-6:eq(0)');



$('#card_duyurular').on('maximized.lte.cardwidget', function() {
	var tbl_duyurular = $( "#tbl_duyurular" ).DataTable();
	var column = tbl_duyurular.column(  tbl_duyurular.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_duyurular.column(  tbl_duyurular.column.length - 2 );
	column.visible( ! column.visible() );
});

$('#card_duyurular').on('minimized.lte.cardwidget', function() {
	var tbl_duyurular = $( "#tbl_duyurular" ).DataTable();
	var column = tbl_duyurular.column(  tbl_duyurular.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_duyurular.column(  tbl_duyurular.column.length - 2 );
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
				document.getElementById("baslik").value = document.getElementsByName("baslik"+dil)[0].value;
				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				window.editor.data.set(document.getElementsByName("icerik"+dil)[0].value);
			<?php } ?>
		}
	</script>
<script>
    $('.foto_sil').on("click", function(e) { 
        var url      = $(this).data("url");
        var foto  = $(this).data("foto");
        var foto_id  = $(this).data("foto_id");
        var islem  = $(this).data("islem");
        var duyuru_id  = $(this).data("duyuru_id");
        
			$.ajax( {
				 url	: url
				,type	: "post"
				,data	: { 
					 foto_id	: foto_id
					,foto		: foto
					,islem		: islem
					,duyuru_id	: duyuru_id
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