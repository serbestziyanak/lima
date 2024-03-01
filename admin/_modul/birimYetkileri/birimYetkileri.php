<?php
$fn	= new Fonksiyonlar();
$vt = new VeriTabani();


/* SEG dosyalarından gelen mesaj */
if( array_key_exists( 'sonuclar', $_SESSION ) ) {
	$mesaj								= $_SESSION[ 'sonuclar' ][ 'mesaj' ];
	$mesaj_turu							= $_SESSION[ 'sonuclar' ][ 'hata' ] ? 'kirmizi' 	: 'yesil';
	$_REQUEST[ 'personel_id' ]			= $_SESSION[ 'sonuclar' ][ 'id' ];
	unset( $_SESSION[ 'sonuclar' ] );
	echo "<script>mesajVer('$mesaj', '$mesaj_turu')</script>";
}


$islem						= array_key_exists( 'islem'		         ,$_REQUEST ) ? $_REQUEST[ 'islem' ]				: 'ekle';
$personel_id				= array_key_exists( 'personel_id' ,$_REQUEST ) ? $_REQUEST[ 'personel_id' ]	: 0;


$satir_renk					= $personel_id > 0	? 'table-warning'						: '';
$kaydet_buton_yazi			= $personel_id > 0	? 'Güncelle'							: 'Kaydet';
$kaydet_buton_cls			= $personel_id > 0	? 'btn btn-warning btn-sm pull-right'	: 'btn btn-success btn-sm pull-right';
$kaydet_buton_yetki_islem	= $personel_id > 0	? 'guncelle'									: 'kaydet';



$SQL_tum_personeller = <<< SQL
SELECT 
	 p.*
	,CONCAT( p.adi, ' ', p.soyadi ) AS adi_soyadi
	,ba.adi as birim_adi
FROM 
	tb_personeller AS p
LEFT JOIN tb_birim_agaci AS ba ON ba.id = p.birim_id
ORDER BY p.adi ASC
SQL;



$SQL_tum_personeller2 = <<< SQL
SELECT 
	p.*,
	CONCAT( p.adi, ' ', p.soyadi ) AS adi_soyadi
FROM 
	tb_personeller AS p
WHERE 
	p.id = ?
ORDER BY p.adi ASC
SQL;



$SQL_tek_personel_oku = <<< SQL
SELECT 
	p.*
	,CONCAT( p.adi, ' ', p.soyadi ) AS adi_soyadi
	,p.foto
FROM 
	tb_personeller as p
WHERE 
	p.id = ? 
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





$personeller					= $vt->select( $SQL_tum_personeller, array(  ) )[ 2 ];

$uzmanlik_dallari			= $vt->select( $SQL_uzmanlik_dallari, array(  ) )[ 2 ];
@$tek_personel				= $vt->select( $SQL_tek_personel_oku, array( $personel_id ) )[ 2 ][ 0 ];
$alt_idler					= $vt->select( $SQL_alt_id_getir, array( $tek_personel['birim_id'] ) )[ 2 ];

foreach( explode(",",$tek_personel['birim_idler']) as $birim_id ){
    $ust_idler = $vt->select( $SQL_ust_id_getir, array( $birim_id ) )[ 2 ];
    foreach($ust_idler as $ust_id) 
        $ust_id_dizi[] = $ust_id['ust_id'];
}

