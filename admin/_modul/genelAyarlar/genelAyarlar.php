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
$birim_id		= array_key_exists( 'birim_id' ,$_REQUEST ) ? $_REQUEST[ 'birim_id' ]	: 0;
$birim_adi		= array_key_exists( 'birim_adi' ,$_REQUEST ) ? $_REQUEST[ 'birim_adi' ]	: "";
$birim_id = 1;
$_REQUEST['birim_id'] = 1;

$satir_renk				= $genel_ayar_id > 0	? 'table-warning'						: '';
$kaydet_buton_yazi		= $genel_ayar_id > 0	? 'Güncelle'							: 'Kaydet';
$kaydet_buton_cls		= $genel_ayar_id > 0	? 'btn btn-warning btn-sm pull-right'	: 'btn btn-success btn-sm pull-right';


include "_modul/birim_agaci_getir.php";

$SQL_tek_genel_ayar_oku = <<< SQL
SELECT 
	*
FROM 
	tb_genel_ayarlar
WHERE 
	birim_id = ? 
SQL;

$SQL_birim_bilgileri = <<< SQL
SELECT 
	*
FROM 
	tb_birim_agaci
WHERE 
	id = ? 
SQL;

@$tek_genel_ayar 		= $vt->selectSingle( $SQL_tek_genel_ayar_oku, array( $birim_id ) )[ 2 ];
@$birim_bilgileri	= $vt->selectSingle( $SQL_birim_bilgileri, array( $birim_id ) )[ 2 ];

//var_dump($tek_genel_ayar);

