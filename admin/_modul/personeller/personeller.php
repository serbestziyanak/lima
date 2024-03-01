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

$where="WHERE p.aktif = 1 ";
if( $_SESSION['super'] != 1 and $_SESSION['rol_id'] != 1 )
    $where .= " AND pab.birim_id IN (".$_SESSION[ 'birim_idler' ].") ";

if( isset($_REQUEST['ara']) ){
    $where .= " 
                AND ( 
                    concat(p.adi,' ',p.soyadi) like '%$_REQUEST[ara]%' OR
                    concat(p.adi_kz,' ',p.soyadi_kz) like '%$_REQUEST[ara]%' OR
                    concat(p.adi_en,' ',p.soyadi_kz) like '%$_REQUEST[ara]%' OR
                    concat(p.adi_ru,' ',p.soyadi_ru) like '%$_REQUEST[ara]%' OR
                    concat(p.soyadi,' ',p.adi,' ',p.baba_adi) like '%$_REQUEST[ara]%' OR
                    concat(p.soyadi_kz,' ',p.adi_kz,' ',p.baba_adi_kz) like '%$_REQUEST[ara]%' OR
                    concat(p.soyadi_en,' ',p.adi_en,' ',p.baba_adi_en) like '%$_REQUEST[ara]%' OR
                    concat(p.soyadi_ru,' ',p.adi_ru,' ',p.baba_adi_ru) like '%$_REQUEST[ara]%' OR
                    p.in_no like '%$_REQUEST[ara]%' OR
                    p.email like '%$_REQUEST[ara]%'
                    )

            ";
    echo "<script>$('.personel_liste').addClass('d-none'); $('.personel_grid').removeClass('d-none');</script>";
}
if( isset( $_REQUEST['filtre'] ) ){
    $filtre_birim_idler = implode(",",$_REQUEST['birim_idler']);
    if( isset( $_REQUEST['birim_idler'] ) )
        $where .= " AND pab.birim_id IN (".$filtre_birim_idler .") ";
    if( $_REQUEST['personel_nitelik_id'] != "" )
        $where .= " AND pab.personel_nitelik_id = ".$_REQUEST['personel_nitelik_id'];
    if( $_REQUEST['akademik_kadro_tipi_id'] != "" )
        $where .= " AND pab.akademik_kadro_tipi_id = ".$_REQUEST['akademik_kadro_tipi_id'];
    if( $_REQUEST['idari_kadro_tipi_id'] != "" )
        $where .= " AND pab.idari_kadro_tipi_id = ".$_REQUEST['idari_kadro_tipi_id'];
    if( $_REQUEST['akademik_derece_id'] != "" )
        $where .= " AND pab.akademik_derece_id = ".$_REQUEST['akademik_derece_id'];
    if( $_REQUEST['akademik_unvan_id'] != "" )
        $where .= " AND pab.akademik_unvan_id = ".$_REQUEST['akademik_unvan_id'];
    if( $_REQUEST['soyadi'] != "" )
        $where .= " AND ( p.soyadi like '%".$_REQUEST['soyadi']."%' OR p.soyadi_kz like '%".$_REQUEST['soyadi']."%' OR p.soyadi_en like '%".$_REQUEST['soyadi']."%' OR p.soyadi_ru like '%".$_REQUEST['soyadi']."%' ) ";
    if( $_REQUEST['adi'] != "" )
        $where .= " AND ( p.adi like '%".$_REQUEST['adi']."%' OR p.adi_kz like '%".$_REQUEST['adi']."%' OR p.adi_en like '%".$_REQUEST['adi']."%' OR p.adi_ru like '%".$_REQUEST['adi']."%' ) ";
    if( $_REQUEST['baba_adi'] != "" )
        $where .= " AND ( p.baba_adi like '%".$_REQUEST['baba_adi']."%' OR p.baba_adi_kz like '%".$_REQUEST['baba_adi']."%' OR p.baba_adi_en like '%".$_REQUEST['baba_adi']."%' OR p.baba_adi_ru like '%".$_REQUEST['baba_adi']."%' ) ";
    if( $_REQUEST['email'] != "" )
        $where .= " AND p.email like '%".$_REQUEST['email']."%' ";
    if( $_REQUEST['gsm1'] != "" )
        $where .= " AND p.gsm1 like '%".$_REQUEST['gsm1']."%' ";
    if( $_REQUEST['is_telefonu'] != "" )
        $where .= " AND p.is_telefonu like '%".$_REQUEST['is_telefonu']."%' ";
    if( $_REQUEST['dahili'] != "" )
        $where .= " AND p.dahili like '%".$_REQUEST['dahili']."%' ";
    if( isset( $_REQUEST['cinsiyet'] ) )
        $where .= " AND p.cinsiyet = ".$_REQUEST['cinsiyet'];

}

//echo $_SESSION['birim_idler'];

$SQL_tum_personeller = <<< SQL
SELECT 
	p.*
	,CONCAT( p.adi, ' ', p.soyadi ) AS adi_soyadi
	,CONCAT( p.adi_kz, ' ', p.soyadi_kz ) AS adi_soyadi_kz
	,CONCAT( p.adi_en, ' ', p.soyadi_en ) AS adi_soyadi_en
	,CONCAT( p.adi_ru, ' ', p.soyadi_ru ) AS adi_soyadi_ru
    ,bu.adi         AS ust_birim_adi
    ,bu.adi_kz      AS ust_birim_adi_kz
    ,bu.adi_en      AS ust_birim_adi_en
    ,bu.adi_ru      AS ust_birim_adi_ru
    ,b.adi          AS birim_adi
    ,b.adi_kz       AS birim_adi_kz
    ,b.adi_en       AS birim_adi_en
    ,b.adi_ru       AS birim_adi_ru
    ,pn.adi         AS personel_nitelik
    ,pn.adi_kz      AS personel_nitelik_kz
    ,pn.adi_en      AS personel_nitelik_en
    ,pn.adi_ru      AS personel_nitelik_ru
    ,ikt.adi        AS idari_kadro_tipi
    ,ikt.adi_kz     AS idari_kadro_tipi_kz
    ,ikt.adi_en     AS idari_kadro_tipi_en
    ,ikt.adi_ru     AS idari_kadro_tipi_ru
    ,akt.adi        AS akademik_kadro_tipi
    ,akt.adi_kz     AS akademik_kadro_tipi_kz
    ,akt.adi_en     AS akademik_kadro_tipi_en
    ,akt.adi_ru     AS akademik_kadro_tipi_ru
    ,ad.adi         AS akademik_derece
    ,ad.adi_kz      AS akademik_derece_kz
    ,ad.adi_en      AS akademik_derece_en
    ,ad.adi_ru      AS akademik_derece_ru
    ,au.adi         AS akademik_unvan
    ,au.adi_kz      AS akademik_unvan_kz
    ,au.adi_en      AS akademik_unvan_en
    ,au.adi_ru      AS akademik_unvan_ru
    ,ht.adi         AS hizmet_turu
    ,ht.adi_kz      AS hizmet_turu_kz
    ,ht.adi_en      AS hizmet_turu_en
    ,ht.adi_ru      AS hizmet_turu_ru
