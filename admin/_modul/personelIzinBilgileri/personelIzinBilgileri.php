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
$personel_id				= array_key_exists( 'personel_id' ,$_REQUEST ) ? $_REQUEST[ 'personel_id' ]	: $_SESSION[ 'kullanici_id' ];


$satir_renk				= $id > 0	? 'table-warning'						: '';
$kaydet_buton_yazi		= $id > 0	? 'Güncelle'							: 'Kaydet';
$kaydet_buton_cls		= $id > 0	? 'btn btn-warning btn-sm pull-right'	: 'btn btn-success btn-sm pull-right';

$SQL_tum_personel_izin_bilgileri = <<< SQL
SELECT 
	i.*
    ,eoy.adi    AS egitim_ogretim_yili
	,it.adi     AS izin_turu
	,it.adi_kz  AS izin_turu_kz
	,it.adi_en  AS izin_turu_en
	,it.adi_ru  AS izin_turu_ru
FROM 
	tb_personel_izinler as i
LEFT JOIN tb_egitim_ogretim_yillari AS eoy ON eoy.id = i.egitim_ogretim_yili_id
LEFT JOIN tb_izin_turleri AS it ON it.id = i.izin_turu_id
WHERE 
	i.personel_id = ?
ORDER BY i.baslama_tarihi DESC
SQL;

$SQL_tek_personel_izin_bilgi_oku = <<< SQL
SELECT 
	*
FROM 
	tb_personel_izinler
WHERE 
	id = ?
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

$SQL_egitim_ogretim_yillari = <<< SQL
SELECT
	 *
FROM
	tb_egitim_ogretim_yillari
ORDER BY id DESC
SQL;

$SQL_birim_agaci_getir = <<< SQL
SELECT
	*
FROM 
	tb_birim_agaci
SQL;

$SQL_izin_turleri = <<< SQL
SELECT
	*
FROM 
	tb_izin_turleri
SQL;

$SQL_akademik_dereceler = <<< SQL
SELECT
	*
FROM 
	tb_akademik_dereceler
SQL;

$SQL_akademik_unvanlar = <<< SQL
SELECT
	*
FROM 
	tb_akademik_unvanlar
SQL;

$SQL_hizmet_turleri = <<< SQL
SELECT
	*
FROM 
	tb_hizmet_turleri
SQL;

$SQL_bilimsel_alanlar = <<< SQL
SELECT
	*
FROM 
	tb_bilimsel_alanlar
SQL;

$SQL_uzmanlik_alanlari = <<< SQL
SELECT
	*
FROM 
	tb_uzmanlik_alanlari
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


$birim_agacilar 		        = $vt->select($SQL_birim_agaci_getir, array(  ) )[ 2 ];
$izin_turleri 	            	= $vt->select($SQL_izin_turleri, array(  ) )[ 2 ];
$akademik_dereceler      		= $vt->select($SQL_akademik_dereceler, array(  ) )[ 2 ];
$akademik_unvanlar 	        	= $vt->select($SQL_akademik_unvanlar, array(  ) )[ 2 ];
$hizmet_turleri 	        	= $vt->select($SQL_hizmet_turleri, array(  ) )[ 2 ];
$bilimsel_alanlar 	        	= $vt->select($SQL_bilimsel_alanlar, array(  ) )[ 2 ];
$uzmanlik_alanlari 	        	= $vt->select($SQL_uzmanlik_alanlari, array(  ) )[ 2 ];
$personel_izin_bilgileri	    = $vt->select( $SQL_tum_personel_izin_bilgileri, array( $personel_id ) )[ 2 ];
$ulkeler                   	    = $vt->select( $SQL_ulkeler, array(  ) )[ 2 ];
$egitim_ogretim_yillari         = $vt->select( $SQL_egitim_ogretim_yillari, array(  ) )[ 2 ];
@$tek_personel_izin_bilgi 	= $vt->selectSingle( $SQL_tek_personel_izin_bilgi_oku, array( $id ) )[ 2 ];
@$tek_personel                  = $vt->selectSingle( $SQL_personel, array( $personel_id ) )[ 2 ];

$ust_idler					= $vt->select( $SQL_ust_id_getir, array( $tek_personel_izin_bilgi['birim_id'] ) )[ 2 ];
$alt_idler					= $vt->select( $SQL_alt_id_getir, array( $tek_personel_izin_bilgi['birim_id'] ) )[ 2 ];