if( $tek_genel_ayar['id'] > 0 )
	$islem = "guncelle";
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
			
			<!-- <div class="col-md-4 p-0">
				<div class="card card-secondary">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Birimler", $dizi_dil, $sistem_dil ); ?></h3>
					</div>
					<div class="card-body p-0">
						<div class="overflow-auto" style="height:600px;">
							<table class="table table-sm table-hover text-sm">
							<tbody>
								<?php
									if( count( $birim_agaclari ) ) 
										echo kategoriListele3($url_modul, $birim_agaclari,0,0, $vt, $ogrenci_id, $sistem_dil, $birim_idler);
								?>
							</tbody>
							</table>
						</div>

					</div>

				</div>
			</div> -->
			<?php if( isset($_REQUEST['birim_id']) ){ ?>

			<div class="col-md-12">
				<div class="card card-secondary">
					<div class="card-header p-2">
						<ul class="nav nav-pills tab-container">
							<h6 style = 'font-size: 1rem;'> &nbsp;&nbsp;&nbsp; <?php echo dil_cevir( "Genel Ayarlar Düzenle", $dizi_dil, $sistem_dil ); ?></h6>

							
						</ul>
					</div>
					<div class="card-body">

						<div class="tab-content">
							<!-- GENEL BİLGİLER -->
							<div class="tab-pane active" id="_genel">
								<form class="form-horizontal" action = "_modul/genelAyarlar/genelAyarlarSEG.php" method = "POST" enctype="multipart/form-data">
									<?php foreach( array_keys($tek_genel_ayar) as $anahtar ){ ?>
									<input type="hidden"  name="<?php echo $anahtar;  ?>" value="<?php echo htmlentities($tek_genel_ayar[$anahtar]);  ?>">
									<?php } ?>
									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
										<select class="form-control col-sm-10" name = "dil" id="dil" required onchange="dil_degistir(this);">
											<option value="_tr" <?php if( $_REQUEST['dil'] == "" ) echo "selected"; ?> >Türkçe</option>
											<option value="_kz" <?php if( $_REQUEST['dil'] == "_kz" ) echo "selected"; ?> >қазақ</option>
											<option value="_en" <?php if( $_REQUEST['dil'] == "_en" ) echo "selected"; ?> >English</option>
											<option value="_ru" <?php if( $_REQUEST['dil'] == "_ru" ) echo "selected"; ?> >Россия</option>
										</select>
									</div>

									<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
									<input type = "hidden" name = "birim_id" value = "<?php echo $birim_id; ?>">
									<input type = "hidden" name = "birim_adi" value = "<?php echo $birim_adi; ?>">
									<input type = "hidden" name = "logo_eski" id="logo_eski" value = "<?php echo $tek_genel_ayar[ 'logo' ]; ?>">
									<input type = "hidden" name = "footer_logo_eski" value = "<?php echo $tek_genel_ayar[ 'footer_logo' ]; ?>">
									<input type = "hidden" name = "birim_icon_eski" value = "<?php echo $tek_genel_ayar[ 'birim_icon' ]; ?>">

									<div class="form-group row card-body bg-light">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Logo", $dizi_dil, $sistem_dil ); ?></label>
										<input type="file" name="logo" class="" >
										<img src="resimler/logolar/<?php echo $tek_genel_ayar[ 'logo' ]; ?>" id="logo" height="100">
									</div>

									<div class="form-group row card-body bg-light">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Footer Logo", $dizi_dil, $sistem_dil ); ?></label>
										<input type="file" name="footer_logo" class="" >
										<img src="resimler/logolar/<?php echo $tek_genel_ayar[ 'footer_logo' ]; ?>" height="100">
									</div>

									<div class="form-group row card-body bg-light">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Birim Icon", $dizi_dil, $sistem_dil ); ?></label>
										<input type="file" name="birim_icon" class="" >
										<img src="resimler/logolar/<?php echo $tek_genel_ayar[ 'birim_icon' ]; ?>" height="100">
									</div>
									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Map", $dizi_dil, $sistem_dil ); ?></label>
										<input  type="text" class="form-control col-sm-10" name ="map" value = "<?php echo $tek_genel_ayar[ "map" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Adres", $dizi_dil, $sistem_dil ); ?></label>
										<textarea  type="text" class="form-control col-sm-10" id ="adres" name ="adres" value = "<?php echo $tek_genel_ayar[ "adres" ]; ?>"  autocomplete="off"><?php echo $tek_genel_ayar[ "adres" ]; ?></textarea>
									</div>
									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Tel", $dizi_dil, $sistem_dil ); ?></label>
										<input  type="text" class="form-control col-sm-10" name ="tel" value = "<?php echo $tek_genel_ayar[ "tel" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?></label>
										<input  type="text" class="form-control col-sm-10" name ="email" value = "<?php echo $tek_genel_ayar[ "email" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Facebook", $dizi_dil, $sistem_dil ); ?></label>
										<input  type="text" class="form-control col-sm-10" name ="facebook" value = "<?php echo $tek_genel_ayar[ "facebook" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Twitter", $dizi_dil, $sistem_dil ); ?></label>
										<input  type="text" class="form-control col-sm-10" name ="twitter" value = "<?php echo $tek_genel_ayar[ "twitter" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Instagram", $dizi_dil, $sistem_dil ); ?></label>
										<input  type="text" class="form-control col-sm-10" name ="instagram" value = "<?php echo $tek_genel_ayar[ "instagram" ]; ?>"  autocomplete="off">
									</div>

									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Linkedin", $dizi_dil, $sistem_dil ); ?></label>
										<input  type="text" class="form-control col-sm-10" name ="linkedin" value = "<?php echo $tek_genel_ayar[ "linkedin" ]; ?>"  autocomplete="off">
									</div>

									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Youtube", $dizi_dil, $sistem_dil ); ?></label>
										<input  type="text" class="form-control col-sm-10" name ="youtube" value = "<?php echo $tek_genel_ayar[ "youtube" ]; ?>"  autocomplete="off">
									</div>

									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Slogan", $dizi_dil, $sistem_dil ); ?></label>
										<input  type="text" class="form-control col-sm-10" id ="slogan" name ="slogan" value = "<?php echo $tek_genel_ayar[ "slogan" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Slogan", $dizi_dil, $sistem_dil ); ?>2</label>
										<input  type="text" class="form-control col-sm-10" id ="slogan2" name ="slogan2" value = "<?php echo $tek_genel_ayar[ "slogan2" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Slogan", $dizi_dil, $sistem_dil ); ?>3</label>
										<input  type="text" class="form-control col-sm-10" id ="slogan3" name ="slogan3" value = "<?php echo $tek_genel_ayar[ "slogan3" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group row">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Anasayfa Başlık", $dizi_dil, $sistem_dil ); ?></label>
										<input type="text" class="form-control col-sm-10" id ="anasayfa_baslik" name ="anasayfa_baslik" value = "<?php echo $tek_genel_ayar[ "anasayfa_baslik" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group">
										<label class="control-label"><?php echo dil_cevir( "Anasayfa İçerik", $dizi_dil, $sistem_dil ); ?></label>
										<style>
										.ck-editor__editable_inline:not(.ck-comment__input *) {
											height: 600px;
											overflow-y: auto;
										}
										</style>
										<textarea id="editor" style="display:none" name="anasayfa_icerik">
										<?php echo @$tek_genel_ayar[ "anasayfa_icerik" ]; ?>
										</textarea>
									</div>
									<div class="form-group row d-none">
                                        <?php if( $birim_bilgileri['birim_turu'] == 5 ){ ?>
										<label class="control-label col-form-label col-sm-2 "><?php echo dil_cevir( "Proje Sayısı", $dizi_dil, $sistem_dil ); ?></label>
                                        <?php }else{ ?>
										<label class="control-label col-form-label col-sm-2 "><?php echo dil_cevir( "Program", $dizi_dil, $sistem_dil ); ?></label>
                                        <?php } ?>
										<input  type="text" class="form-control col-sm-10 " name ="sayac1" value = "<?php echo $tek_genel_ayar[ "sayac1" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group row d-none">
                                        <?php if( $birim_bilgileri['birim_turu'] == 5 ){ ?>
										<label class="control-label col-form-label col-sm-2 "><?php echo dil_cevir( "Yayın Sayısı", $dizi_dil, $sistem_dil ); ?></label>
                                        <?php }else{ ?>
										<label class="control-label col-form-label col-sm-2 "><?php echo dil_cevir( "Öğrenci", $dizi_dil, $sistem_dil ); ?></label>
                                        <?php } ?>
										<input  type="text" class="form-control col-sm-10 " name ="sayac2" value = "<?php echo $tek_genel_ayar[ "sayac2" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group row d-none">
                                        <?php if( $birim_bilgileri['birim_turu'] == 5 ){ ?>
										<label class="control-label col-form-label col-sm-2 "><?php echo dil_cevir( "Araştırma Sayısı", $dizi_dil, $sistem_dil ); ?></label>
                                        <?php }else{ ?>
										<label class="control-label col-form-label col-sm-2 "><?php echo dil_cevir( "İşe Yerleşme Oranı", $dizi_dil, $sistem_dil ); ?></label>
                                        <?php } ?>
										<input  type="text" class="form-control col-sm-10 " name ="sayac3" value = "<?php echo $tek_genel_ayar[ "sayac3" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group row d-none">
                                        <?php if( $birim_bilgileri['birim_turu'] == 5 ){ ?>
										<label class="control-label col-form-label col-sm-2 "><?php echo dil_cevir( "Bilimsel Etkinlik Sayısı", $dizi_dil, $sistem_dil ); ?></label>
                                        <?php }else{ ?>
										<label class="control-label col-form-label col-sm-2 "><?php echo dil_cevir( "Akademik Personel", $dizi_dil, $sistem_dil ); ?></label>
                                        <?php } ?>
										<input  type="text" class="form-control col-sm-10 " name ="sayac4" value = "<?php echo $tek_genel_ayar[ "sayac4" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group row d-none">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "AYU Portal", $dizi_dil, $sistem_dil ); ?> URL</label>
										<input  type="text" class="form-control col-sm-10" name ="buton_url1" value = "<?php echo $tek_genel_ayar[ "buton_url1" ]; ?>"  autocomplete="off">
									</div>
									<div class="form-group row d-none">
										<label class="control-label col-form-label col-sm-2"><?php echo dil_cevir( "Öğrenci İşleri", $dizi_dil, $sistem_dil ); ?> URL</label>
										<input  type="text" class="form-control col-sm-10" name ="buton_url2" value = "<?php echo $tek_genel_ayar[ "buton_url2" ]; ?>"  autocomplete="off">
									</div>

									<div class="card-footer">
										<button modul= 'genel_ayarlar' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php }?>

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

