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
$personel_id				= array_key_exists( 'personel_id' ,$_REQUEST ) ? $_REQUEST[ 'personel_id' ]	: 0;


$satir_renk				= $id > 0	? 'table-warning'						: '';
$kaydet_buton_yazi		= $id > 0	? 'Güncelle'							: 'Kaydet';
$kaydet_buton_cls		= $id > 0	? 'btn btn-warning btn-sm pull-right'	: 'btn btn-success btn-sm pull-right';

$SQL_tum_personel_sertifika_bilgileri = <<< SQL
SELECT
	psb.*
    ,ulk.adi    AS ulke_adi
    ,ulk.adi_kz AS ulke_adi_kz
    ,ulk.adi_en AS ulke_adi_en
    ,ulk.adi_ru AS ulke_adi_ru
FROM
	tb_personel_sertifika_bilgileri AS psb
LEFT JOIN tb_ulkeler AS ulk ON ulk.id = psb.ulke_id
WHERE 
    psb.personel_id = ?
ORDER BY psb.bitis_tarihi DESC
SQL;

$SQL_tek_personel_sertifika_bilgi_oku = <<< SQL
SELECT 
	*
FROM 
	tb_personel_sertifika_bilgileri
WHERE 
	id = ?
SQL;

$SQL_egitim_duzeyleri = <<< SQL
SELECT 
	*
FROM 
	tb_egitim_duzeyleri
SQL;

$SQL_ulkeler = <<< SQL
SELECT
	 *
FROM
	tb_ulkeler
ORDER BY alfa2_kodu
SQL;

$SQL_personel = <<< SQL
SELECT 
	p.*
	,CONCAT( p.adi, ' ', p.soyadi ) AS adi_soyadi
	,CONCAT( p.adi_kz, ' ', p.soyadi_kz ) AS adi_soyadi_kz
	,CONCAT( p.adi_en, ' ', p.soyadi_en ) AS adi_soyadi_en
	,CONCAT( p.adi_ru, ' ', p.soyadi_ru ) AS adi_soyadi_ru
	,ba.adi    as birim_adi
	,ba.adi_kz as birim_adi_kz
	,ba.adi_en as birim_adi_en
	,ba.adi_ru as birim_adi_ru
	,pn.adi    as personel_nitelik_adi
	,pn.adi_kz as personel_nitelik_adi_kz
	,pn.adi_en as personel_nitelik_adi_en
	,pn.adi_ru as personel_nitelik_adi_ru
FROM 
	tb_personeller AS p
LEFT JOIN tb_birim_agaci AS ba ON ba.id = p.birim_id
LEFT JOIN tb_personel_nitelikleri AS pn ON pn.id = p.personel_nitelik_id
WHERE 
    p.id = ?
SQL;

$personel_sertifika_bilgileri	= $vt->select( $SQL_tum_personel_sertifika_bilgileri, array( $personel_id ) )[ 2 ];
$egitim_duzeyleri       	    = $vt->select( $SQL_egitim_duzeyleri, array(  ) )[ 2 ];
$ulkeler                   	    = $vt->select( $SQL_ulkeler, array(  ) )[ 2 ];
@$tek_personel_sertifika_bilgi 	= $vt->selectSingle( $SQL_tek_personel_sertifika_bilgi_oku, array( $id ) )[ 2 ];
@$tek_personel                  = $vt->selectSingle( $SQL_personel, array( $personel_id ) )[ 2 ];

if( $tek_personel[ "foto" ] == "resim_yok.png" or $tek_personel[ "foto" ] == "" )
    $personel_foto = $tek_personel[ "cinsiyet" ]."resim_yok.png";
else
    $personel_foto = $tek_personel[ "foto" ];


?>



