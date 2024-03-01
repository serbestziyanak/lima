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
$kaydet_buton_yazi		= $id > 0	? 'Güncelle'							: 'Kaydet';
$kaydet_buton_cls		= $id > 0	? 'btn btn-warning btn-sm pull-right'	: 'btn btn-success btn-sm pull-right';

$SQL_tum_sozlesme_turleri = <<< SQL
SELECT 
	 *
FROM 
	tb_sozlesme_turleri
SQL;

$SQL_tek_sozlesme_turu_oku = <<< SQL
SELECT 
	*
FROM 
	tb_sozlesme_turleri
WHERE 
	id = ?
SQL;

$sozlesme_turleri		= $vt->select( $SQL_tum_sozlesme_turleri, array( ) )[ 2 ];
@$tek_sozlesme_turu 	= $vt->select( $SQL_tek_sozlesme_turu_oku, array( $id ) )[ 2 ][ 0 ];

?>



<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">
				<div class="card card-secondary" id = "card_sozlesme_turleri">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Sözleşme Türleri", $dizi_dil, $sistem_dil ); ?></h3>
						<div class = "card-tools">
							<button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
							<a id = "yeni_fakulte" data-toggle = "tooltip" title = "Yeni Üviversite Ekle" href = "?modul=sozlesmeTurleri&islem=ekle" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
						</div>
					</div>
					<div class="card-body">
						<table id="tbl_sozlesme_turleri" class="table table-bordered table-hover table-sm" width = "100%" >
							<thead>
								<tr>
									<th style="width: 15px">#</th>
									<th><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?> (KZ)</th>
									<th><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?> (EN)</th>
									<th><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?> (RU)</th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $sayi = 1; foreach( $sozlesme_turleri AS $sozlesme_turu ) { ?>
								<tr oncontextmenu="fun();" class =" <?php if( $sozlesme_turu[ 'id' ] == $id ) echo $satir_renk; ?>" data-id="<?php echo $sozlesme_turu[ 'id' ]; ?>">
									<td><?php echo $sayi++; ?></td>
									<td><?php echo $sozlesme_turu[ 'adi' ]; ?></td>
									<td><?php echo $sozlesme_turu[ 'adi_kz' ]; ?></td>
									<td><?php echo $sozlesme_turu[ 'adi_en' ]; ?></td>
									<td><?php echo $sozlesme_turu[ 'adi_ru' ]; ?></td>
									<td align = "center">
										<a modul = 'sozlesmeTurleri' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=sozlesmeTurleri&islem=guncelle&id=<?php echo $sozlesme_turu[ 'id' ]; ?>" >
											<?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
										</a>
									</td>
									<td align = "center">
										<button modul= 'sozlesmeTurleri' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/sozlesmeTurleri/sozlesmeTurleriSEG.php?islem=sil&id=<?php echo $sozlesme_turu[ 'id' ]; ?>" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<form class="form-horizontal" action = "_modul/sozlesmeTurleri/sozlesmeTurleriSEG.php" method = "POST" enctype="multipart/form-data">
					<div class="card card-secondary">
						<div class="card-header ">
							<h3 class='card-title'><?php echo dil_cevir( "Sözleşme Türü Ekle / Düzenle", $dizi_dil, $sistem_dil ); ?></h3>
						</div>
						<div class="card-body">
								<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
								<input type = "hidden" name = "id" value = "<?php echo $id; ?>">
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?> (TR)</label>
									<input required type="text" class="form-control form-control-sm " name ="adi" value = "<?php echo $tek_sozlesme_turu[ "adi" ]; ?>"  autocomplete="off">
								</div>
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?> (KZ)</label>
									<input type="text" class="form-control form-control-sm " name ="adi_kz" value = "<?php echo $tek_sozlesme_turu[ "adi_kz" ]; ?>"  autocomplete="off">
								</div>
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?> (EN)</label>
									<input type="text" class="form-control form-control-sm " name ="adi_en" value = "<?php echo $tek_sozlesme_turu[ "adi_en" ]; ?>"  autocomplete="off">
								</div>
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?> (RU)</label>
									<input type="text" class="form-control form-control-sm " name ="adi_ru" value = "<?php echo $tek_sozlesme_turu[ "adi_ru" ]; ?>"  autocomplete="off">
								</div>								
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "EPVO ID", $dizi_dil, $sistem_dil ); ?></label>
									<input type="text" class="form-control form-control-sm " name ="epvo_id" value = "<?php echo $tek_sozlesme_turu[ "epvo_id" ]; ?>"  autocomplete="off">
								</div>								
						</div>
						<div class="card-footer">
							<button modul= 'sozlesmeTurleri' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span><?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">


var tbl_sozlesme_turleri = $( "#tbl_sozlesme_turleri" ).DataTable( {
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
} ).buttons().container().appendTo('#tbl_sozlesme_turleri_wrapper .col-md-6:eq(0)');



$('#card_sozlesme_turleri').on('maximized.lte.cardwidget', function() {
	var tbl_sozlesme_turleri = $( "#tbl_sozlesme_turleri" ).DataTable();
	var column = tbl_sozlesme_turleri.column(  tbl_sozlesme_turleri.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_sozlesme_turleri.column(  tbl_sozlesme_turleri.column.length - 2 );
	column.visible( ! column.visible() );
});

$('#card_sozlesme_turleri').on('minimized.lte.cardwidget', function() {
	var tbl_sozlesme_turleri = $( "#tbl_sozlesme_turleri" ).DataTable();
	var column = tbl_sozlesme_turleri.column(  tbl_sozlesme_turleri.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_sozlesme_turleri.column(  tbl_sozlesme_turleri.column.length - 2 );
	column.visible( ! column.visible() );
} );



</script>