FROM 
	tb_personeller AS p
LEFT JOIN tb_personel_calisma_yeri_bilgileri AS pab ON p.id = pab.personel_id AND pab.aktif_calisma_yeri=1
LEFT JOIN tb_personel_nitelikleri AS pn ON pab.personel_nitelik_id = pn.id
LEFT JOIN tb_birim_agaci AS b ON b.id = pab.birim_id
LEFT JOIN tb_birim_agaci AS bu ON bu.id = b.ust_id
LEFT JOIN tb_akademik_kadro_tipleri AS akt ON akt.id = pab.akademik_kadro_tipi_id
LEFT JOIN tb_idari_kadro_tipleri AS ikt ON ikt.id = pab.idari_kadro_tipi_id
LEFT JOIN tb_akademik_dereceler AS ad ON ad.id = pab.akademik_derece_id
LEFT JOIN tb_akademik_unvanlar AS au ON au.id = pab.akademik_unvan_id
LEFT JOIN tb_hizmet_turleri AS ht ON ht.id = pab.hizmet_turu_id
$where
ORDER BY p.id DESC
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

$SQL_ulkeler = <<< SQL
SELECT
	 *
FROM
	tb_ulkeler
ORDER BY sira is null
SQL;

$SQL_roller = <<< SQL
SELECT
	 *
FROM
	tb_roller
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

$where="";
if( $_SESSION['super'] == 1 ){
	$where = "";
	$birim_idler = array();
}else{
	$birim_idler = explode(",",$_SESSION[ 'birim_idler' ]);
	foreach( $birim_idler as $birim_id2 ){
		$ust_idler	= $vt->select( $SQL_ust_id_getir, array( $birim_id2 ) )[ 2 ];
		foreach($ust_idler as $ust_id) 
			$ust_id_dizi[] = $ust_id['id'];
	}
	$ust_id_dizi = array_unique($ust_id_dizi);
	sort($ust_id_dizi);
	$birim_idler2 = implode(",",$ust_id_dizi);
	$where = "WHERE id IN (".$birim_idler2.")";
}

$SQL_birim_agaci_getir = <<< SQL
SELECT
	*
FROM 
	tb_birim_agaci
$where
SQL;


$SQL_akademik_kadro_tipleri = <<< SQL
SELECT
	*
FROM 
	tb_akademik_kadro_tipleri
SQL;

$SQL_idari_kadro_tipleri = <<< SQL
SELECT
	*
FROM 
	tb_idari_kadro_tipleri
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

$akademik_kadro_tipleri 		= $vt->select($SQL_akademik_kadro_tipleri, array(  ) )[ 2 ];
$idari_kadro_tipleri 	    	= $vt->select($SQL_idari_kadro_tipleri, array(  ) )[ 2 ];
$akademik_dereceler      		= $vt->select($SQL_akademik_dereceler, array(  ) )[ 2 ];
$akademik_unvanlar 	        	= $vt->select($SQL_akademik_unvanlar, array(  ) )[ 2 ];

@$birim_agacilar 		= $vt->select($SQL_birim_agaci_getir, array(  ) )[ 2 ];
$ulkeler				= $vt->select( $SQL_ulkeler, array(  ) )[ 2 ];
$kan_gruplari			= $vt->select( $SQL_kan_gruplari, array(  ) )[ 2 ];
$egitim_duzeyleri		= $vt->select( $SQL_egitim_duzeyleri, array(  ) )[ 2 ];
$unvanlar				= $vt->select( $SQL_unvanlar, array(  ) )[ 2 ];
$personel_nitelikleri	= $vt->select( $SQL_personel_nitelikleri, array(  ) )[ 2 ];
$personel_turleri		= $vt->select( $SQL_personel_turleri, array(  ) )[ 2 ];
$roller		= $vt->select( $SQL_roller, array(  ) )[ 2 ];




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

unset($ust_id_dizi);
foreach( $_REQUEST['birim_idler'] as $birim_id ){
    $ust_idler = $vt->select( $SQL_ust_id_getir, array( $birim_id ) )[ 2 ];
    foreach($ust_idler as $ust_id) 
        $ust_id_dizi[] = $ust_id['ust_id'];
}

foreach($alt_idler as $alt_id) 
	$alt_id_dizi[] = $alt_id['ust_id'];

$toplam_kayit_sayisi = count($personeller);
$sayfa_kayit_sayisi = 9;
$max_sayfa_no = ceil( $toplam_kayit_sayisi/$sayfa_kayit_sayisi );
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
    		<div class="modal fade" id="modal_personel_resim" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  	<div class="modal-dialog modal-lg" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<h5 class="modal-title" id="modalLabel">Crop Image Before Upload</h5>
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          			<span aria-hidden="true">×</span>
			        		</button>
			      		</div>
			      		<div class="modal-body">
			        		<div class="img-container">
			            		<div class="row">
			                		<div class="col-md-8">
			                    		<img src="" id="sample_image" width="100%" height="100%" />
			                		</div>
			                		<div class="col-md-4">
			                    		<div class="preview"></div>
			                		</div>
			            		</div>
			        		</div>
			      		</div>
			      		<div class="modal-footer">
			        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			        		<button type="button" class="btn btn-primary" id="crop">Crop</button>
			      		</div>
			    	</div>
			  	</div>
			</div>	
