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

$SQL_tum_fuar_tanimlari = <<< SQL
SELECT 
	 ft.*
     ,ftd.fuar_tanim_id
     ,ftd.dil_id
     ,ftd.adi
FROM 
	tb_fuar_tanimlari AS ft
LEFT JOIN tb_fuar_tanimlari_dil AS ftd ON ft.id = ftd.fuar_tanim_id
LEFT JOIN tb_diller AS dil ON dil.id = ftd.dil_id
WHERE ftd.dil_id = 1
SQL;

$SQL_tek_fuar_tanim_oku = <<< SQL
SELECT 
	 fk.*
     ,fkd.fuar_tanim_id
     ,fkd.dil_id
     ,fkd.adi
     ,dil.default_dil
     ,dil.id as dil_id
FROM 
	tb_fuar_tanimlari AS fk
LEFT JOIN tb_fuar_tanimlari_dil AS fkd ON fk.id = fkd.fuar_tanim_id
LEFT JOIN tb_diller AS dil ON dil.id = fkd.dil_id
WHERE fk.id = ?
SQL;

$SQL_diller = <<< SQL
SELECT
	*
FROM 
	tb_diller
WHERE aktif = 1
ORDER BY sira
SQL;

$SQL_fuar_kategorileri = <<< SQL
SELECT 
	 fk.*
     ,fkd.fuar_kategori_id
     ,fkd.dil_id
     ,fkd.adi
FROM 
	tb_fuar_kategorileri AS fk
LEFT JOIN tb_fuar_kategorileri_dil AS fkd ON fk.id = fkd.fuar_kategori_id
LEFT JOIN tb_diller AS dil ON dil.id = fkd.dil_id
WHERE fkd.dil_id = 1
SQL;

@$diller 		        = $vt->select( $SQL_diller, array(  ) )[ 2 ];
$fuar_tanimlari		    = $vt->select( $SQL_tum_fuar_tanimlari, array( ) )[ 2 ];
@$tek_fuar_tanimler 	= $vt->select( $SQL_tek_fuar_tanim_oku, array( $id ) )[ 2 ];
$fuar_kategorileri		= $vt->select( $SQL_fuar_kategorileri, array( ) )[ 2 ];

// var_dump($tek_fuar_tanimler);
foreach( $tek_fuar_tanimler as $result ){
    if( $result['dil_id'] == 1 ){
        $default_kayit = $result;
    }
    $hidden_kayitlar[] = $result;
}
?>



<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">
				<div class="card card-olive" id = "card_fuar_tanimlari">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Fuar Tanımları", $dizi_dil, $sistem_dil ); ?></h3>
						<div class = "card-tools">
							<button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
							<a data-toggle = "tooltip" title = "Yeni Kayıt Ekle" href = "?modul=fuarTanimlari&islem=ekle" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
						</div>
					</div>
					<div class="card-body">
						<table id="tbl_fuar_tanimlari" class="table table-bordered table-hover table-sm" width = "100%" >
							<thead>
								<tr>
									<th style="width: 15px">#</th>
									<th><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $sayi = 1; foreach( $fuar_tanimlari AS $fuar_tanim ) { ?>
								<tr oncontextmenu="fun();" class =" <?php if( $fuar_tanim[ 'id' ] == $id ) echo $satir_renk; ?>" data-id="<?php echo $fuar_tanim[ 'id' ]; ?>">
									<td><?php echo $sayi++; ?></td>
									<td><?php echo $fuar_tanim[ 'adi' ]; ?></td>
									<td align = "center">
										<a modul = 'fuarTanimlari' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=fuarTanimlari&islem=guncelle&id=<?php echo $fuar_tanim[ 'id' ]; ?>" >
											<?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
										</a>
									</td>
									<td align = "center">
										<button modul= 'fuarTanimlari' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/fuarTanimlari/fuarTanimlariSEG.php?islem=sil&id=<?php echo $fuar_tanim[ 'id' ]; ?>" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<form class="form-horizontal" action = "_modul/fuarTanimlari/fuarTanimlariSEG.php" method = "POST" enctype="multipart/form-data">
					<div class="card card-secondary">
						<div class="card-header">
							<h3 class='card-title'><?php echo dil_cevir( "Fuar Tanım Ekle / Düzenle", $dizi_dil, $sistem_dil ); ?></h3>
						</div>
						<div class="card-body">
									<?php 
                                    foreach( $hidden_kayitlar as $hidden_kayit ){ 
                                        foreach( array_keys($hidden_kayit) as $anahtar ){
                                    ?>
									<input type="hidden"  id="<?php echo $anahtar."_".$hidden_kayit['dil_id'];  ?>" value="<?php echo htmlentities($hidden_kayit[$anahtar]);  ?>">
									<?php }} ?>
								<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
								<input type = "hidden" name = "id" value = "<?php echo $id; ?>">
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
									<label class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></label>
									<input required type="text" class="form-control form-control-sm " id ="adi" name ="adi" value = "<?php echo $default_kayit[ "adi" ]; ?>"  autocomplete="off">
								</div>			
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Fuar Kategorileri", $dizi_dil, $sistem_dil ); ?></label>
                                    <select   class="form-control select2"  multiple="multiple" name = "fuar_kategori_idler[]" data-close-on-select="false">
                                        <?php foreach( $fuar_kategorileri AS $result ) { 
                                                $fuar_kategorileri2 = explode(",", $default_kayit[ 'fuar_kategori_idler' ]);
                                        ?>
                                            <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( in_array($result[ 'id' ], $fuar_kategorileri2) ) echo 'selected'?>><?php echo $result[ 'adi' ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
					
						</div>
						<div class="card-footer">
							<button modul= 'fuarTanimlari' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span><?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
		function dil_degistir(eleman){
            var dil_id = eleman.value;
			<?php if( $islem == "guncelle" ){ ?>
				    document.getElementById("adi").value = (document.getElementById("adi_"+dil_id)) ? document.getElementById("adi_"+eleman.value).value : "";
				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				//window.editor.data.set(document.getElementsByName("icerik"+dil)[0].value);
			<?php } ?>
		}


var tbl_fuar_tanimlari = $( "#tbl_fuar_tanimlari" ).DataTable( {
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
} ).buttons().container().appendTo('#tbl_fuar_tanimlari_wrapper .col-md-6:eq(0)');



$('#card_fuar_tanimlari').on('maximized.lte.cardwidget', function() {
	var tbl_fuar_tanimlari = $( "#tbl_fuar_tanimlari" ).DataTable();
	var column = tbl_fuar_tanimlari.column(  tbl_fuar_tanimlari.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_fuar_tanimlari.column(  tbl_fuar_tanimlari.column.length - 2 );
	column.visible( ! column.visible() );
});

$('#card_fuar_tanimlari').on('minimized.lte.cardwidget', function() {
	var tbl_fuar_tanimlari = $( "#tbl_fuar_tanimlari" ).DataTable();
	var column = tbl_fuar_tanimlari.column(  tbl_fuar_tanimlari.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_fuar_tanimlari.column(  tbl_fuar_tanimlari.column.length - 2 );
	column.visible( ! column.visible() );
} );



</script>