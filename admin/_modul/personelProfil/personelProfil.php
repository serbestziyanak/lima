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

$where = "WHERE aktif = 1 ";
if( $_SESSION['super'] != 1 and $_SESSION['rol_id'] != 1 )
    $where .= "AND birim_id IN (".$_SESSION[ 'birim_idler' ].")";

if( isset($_REQUEST['ara']) ){
    $where .= " 
                AND ( 
                    concat(p.adi,' ',p.soyadi) like '%$_REQUEST[ara]%'
                    OR p.in_no like '%$_REQUEST[ara]%'
                    OR p.email like '%$_REQUEST[ara]%'
                    )

            ";
}
//echo $_SESSION['birim_idler'];

$SQL_tum_personeller = <<< SQL
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
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
          <form class="form-inline" action="index.php?modul=personelProfil" method="POST">
            <div class="input-group mb-3 w-100">
                <input type="text" name="ara" value = "<?php echo $_REQUEST['ara']; ?>" class="form-control" placeholder="<?php echo dil_cevir( "IIN No", $dizi_dil, $sistem_dil ); ?>, <?php echo dil_cevir( "Adı Soyadı", $dizi_dil, $sistem_dil ); ?>, <?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?>" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit"><?php echo dil_cevir( "Ara", $dizi_dil, $sistem_dil ); ?></button>
                </div>
            </div>

          </form>
        </div>

        </div>
		<div class="row">
      <!-- Navbar Search -->
            <?php $sayi = 1; foreach( $personeller AS $personel ) { ?>
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                  <?php echo $personel[ 'personel_nitelik_adi'.$dil ]; ?>
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?php echo $personel[ 'adi_soyadi'.$dil ]; ?></b></h2>
                      <p class="text-muted text-sm"><b><?php echo dil_cevir( "Birim", $dizi_dil, $sistem_dil ); ?>: </b> <?php echo $personel[ 'birim_adi'.$dil ]; ?> </p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small">
                            <span class="fa-li"><i class="fas fa-building"></i></span> : 
                            <?php echo $personel[ "is_adresi" ];?>
                            <?php echo dil_cevir( "Oda No", $dizi_dil, $sistem_dil ); ?> : <?php echo $personel[ "oda_no" ];?>
                        </li>
                        <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> : <?php echo $personel[ "is_telefonu" ];?></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-envelope"></i></i></span> : <?php echo $personel[ "email" ];?></li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img style="object-fit: cover; height: 150px; width: 150px; " src="resimler/personel_resimler/<?php echo $personel[ "foto" ];?>" alt="user-avatar" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <a href="index.php?modul=personelDetay&personel_id=<?php echo $personel[ "id" ];?>" class="btn btn-sm btn-primary">
                      <i class="fas fa-user"></i> <?php echo dil_cevir( "Personel Detay", $dizi_dil, $sistem_dil ); ?>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
        </div>
	</div>
</section>



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
				document.getElementById("profil_kisa_aciklama").value = document.getElementsByName("profil_kisa_aciklama"+dil)[0].value;
				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				window.editor.data.set(document.getElementsByName("ozgecmis"+dil)[0].value);
			<?php } ?>
		}
	</script>