<div class="modal fade" id="personel_ekle" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
			<form class="form-horizontal was-validated" action = "_modul/personeller/personellerSEG.php" method = "POST" enctype="multipart/form-data">
                <?php foreach( array_keys($tek_personel) as $anahtar ){ ?>
                <input type="hidden"  name="<?php echo $anahtar;  ?>" value="<?php echo htmlentities($tek_personel[$anahtar]);  ?>">
                <?php } ?>

                <input type = "hidden" name = "islem" value = "ekle" >
                <input type = "hidden" name = "personel_id" value = "<?php echo $personel_id; ?>">
                <input type = "hidden" name = "universite_id" value = "<?php echo $_SESSION['universite_id']; ?>">

                <div class="modal-header bg-gray-dark">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo dil_cevir( "Personel Ekle", $dizi_dil, $sistem_dil ); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
							<?php
								if( $islem == "guncelle" ){
									$resim_src = "resimler/personel_resimler/".$tek_personel[ "foto" ];
								}else{
									$resim_src = "resimler/resim_yok.png";
								}
							?>
							<div class="text-center">
								<img class="img-fluid img-circle img-thumbnail mw-100"
									style="width:120px; cursor:pointer;"
									src="<?php echo $resim_src; ?>" 
									alt="User profile picture"
									id = "personel_kullanici_resim">
							</div>
							<p class="text-muted text-center"><?php echo dil_cevir( "Fotoğraf değiştirmek için fotoğrafa tıklayınız", $dizi_dil, $sistem_dil ); ?></p>	
							<h3 class="profile-username text-center"><?php echo $tek_personel[ "adi" ]." ".$tek_personel[ "soyadi" ]; ?></h3>
							<input type="file" id="gizli_input_file" name = "input_personel_resim" style = "display:none;" name = "resim" accept="image/gif, image/jpeg, image/png"  onchange="resimOnizle(this)"; />
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
								<select class="form-control" name = "dil" id="dil" required onchange="dil_degistir(this);">
									<option value="_tr" <?php if( $_REQUEST['dil'] == "" ) echo "selected"; ?> >Türkçe</option>
									<option value="_kz" <?php if( $_REQUEST['dil'] == "_kz" ) echo "selected"; ?> >қазақ</option>
									<option value="_en" <?php if( $_REQUEST['dil'] == "_en" ) echo "selected"; ?> >English</option>
									<option value="_ru" <?php if( $_REQUEST['dil'] == "_ru" ) echo "selected"; ?> >Россия</option>
								</select>
							</div>

                        </div>
                        <div class="col-6">
							<br><h5 class="float-left text-olive"><?php echo dil_cevir( "Kişisel Bilgiler", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "IIN No", $dizi_dil, $sistem_dil ); ?></label>
								<input required type="text" placeholder="IIN Numarası" class="form-control form-control-sm" name ="in_no" value = "<?php echo $tek_personel[ "in_no" ]; ?>"  >
							</div>
							<div class="form-group">
								<label  class="control-label"><?php echo dil_cevir( "Uyruk", $dizi_dil, $sistem_dil ); ?></label>
								<select required class="form-control form-control-sm select2" name = "uyruk_id" >
									<option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
									<?php 
										foreach( $ulkeler AS $uyruk ){
											echo '<option value="'.$uyruk[ "id" ].'" '.( $tek_personel[ "uyruk_id" ] == $uyruk[ "id" ] ? "selected" : null) .'>'.$uyruk[ "alfa2_kodu" ]." - ".$uyruk[ "adi" ].'</option>';
										}

									?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Soyadı", $dizi_dil, $sistem_dil ); ?></label>
								<input required type="text" placeholder="Soyadı" class="form-control form-control-sm" id ="soyadi" name ="soyadi" value = "<?php echo $tek_personel[ "soyadi" ]; ?>"  >
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></label>
								<input required type="text" placeholder="Adı" class="form-control form-control-sm" id ="adi" name ="adi" value = "<?php echo $tek_personel[ "adi".$dil ]; ?>"  >
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Baba Adı", $dizi_dil, $sistem_dil ); ?></label>
								<input required type="text" placeholder="Soyadı" class="form-control form-control-sm" id ="baba_adi" name ="baba_adi" value = "<?php echo $tek_personel[ "baba_adi" ]; ?>"  >
							</div>
							<div class="form-group card card-body">
								<label class="control-label"><?php echo dil_cevir( "Cinsiyet", $dizi_dil, $sistem_dil ); ?></label>
								<div class='icheck-maroon d-inline '>
									<input required type='radio' class='form-control form-control-sm' id='kadin' name='cinsiyet' value="1" <?php if( $tek_personel[ "cinsiyet" ] == 1 ) echo "checked"; ?> >
									<label for='kadin'>
										<?php echo dil_cevir( "Kadın", $dizi_dil, $sistem_dil ); ?>
									</label>
								</div>
								<div class='icheck-primary d-inline'>
									<input required type='radio' class='form-control form-control-sm' id='erkek' name='cinsiyet' value="2" <?php if( $tek_personel[ "cinsiyet" ] == 2 ) echo "checked"; ?> >
									<label for='erkek'>
										<?php echo dil_cevir( "Erkek", $dizi_dil, $sistem_dil ); ?>
									</label>
								</div>
							</div>
							<br><h5 class="float-right text-olive"><?php echo dil_cevir( "İletişim Bilgileri", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?></label>
								<input required type="email" class="form-control form-control-sm" pattern="^[\w.+\-]+@ayu\.edu.kz$" title="@ayu.edu.kz uzantılı mail girilmelidir." name ="email" value = "<?php echo $tek_personel[ "email" ]; ?>"  >
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "GSM 1", $dizi_dil, $sistem_dil ); ?></label>
                                <input name ="gsm1" type="text" value = "<?php echo $tek_personel[ "gsm1" ]; ?>" placeholder="İş Telefonu" class="form-control form-control-sm" data-inputmask='"mask": "+7(999) 999-9999"' data-mask autocomplete="off">
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "İş Telefonu", $dizi_dil, $sistem_dil ); ?></label>
                                <input name ="is_telefonu" type="text" value = "<?php echo $tek_personel[ "is_telefonu" ]; ?>" placeholder="İş Telefonu" class="form-control form-control-sm" data-inputmask='"mask": "+7(999) 999-9999"' data-mask autocomplete="off">
                            </div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Dahili Telefon", $dizi_dil, $sistem_dil ); ?></label>
								<input  type="number" class="form-control form-control-sm" name ="dahili" value = "<?php echo $tek_personel[ "dahili" ]; ?>" >
							</div>

                        </div>
                        <div class="col-6">    
							<br><h5 class="float-left text-olive"><?php echo dil_cevir( "Çalışma Yeri Bilgileri", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
							<div class="form-group ">
								<label  class="control-label"><?php echo dil_cevir( "Birim", $dizi_dil, $sistem_dil ); ?></label>
								<div class="overflow-auto" style="max-height:500px;">
									<table class="table table-sm table-hover ">
									<tbody>
										<?php
										//var_dump($birim_agacilar);
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

														if( $kategori['id'] == $gelen_birim_id  ){
															$secili = "checked";
														}else{
															$secili = "";
														}

                                                        if( $kategori['kategori'] == 0  or $kategori['birim_turu'] == 3 ){
															$html .= "
																	<tr>
																		<td class=' bg-renk7' >
																				<div class='icheck-success d-inline'>
																					<input type='radio' class='form-control form-control-sm' id='icheck_$kategori[id]' name='birim_id' value='$kategori[id]' $secili required>
																					<label for='icheck_$kategori[id]' onclick='event.stopPropagation();'>
																					$kategori[$adi]
																					</label>
																				</div>
																		</td>
																	</tr>";									

														}elseif( $kategori['kategori'] == 1 ){
															// if( in_array($kategori['id'], $ust_id_dizi) )
															// 	$agac_acik = "true";
															// else
																$agac_acik = "false";

															if( $kategori['grup'] == 1 ){
																$html .= "
																		<tr data-widget='expandable-table' aria-expanded='$agac_acik' class='border-0'>
																			<td class='bg-renk$renk'>																
																				$kategori[$adi]
																				<i class='expandable-table-caret fas fa-caret-right fa-fw'></i>
																			</td>
																		</tr>
																	";								
															}else{
																$html .= "
																		<tr data-widget='expandable-table' aria-expanded='$agac_acik' class='border-0'>
																			<td class='bg-renk$renk'>																
																				<div class='icheck-success d-inline'>
																					<input type='radio' class='form-control form-control-sm' id='icheck_$kategori[id]' name='birim_id' value='$kategori[id]' $secili required>
																					<label for='icheck_$kategori[id]' onclick='event.stopPropagation();'>
																					</label>
																				</div>
																					$kategori[$adi]
																			<i class='expandable-table-caret fas fa-caret-right fa-fw'></i>
																			</td>
																		</tr>
																	";								

															}
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
												echo kategoriListele3($birim_agacilar,0,0, $vt, $tek_personel[ "birim_id" ], $ust_id_dizi, $sistem_dil);
											

										?>
									</tbody>
									</table>
								</div>
							</div>

                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Personel Türü", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" id = "personel_nitelik_id" name = "personel_nitelik_id" onchange="kadro_tipi_degistir(this)" required  >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $personel_nitelikleri AS $personel_nitelik ){ ?>
                                            <option value="<?php echo $personel_nitelik[ "id" ]; ?>" <?php echo $tek_personel[ "personel_nitelik_id" ] == $personel_nitelik[ "id" ] ? "selected" : null ?>><?php echo $personel_nitelik[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group akademik_kadrolar">
                                    <label  class="control-label"><?php echo dil_cevir( "Kadro Tipi", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" id = "akademik_kadro_tipi_id" name = "akademik_kadro_tipi_id" >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $akademik_kadro_tipleri AS $result ){ ?>
                                            <option value="<?php echo $result[ "id" ]; ?>" <?php echo $tek_personel[ "akademik_kadro_tipi_id" ] == $result[ "id" ] ? "selected" : null ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group idari_kadrolar">
                                    <label  class="control-label"><?php echo dil_cevir( "Kadro Tipi", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" id = "idari_kadro_tipi_id" name = "idari_kadro_tipi_id" >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $idari_kadro_tipleri AS $result ){ ?>
                                            <option value="<?php echo $result[ "id" ]; ?>" <?php echo $tek_personel[ "idari_kadro_tipi_id" ] == $result[ "id" ] ? "selected" : null ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Akademik Derece", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" name = "akademik_derece_id" >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $akademik_dereceler AS $result ){ ?>
                                            <option value="<?php echo $result[ "id" ]; ?>" ><?php echo $result[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Akademik Unvan", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" name = "akademik_unvan_id" >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $akademik_unvanlar AS $result ){ ?>
                                            <option value="<?php echo $result[ "id" ]; ?>" ><?php echo $result[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                        <option value="0"><?php echo dil_cevir( "Yok", $dizi_dil, $sistem_dil ); ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo dil_cevir( "Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                    <div class="input-group date" id="baslama_tarihi" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#baslama_tarihi" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input  required  type="text" data-target="#baslama_tarihi" data-toggle="datetimepicker" name="baslama_tarihi"  class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker1"/>
                                    </div>
                                </div>


                        </div>


                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo dil_cevir( "İptal", $dizi_dil, $sistem_dil ); ?></button>
                    <button modul= 'personeller' yetki_islem="kaydet"  type="submit" class="btn btn-success"><?php echo dil_cevir( "Kaydet", $dizi_dil, $sistem_dil ); ?></button>
                </div>
            </form>
        </div>

    </div>
</div>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-olive" id = "card_personeller">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Personeller", $dizi_dil, $sistem_dil ); ?></h3>
						<div class = "card-tools">
                            <a class="btn btn-tool" data-toggle="collapse" href="#filterData" role="button" aria-expanded="false" aria-controls="filterData">
                                <i class="fas fa-filter"></i>
                            </a>
							<button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
							<a modul= 'personeller' yetki_islem="ekle" id = "yeni_ogretim_elemanlari" data-toggle = "tooltip" title = "<?php echo dil_cevir( "Personel Ekle", $dizi_dil, $sistem_dil ); ?>" onclick="$('#personel_ekle').modal('show');" class="btn btn-tool" ><i class="fas fa-user-plus"></i></a>
						</div>
					</div>
					<div class="card-body">
                        <div class="collapse" id="filterData">
                            <form class="form-horizontal " action = "" method = "POST" enctype="multipart/form-data">  
                                <div class="card " >
                                    <div class="card-header text-white" style="background-color: #ED553B !important;">
                                        <h3 class="card-title"><?php echo dil_cevir( "Filtreler", $dizi_dil, $sistem_dil ); ?></h3>
                                    </div>

                                    <?php //var_dump($_REQUEST); echo $SQL_tum_personeller;?>
                                    <div class="card-body row">
                                            <div class="form-group col-lg-4">
                                                <label  class="control-label"><?php echo dil_cevir( "Birimler", $dizi_dil, $sistem_dil ); ?></label>
                                                <div class="overflow-auto border p-1" >
                                                    <table class="table table-sm table-hover ">
                                                    <tbody>
                                                        <?php
                                                            function kategoriListele4( $kategoriler, $parent = 0, $renk = 0,$vt, $gelen_birim_id, $ust_id_dizi, $sistem_dil){
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
                                                                        
                                                                        if( in_array( $kategori['id'], $gelen_birim_id ) ){
                                                                            $secili = "checked";
                                                                        }else{
                                                                            $secili = "";
                                                                        }

                                                                        if( $kategori['kategori'] == 0){
                                                                            $html .= "
                                                                                    <tr>
                                                                                        <td class=' bg-renk7' >
                                                                                            <input type='checkbox' class='item_$kategori[ust_id]' id='icheck_$kategori[id]' name='birim_idler[]' value='$kategori[id]' $secili  onclick='event.stopPropagation();'>
                                                                                            $kategori[$adi]
                                                                                        </td>
                                                                                    </tr>";									

                                                                        }
                                                                        if( $kategori['kategori'] == 1 ){
                                                                            if( in_array( $kategori['id'], $ust_id_dizi ) ){
                                                                                $agac_acik = "true";
                                                                            }else{
                                                                                if( $kategori['ust_id'] == 0 )
                                                                                    $agac_acik = "true";
                                                                                else
                                                                                    $agac_acik = "false";
                                                                            }

                                                                            // if( $kategori['ust_id'] == 0 )
                                                                            // 	$agac_acik = "true";
                                                                            // else
                                                                            // 	$agac_acik = "false";

                                                                                $html .= "
                                                                                        <tr data-widget='expandable-table' aria-expanded='$agac_acik' class='border-0'>
                                                                                            <td class='bg-renk$renk'>																
                                                                                            <input type='checkbox' data-id='$kategori[id]' class='kategori item_$kategori[ust_id]' id='icheck_$kategori[id]' name='birim_idler[]' value='$kategori[id]' $secili   onclick='event.stopPropagation();sec(this)'>
                                                                                            $kategori[$adi]
                                                                                            <i class='expandable-table-caret fas fa-caret-right fa-fw'></i>
                                                                                            </td>
                                                                                        </tr>
                                                                                    ";								
                                                                                $renk++;
                                                                                $html .= kategoriListele4($kategoriler, $kategori['id'],$renk, $vt, $gelen_birim_id, $ust_id_dizi, $sistem_dil);
                                                                                
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
                                                                echo kategoriListele4($birim_agacilar,0,0, $vt, $_REQUEST[ "birim_idler" ], $ust_id_dizi, $sistem_dil);
                                                            

                                                        ?>
                                                    </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="form-group col-lg-4">
                                                        <label class="control-label"><?php echo dil_cevir( "Soyadı", $dizi_dil, $sistem_dil ); ?></label>
                                                        <input type="text" placeholder="<?php echo dil_cevir( "Soyadı", $dizi_dil, $sistem_dil ); ?>" class="form-control form-control-sm" id ="soyadi" name ="soyadi" value = "<?php echo $_REQUEST[ "soyadi" ]; ?>"  >
                                                    </div>
                                                    <div class="form-group col-lg-4">
                                                        <label class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></label>
                                                        <input type="text" placeholder="<?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?>" class="form-control form-control-sm" id ="adi" name ="adi" value = "<?php echo $_REQUEST[ "adi".$dil ]; ?>"  >
                                                    </div>
                                                    <div class="form-group col-lg-4">
                                                        <label class="control-label"><?php echo dil_cevir( "Baba Adı", $dizi_dil, $sistem_dil ); ?></label>
                                                        <input type="text" placeholder="<?php echo dil_cevir( "Baba Adı", $dizi_dil, $sistem_dil ); ?>" class="form-control form-control-sm" id ="baba_adi" name ="baba_adi" value = "<?php echo $_REQUEST[ "baba_adi" ]; ?>"  >
                                                    </div>
                                                    <div class="form-group col-lg-4">
                                                        <label class="control-label"><?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?></label>
                                                        <input type="text" placeholder="<?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?>" class="form-control form-control-sm" name ="email" value = "<?php echo $_REQUEST[ "email" ]; ?>"  >
                                                    </div>
                                                    <div class="form-group col-lg-4">
                                                        <label class="control-label"><?php echo dil_cevir( "GSM 1", $dizi_dil, $sistem_dil ); ?></label>
                                                        <input type="number" placeholder="<?php echo dil_cevir( "GSM 1", $dizi_dil, $sistem_dil ); ?>"  class="form-control form-control-sm" name ="gsm1" value = "<?php echo $_REQUEST[ "gsm1" ]; ?>"  >
                                                    </div>
                                                    <div class="form-group col-lg-4">
                                                        <label class="control-label"><?php echo dil_cevir( "İş Telefonu", $dizi_dil, $sistem_dil ); ?></label>
                                                        <input  type="number" placeholder="<?php echo dil_cevir( "İş Telefonu", $dizi_dil, $sistem_dil ); ?>"  class="form-control form-control-sm" name ="is_telefonu" value = "<?php echo $_REQUEST[ "is_telefonu" ]; ?>" >
                                                    </div>
                                                    <div class="form-group col-lg-4">
                                                        <label class="control-label"><?php echo dil_cevir( "Dahili Telefon", $dizi_dil, $sistem_dil ); ?></label>
                                                        <input  type="number" placeholder="<?php echo dil_cevir( "Dahili Telefon", $dizi_dil, $sistem_dil ); ?>"  class="form-control form-control-sm" name ="dahili" value = "<?php echo $_REQUEST[ "dahili" ]; ?>" >
                                                    </div>
                                                    <div class="form-group col-lg-4">
                                                        <label  class="control-label"><?php echo dil_cevir( "Personel Türü", $dizi_dil, $sistem_dil ); ?></label>
                                                        <select class="form-control form-control-sm select2" name = "personel_nitelik_id" onchange="kadro_tipi_degistir(this)"  >
                                                            <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                                            <?php foreach( $personel_nitelikleri AS $personel_nitelik ){ ?>
                                                                <option value="<?php echo $personel_nitelik[ "id" ]; ?>" <?php echo $_REQUEST[ "personel_nitelik_id" ] == $personel_nitelik[ "id" ] ? "selected" : "" ?>><?php echo $personel_nitelik[ "adi".$dil ]; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group akademik_kadrolar  col-lg-4">
                                                        <label  class="control-label"><?php echo dil_cevir( "Kadro Tipi", $dizi_dil, $sistem_dil ); ?></label>
                                                        <select class="form-control form-control-sm select2" name = "akademik_kadro_tipi_id" >
                                                            <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                                            <?php foreach( $akademik_kadro_tipleri AS $result ){ ?>
                                                                <option value="<?php echo $result[ "id" ]; ?>" <?php echo $_REQUEST[ "akademik_kadro_tipi_id" ] == $result[ "id" ] ? "selected" : "" ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group idari_kadrolar  col-lg-4">
                                                        <label  class="control-label"><?php echo dil_cevir( "Kadro Tipi", $dizi_dil, $sistem_dil ); ?></label>
                                                        <select class="form-control form-control-sm select2" name = "idari_kadro_tipi_id" >
                                                            <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                                            <?php foreach( $idari_kadro_tipleri AS $result ){ ?>
                                                                <option value="<?php echo $result[ "id" ]; ?>" <?php echo $_REQUEST[ "idari_kadro_tipi_id" ] == $result[ "id" ] ? "selected" : "" ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group  col-lg-4">
                                                        <label  class="control-label"><?php echo dil_cevir( "Akademik Derece", $dizi_dil, $sistem_dil ); ?></label>
                                                        <select class="form-control form-control-sm select2" name = "akademik_derece_id" >
                                                            <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                                            <?php foreach( $akademik_dereceler AS $result ){ ?>
                                                                <option value="<?php echo $result[ "id" ]; ?>" <?php echo $_REQUEST[ "akademik_derece_id" ] == $result[ "id" ] ? "selected" : "" ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group  col-lg-4">
                                                        <label  class="control-label"><?php echo dil_cevir( "Akademik Unvan", $dizi_dil, $sistem_dil ); ?></label>
                                                        <select class="form-control form-control-sm select2" name = "akademik_unvan_id" >
                                                            <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                                            <?php foreach( $akademik_unvanlar AS $result ){ ?>
                                                                <option value="<?php echo $result[ "id" ]; ?>" <?php echo $_REQUEST[ "akademik_unvan_id" ] == $result[ "id" ] ? "selected" : null ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                                            <?php } ?>
                                                            <option value="0"><?php echo dil_cevir( "Yok", $dizi_dil, $sistem_dil ); ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group  col-lg-4">
                                                        <label class="control-label"><?php echo dil_cevir( "Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                                        <div class="input-group date" id="filtre_baslama_tarihi" data-target-input="nearest">
                                                            <div class="input-group-append" data-target="#filtre_baslama_tarihi" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                            <input  type="text" data-target="#filtre_baslama_tarihi" data-toggle="datetimepicker" name="baslama_tarihi" value="<?php if( $_REQUEST[ 'baslama_tarihi' ] !='' ){echo date('d.m.Y',strtotime($_REQUEST[ 'baslama_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>"  class="form-control form-control-sm datetimepicker-input" data-target="#filtre_baslama_tarihi"/>
                                                        </div>
                                                    </div>  
                                                    <div class="form-group  col-lg-4">
                                                        <div class="card card-body">
                                                            <label class="control-label"><?php echo dil_cevir( "Cinsiyet", $dizi_dil, $sistem_dil ); ?></label>
                                                            <div class='icheck-maroon d-inline '>
                                                                <input type='radio' class='form-control form-control-sm' id='kadin2' name='cinsiyet' value="1" <?php if( $_REQUEST[ "cinsiyet" ] == 1 ) echo "checked"; ?> >
                                                                <label for='kadin2'>
                                                                    <?php echo dil_cevir( "Kadın", $dizi_dil, $sistem_dil ); ?>
                                                                </label>
                                                            </div>
                                                            <div class='icheck-primary d-inline'>
                                                                <input type='radio' class='form-control form-control-sm' id='erkek2' name='cinsiyet' value="2" <?php if( $_REQUEST[ "cinsiyet" ] == 2 ) echo "checked"; ?> >
                                                                <label for='erkek2'>
                                                                    <?php echo dil_cevir( "Erkek", $dizi_dil, $sistem_dil ); ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-lg-4">
                                                        <div class="card card-body">
                                                            <label class="control-label"><?php echo dil_cevir( "Medeni Durumu", $dizi_dil, $sistem_dil ); ?></label>
                                                            <div class='icheck-primary d-inline '>
                                                                <input type='radio' class='form-control form-control-sm' id='bekar' name='medeni_durumu' value="1" <?php if( $tek_personel[ "medeni_durumu" ] == 1 ) echo "checked"; ?> >
                                                                <label for='bekar'>
                                                                    <?php echo dil_cevir( "Bekar", $dizi_dil, $sistem_dil ); ?>
                                                                </label>
                                                            </div>
                                                            <div class='icheck-primary d-inline'>
                                                                <input type='radio' class='form-control form-control-sm' id='evli' name='medeni_durumu' value="2" <?php if( $tek_personel[ "medeni_durumu" ] == 2 ) echo "checked"; ?> >
                                                                <label for='evli'>
                                                                    <?php echo dil_cevir( "Evli", $dizi_dil, $sistem_dil ); ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-lg-4">
                                                        <div class="card card-body">
                                                            <label class="control-label"><?php echo dil_cevir( "Engel Durumu", $dizi_dil, $sistem_dil ); ?></label>
                                                            <div class='icheck-primary d-inline '>
                                                                <input onclick="egitim_bilgileri_degistir(this)" type='radio' class='form-control form-control-sm' id='engel_yok' name='engel_durumu' value="1" <?php if( $tek_personel[ "engel_durumu" ] == 1 ) echo "checked"; ?> >
                                                                <label for='engel_yok'>
                                                                    <?php echo dil_cevir( "Yok", $dizi_dil, $sistem_dil ); ?>
                                                                </label>
                                                            </div>
                                                            <div class='icheck-primary d-inline'>
                                                                <input onclick="egitim_bilgileri_degistir(this)" type='radio' class='form-control form-control-sm' id='engel_var' name='engel_durumu' value="2" <?php if( $tek_personel[ "engel_durumu" ] == 2 ) echo "checked"; ?> >
                                                                <label for='engel_var'>
                                                                    <?php echo dil_cevir( "Var", $dizi_dil, $sistem_dil ); ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                    </div>
                                    <div class="card-footer">
                                        <button modul= 'personeller' yetki_islem="filtrele" name="filtre"  type="submit" class="btn btn-sm btn-success"><?php echo dil_cevir( "Filtrele", $dizi_dil, $sistem_dil ); ?></button>                           
                                    </div>
                                </div>
                            </form>
                        </div>
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link bg-olive active buton_grid" role="button" data-toggle="tab"><i class="fa fa-th-large"></i> Grid</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link buton_liste" role="button"  data-toggle="tab"><i class="fa fa-bars"></i> List</a>
                            </li>
                        </ul>
                        <script>
                            $('.buton_liste').on('click', function() {
                                $(".buton_liste").addClass("bg-olive");
                                $(".buton_grid").removeClass("bg-olive");
                                $(".personel_grid").addClass("d-none");
                                $(".personel_liste").removeClass("d-none");
                            } );                           
                            $('.buton_grid').on('click', function() {
                                $(".buton_grid").addClass("bg-olive");
                                $(".buton_liste").removeClass("bg-olive");
                                $(".personel_liste").addClass("d-none");
                                $(".personel_grid").removeClass("d-none");
                            } );         
                        </script>
                        <br>
                        <div class="personel_grid row ">
                            <div class="col-12 p-0">
                                <form class="form-inline" action="index.php?modul=personeller" method="POST">
                                    <div class="input-group col-md-4 mb-3 w-100">
                                        <input type="text" name="ara" value = "<?php echo $_REQUEST['ara']; ?>" class="form-control" placeholder="<?php echo dil_cevir( "IIN No", $dizi_dil, $sistem_dil ); ?>, <?php echo dil_cevir( "Adı Soyadı", $dizi_dil, $sistem_dil ); ?>, <?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?>" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-success" type="submit"><?php echo dil_cevir( "Ara", $dizi_dil, $sistem_dil ); ?></button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <?php $sayi = 1; foreach( $personeller AS $personel ) { 
                                $sayfa_class="sayfa_".ceil($sayi / $sayfa_kayit_sayisi);
								if( $personel[ "foto" ] == "resim_yok.png" or $personel[ "foto" ] == "" )
									$personel_resim = $personel[ "cinsiyet" ]."resim_yok.png";
								else
									$personel_resim = $personel[ "foto" ];
							?>
                            <div class="<?php echo $sayfa_class; ?> sayfalar col-12 col-sm-6 col-md-4 <?php echo $sayi > $sayfa_kayit_sayisi ? "d-none" : "d-flex"; ?> align-items-stretch flex-column ">
                                <div class="card bg-light d-flex flex-fill d-none">
                                    <div class="card-header text-muted border-bottom-0">
                                    <?php echo $personel[ 'personel_nitelik'.$dil ]; ?>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-7">
                                            <?php if( $personel[ 'uyruk_id' ] == 113 ){ ?>
                                            <h2 class="lead"><b><?php echo $personel[ 'soyadi'.$dil ]; ?> <?php echo $personel[ 'adi'.$dil ]; ?>  <?php echo $personel[ 'baba_adi'.$dil ]; ?></b></h2>
                                            <?php }else{ ?>
                                            <h2 class="lead"><b><?php echo $personel[ 'adi'.$dil ]; ?> <?php echo $personel[ 'soyadi'.$dil ]; ?></b></h2>
                                            <?php } ?>
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
                                            <img style="object-fit: cover; height: 150px; width: 150px; " src="resimler/personel_resimler/<?php echo $personel_resim;?>" alt="user-avatar" class="img-circle img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                    <div class="text-right">
                                        <a href="index.php?modul=personelDetay&personel_id=<?php echo $personel[ "id" ];?>" class="btn btn-sm bg-olive">
                                        <i class="fas fa-address-card"></i> <?php echo dil_cevir( "Personel Detay", $dizi_dil, $sistem_dil ); ?>
                                        </a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <?php $sayi++; } ?>
                            <div class="col-12">
                                <nav aria-label="Contacts Page Navigation">
                                    <ul class="pagination justify-content-center m-0">
                                        <li class="page-item"><a class="page-link sayfalama" data-sayfa_no="1" role="button"><i class="fas fa-angle-double-left"></i></a></li>
                                        <li class="page-item geri disabled"><a class="page-link sayfalama geri" data-sayfa_no="" role="button"><i class="fas fa-angle-left"></i></a></li>
                                        <?php 
                                        for( $i = 1; $i <= $max_sayfa_no; $i++ ){ 
                                        ?>
                                        <li class="page-item pages page_<?php echo $i; ?> <?php echo $i == 1 ?  "active" :""; ?>"><a class="page-link sayfalama" data-sayfa_no="<?php echo $i; ?>" role="button"><?php echo $i; ?></a></li>
                                        <?php } ?>
                                        <li class="page-item ileri"><a class="page-link sayfalama ileri" data-sayfa_no="" role="button"><i class="fas fa-angle-right"></i></a></li>
                                        <li class="page-item"><a class="page-link sayfalama" data-sayfa_no="<?php echo $max_sayfa_no; ?>" role="button"><i class="fas fa-angle-double-right"></i></a></li>
                                        <!-- <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                                        <li class="page-item"><a class="page-link" href="#">7</a></li>
                                        <li class="page-item"><a class="page-link" href="#">8</a></li> -->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="personel_liste d-none">
                            <table id="tbl_personeller" class="table table-bordered table-hover table-sm" width = "100%" >
                                <thead>
                                    <tr>
                                        <th style="width: 15px">#</th>
                                        <!-- <th><?php echo dil_cevir( "IIN No", $dizi_dil, $sistem_dil ); ?></th> -->
                                        <th><?php echo dil_cevir( "Adı Soyadı", $dizi_dil, $sistem_dil ); ?></th>
                                        <th><?php echo dil_cevir( "Personel Nitelik", $dizi_dil, $sistem_dil ); ?></th>
                                        <!-- <th><?php echo dil_cevir( "Kadro Tipi", $dizi_dil, $sistem_dil ); ?></th>
                                        <th><?php echo dil_cevir( "Akademik Derece", $dizi_dil, $sistem_dil ); ?></th>
                                        <th><?php echo dil_cevir( "Akademik Unvan", $dizi_dil, $sistem_dil ); ?></th> -->
                                        <th><?php echo dil_cevir( "Üst Birim", $dizi_dil, $sistem_dil ); ?></th>
                                        <th><?php echo dil_cevir( "Birim", $dizi_dil, $sistem_dil ); ?></th>
                                        <!--th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Profil", $dizi_dil, $sistem_dil ); ?></th-->
                                        <th data-priority="1" style=""><?php echo dil_cevir( "Personel Detay", $dizi_dil, $sistem_dil ); ?></th>
                                        <th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sayi = 1; foreach( $personeller AS $personel ) { ?>
                                    <tr oncontextmenu="fun();" class ="ogretim_elemanlari-Tr <?php if( $personel[ 'id' ] == $personel_id ) echo $satir_renk; ?>" data-id="<?php echo $personel[ 'id' ]; ?>">
                                        <td><?php echo $sayi++; ?></td>
                                        <!-- <td><?php echo "********".substr($personel[ "in_no" ], -4); ?></td> -->
                                        <td><?php echo $personel[ 'adi'.$dil ]." ".$personel[ 'soyadi'.$dil ]; ?></td>
                                        <td><?php echo $personel[ 'personel_nitelik'.$dil ]; ?></td>
                                        <!-- <?php if( $personel[ 'personel_nitelik_id' ] == 1 OR $personel[ 'personel_nitelik_id' ] == 3 ){ ?>
                                            <td><?php echo $personel[ 'akademik_kadro_tipi'.$dil ]; ?></td>
                                        <?php }else{ ?>
                                            <td><?php echo $personel[ 'idari_kadro_tipi'.$dil ]; ?></td>
                                        <?php } ?>
                                        <td><?php echo $personel[ 'akademik_derece'.$dil ]; ?></td>
                                        <td><?php echo $personel[ 'akademik_unvan'.$dil ]; ?></td> -->
                                        <td><?php echo $personel[ 'ust_birim_adi'.$dil ]; ?></td>
                                        <td><?php echo $personel[ 'birim_adi'.$dil ]; ?></td>
                                        <!--td align = "center">
                                            <a modul = 'personeller' yetki_islem="profil_goster" class="text-olive" href = "?modul=personelProfil&personel_id=<?php echo $personel[ 'id' ]; ?>" >
                                                <h5><i class="fas fa-id-card"></i></h5>
                                            </a>
                                        </td-->
                                        <td align = "center">
                                            <a modul = 'personeller' yetki_islem="duzenle" class = "btn btn-sm bg-olive btn-xs" href = "?modul=personelDetay&personel_id=<?php echo $personel[ 'id' ]; ?>" >
                                                <i class="fas fa-address-card"></i> <?php echo dil_cevir( "Personel Detay", $dizi_dil, $sistem_dil ); ?>
                                            </a>
                                        </td>
                                        <td align = "center">
                                            <button modul= 'personeller' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/personeller/personellerSEG.php?islem=sil&personel_id=<?php echo $personel[ 'id' ]; ?>" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
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
</script>
<script>
    var gosterilecek_max_sayfa_no = 7;
    var max_sayfa_no = <?php echo $max_sayfa_no; ?>;
    if( max_sayfa_no > 1 )
        $( ".ileri" ).data( "sayfa_no", 2 );
    else
        $( ".ileri" ).addClass( "disabled" );

    for( var i = gosterilecek_max_sayfa_no+1; i <= max_sayfa_no; i++ ){
        $( ".page_"+i ).addClass( "d-none" );
    }

    $('.sayfalama').on("click", function(e) { 
        var sayfa_no    = $(this).data("sayfa_no");
        $( ".ileri" ).data( "sayfa_no", sayfa_no+1 );
        if( sayfa_no > 1 ){
            $( ".geri" ).removeClass( "disabled" );
            $( ".geri" ).data( "sayfa_no", sayfa_no-1 );
        }
        if( sayfa_no == 1 ){
            $( ".geri" ).addClass( "disabled" );
        }
        if( sayfa_no == max_sayfa_no ){
            $( ".ileri" ).addClass( "disabled" );
        }else{
            $( ".ileri" ).removeClass( "disabled" );
        }
        $( ".sayfalar" ).removeClass( "d-flex" );
        $( ".sayfalar" ).addClass( "d-none" );
        $( ".sayfa_"+sayfa_no ).addClass( "d-flex" );
        $( ".pages" ).removeClass( "active" );
        $( ".page_"+sayfa_no ).addClass( "active" );

        $( ".pages" ).removeClass( "d-none" );
        for( var i = 1; i < sayfa_no; i++ ){
            if( (max_sayfa_no - i) >= 7 )
            $( ".page_"+i ).addClass( "d-none" );
        }
        for( var i = sayfa_no+gosterilecek_max_sayfa_no; i <= max_sayfa_no; i++ ){
            $( ".page_"+i ).addClass( "d-none" );
        }
    });
</script>

<?php 
    if( isset($_REQUEST['ara']) ){
?>
    <script>
        $('.buton_grid').trigger( "click" );
    </script>;
<?php
    }
?>                  


	<script>
		var select_personel_nitelik = document.getElementById('personel_nitelik_id');
		<?php if( isset($_REQUEST['personel_nitelik_id'] )){ ?>
			select_personel_nitelik.value = "<?php echo $_REQUEST['personel_nitelik_id'];  ?>";
		<?php }?>



		select_personel_nitelik.dispatchEvent(new Event('change'));

		function kadro_tipi_degistir(eleman){
			if( eleman.value == "1" ){
				$('.akademik_kadrolar').css('display','block');
				$('.idari_kadrolar').css('display','none');
                $("#akademik_kadro_tipi_id").attr("required","required");
                $("#idari_kadro_tipi_id").removeAttr("required");
                $("#idari_kadro_tipi_id").val('').change();
            }else if( eleman.value == "2" ){
				$('.akademik_kadrolar').css('display','none');
				$('.idari_kadrolar').css('display','block');
                $("#idari_kadro_tipi_id").attr("required","required");
                $("#akademik_kadro_tipi_id").removeAttr("required");
                $("#akademik_kadro_tipi_id").val('').change();
            }else if( eleman.value == "3" ){
				$('.akademik_kadrolar').css('display','block');
				$('.idari_kadrolar').css('display','none');
                $("#akademik_kadro_tipi_id").attr("required","required");
                $("#idari_kadro_tipi_id").removeAttr("required");
                $("#idari_kadro_tipi_id").val('').change();
            }else{
				$('.idari_kadrolar').css('display','none');
                $("#akademik_kadro_tipi_id").removeAttr("required");
                $("#idari_kadro_tipi_id").removeAttr("required");
                $("#akademik_kadro_tipi_id").val('').change();
                $("#idari_kadro_tipi_id").val('').change();
            }
		}
	</script>
<script>

$(document).ready(function(){

$( function() {
	$( "#personel_kullanici_resim" ).click( function() {
		$( "#gizli_input_file" ).trigger( 'click' );
	});
});
	var $modal = $('#modal_personel_resim');
	var image = document.getElementById('sample_image');
	var cropper;

	//$("body").on("change", ".image", function(e){
	$('#gizli_input_file').change(function(event){
    	var files = event.target.files;
    	var done = function (url) {
      		image.src = url;
      		$modal.modal('show');
    	};
    	//var reader;
    	//var file;
    	//var url;

    	if (files && files.length > 0)
    	{
      		/*file = files[0];
      		if(URL)
      		{
        		done(URL.createObjectURL(file));
      		}
      		else if(FileReader)
      		{*/
        		reader = new FileReader();
		        reader.onload = function (event) {
		          	done(reader.result);
		        };
        		reader.readAsDataURL(files[0]);
      		//}
    	}
	});

	$modal.on('shown.bs.modal', function() {
    	cropper = new Cropper(image, {
    		aspectRatio: 1,
    		viewMode: 3,
    		preview: '.preview'
    	});
	}).on('hidden.bs.modal', function() {
   		cropper.destroy();
   		cropper = null;
	});

	$("#crop").click(function(){
    	canvas = cropper.getCroppedCanvas({
      		width: 600,
      		height: 600,
    	});

    	canvas.toBlob(function(blob) {
        	//url = URL.createObjectURL(blob);
        	var reader = new FileReader();
         	reader.readAsDataURL(blob); 
         	reader.onloadend = function() {
            	var base64data = reader.result;  
				$('#uploaded_image').attr('src', base64data);
				$modal.modal('hide');
            	// $.ajax({
            		// url: "upload.php",
                	// method: "POST",                	
                	// data: {image: base64data},
                	// success: function(data){
                    	// console.log(data);
                    	// $modal.modal('hide');
                    	// $('#uploaded_image').attr('src', data);
                    	// //alert("success upload image");
                	// }
              	// });
         	}
    	});
    });
	
});
</script>


<!-- <script>
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
</script> -->
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
		$('#filtre_baslama_tarihi').datetimepicker({
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
	"stateSave": false,
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