foreach($ust_idler as $ust_id) 
	$ust_id_dizi[] = $ust_id['ust_id'];

foreach($alt_idler as $alt_id) 
	$alt_id_dizi[] = $alt_id['ust_id'];

if( $tek_personel[ "foto" ] == "resim_yok.png" or $tek_personel[ "foto" ] == "" )
    $personel_foto = $tek_personel[ "cinsiyet" ]."resim_yok.png";
else
    $personel_foto = $tek_personel[ "foto" ];


?>


<?php include "buyruk_modal.php"; ?>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">
                <div class="row">
                    <div class="col-12 ">
                        <div class="card card-danger card-outline" id = "card_personel_izin_bilgileri">
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
                        <div class="card card-olive" id = "card_personel_izin_bilgileri">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo dil_cevir( "İzin Bilgiler", $dizi_dil, $sistem_dil ); ?></h3>
                                <div class = "card-tools">
                                    <button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
                                    <a id = "yeni_fakulte" data-toggle = "tooltip" title = "Add" href = "?modul=personelIzinBilgileri&islem=ekle&personel_id=<?php echo $personel_id ?>" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="tbl_personel_izin_bilgileri" class="table table-bordered table-hover table-sm" width = "100%" >
                                    <thead>
                                        <tr>
                                            <th style="width: 15px">#</th>
                                            <th><?php echo dil_cevir( "Eğitim Öğretim Yılı", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "İzin Türü", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></th>
                                            <th><?php echo dil_cevir( "Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></th>
                                            <th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
                                            <th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sayi = 1; 
                                        foreach( $personel_izin_bilgileri AS $personel_izin_bilgi ) { 
                                        ?>
                                        <tr oncontextmenu="fun();" class =" <?php if( $personel_izin_bilgi[ 'id' ] == $id ) echo $satir_renk; ?>" data-id="<?php echo $personel_izin_bilgi[ 'id' ]; ?>">
                                            <td><?php echo $sayi++; ?></td>
                                            <td><?php echo $personel_izin_bilgi[ 'egitim_ogretim_yili' ]; ?></td>
                                            <td><?php echo $personel_izin_bilgi[ 'izin_turu'.$dil ]; ?></td>
                                            <td><?php echo $fn->tarihVer($personel_izin_bilgi[ 'baslama_tarihi' ]); ?></td>
                                            <td><?php echo $fn->tarihVer($personel_izin_bilgi[ 'bitis_tarihi' ]); ?></td>
                                            <td align = "center">
                                                <a modul = 'personelIzinBilgileri' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=personelIzinBilgileri&islem=guncelle&personel_id=<?php echo $personel_izin_bilgi[ 'personel_id' ]; ?>&id=<?php echo $personel_izin_bilgi[ 'id' ]; ?>" >
                                                    <?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
                                                </a>
                                            </td>
                                            <td align = "center">
                                                <button modul= 'personelIzinBilgileri' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/personelIzinBilgileri/personelIzinBilgileriSEG.php?islem=sil&personel_id=<?php echo $personel_izin_bilgi[ 'personel_id' ]; ?>&id=<?php echo $personel_izin_bilgi[ 'id' ]; ?>" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
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
				<form class="form-horizontal" action = "_modul/personelIzinBilgileri/personelIzinBilgileriSEG.php" method = "POST" enctype="multipart/form-data">
					<div class="card card-secondary">
						<div class="card-header">
							<h3 class='card-title'><?php echo dil_cevir( "İzin Ekle / Düzenle", $dizi_dil, $sistem_dil ); ?></h3>
						</div>
						<div class="card-body">
								<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
								<input type = "hidden" name = "id" value = "<?php echo $id; ?>">
								<input type = "hidden" name = "personel_id" value = "<?php echo $personel_id; ?>">
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Eğitim Öğretim Yılı", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" name = "egitim_ogretim_yili_id" required  >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $egitim_ogretim_yillari AS $egitim_ogretim_yili ){ ?>
                                            <option value="<?php echo $egitim_ogretim_yili[ "id" ]; ?>" <?php echo $tek_personel_izin_bilgi[ "egitim_ogretim_yili_id" ] == $egitim_ogretim_yili[ "id" ] ? "selected" : null ?>><?php echo $egitim_ogretim_yili[ "adi" ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "İzin Türü", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" name = "izin_turu_id" >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $izin_turleri AS $result ){ ?>
                                            <option value="<?php echo $result[ "id" ]; ?>" <?php echo $tek_personel_izin_bilgi[ "izin_turu_id" ] == $result[ "id" ] ? "selected" : null ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Buyruk", $dizi_dil, $sistem_dil ); ?></label>
                                    <div class="row">
                                        <div class="col-8">
                                            <select class="form-control form-control-sm select2" name = "buyruk_id" id="buyruk_id" >
                                                <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                                <?php foreach( $personel_buyruk_bilgileri AS $result ){ ?>
                                                    <option value="<?php echo $result[ "id" ]; ?>" <?php echo $tek_personel_izin_bilgi[ "buyruk_id" ] == $result[ "id" ] ? "selected" : null ?>><?php echo $result[ "buyruk_no" ]." (".$result[ "buyruk_turu".$dil ].")"; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn bg-olive btn-sm btn-block" onclick="$('#buyruk_modal').modal('show');"><i class="fas fa-plus"></i> <?php echo dil_cevir( "Ekle", $dizi_dil, $sistem_dil ); ?></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo dil_cevir( "Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                    <div class="input-group date" id="baslama_tarihi" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#baslama_tarihi" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input  type="text" data-target="#baslama_tarihi" data-toggle="datetimepicker" name="baslama_tarihi" value="<?php if( $tek_personel_izin_bilgi[ 'baslama_tarihi' ] !='' ){echo date('d.m.Y',strtotime($tek_personel_izin_bilgi[ 'baslama_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker1"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo dil_cevir( "Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                    <div class="input-group date" id="bitis_tarihi" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#bitis_tarihi" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input  type="text" data-target="#bitis_tarihi" data-toggle="datetimepicker" name="bitis_tarihi" value="<?php if( $tek_personel_izin_bilgi[ 'bitis_tarihi' ] !='' ){echo date('d.m.Y',strtotime($tek_personel_izin_bilgi[ 'bitis_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker1"/>
                                    </div>
                                </div>
                                <div class="form-group sabit card p-3">
                                    <label class="control-label"><?php echo dil_cevir( "Belge", $dizi_dil, $sistem_dil ); ?>: </label>
                                    <br>
                                    <input  type="file" class="" id ="belge" name ="belge"   >
                                </div>
						</div>
						<div class="card-footer">
							<button modul= 'personelIzinBilgileri' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
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


var tbl_personel_izin_bilgileri = $( "#tbl_personel_izin_bilgileri" ).DataTable( {
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
} ).buttons().container().appendTo('#tbl_personel_izin_bilgileri_wrapper .col-md-6:eq(0)');



$('#card_personel_izin_bilgileri').on('maximized.lte.cardwidget', function() {
	var tbl_personel_izin_bilgileri = $( "#tbl_personel_izin_bilgileri" ).DataTable();
	var column = tbl_personel_izin_bilgileri.column(  tbl_personel_izin_bilgileri.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_personel_izin_bilgileri.column(  tbl_personel_izin_bilgileri.column.length - 2 );
	column.visible( ! column.visible() );
});

$('#card_personel_izin_bilgileri').on('minimized.lte.cardwidget', function() {
	var tbl_personel_izin_bilgileri = $( "#tbl_personel_izin_bilgileri" ).DataTable();
	var column = tbl_personel_izin_bilgileri.column(  tbl_personel_izin_bilgileri.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_personel_izin_bilgileri.column(  tbl_personel_izin_bilgileri.column.length - 2 );
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
				
				document.getElementById("okul_adi").value = document.getElementsByName("okul_adi"+dil)[0].value;
				document.getElementById("fakulte").value = document.getElementsByName("fakulte"+dil)[0].value;
				document.getElementById("bolum").value = document.getElementsByName("bolum"+dil)[0].value;
				document.getElementById("program").value = document.getElementsByName("program"+dil)[0].value;
				document.getElementById("docentlik_alani").value = document.getElementsByName("docentlik_alani"+dil)[0].value;
				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				// window.editor.data.set(document.getElementsByName("ozgecmis"+dil)[0].value);
			<?php } ?>
		}
	</script>