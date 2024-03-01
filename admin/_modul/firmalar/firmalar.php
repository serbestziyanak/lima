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

$SQL_tum_firmalar = <<< SQL
SELECT 
	 *
FROM 
	tb_firmalar
SQL;

$SQL_tek_firma_oku = <<< SQL
SELECT 
	*
FROM 
	tb_firmalar
WHERE 
	id = ?
SQL;

$SQL_ulkeler = <<< SQL
SELECT 
	 *
FROM 
	tb_ulkeler
SQL;

$SQL_sehirler = <<< SQL
SELECT 
	 *
FROM 
	tb_sehirler
WHERE
    ulke_id = ?
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

$SQL_firma_personelleri = <<< SQL
SELECT
	 *
FROM
	tb_firma_personelleri
WHERE
	firma_id = ?
SQL;

$SQL_tum_fuarlar = <<< SQL
SELECT 
	f.*
    ,fd.fuar_id
    ,fd.dil_id
    ,fd.adi
FROM 
	tb_fuarlar AS f
LEFT JOIN tb_fuarlar_dil AS fd ON f.id = fd.fuar_id and fd.dil_id = 1
WHERE fd.dil_id = 1
SQL;

$fuarlar		        = $vt->select( $SQL_tum_fuarlar, array( ) )[ 2 ];

$fuar_kategorileri		= $vt->select( $SQL_fuar_kategorileri, array( ) )[ 2 ];


$firmalar		        = $vt->select( $SQL_tum_firmalar, array( ) )[ 2 ];
$firma_personelleri		= $vt->select( $SQL_firma_personelleri, array( $id ) )[ 2 ];
@$tek_firma 	        = $vt->selectSingle( $SQL_tek_firma_oku, array( $id ) )[ 2 ];
$ulkeler		        = $vt->select( $SQL_ulkeler, array(  ) )[ 2 ];
$sehirler		        = $vt->select( $SQL_sehirler, array( $tek_firma['ulke_id'] ) )[ 2 ];

?>