foreach($alt_idler as $alt_id) 
	$ust_id_dizi[] = $alt_id['ust_id'];

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
					</div>
					<div class="card-body">
						<table id="tbl_personeller" class="table table-bordered table-hover table-sm" width = "100%" >
							<thead>
								<tr>
									<th style="width: 15px">#</th>
									<th><?php echo dil_cevir( "In No", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Adı Soyadı", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Yetkili Olduğu Birimler", $dizi_dil, $sistem_dil ); ?></th>
									<!--th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Profil", $dizi_dil, $sistem_dil ); ?></th-->
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $sayi = 1; foreach( $personeller AS $personel ) { ?>
								<tr oncontextmenu="fun();" class ="ogretim_elemanlari-Tr <?php if( $personel[ 'id' ] == $personel_id ) echo $satir_renk; ?>" data-id="<?php echo $personel[ 'id' ]; ?>">
									<td><?php echo $sayi++; ?></td>
									<td><?php echo $personel[ 'in_no' ]; ?></td>
									<td><?php echo $personel[ 'adi_soyadi' ]; ?></td>
									<td>
									<?php 
										$where_yetkili_birimler = "WHERE id IN (".$personel[ 'birim_idler' ].")";
										$SQL_yetkili_birimler = <<< SQL
										SELECT
											*
										FROM 
											tb_birim_agaci
										$where_yetkili_birimler
										SQL;
										$yetkili_birimler = $vt->select( $SQL_yetkili_birimler, array(  ) )[ 2 ];
										foreach( $yetkili_birimler as $yetkili_birim )
											echo "<span class='badge badge-primary'>".$yetkili_birim['adi']."</span> ";					
									?>
									</td>
									<!--td align = "center">
										<a modul = 'personeller' yetki_islem="profil_goster" class="text-olive" href = "?modul=personelProfil&personel_id=<?php echo $personel[ 'id' ]; ?>" >
											<h5><i class="fas fa-id-card"></i></h5>
										</a>
									</td-->
									<td align = "center">
										<a modul = 'birimYetkileri' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=birimYetkileri&islem=guncelle&personel_id=<?php echo $personel[ 'id' ]; ?>" >
											<?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
										</a>
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
					<form class="form-horizontal" action = "_modul/birimYetkileri/birimYetkileriSEG.php" method = "POST" enctype="multipart/form-data">
						<div class="card-body">
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
									style="width:120px; "
									src="<?php echo $resim_src; ?>" 
									alt="User profile picture"
									>
								<h3 class="profile-username text-center"><?php echo $tek_personel[ "adi_soyadi" ]; ?></h3>

							</div>
							<br><h5 class="float-right text-olive"><?php echo dil_cevir( "Birim", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
							<div class="form-group ">
								<label  class="control-label"><?php echo dil_cevir( "Birimler", $dizi_dil, $sistem_dil ); ?></label>
								<div class="overflow-auto" >
									<table class="table table-sm table-hover ">
									<tbody>
										<?php
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
														
														if( in_array( $kategori['id'], explode( ",", $gelen_birim_id ) ) ){
															$secili = "checked";
														}else{
															$secili = "";
														}

														if( $kategori['kategori'] == 0){
															$html .= "
																	<tr>
																		<td class=' bg-renk7' >
																			<input type='checkbox' class='item_$kategori[ust_id]' id='icheck_$kategori[id]' name='birim_idler[]' value='$kategori[id]' $secili  onclick='event.stopPropagation();'>
																			$kategori[adi]
																		</td>
																	</tr>";									

														}
														if( $kategori['kategori'] == 1 ){
															if( in_array( $kategori['id'], $ust_id_dizi ) )
																$agac_acik = "true";
															else
																$agac_acik = "false";

															// if( $kategori['ust_id'] == 0 )
															// 	$agac_acik = "true";
															// else
															// 	$agac_acik = "false";

																$html .= "
																		<tr data-widget='expandable-table' aria-expanded='$agac_acik' class='border-0'>
																			<td class='bg-renk$renk'>																
																			<input type='checkbox' data-id='$kategori[id]' class='kategori item_$kategori[ust_id]' id='icheck_$kategori[id]' name='birim_idler[]' value='$kategori[id]' $secili   onclick='event.stopPropagation();sec(this)'>
																			$kategori[adi]
																			<i class='expandable-table-caret fas fa-caret-right fa-fw'></i>
																			</td>
																		</tr>
																	";								
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
												echo kategoriListele3($birim_agacilar,0,0, $vt, $tek_personel[ "birim_idler" ], $ust_id_dizi, $sistem_dil);
											

										?>
									</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button modul= 'birimYetkileri' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</section>
<script>

function sec(eleman){
	if( eleman.checked == 1 )
		var deger=1;
	else
		var deger=0;
	var cl = "item_"+eleman.getAttribute("data-id");
	for(var k =0; k < document.getElementsByClassName(cl).length; k++){
		document.getElementsByClassName(cl)[k].checked=deger;
		sec(document.getElementsByClassName(cl)[k]);
	}
}


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
				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				//window.editor.data.set(document.getElementsByName("icerik"+dil)[0].value);
			<?php } ?>
		}
	</script>
