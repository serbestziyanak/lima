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

$SQL_tum_onemli_baglantilar = <<< SQL
SELECT 
	*
FROM 
	tb_onemli_baglantilar
SQL;

$SQL_tek_onemli_baglanti_oku = <<< SQL
SELECT 
	*
FROM 
	tb_onemli_baglantilar
WHERE 
	id = ?
SQL;

$onemli_baglantilar		= $vt->select( $SQL_tum_onemli_baglantilar, array( ) )[ 2 ];
@$tek_onemli_baglanti 	= $vt->select( $SQL_tek_onemli_baglanti_oku, array( $id ) )[ 2 ][ 0 ];

?>




<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">
				<div class="card card-secondary" id = "card_onemli_baglantilar">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Önemli Bağlantılar", $dizi_dil, $sistem_dil ); ?></h3>
						<div class = "card-tools">
							<button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
							<a id = "yeni_fakulte" data-toggle = "tooltip" title = "Yeni Üviversite Ekle" href = "?modul=onemli_baglantilar&islem=ekle" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
						</div>
					</div>
					<div class="card-body">
						<table id="tbl_onemli_baglantilar" class="table table-bordered table-hover table-sm" width = "100%" >
							<thead>
								<tr>
									<th style="width: 15px">#</th>
									<th><?php echo dil_cevir( "Foto", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Link", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $sayi = 1; foreach( $onemli_baglantilar AS $onemli_baglanti ) { ?>
								<tr oncontextmenu="fun();" class =" <?php if( $onemli_baglanti[ 'id' ] == $id ) echo $satir_renk; ?>" data-id="<?php echo $onemli_baglanti[ 'id' ]; ?>">
									<td><?php echo $sayi++; ?></td>
									<td><img src="resimler/logolar/<?php echo $onemli_baglanti[ 'foto' ]; ?>" height="100"></td>
									<td><?php echo $onemli_baglanti[ 'link' ]; ?></td>
									<td align = "center">
										<a modul = 'onemli_baglantilar' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=onemliBaglantilar&islem=guncelle&id=<?php echo $onemli_baglanti[ 'id' ]; ?>" >
											<?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
										</a>
									</td>
									<td align = "center">
										<button modul= 'onemli_baglantilar' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/onemliBaglantilar/onemliBaglantilarSEG.php?islem=sil&id=<?php echo $onemli_baglanti[ 'id' ]; ?>" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<form class="form-horizontal" action = "_modul/onemliBaglantilar/onemliBaglantilarSEG.php" method = "POST" enctype="multipart/form-data">
					<div class="card card-secondary">
						<div class="card-header p-2">
							<h3 class='card-title'><?php echo dil_cevir( "Önemli Bağlantı Ekle / Düzenle", $dizi_dil, $sistem_dil ); ?></h3>
						</div>
						<div class="card-body">
								<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
								<input type = "hidden" name = "id" value = "<?php echo $id; ?>">
                                <div class="form-group">
                                    <label class="control-label"><?php echo dil_cevir( "Foto", $dizi_dil, $sistem_dil ); ?></label>
                                    <input type="file" name="foto" class="" ><br>
                                </div>
                                <?php if( $islem == "guncelle" ){ ?>
                                <div class="form-group">
                                    <label class="control-label"><?php echo dil_cevir( "Var olan görsel", $dizi_dil, $sistem_dil ); ?></label><br>
                                    <img src="resimler/logolar/<?php echo $tek_onemli_baglanti[ 'foto' ]; ?>" width="200">
                                </div>
                                <?php } ?>

								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Link", $dizi_dil, $sistem_dil ); ?> (TR)</label>
									<input type="text" class="form-control" name ="link" value = "<?php echo $tek_onemli_baglanti[ "link" ]; ?>"  autocomplete="off">
								</div>
						</div>
						<div class="card-footer">
							<button modul= 'onemliBaglantilar' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span><?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">


var tbl_onemli_baglantilar = $( "#tbl_onemli_baglantilar" ).DataTable( {
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
} ).buttons().container().appendTo('#tbl_onemli_baglantilar_wrapper .col-md-6:eq(0)');



$('#card_onemli_baglantilar').on('maximized.lte.cardwidget', function() {
	var tbl_onemli_baglantilar = $( "#tbl_onemli_baglantilar" ).DataTable();
	var column = tbl_onemli_baglantilar.column(  tbl_onemli_baglantilar.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_onemli_baglantilar.column(  tbl_onemli_baglantilar.column.length - 2 );
	column.visible( ! column.visible() );
});

$('#card_onemli_baglantilar').on('minimized.lte.cardwidget', function() {
	var tbl_onemli_baglantilar = $( "#tbl_onemli_baglantilar" ).DataTable();
	var column = tbl_onemli_baglantilar.column(  tbl_onemli_baglantilar.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_onemli_baglantilar.column(  tbl_onemli_baglantilar.column.length - 2 );
	column.visible( ! column.visible() );
} );



</script>