<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">
                <div class="row">
                    <div class="col-12 ">
                        <div class="card card-danger card-outline" id = "card_personel_sertifika_bilgileri">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="img-fluid img-circle img-thumbnail mw-100"
                                        style="width:120px; cursor:pointer;"
                                        src="resimler/personel_resimler/<?php echo $personel_foto; ?>" 
                                        alt="User profile picture"
                                        id = "personel_kullanici_resim">
                                </div>
                                <h3 class="profile-username text-center text-danger"><?php echo $tek_personel[ "adi".$dil ]." ".$tek_personel[ "soyadi".$dil ]; ?></h3>
                                <p class="text-muted text-center"><?php echo $tek_personel[ "personel_nitelik_adi".$dil ]; ?></p>
                                <a class = "btn btn-sm btn-danger  float-right" href = "?modul=personelDetay&personel_id=<?php echo $personel_id;; ?>" >
                                    <i class="fas fa-arrow-left"></i> <?php echo dil_cevir( "Profile Geri Dön", $dizi_dil, $sistem_dil ); ?>
                                </a>
                                <input type="file" id="gizli_input_file" name = "input_personel_resim" style = "display:none;" name = "resim" accept="image/gif, image/jpeg, image/png"  onchange="resimOnizle(this)"; />
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-olive" id = "card_personel_sertifika_bilgileri">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo dil_cevir( "Sertifika Bilgileri", $dizi_dil, $sistem_dil ); ?></h3>
                                <div class = "card-tools">
                                    <button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
                                    <a id = "yeni_fakulte" data-toggle = "tooltip" title = "Add" href = "?modul=personelSertifikaBilgileri&islem=ekle&personel_id=<?php echo $personel_id ?>" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="tbl_personel_sertifika_bilgileri" class="table table-bordered table-hover table-sm" width = "100%" >
                                    <thead>
                                        <tr>
                                            <th style="width: 15px">#</th>
                                            <th><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Kurum", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Ülke", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Alış / Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Belge", $dizi_dil, $sistem_dil ); ?></th>
                                            <th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
                                            <th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sayi = 1; 
                                        foreach( $personel_sertifika_bilgileri AS $personel_sertifika_bilgi ) { 
                                        ?>
                                        <tr oncontextmenu="fun();" class =" <?php if( $personel_sertifika_bilgi[ 'id' ] == $id ) echo $satir_renk; ?>" data-id="<?php echo $personel_sertifika_bilgi[ 'id' ]; ?>">
                                            <td><?php echo $sayi++; ?></td>
                                            <td><?php echo $personel_sertifika_bilgi[ 'adi'.$dil ]; ?></td>
                                            <td><?php echo $personel_sertifika_bilgi[ 'kurum_adi'.$dil ]; ?></td>
                                            <td><?php echo $personel_sertifika_bilgi[ 'ulke_adi'.$dil ]; ?></td>
                                            <td><span style="display:none;"><?php echo $personel_sertifika_bilgi[ 'baslama_tarihi' ]; ?></span><?php echo $fn->tarihVer($personel_sertifika_bilgi[ 'baslama_tarihi' ]); ?></td>
                                            <td><span style="display:none;"><?php echo $personel_sertifika_bilgi[ 'bitis_tarihi' ]; ?></span><?php echo $fn->tarihVer($personel_sertifika_bilgi[ 'bitis_tarihi' ]); ?></td>
                                            <td>
                                                <?php if( strlen($personel_sertifika_bilgi[ 'belge' ]) > 2 ){ ?>
                                                <a href="<?php echo "belgeler/".$personel_sertifika_bilgi[ 'belge' ]; ?>" target="_blank" download><?php echo dil_cevir( "İndir", $dizi_dil, $sistem_dil ); ?></a>
                                                <?php } ?>
                                            </td>
                                            <td align = "center">
                                                <a modul = 'personelSertifikaBilgileri' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=personelSertifikaBilgileri&islem=guncelle&personel_id=<?php echo $personel_sertifika_bilgi[ 'personel_id' ]; ?>&id=<?php echo $personel_sertifika_bilgi[ 'id' ]; ?>" >
                                                    <?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
                                                </a>
                                            </td>
                                            <td align = "center">
                                                <button modul= 'personelSertifikaBilgileri' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/personelSertifikaBilgileri/personelSertifikaBilgileriSEG.php?islem=sil&personel_id=<?php echo $personel_sertifika_bilgi[ 'personel_id' ]; ?>&id=<?php echo $personel_sertifika_bilgi[ 'id' ]; ?>" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<div class="col-md-4">
				<form class="form-horizontal" action = "_modul/personelSertifikaBilgileri/personelSertifikaBilgileriSEG.php" method = "POST" enctype="multipart/form-data">
					<div class="card card-secondary">
						<div class="card-header">
							<h3 class='card-title'><?php echo dil_cevir( "Sertifika Bilgileri Ekle / Düzenle", $dizi_dil, $sistem_dil ); ?></h3>
						</div>
						<div class="card-body">
							<?php foreach( array_keys($tek_personel_sertifika_bilgi) as $anahtar ){ ?>
							<input type="hidden"  name="<?php echo $anahtar;  ?>" value="<?php echo htmlentities($tek_personel_sertifika_bilgi[$anahtar]);  ?>">
							<?php } ?>

								<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
								<input type = "hidden" name = "id" value = "<?php echo $id; ?>">
								<input type = "hidden" name = "personel_id" value = "<?php echo $personel_id; ?>">
                                <div class="form-group sabit">
                                    <label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control" name = "dil" id="dil" required onchange="dil_degistir(this);">
                                        <option value="_tr" <?php if( $_REQUEST['dil'] == "" ) echo "selected"; ?> >Türkçe</option>
                                        <option value="_kz" <?php if( $_REQUEST['dil'] == "_kz" ) echo "selected"; ?> >қазақ</option>
                                        <option value="_en" <?php if( $_REQUEST['dil'] == "_en" ) echo "selected"; ?> >English</option>
                                        <option value="_ru" <?php if( $_REQUEST['dil'] == "_ru" ) echo "selected"; ?> >Россия</option>
                                    </select>
                                </div>

                                <div class="form-group sabit">
                                    <label  class="control-label"><?php echo dil_cevir( "Ülke", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" name = "ulke_id" >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $ulkeler AS $ulke ){ ?>
                                            <option value="<?php echo $ulke[ "id" ]; ?>" <?php echo $tek_personel_sertifika_bilgi[ "ulke_id" ] == $ulke[ "id" ] ? "selected" : null ?>><?php echo $ulke['alfa2_kodu']." - ".$ulke[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
								<div class="form-group sabit">
									<label class="control-label"><?php echo dil_cevir( "Sertifika / Staj Adı", $dizi_dil, $sistem_dil ); ?></label>
									<input required type="text" class="form-control form-control-sm" id ="adi" name ="adi" value = "<?php echo $tek_personel_sertifika_bilgi[ "adi".$dil ]; ?>"  >
								</div>
								<div class="form-group sabit">
									<label class="control-label"><?php echo dil_cevir( "Kurum Adı", $dizi_dil, $sistem_dil ); ?></label>
									<input required type="text" class="form-control form-control-sm" id ="kurum_adi" name ="kurum_adi" value = "<?php echo $tek_personel_sertifika_bilgi[ "kurum_adi".$dil ]; ?>"  >
								</div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo dil_cevir( "Alış / Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                    <div class="input-group date" id="baslama_tarihi" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#baslama_tarihi" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input  type="text" data-target="#baslama_tarihi" data-toggle="datetimepicker" name="baslama_tarihi" value="<?php if( $tek_personel_sertifika_bilgi[ 'baslama_tarihi' ] !='' ){echo date('d.m.Y',strtotime($tek_personel_sertifika_bilgi[ 'baslama_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker1"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo dil_cevir( "Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                    <div class="input-group date" id="bitis_tarihi" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#bitis_tarihi" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input  type="text" data-target="#bitis_tarihi" data-toggle="datetimepicker" name="bitis_tarihi" value="<?php if( $tek_personel_sertifika_bilgi[ 'bitis_tarihi' ] !='' ){echo date('d.m.Y',strtotime($tek_personel_sertifika_bilgi[ 'bitis_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker1"/>
                                    </div>
                                </div>

                                <div class="form-group sabit card p-3">
                                    <label class="control-label"><?php echo dil_cevir( "Belge", $dizi_dil, $sistem_dil ); ?>: </label>
                                    <br>
                                    <input  type="file" class="" id ="belge" name ="belge"   >
                                </div>

						</div>
						<div class="card-footer">
							<button modul= 'personelSertifikaBilgileri' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>


<script type="text/javascript">
	var simdi = new Date(); 
	//var simdi="11/25/2015 15:58";
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

	$(function () {
		$('#belge_tarihi').datetimepicker({
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


var tbl_personel_sertifika_bilgileri = $( "#tbl_personel_sertifika_bilgileri" ).DataTable( {
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
} ).buttons().container().appendTo('#tbl_personel_sertifika_bilgileri_wrapper .col-md-6:eq(0)');



$('#card_personel_sertifika_bilgileri').on('maximized.lte.cardwidget', function() {
	var tbl_personel_sertifika_bilgileri = $( "#tbl_personel_sertifika_bilgileri" ).DataTable();
	var column = tbl_personel_sertifika_bilgileri.column(  tbl_personel_sertifika_bilgileri.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_personel_sertifika_bilgileri.column(  tbl_personel_sertifika_bilgileri.column.length - 2 );
	column.visible( ! column.visible() );
});

$('#card_personel_sertifika_bilgileri').on('minimized.lte.cardwidget', function() {
	var tbl_personel_sertifika_bilgileri = $( "#tbl_personel_sertifika_bilgileri" ).DataTable();
	var column = tbl_personel_sertifika_bilgileri.column(  tbl_personel_sertifika_bilgileri.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_personel_sertifika_bilgileri.column(  tbl_personel_sertifika_bilgileri.column.length - 2 );
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
				document.getElementById("kurum_adi").value = document.getElementsByName("kurum_adi"+dil)[0].value;
				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				// window.editor.data.set(document.getElementsByName("ozgecmis"+dil)[0].value);
			<?php } ?>
		}
	</script>