<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">
				<div class="card card-secondary" id = "card_firmalar">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Firmalar", $dizi_dil, $sistem_dil ); ?></h3>
						<div class = "card-tools">
							<button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
							<a id = "yeni_fakulte" data-toggle = "tooltip" title = "Yeni Üviversite Ekle" href = "?modul=firmalar&islem=ekle" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
						</div>
					</div>
					<div class="card-body">
						<table id="tbl_firmalar" class="table table-bordered table-hover table-sm" width = "100%" >
							<thead>
								<tr>
									<th style="width: 15px">#</th>
									<th><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Vergi Dairesi", $dizi_dil, $sistem_dil ); ?> (KZ)</th>
									<th><?php echo dil_cevir( "Vergi No", $dizi_dil, $sistem_dil ); ?> (EN)</th>
									<th><?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?> (RU)</th>
									<th><?php echo dil_cevir( "Telefon", $dizi_dil, $sistem_dil ); ?> (RU)</th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $sayi = 1; foreach( $firmalar AS $firma ) { ?>
								<tr oncontextmenu="fun();" class =" <?php if( $firma[ 'id' ] == $id ) echo $satir_renk; ?>" data-id="<?php echo $firma[ 'id' ]; ?>">
									<td><?php echo $sayi++; ?></td>
									<td><?php echo $firma[ 'adi' ]; ?></td>
									<td><?php echo $firma[ 'vergi_dairesi' ]; ?></td>
									<td><?php echo $firma[ 'vergi_no' ]; ?></td>
									<td><?php echo $firma[ 'email' ]; ?></td>
									<td><?php echo $firma[ 'sabit_tel' ]; ?></td>
									<td align = "center">
										<a modul = 'firmalar' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=firmalar&islem=guncelle&id=<?php echo $firma[ 'id' ]; ?>" >
											<?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
										</a>
									</td>
									<td align = "center">
										<button modul= 'firmalar' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/firmalar/firmalarSEG.php?islem=sil&id=<?php echo $firma[ 'id' ]; ?>" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<form class="form-horizontal" action = "_modul/firmalar/firmalarSEG.php" method = "POST" enctype="multipart/form-data">
					<div class="card card-secondary">
						<div class="card-header ">
							<h3 class='card-title'><?php echo dil_cevir( "Firma Ekle / Düzenle", $dizi_dil, $sistem_dil ); ?></h3>
						</div>
						<div class="card-body">
								<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
								<input type = "hidden" name = "id" value = "<?php echo $id; ?>">              
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Tam Şirket Ünvanı", $dizi_dil, $sistem_dil ); ?></label>
									<input required type="text" class="form-control form-control-sm " name ="adi" value = "<?php echo $tek_firma[ "adi" ]; ?>"  autocomplete="off">
								</div>
                                <div class="form-group" id="ulke_id_select">
                                    <label  class="control-label">Sektör</label>
                                    <select required class="form-control select2" name = "sektor_id" id="sektor_id">
                                        <option value="">Seçiniz...</option>
                                        <?php foreach( $fuar_kategorileri AS $result ) { ?>
                                            <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( $result[ 'id' ] == $tek_firma[ "sektor_id" ] ) echo 'selected'?>><?php echo $result[ 'adi' ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group" id="ulke_id_select">
                                    <label  class="control-label">Ülke</label>
                                    <select required class="form-control select2" name = "ulke_id" id="ulke_id">
                                        <option value="">Seçiniz...</option>
                                        <?php foreach( $ulkeler AS $result ) { ?>
                                            <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( $result[ 'id' ] == $tek_firma[ "ulke_id" ] ) echo 'selected'?>><?php echo $result[ 'adi' ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group" id="sehir_id_select">
                                    <label  class="control-label">Şehir</label>
                                    <select required class="form-control select2" name = "sehir_id" id="sehir_id">
                                        <option value="">Seçiniz...</option>
                                        <?php foreach( $sehirler AS $result ) { ?>
                                            <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( $result[ 'id' ] == $tek_firma[ "sehir_id" ] ) echo 'selected'?>><?php echo $result[ 'adi' ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Sabit Telefon", $dizi_dil, $sistem_dil ); ?></label>
									<input  type="text" class="form-control form-control-sm " name ="sabit_tel" value = "<?php echo $tek_firma[ "sabit_tel" ]; ?>"  autocomplete="off">
								</div>
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Kurumsal Email", $dizi_dil, $sistem_dil ); ?></label>
									<input  type="text" class="form-control form-control-sm " name ="email" value = "<?php echo $tek_firma[ "email" ]; ?>"  autocomplete="off">
								</div>
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Web Sitesi", $dizi_dil, $sistem_dil ); ?></label>
									<input  type="text" class="form-control form-control-sm " name ="web" value = "<?php echo $tek_firma[ "web" ]; ?>"  autocomplete="off">
								</div>
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Vergi Dairesi", $dizi_dil, $sistem_dil ); ?></label>
									<input  type="text" class="form-control form-control-sm " name ="vergi_dairesi" value = "<?php echo $tek_firma[ "vergi_dairesi" ]; ?>"  autocomplete="off">
								</div>
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Vergi No", $dizi_dil, $sistem_dil ); ?></label>
									<input  type="text" class="form-control form-control-sm " name ="vergi_no" value = "<?php echo $tek_firma[ "vergi_no" ]; ?>"  autocomplete="off">
								</div>
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Adres", $dizi_dil, $sistem_dil ); ?></label>
									<input  type="text" class="form-control form-control-sm " name ="adres" value = "<?php echo $tek_firma[ "adres" ]; ?>"  autocomplete="off">
								</div>
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Katıldığı Fuarlar", $dizi_dil, $sistem_dil ); ?></label>
                                    <select   class="form-control select2"  multiple="multiple" name = "katildigi_fuar_idler[]" data-close-on-select="true">
                                        <?php foreach( $fuarlar AS $result ) { 
                                                $fuarlar2 = explode(",", $tek_firma[ 'katildigi_fuar_idler' ]);
                                        ?>
                                            <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( in_array($result[ 'id' ], $fuarlar2) ) echo 'selected'?>><?php echo $result[ 'adi' ]." ".$result[ 'soyadi' ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "İletişim Kişileri", $dizi_dil, $sistem_dil ); ?></label>
                                    <select   class="form-control select2"  multiple="multiple" name = "iletisim_personel_idler[]" data-close-on-select="true">
                                        <?php foreach( $firma_personelleri AS $result ) { 
                                                $firma_personelleri2 = explode(",", $tek_firma[ 'iletisim_personel_idler' ]);
                                        ?>
                                            <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( in_array($result[ 'id' ], $firma_personelleri2) ) echo 'selected'?>><?php echo $result[ 'adi' ]." ".$result[ 'soyadi' ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                        <div class="col-12">
                            <div class="card card-olive" >
                                <div class="card-header renk1">
                                    <h3 class="card-title"><?php echo dil_cevir( "Notlar", $dizi_dil, $sistem_dil ); ?></h3>
                                    <div class = "card-tools">
                                        <button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Notlar", $dizi_dil, $sistem_dil ); ?></label>
                                        <style>
                                        .ck-editor__editable_inline:not(.ck-comment__input *) {
                                            height: 400px;
                                            overflow-y: auto;
                                        }
                                        </style>

                                        <textarea id="editor" style="display:none" name="notlar">
                                        <?php echo @$tek_firma[ "notlar" ]; ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include "editor.php"; ?>

						</div>
						<div class="card-footer">
							<button modul= 'firmalar' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span><?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">


var tbl_firmalar = $( "#tbl_firmalar" ).DataTable( {
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
} ).buttons().container().appendTo('#tbl_firmalar_wrapper .col-md-6:eq(0)');



$('#card_firmalar').on('maximized.lte.cardwidget', function() {
	var tbl_firmalar = $( "#tbl_firmalar" ).DataTable();
	var column = tbl_firmalar.column(  tbl_firmalar.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_firmalar.column(  tbl_firmalar.column.length - 2 );
	column.visible( ! column.visible() );
});

$('#card_firmalar').on('minimized.lte.cardwidget', function() {
	var tbl_firmalar = $( "#tbl_firmalar" ).DataTable();
	var column = tbl_firmalar.column(  tbl_firmalar.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_firmalar.column(  tbl_firmalar.column.length - 2 );
	column.visible( ! column.visible() );
} );



</script>