var tbl_genel_ayarlar = $( "#tbl_genel_ayarlar" ).DataTable( {
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
} ).buttons().container().appendTo('#tbl_genel_ayarlar_wrapper .col-md-6:eq(0)');



$('#card_genel_ayarlar').on('maximized.lte.cardwidget', function() {
	var tbl_genel_ayarlar = $( "#tbl_genel_ayarlar" ).DataTable();
	var column = tbl_genel_ayarlar.column(  tbl_genel_ayarlar.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_genel_ayarlar.column(  tbl_genel_ayarlar.column.length - 2 );
	column.visible( ! column.visible() );
});

$('#card_genel_ayarlar').on('minimized.lte.cardwidget', function() {
	var tbl_genel_ayarlar = $( "#tbl_genel_ayarlar" ).DataTable();
	var column = tbl_genel_ayarlar.column(  tbl_genel_ayarlar.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_genel_ayarlar.column(  tbl_genel_ayarlar.column.length - 2 );
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
				document.getElementById("adres").value = document.getElementsByName("adres"+dil)[0].value;
				document.getElementById("anasayfa_baslik").value = document.getElementsByName("anasayfa_baslik"+dil)[0].value;
				document.getElementById("slogan").value = document.getElementsByName("slogan"+dil)[0].value;
				document.getElementById("slogan2").value = document.getElementsByName("slogan2"+dil)[0].value;
				document.getElementById("slogan3").value = document.getElementsByName("slogan3"+dil)[0].value;
				document.getElementById("logo").src = "resimler/logolar/"+document.getElementsByName("logo"+dil)[0].value;
				document.getElementById("logo_eski").value = document.getElementsByName("logo"+dil)[0].value;
				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				window.editor.data.set(document.getElementsByName("anasayfa_icerik"+dil)[0].value);
			<?php } ?>
		}
	</script>
