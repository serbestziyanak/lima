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


$islem						= "guncelle";
$personel_id				= array_key_exists( 'personel_id' ,$_REQUEST ) ? $_REQUEST[ 'personel_id' ]	: $_SESSION[ 'kullanici_id' ];

$SQL_tek_personel_oku = <<< SQL
SELECT 
	p.*
    ,roller.id          AS rol_id
    ,roller.adi         AS rol_adi
    ,roller.adi_kz      AS rol_adi_kz
    ,roller.adi_en      AS rol_adi_en
    ,roller.adi_ru      AS rol_adi_ru
    ,pn.id         AS personel_nitelik_id
    ,pn.adi         AS personel_nitelik_adi
    ,pn.adi_kz      AS personel_nitelik_adi_kz
    ,pn.adi_en      AS personel_nitelik_adi_en
    ,pn.adi_ru      AS personel_nitelik_adi_ru
    ,bvk.adi         AS pasaportu_veren_kurum
    ,bvk.adi_kz      AS pasaportu_veren_kurum_kz
    ,bvk.adi_en      AS pasaportu_veren_kurum_en
    ,bvk.adi_ru      AS pasaportu_veren_kurum_ru
    ,uyruk.id      AS uyruk_id
    ,uyruk.adi      AS uyruk
    ,uyruk.adi_kz   AS uyruk_kz
    ,uyruk.adi_en   AS uyruk_en
    ,uyruk.adi_ru   AS uyruk_ru
    ,ulus.adi       AS ulus
    ,ulus.adi_kz    AS ulus_kz
    ,ulus.adi_en    AS ulus_en
    ,ulus.adi_ru    AS ulus_ru
    ,ulke.adi       AS dogdugu_ulke
    ,ulke.adi_kz    AS dogdugu_ulke_kz
    ,ulke.adi_en    AS dogdugu_ulke_en
    ,ulke.adi_ru    AS dogdugu_ulke_ru
    ,p_ulke.adi       AS p_ulke
    ,p_ulke.adi_kz    AS p_ulke_kz
    ,p_ulke.adi_en    AS p_ulke_en
    ,p_ulke.adi_ru    AS p_ulke_ru
    ,kg.adi         AS kan_grubu
FROM 
	tb_personeller AS p
LEFT JOIN tb_personel_calisma_yeri_bilgileri AS pab ON p.id = pab.personel_id AND pab.aktif_calisma_yeri=1
LEFT JOIN tb_personel_nitelikleri AS pn ON pn.id = pab.personel_nitelik_id
LEFT JOIN tb_ulkeler AS uyruk ON uyruk.id = p.uyruk_id
LEFT JOIN tb_uluslar AS ulus ON ulus.id = p.ulus_id
LEFT JOIN tb_kan_gruplari AS kg ON kg.id = p.kan_grubu_id	
LEFT JOIN tb_ulkeler AS ulke ON ulke.id = p.dogdugu_ulke_id
LEFT JOIN tb_ulkeler AS p_ulke ON p_ulke.id = p.pasaportu_aldigi_ulke_id
LEFT JOIN tb_belgeyi_veren_kurumlar AS bvk ON bvk.id = p.pasaportu_veren_kurum_id
LEFT JOIN tb_roller AS roller ON roller.id = p.rol_id
WHERE
p.id = ? AND p.aktif = 1 
SQL;

$SQL_personel_vize_bilgileri = <<< SQL
SELECT
	 pvb.*
    ,eoy.adi AS egitim_ogretim_yili
    ,bvk.adi AS belgeyi_veren_kurum
    ,bvk.adi_kz AS belgeyi_veren_kurum_kz
    ,bvk.adi_en AS belgeyi_veren_kurum_en
    ,bvk.adi_ru AS belgeyi_veren_kurum_ru
FROM
	tb_personel_vize_bilgileri AS pvb
LEFT JOIN tb_egitim_ogretim_yillari AS eoy ON eoy.id = pvb.egitim_ogretim_yili_id
LEFT JOIN tb_belgeyi_veren_kurumlar AS bvk ON bvk.id = pvb.belgeyi_veren_kurum_id
WHERE 
    pvb.personel_id = ?
ORDER BY pvb.baslama_tarihi DESC
SQL;

$SQL_personel_calisma_yeri_bilgileri = <<< SQL
SELECT
	 pab.*
     ,eoy.adi       AS egitim_ogretim_yili
	 ,b.adi         AS birim_adi
	 ,b.adi_kz      AS birim_adi_kz
	 ,b.adi_en      AS birim_adi_en
	 ,b.adi_ru      AS birim_adi_ru
	 ,pn.adi         AS personel_nitelik
	 ,pn.adi_kz      AS personel_nitelik_kz
	 ,pn.adi_en      AS personel_nitelik_en
	 ,pn.adi_ru      AS personel_nitelik_ru
	 ,akt.adi         AS akademik_kadro_tipi
	 ,akt.adi_kz      AS akademik_kadro_tipi_kz
	 ,akt.adi_en      AS akademik_kadro_tipi_en
	 ,akt.adi_ru      AS akademik_kadro_tipi_ru
	 ,ikt.adi         AS idari_kadro_tipi
	 ,ikt.adi_kz      AS idari_kadro_tipi_kz
	 ,ikt.adi_en      AS idari_kadro_tipi_en
	 ,ikt.adi_ru      AS idari_kadro_tipi_ru
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
	 ,it.adi         AS istihdam_turu
	 ,it.adi_kz      AS istihdam_turu_kz
	 ,it.adi_en      AS istihdam_turu_en
	 ,it.adi_ru      AS istihdam_turu_ru
	 ,ba.adi         AS bilimsel_alani
	 ,ba.adi_kz      AS bilimsel_alani_kz
	 ,ba.adi_en      AS bilimsel_alani_en
	 ,ba.adi_ru      AS bilimsel_alani_ru
FROM
	tb_personel_calisma_yeri_bilgileri AS pab
LEFT JOIN tb_egitim_ogretim_yillari AS eoy ON eoy.id = pab.egitim_ogretim_yili_id
LEFT JOIN tb_birim_agaci AS b ON b.id = pab.birim_id
LEFT JOIN tb_akademik_kadro_tipleri AS akt ON akt.id = pab.akademik_kadro_tipi_id
LEFT JOIN tb_idari_kadro_tipleri AS ikt ON ikt.id = pab.idari_kadro_tipi_id
LEFT JOIN tb_akademik_dereceler AS ad ON ad.id = pab.akademik_derece_id
LEFT JOIN tb_akademik_unvanlar AS au ON au.id = pab.akademik_unvan_id
LEFT JOIN tb_istihdam_turleri AS it ON it.id = pab.istihdam_turu_id
LEFT JOIN tb_hizmet_turleri AS ht ON ht.id = pab.hizmet_turu_id
LEFT JOIN tb_personel_nitelikleri AS pn ON pn.id = pab.personel_nitelik_id
LEFT JOIN tb_bilimsel_alanlar AS ba ON ba.id = pab.bilimsel_alan_id
WHERE 
    pab.personel_id = ?
ORDER BY pab.egitim_ogretim_yili_id DESC
SQL;

$SQL_personel_akademik_unvan_bilgileri = <<< SQL
SELECT
	 pab.*
	 ,au.adi         AS akademik_unvan
	 ,au.adi_kz      AS akademik_unvan_kz
	 ,au.adi_en      AS akademik_unvan_en
	 ,au.adi_ru      AS akademik_unvan_ru
	 ,ba.adi         AS bilimsel_alani
	 ,ba.adi_kz      AS bilimsel_alani_kz
	 ,ba.adi_en      AS bilimsel_alani_en
	 ,ba.adi_ru      AS bilimsel_alani_ru
FROM
	tb_personel_akademik_unvan_bilgileri AS pab
LEFT JOIN tb_akademik_unvanlar AS au ON au.id = pab.akademik_unvan_id
LEFT JOIN tb_bilimsel_alanlar AS ba ON ba.id = pab.bilimsel_alan_id
WHERE 
    pab.personel_id = ?
ORDER BY au.id
SQL;

$SQL_personel_uzmanlik_alanlari = <<< SQL
SELECT
	*
FROM
	tb_uzmanlik_alanlari
WHERE 
    id = ?
SQL;

$SQL_personel_egitim_bilgileri = <<< SQL
SELECT
	peb.*
    ,ed.adi     AS egitim_duzeyi_adi
    ,ed.adi_kz  AS egitim_duzeyi_adi_kz
    ,ed.adi_en  AS egitim_duzeyi_adi_en
    ,ed.adi_ru  AS egitim_duzeyi_adi_ru
    ,ulk.adi    AS ulke_adi
    ,ulk.adi_kz AS ulke_adi_kz
    ,ulk.adi_en AS ulke_adi_en
    ,ulk.adi_ru AS ulke_adi_ru
FROM
	tb_personel_egitim_bilgileri AS peb
LEFT JOIN tb_egitim_duzeyleri AS ed ON ed.id = peb.egitim_duzeyi_id
LEFT JOIN tb_ulkeler AS ulk ON ulk.id = peb.ulke_id
WHERE 
    peb.personel_id = ?
ORDER BY ed.sira DESC
SQL;

$SQL_personel_sertifika_bilgileri = <<< SQL
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

$SQL_personel_gorevler = <<< SQL
SELECT 
	g.*
	,ba.adi AS birim_adi
	,ba.adi_kz AS birim_adi_kz
	,ba.adi_en AS birim_adi_en
	,ba.adi_ru AS birim_adi_ru
	,gk.adi as gorev_adi
	,gk.adi_kz as gorev_adi_kz
	,gk.adi_en as gorev_adi_en
	,gk.adi_ru as gorev_adi_ru
	,gt.adi as gorev_turu
	,gt.adi_kz as gorev_turu_kz
	,gt.adi_en as gorev_turu_en
	,gt.adi_ru as gorev_turu_ru
FROM 
	tb_gorevler as g
LEFT JOIN tb_birim_agaci AS ba ON ba.id = g.birim_id
LEFT JOIN tb_gorev_turleri AS gt ON gt.id = g.gorev_turu_id
LEFT JOIN tb_gorev_kategorileri AS gk ON gk.id = g.gorev_kategori_id
WHERE 
	g.personel_id = ?
SQL;

$SQL_personel_izinler = <<< SQL
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

$SQL_personel_buyruklar = <<< SQL
SELECT 
	b.*
    ,eoy.adi    AS egitim_ogretim_yili
	,bt.adi     AS buyruk_turu
	,bt.adi_kz  AS buyruk_turu_kz
	,bt.adi_en  AS buyruk_turu_en
	,bt.adi_ru  AS buyruk_turu_ru
FROM 
	tb_personel_buyruklar as b
LEFT JOIN tb_egitim_ogretim_yillari AS eoy ON eoy.id = b.egitim_ogretim_yili_id
LEFT JOIN tb_buyruk_turleri AS bt ON bt.id = b.buyruk_turu_id
WHERE 
	b.personel_id = ?
SQL;

$SQL_personel_sozlesmeler = <<< SQL
SELECT 
	s.*
    ,eoy.adi    AS egitim_ogretim_yili
	,st.adi     AS sozlesme_turu
	,st.adi_kz  AS sozlesme_turu_kz
	,st.adi_en  AS sozlesme_turu_en
	,st.adi_ru  AS sozlesme_turu_ru
	,it.adi     AS istihdam_turu
	,it.adi_kz  AS istihdam_turu_kz
	,it.adi_en  AS istihdam_turu_en
	,it.adi_ru  AS istihdam_turu_ru
    ,ht.adi         AS hizmet_turu
    ,ht.adi_kz      AS hizmet_turu_kz
    ,ht.adi_en      AS hizmet_turu_en
    ,ht.adi_ru      AS hizmet_turu_ru
    ,icd.adi         AS isten_cikis_nedeni
    ,icd.adi_kz      AS isten_cikis_nedeni_kz
    ,icd.adi_en      AS isten_cikis_nedeni_en
    ,icd.adi_ru      AS isten_cikis_nedeni_ru
    ,buyruk.buyruk_no
    ,buyruk.belge
FROM 
	tb_personel_sozlesmeler as s
LEFT JOIN tb_egitim_ogretim_yillari AS eoy ON eoy.id = s.egitim_ogretim_yili_id
LEFT JOIN tb_sozlesme_turleri AS st ON st.id = s.sozlesme_turu_id
LEFT JOIN tb_istihdam_turleri AS it ON it.id = s.istihdam_turu_id
LEFT JOIN tb_hizmet_turleri AS ht ON ht.id = s.hizmet_turu_id
LEFT JOIN tb_personel_buyruklar AS buyruk ON buyruk.id = s.buyruk_id
LEFT JOIN tb_isten_cikis_nedenleri AS icd ON icd.id = s.isten_cikis_neden_id

WHERE 
	s.personel_id = ?
SQL;

$SQL_personel_statlar = <<< SQL
SELECT 
	s.*
	,ba.adi AS birim_adi
	,ba.adi_kz AS birim_adi_kz
	,ba.adi_en AS birim_adi_en
	,ba.adi_ru AS birim_adi_ru
    ,eoy.adi    AS egitim_ogretim_yili
	,st.adi     AS istihdam_turu
	,st.adi_kz  AS istihdam_turu_kz
	,st.adi_en  AS istihdam_turu_en
	,st.adi_ru  AS istihdam_turu_ru
FROM 
	tb_personel_statlar as s
LEFT JOIN tb_birim_agaci AS ba ON ba.id = s.birim_id
LEFT JOIN tb_egitim_ogretim_yillari AS eoy ON eoy.id = s.egitim_ogretim_yili_id
LEFT JOIN tb_istihdam_turleri AS st ON st.id = s.istihdam_turu_id
WHERE 
	s.personel_id = ?
SQL;

$SQL_personel_emekli_bilgileri = <<< SQL
SELECT 
	eb.*
    ,eoy.adi    AS egitim_ogretim_yili
FROM 
	tb_personel_emekli_bilgileri AS eb
LEFT JOIN tb_egitim_ogretim_yillari AS eoy ON eoy.id = eb.egitim_ogretim_yili_id
WHERE 
	eb.personel_id = ?
SQL;

$SQL_ulkeler = <<< SQL
SELECT
	 *
FROM
	tb_ulkeler
ORDER BY alfa2_kodu
SQL;

$SQL_uluslar = <<< SQL
SELECT
	 *
FROM
	tb_uluslar
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

$SQL_belgeyi_veren_kurumlar = <<< SQL
SELECT
	*
FROM 
	tb_belgeyi_veren_kurumlar
SQL;

$SQL_tum_personel_odul_bilgileri = <<< SQL
SELECT
	 pob.*
    ,ovk.adi AS odulu_veren_kurum
    ,ovk.adi_kz AS odulu_veren_kurum_kz
    ,ovk.adi_en AS odulu_veren_kurum_en
    ,ovk.adi_ru AS odulu_veren_kurum_ru
    ,od.adi 	 AS odul_adi
    ,od.adi_kz AS odul_adi_kz
    ,od.adi_en AS odul_adi_en
    ,od.adi_ru AS odul_adi_ru
    ,ot.adi 	 AS odul_turu
    ,ot.adi_kz AS odul_turu_kz
    ,ot.adi_en AS odul_turu_en
    ,ot.adi_ru AS odul_turu_ru
FROM
	tb_personel_odul_bilgileri AS pob
LEFT JOIN tb_odul_veren_kurumlar AS ovk ON ovk.id = pob.odulu_veren_kurum_id
LEFT JOIN tb_odul_adlari AS od ON od.id = pob.odul_adi_id
LEFT JOIN tb_odul_turleri AS ot ON ot.id = pob.odul_turu_id
WHERE 
    pob.personel_id = ?
ORDER BY pob.odul_tarihi DESC
SQL;

$SQL_personel_nitelikleri = <<< SQL
SELECT
	*
FROM 
	tb_personel_nitelikleri
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

@$birim_agacilar 		    = $vt->select($SQL_birim_agaci_getir, array(  ) )[ 2 ];
@$tek_personel				= $vt->select( $SQL_tek_personel_oku, array( $personel_id ) )[ 2 ][ 0 ];		
$oduller	    			= $vt->select( $SQL_tum_personel_odul_bilgileri, array( $personel_id ) )[ 2 ];		
$vizeler	    			= $vt->select( $SQL_personel_vize_bilgileri, array( $personel_id ) )[ 2 ];		
$calisma_yeri_bilgileri 	= $vt->select( $SQL_personel_calisma_yeri_bilgileri, array( $personel_id ) )[ 2 ];		
$akademik_bilgiler       	= $vt->select( $SQL_personel_akademik_unvan_bilgileri, array( $personel_id ) )[ 2 ];		
$egitim_bilgileri  			= $vt->select( $SQL_personel_egitim_bilgileri, array( $personel_id ) )[ 2 ];	
$sertifika_bilgileri 		= $vt->select( $SQL_personel_sertifika_bilgileri, array( $personel_id ) )[ 2 ];	
$gorevler         			= $vt->select( $SQL_personel_gorevler, array( $personel_id ) )[ 2 ];	
$izinler         			= $vt->select( $SQL_personel_izinler, array( $personel_id ) )[ 2 ];	
$buyruklar         			= $vt->select( $SQL_personel_buyruklar, array( $personel_id ) )[ 2 ];	
$sozlesmeler       			= $vt->select( $SQL_personel_sozlesmeler, array( $personel_id ) )[ 2 ];	
$statlar       			    = $vt->select( $SQL_personel_statlar, array( $personel_id ) )[ 2 ];	
$emekli_bilgileri		    = $vt->select( $SQL_personel_emekli_bilgileri, array( $personel_id ) )[ 2 ];	
$personel_nitelikleri 	    = $vt->select($SQL_personel_nitelikleri, array(  ) )[ 2 ];
$ulkeler				    = $vt->select( $SQL_ulkeler, array(  ) )[ 2 ];
$uluslar				    = $vt->select( $SQL_uluslar, array(  ) )[ 2 ];
$kan_gruplari			    = $vt->select( $SQL_kan_gruplari, array(  ) )[ 2 ];
$belgeyi_veren_kurumlar     = $vt->select( $SQL_belgeyi_veren_kurumlar, array(  ) )[ 2 ];
$roller		                = $vt->select( $SQL_roller, array(  ) )[ 2 ];

	$birim_idler = explode(",",$tek_personel[ 'birim_idler' ]);
	foreach( $birim_idler as $birim_id2 ){
		$ust_idler	= $vt->select( $SQL_ust_id_getir, array( $birim_id2 ) )[ 2 ];
		foreach($ust_idler as $ust_id) 
			$ust_id_dizi[] = $ust_id['id'];
	}
	$ust_id_dizi = array_unique($ust_id_dizi);
	sort($ust_id_dizi);
	$birim_idler2 = implode(",",$ust_id_dizi);
	$where = "WHERE id IN (".$birim_idler2.")";

$SQL_birim_agaci_getir2 = <<< SQL
SELECT
	*
FROM 
	tb_birim_agaci
$where
SQL;
@$birim_agacilar2 		    = $vt->select($SQL_birim_agaci_getir2, array(  ) )[ 2 ];

foreach($alt_idler as $alt_id) 
	$ust_id_dizi[] = $alt_id['ust_id'];

// var_dump($akademik_bilgiler);
if( $tek_personel[ "foto" ] == "resim_yok.png" or $tek_personel[ "foto" ] == "" )
    $personel_foto = $tek_personel[ "cinsiyet" ]."resim_yok.png";
else
    $personel_foto = $tek_personel[ "foto" ];
                            
?>
<style>
    .collapsed-card .card-header {
            height:100px;
            background-image: url('resimler/logolar/ayu_logo_beyaz_yazisiz.png');
            background-size: 80px;
            background-repeat: no-repeat;
            background-position: bottom right;
    }
    .collapsing-card .card-header {
            height:100px;
            background-image: url('resimler/logolar/ayu_logo_beyaz_yazisiz.png');
            background-size: 80px;
            background-repeat: no-repeat;
            background-position: bottom right;
    }
    .expanding-card .card-header {
            height:100%;
            background-image: none;
    }

    .renk1{ background-color:#112F41 !important;}
    .renk2{ background-color:#068587 !important;}
    .renk3{ background-color:#4FB99F !important;}
    .renk4{ background-color:#F2B134 !important;}
    .renk5{ background-color:#ED553B !important;}
    .renk6{ background-color:#355B8C !important;}
    .renk7{ background-color:#FE5F1B !important;}
    .renk8{ background-color:#33ABB1 !important;}
    .renk9{ background-color:#CC9612 !important;}
    .renk10{background-color:#103754 !important;}
    .renk11{background-color:#284F47 !important;}
    .renk12{background-color:#334F70 !important;}
    .renk13{background-color:#D53D13 !important;}
    .renk14{background-color:#F76A24 !important;}
    .renk15{background-color:#0080D1 !important;}
    .renk16{background-color:#581659 !important;}
    .renk17{background-color:#008773 !important;}
    .renk18{background-color:#6BB983 !important;}
    .renk19{background-color:#F2C975 !important;}
    .renk20{background-color:#ED6353 !important;}                
</style>
<div class="modal fade" id="demografik_bilgiler" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action = "_modul/personelDetay/demografikSEG.php" method = "POST" enctype="multipart/form-data">
                <?php foreach( array_keys($tek_personel) as $anahtar ){ ?>
                <input type="hidden" id="<?php echo "demografik_bilgiler_gizli_".$anahtar;  ?>"  name="<?php echo $anahtar;  ?>" value="<?php echo htmlentities($tek_personel[$anahtar]);  ?>">
                <?php } ?>

                <input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
                <input type = "hidden" name = "personel_id" value = "<?php echo $personel_id; ?>">

                <div class="modal-header bg-gray-dark">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo dil_cevir( "Demografik Bilgiler", $dizi_dil, $sistem_dil ); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
							<div class="text-center">
								<img class="img-fluid img-circle img-thumbnail mw-100"
									style="width:120px; cursor:pointer;"
									src="resimler/personel_resimler/<?php echo $personel_foto; ?>" 
									alt="User profile picture"
									id = "personel_kullanici_resim">
							</div>
							<p class="text-muted text-center"><?php echo dil_cevir( "Fotoğraf değiştirmek için fotoğrafa tıklayınız", $dizi_dil, $sistem_dil ); ?></p>	
							<h3 class="profile-username text-center text-danger"><?php echo $tek_personel[ "adi" ]." ".$tek_personel[ "soyadi" ]; ?></h3>
							<input type="file" id="gizli_input_file" name = "input_personel_resim" style = "display:none;" name = "resim" accept="image/gif, image/jpeg, image/png"  onchange="resimOnizle(this)"; />
                        </div>
                        <div class="col-6">
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
								<select class="form-control" name = "dil" id="dil" required onchange="dil_degistir(this);">
									<option value="_tr" <?php if( $_REQUEST['dil'] == "" ) echo "selected"; ?> >Türkçe</option>
									<option value="_kz" <?php if( $_REQUEST['dil'] == "_kz" ) echo "selected"; ?> >қазақ</option>
									<option value="_en" <?php if( $_REQUEST['dil'] == "_en" ) echo "selected"; ?> >English</option>
									<option value="_ru" <?php if( $_REQUEST['dil'] == "_ru" ) echo "selected"; ?> >Россия</option>
								</select>
							</div>
                            <div class="form-group">
                                <label  class="control-label"><?php echo dil_cevir( "Personel Türü", $dizi_dil, $sistem_dil ); ?></label>
                                <select class="form-control form-control-sm select2" name = "personel_nitelik_id" >
                                    <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                    <?php foreach( $personel_nitelikleri AS $result ){ ?>
                                        <option value="<?php echo $result[ "id" ]; ?>" <?php echo $tek_personel[ "personel_nitelik_id" ] == $result[ "id" ] ? "selected" : null ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if( $_SESSION['super'] == 1 AND ($_SESSION[ 'kullanici_id' ] == 19 OR $_SESSION[ 'kullanici_id' ] == 35)  ){ ?>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "IIN No", $dizi_dil, $sistem_dil ); ?></label>
                                <input required type="text" placeholder="IIN Numarası" class="form-control form-control-sm" name ="in_no" value = "<?php echo $tek_personel[ "in_no" ]; ?>"  autocomplete="off">
                            </div>
                            <?php }else{ ?>
                            <div class="form-group d-none">
                                <label class="control-label"><?php echo dil_cevir( "IIN No", $dizi_dil, $sistem_dil ); ?></label>
                                <input disabled type="text" placeholder="IIN Numarası" class="form-control form-control-sm" name ="in_no" value = "<?php echo "********".substr($tek_personel[ "in_no" ], -4); ?>"  autocomplete="off">
                            </div>
                            <?php } ?>

                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "EPVO Tutor ID", $dizi_dil, $sistem_dil ); ?></label>
                                <input type="number"  placeholder="EPVO Tutor ID" class="form-control form-control-sm" name ="tutor_id" value = "<?php echo $tek_personel[ "tutor_id" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Vatandaşlık No", $dizi_dil, $sistem_dil ); ?></label>
                                <input  type="text" placeholder="Vatandaşlık No" class="form-control form-control-sm" name ="vatandaslik_no" value = "<?php echo $tek_personel[ "vatandaslik_no" ]; ?>"  autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Soyadı", $dizi_dil, $sistem_dil ); ?></label>
                                <input required type="text" placeholder="Soyadı" class="form-control form-control-sm" id ="demografik_bilgiler_soyadi" name ="soyadi" value = "<?php echo $tek_personel[ "soyadi" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></label>
                                <input required type="text" placeholder="Adı" class="form-control form-control-sm" id ="demografik_bilgiler_adi" name ="adi" value = "<?php echo $tek_personel[ "adi".$dil ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Baba Adı", $dizi_dil, $sistem_dil ); ?></label>
                                <input required type="text" placeholder="Baba Adı" class="form-control form-control-sm" id ="demografik_bilgiler_baba_adi" name ="baba_adi" value = "<?php echo $tek_personel[ "baba_adi" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group card card-body">
                                <label class="control-label"><?php echo dil_cevir( "Cinsiyet", $dizi_dil, $sistem_dil ); ?></label>
                                <div class='icheck-danger d-inline '>
                                    <input type='radio' class='form-control form-control-sm' id='kadin' name='cinsiyet' value="1" <?php if( $tek_personel[ "cinsiyet" ] == 1 ) echo "checked"; ?> >
                                    <label for='kadin'>
                                        <?php echo dil_cevir( "Kadın", $dizi_dil, $sistem_dil ); ?>
                                    </label>
                                </div>
                                <div class='icheck-primary d-inline'>
                                    <input type='radio' class='form-control form-control-sm' id='erkek' name='cinsiyet' value="2" <?php if( $tek_personel[ "cinsiyet" ] == 2 ) echo "checked"; ?> >
                                    <label for='erkek'>
                                        <?php echo dil_cevir( "Erkek", $dizi_dil, $sistem_dil ); ?>
                                    </label>
                                </div>
                            </div>
							<div class="form-group card card-body">
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
							<div class="form-group engel_bilgileri">
								<label class="control-label"><?php echo dil_cevir( "Engel Türü", $dizi_dil, $sistem_dil ); ?></label>
								<input type="text" class="form-control form-control-sm" id ="demografik_bilgiler_engel_turu" name ="engel_turu" value = "<?php echo $tek_personel[ "engel_turu" ]; ?>"  autocomplete="off">
							</div>
							<div class="form-group engel_bilgileri">
								<label class="control-label"><?php echo dil_cevir( "Engel Belgesi", $dizi_dil, $sistem_dil ); ?>: </label>
                                <br>
								<input  type="file" class="" id ="engel_belgesi" name ="engel_belgesi"   autocomplete="off">
							</div>
                        </div>
                        <div class="col-6">    
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Doğum Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                <div class="input-group date" id="dogum_tarihi" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#dogum_tarihi" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input  type="text" data-target="#dogum_tarihi" data-toggle="datetimepicker" name="dogum_tarihi" value="<?php if( $tek_personel[ 'dogum_tarihi' ] !='' ){echo $fn->tarihVer(($tek_personel[ 'dogum_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker1"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Doğum Yeri", $dizi_dil, $sistem_dil ); ?></label>
                                <input required type="text" placeholder="Doğum Yeri" class="form-control form-control-sm" id ="demografik_bilgiler_dogum_yeri" name ="dogum_yeri" value = "<?php echo $tek_personel[ "dogum_yeri" ]; ?>"  autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label  class="control-label"><?php echo dil_cevir( "Doğduğu Ülke", $dizi_dil, $sistem_dil ); ?></label>
                                <select class="form-control form-control-sm select2" name = "dogdugu_ulke_id" >
                                    <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                    <?php foreach( $ulkeler AS $ulke ){ ?>
                                        <option value="<?php echo $ulke[ "id" ]; ?>" <?php echo $tek_personel[ "dogdugu_ulke_id" ] == $ulke[ "id" ] ? "selected" : null ?>><?php echo $ulke['alfa2_kodu']." - ".$ulke[ "adi".$dil ]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label  class="control-label"><?php echo dil_cevir( "Ulus", $dizi_dil, $sistem_dil ); ?></label>
                                <select class="form-control form-control-sm select2" name = "ulus_id" >
                                    <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                    <?php foreach( $uluslar AS $ulus ){ ?>
                                        <option value="<?php echo $ulus[ "id" ]; ?>" <?php echo $tek_personel[ "ulus_id" ] == $ulus[ "id" ] ? "selected" : null ?>><?php echo $ulus[ "adi".$dil ]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label  class="control-label"><?php echo dil_cevir( "Uyruk", $dizi_dil, $sistem_dil ); ?></label>
                                <select class="form-control form-control-sm select2" name = "uyruk_id" >
                                    <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                    <?php foreach( $ulkeler AS $ulke ){ ?>
                                        <option value="<?php echo $ulke[ "id" ]; ?>" <?php echo $tek_personel[ "uyruk_id" ] == $ulke[ "id" ] ? "selected" : null ?>><?php echo $ulke['alfa2_kodu']." - ".$ulke[ "adi".$dil ]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group card card-body">
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

                            <div class="form-group">
                                <label  class="control-label"><?php echo dil_cevir( "Kan Grubu", $dizi_dil, $sistem_dil ); ?></label>
                                <select class="form-control form-control-sm select2" name = "kan_grubu_id" >
                                    <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                    <?php 
                                        foreach( $kan_gruplari AS $kan_grubu ){
                                            echo '<option value="'.$kan_grubu[ "id" ].'" '.( $tek_personel[ "kan_grubu_id" ] == $kan_grubu[ "id" ] ? "selected" : null) .'>'.$kan_grubu[ "adi" ].'</option>';
                                        }

                                    ?>
                                </select>
                            </div>

							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Vatandaşlık Belgesi", $dizi_dil, $sistem_dil ); ?>: </label>
                                <br>
								<input  type="file" class="" id ="vatandaslik_belgesi" name ="vatandaslik_belgesi"   autocomplete="off">
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Doğum Belgesi", $dizi_dil, $sistem_dil ); ?>: </label>
                                <br>
								<input  type="file" class="" id ="dogum_belgesi" name ="dogum_belgesi"   autocomplete="off">
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Oturma İzin Belgesi", $dizi_dil, $sistem_dil ); ?>: </label>
                                <br>
								<input  type="file" class="" id ="oturma_izin_belgesi" name ="oturma_izin_belgesi"   autocomplete="off">
							</div>

                        </div>
                        <div class="col-12">
                            <div class="card card-olive" >
                                <div class="card-header renk1">
                                    <h3 class="card-title"><?php echo dil_cevir( "Özgeçmiş", $dizi_dil, $sistem_dil ); ?></h3>
                                    <div class = "card-tools">
                                        <button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Özgeçmiş", $dizi_dil, $sistem_dil ); ?></label>
                                        <style>
                                        .ck-editor__editable_inline:not(.ck-comment__input *) {
                                            height: 400px;
                                            overflow-y: auto;
                                        }
                                        </style>

                                        <textarea id="editor" style="display:none" name="ozgecmis">
                                        <?php echo @$tek_personel[ "ozgecmis" ]; ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include "editor.php"; ?>

                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo dil_cevir( "İptal", $dizi_dil, $sistem_dil ); ?></button>
                    <button modul= 'personelDemografikBilgiler' yetki_islem="kaydet"  type="submit" class="btn btn-success"><?php echo dil_cevir( "Kaydet", $dizi_dil, $sistem_dil ); ?></button>
                </div>
            </form>
        </div>

    </div>
</div>
<div class="modal fade" id="iletisim_bilgileri" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action = "_modul/personelDetay/iletisimSEG.php" method = "POST" enctype="multipart/form-data">
                <?php foreach( array_keys($tek_personel) as $anahtar ){ ?>
                <input type="hidden" id="<?php echo "iletisim_bilgileri_gizli_".$anahtar;  ?>"  name="<?php echo $anahtar;  ?>" value="<?php echo htmlentities($tek_personel[$anahtar]);  ?>">
                <?php } ?>

                <input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
                <input type = "hidden" name = "personel_id" value = "<?php echo $personel_id; ?>">

                <div class="modal-header bg-gray-dark">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo dil_cevir( "İletişim Bilgileri", $dizi_dil, $sistem_dil ); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
							<div class="text-center">
								<img class="img-fluid img-circle img-thumbnail mw-100"
									style="width:120px; cursor:pointer;"
									src="resimler/personel_resimler/<?php echo $personel_foto; ?>" 
									alt="User profile picture"
									>
							</div>
							<h3 class="profile-username text-center text-danger"><?php echo $tek_personel[ "adi" ]." ".$tek_personel[ "soyadi" ]; ?></h3>
                        </div>
                    </div>                
                    <div class="row">
                        <div class="col-6">
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Dil", $dizi_dil, $sistem_dil ); ?></label>
								<select class="form-control" name = "dil" id="dil2" required onchange="dil_degistir2(this);">
									<option value="_tr" <?php if( $_REQUEST['dil'] == "" ) echo "selected"; ?> >Türkçe</option>
									<option value="_kz" <?php if( $_REQUEST['dil'] == "_kz" ) echo "selected"; ?> >қазақ</option>
									<option value="_en" <?php if( $_REQUEST['dil'] == "_en" ) echo "selected"; ?> >English</option>
									<option value="_ru" <?php if( $_REQUEST['dil'] == "_ru" ) echo "selected"; ?> >Россия</option>
								</select>
							</div>

                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "GSM 1", $dizi_dil, $sistem_dil ); ?></label>
                                <!-- <input required type="number" placeholder="GSM 1" class="form-control form-control-sm" name ="gsm1" value = "<?php echo $tek_personel[ "gsm1" ]; ?>"  autocomplete="off"> -->
                                <input required name ="gsm1" type="text" value = "<?php echo $tek_personel[ "gsm1" ]; ?>" placeholder="GSM 1" class="form-control form-control-sm" data-inputmask='"mask": "+7(999) 999-9999"' data-mask autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "GSM 2", $dizi_dil, $sistem_dil ); ?></label>
                                <input type="number" placeholder="GSM 2" class="form-control form-control-sm" name ="gsm2" value = "<?php echo $tek_personel[ "gsm2" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "İş Telefonu", $dizi_dil, $sistem_dil ); ?></label>
                                <!-- <input type="number" placeholder="İş Telefonu" class="form-control form-control-sm" name ="is_telefonu" value = "<?php echo $tek_personel[ "is_telefonu" ]; ?>"  autocomplete="off"> -->
                                <input name ="is_telefonu" type="text" value = "<?php echo $tek_personel[ "is_telefonu" ]; ?>" placeholder="İş Telefonu" class="form-control form-control-sm" data-inputmask='"mask": "+7(999) 999-9999"' data-mask autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Dahili Telefon", $dizi_dil, $sistem_dil ); ?></label>
                                <input type="number" placeholder="Dahili Telefonu" class="form-control form-control-sm" name ="dahili" value = "<?php echo $tek_personel[ "dahili" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?> 1</label>
                                <input required type="email" placeholder="Email 1" class="form-control form-control-sm" name ="email" value = "<?php echo $tek_personel[ "email" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?> 2</label>
                                <input type="email" placeholder="Email 2" class="form-control form-control-sm" name ="email2" value = "<?php echo $tek_personel[ "email2" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "İş Adresi", $dizi_dil, $sistem_dil ); ?></label>
                                <textarea type="text" placeholder="İş Adresi" class="form-control form-control-sm" id ="iletisim_bilgileri_is_adresi" name ="is_adresi" value = ""  autocomplete="off"><?php echo $tek_personel[ "is_adresi" ]; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Bina Adı", $dizi_dil, $sistem_dil ); ?></label>
                                <input type="text" placeholder="Bina Adı" class="form-control form-control-sm" id ="iletisim_bilgileri_bina_adi" name ="bina_adi" value = "<?php echo $tek_personel[ "bina_adi".$dil ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Kat No", $dizi_dil, $sistem_dil ); ?></label>
                                <input type="text" placeholder="Kat No" class="form-control form-control-sm" name ="kat_no" value = "<?php echo $tek_personel[ "kat_no" ]; ?>"  autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Oda No", $dizi_dil, $sistem_dil ); ?></label>
                                <input  type="text" placeholder="Oda No" class="form-control form-control-sm" name ="oda_no" value = "<?php echo $tek_personel[ "oda_no" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Ev Adresi", $dizi_dil, $sistem_dil ); ?></label>
                                <textarea type="text" placeholder="Ev Adresi" class="form-control form-control-sm" id ="iletisim_bilgileri_ev_adresi" name ="ev_adresi" value = ""  autocomplete="off"><?php echo $tek_personel[ "ev_adresi".$dil ]; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Araç Plaka", $dizi_dil, $sistem_dil ); ?> 1</label>
                                <input type="text" placeholder="Araç Plaka" class="form-control form-control-sm" name ="arac_plaka1" value = "<?php echo $tek_personel[ "arac_plaka1" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Araç Plaka", $dizi_dil, $sistem_dil ); ?> 2</label>
                                <input type="text" placeholder="Araç Plaka" class="form-control form-control-sm" name ="arac_plaka2" value = "<?php echo $tek_personel[ "arac_plaka2" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Araç Plaka", $dizi_dil, $sistem_dil ); ?> 3</label>
                                <input type="text" placeholder="Araç Plaka" class="form-control form-control-sm" name ="arac_plaka3" value = "<?php echo $tek_personel[ "arac_plaka3" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Orcid URL", $dizi_dil, $sistem_dil ); ?></label>
                                <input type="text" placeholder="Orcid" class="form-control form-control-sm" name ="orcid" value = "<?php echo $tek_personel[ "orcid" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Avesis URL", $dizi_dil, $sistem_dil ); ?></label>
                                <input type="text" placeholder="Avesis" class="form-control form-control-sm" name ="avesis" value = "<?php echo $tek_personel[ "avesis" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Google Scholar URL", $dizi_dil, $sistem_dil ); ?></label>
                                <input type="text" placeholder="Scholar" class="form-control form-control-sm" name ="scholar" value = "<?php echo $tek_personel[ "scholar" ]; ?>"  autocomplete="off">
                            </div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Yerleşim Yeri Belgesi", $dizi_dil, $sistem_dil ); ?>: </label>
								<input  type="file" class="form-control" id ="yerlesim_yeri_belgesi" name ="yerlesim_yeri_belgesi"   autocomplete="off">
							</div>


                        </div>
                    </div>                         
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo dil_cevir( "İptal", $dizi_dil, $sistem_dil ); ?></button>
                    <button modul= 'personelIletisimBilgileri' yetki_islem="kaydet" type="submit" class="btn btn-success"><?php echo dil_cevir( "Kaydet", $dizi_dil, $sistem_dil ); ?></button>
                </div>
            </form>
        </div>

    </div>
</div>
<div class="modal fade" id="pasaport_bilgileri" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action = "_modul/personelDetay/pasaportSEG.php" method = "POST" enctype="multipart/form-data">
                <input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
                <input type = "hidden" name = "personel_id" value = "<?php echo $personel_id; ?>">

                <div class="modal-header bg-gray-dark">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo dil_cevir( "Pasaport Bilgileri", $dizi_dil, $sistem_dil ); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
							<div class="text-center">
								<img class="img-fluid img-circle img-thumbnail mw-100"
									style="width:120px; cursor:pointer;"
									src="resimler/personel_resimler/<?php echo $personel_foto; ?>" 
									alt="User profile picture"
									>
							</div>
							<h3 class="profile-username text-center text-danger"><?php echo $tek_personel[ "adi" ]." ".$tek_personel[ "soyadi" ]; ?></h3>

                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Pasaport ID", $dizi_dil, $sistem_dil ); ?></label>
                                <input required type="text" placeholder="Pasaport ID" class="form-control form-control-sm" name ="pasaport_no" value = "<?php echo $tek_personel[ "pasaport_no" ]; ?>"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Pasaport Alış Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                <div class="input-group date" id="pasaport_alis_tarihi" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#pasaport_alis_tarihi" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input  type="text" data-target="#pasaport_alis_tarihi" data-toggle="datetimepicker" name="pasaport_alis_tarihi" value="<?php if( $tek_personel[ 'pasaport_alis_tarihi' ] !='' ){echo $fn->tarihVer(($tek_personel[ 'pasaport_alis_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#pasaport_alis_tarihi"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Pasaport Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                <div class="input-group date" id="pasaport_bitis_tarihi" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#pasaport_bitis_tarihi" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input  type="text" data-target="#pasaport_bitis_tarihi" data-toggle="datetimepicker" name="pasaport_bitis_tarihi" value="<?php if( $tek_personel[ 'pasaport_bitis_tarihi' ] !='' ){echo $fn->tarihVer(($tek_personel[ 'pasaport_bitis_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#pasaport_bitis_tarihi"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="control-label"><?php echo dil_cevir( "Pasaportun Alındığı Ülke", $dizi_dil, $sistem_dil ); ?></label>
                                <select class="form-control form-control-sm select2" name = "pasaportu_aldigi_ulke_id" >
                                    <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                    <?php foreach( $ulkeler AS $ulke ){ ?>
                                        <option value="<?php echo $ulke[ "id" ]; ?>" <?php echo $tek_personel[ "pasaportu_aldigi_ulke_id" ] == $ulke[ "id" ] ? "selected" : null ?>><?php echo $ulke['alfa2_kodu']." - ".$ulke[ "adi".$dil ]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label  class="control-label"><?php echo dil_cevir( "Pasaportu Veren Kurum", $dizi_dil, $sistem_dil ); ?></label>
                                <select class="form-control form-control-sm select2" name = "pasaportu_veren_kurum_id" >
                                    <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                    <?php foreach( $belgeyi_veren_kurumlar AS $result ){ ?>
                                        <option value="<?php echo $result[ "id" ]; ?>" <?php echo $tek_personel[ "pasaportu_veren_kurum_id" ] == $result[ "id" ] ? "selected" : null ?>><?php echo $result[ "adi".$dil ]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
							<div class="form-group">
								<label class="control-label"><?php echo dil_cevir( "Pasaport Belgesi", $dizi_dil, $sistem_dil ); ?>: </label>
								<input  type="file" class="form-control" id ="pasaport_dosya" name ="pasaport_dosya"   autocomplete="off">
							</div>


                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo dil_cevir( "İptal", $dizi_dil, $sistem_dil ); ?></button>
                    <button modul= 'personelPasaportBilgileri' yetki_islem="kaydet" type="submit" class="btn btn-success"><?php echo dil_cevir( "Kaydet", $dizi_dil, $sistem_dil ); ?></button>
                </div>
            </form>
        </div>

    </div>
</div>
<div class="modal fade" id="is_deneyimi_bilgileri" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action = "_modul/personelDetay/isDeneyimiSEG.php" method = "POST" enctype="multipart/form-data">
                <input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
                <input type = "hidden" name = "personel_id" value = "<?php echo $personel_id; ?>">

                <div class="modal-header bg-gray-dark">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo dil_cevir( "İş Deneyimi Bilgileri", $dizi_dil, $sistem_dil ); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
							<div class="text-center">
								<img class="img-fluid img-circle img-thumbnail mw-100"
									style="width:120px; cursor:pointer;"
									src="resimler/personel_resimler/<?php echo $personel_foto; ?>" 
									alt="User profile picture"
									>
							</div>
							<h3 class="profile-username text-center text-danger"><?php echo $tek_personel[ "adi" ]." ".$tek_personel[ "soyadi" ]; ?></h3>

                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "İlk İşe Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                <div class="input-group date" id="ilk_ise_baslama_tarihi" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#ilk_ise_baslama_tarihi" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input  type="text" data-target="#ilk_ise_baslama_tarihi" data-toggle="datetimepicker" name="ilk_ise_baslama_tarihi" value="<?php if( $tek_personel[ 'ilk_ise_baslama_tarihi' ] !='' ){echo $fn->tarihVer(($tek_personel[ 'ilk_ise_baslama_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#ilk_ise_baslama_tarihi"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "AYU İşe Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                <div class="input-group date" id="ayu_ise_baslama_tarihi" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#ayu_ise_baslama_tarihi" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input  type="text" data-target="#ayu_ise_baslama_tarihi" data-toggle="datetimepicker" name="ayu_ise_baslama_tarihi" value="<?php if( $tek_personel[ 'ayu_ise_baslama_tarihi' ] !='' ){echo $fn->tarihVer(($tek_personel[ 'ayu_ise_baslama_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#ayu_ise_baslama_tarihi"/>
                                </div>
                            </div>
                            <?php if( $tek_personel['personel_nitelik_id'] == 1 or $tek_personel['personel_nitelik_id'] == 3 ){ ?>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Öğretmenliğe Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                <div class="input-group date" id="ogretmenlik_baslama_tarihi" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#ogretmenlik_baslama_tarihi" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input  type="text" data-target="#ogretmenlik_baslama_tarihi" data-toggle="datetimepicker" name="ogretmenlik_baslama_tarihi" value="<?php if( $tek_personel[ 'ogretmenlik_baslama_tarihi' ] !='' ){echo $fn->tarihVer(($tek_personel[ 'ogretmenlik_baslama_tarihi' ] ));}//else{ echo date('d.m.Y'); } ?>" class="form-control form-control-sm datetimepicker-input" data-target="#ogretmenlik_baslama_tarihi"/>
                                </div>
                            </div>
                            <?php } ?>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo dil_cevir( "İptal", $dizi_dil, $sistem_dil ); ?></button>
                    <button modul= 'personelIsDeneyimiBilgileri' yetki_islem="kaydet" type="submit" class="btn btn-success"><?php echo dil_cevir( "Kaydet", $dizi_dil, $sistem_dil ); ?></button>
                </div>
            </form>
        </div>

    </div>
</div>
<div class="modal fade" id="birim_yetkileri" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action = "_modul/personelDetay/birimYetkileriSEG.php" method = "POST" enctype="multipart/form-data">
                <input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
                <input type = "hidden" name = "personel_id" value = "<?php echo $personel_id; ?>">

                <div class="modal-header bg-gray-dark">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo dil_cevir( "Birim Yetkileri", $dizi_dil, $sistem_dil ); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
							<div class="text-center">
								<img class="img-fluid img-circle img-thumbnail mw-100"
									style="width:120px; cursor:pointer;"
									src="resimler/personel_resimler/<?php echo $personel_foto; ?>" 
									alt="User profile picture"
									>
							</div>
							<h3 class="profile-username text-center text-danger"><?php echo $tek_personel[ "adi" ]." ".$tek_personel[ "soyadi" ]; ?></h3>

                            <div class="form-group">
                                <label  class="control-label"><?php echo dil_cevir( "Rol", $dizi_dil, $sistem_dil ); ?></label>
                                <select required class="form-control form-control-sm select2" id = "rol_id" name = "rol_id" onchange="rol_degistir(this);" >
                                    <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                    <?php foreach( $roller AS $rol ){ ?>
                                        <option value="<?php echo $rol[ "id" ]; ?>" <?php echo $tek_personel[ "rol_id" ] == $rol[ "id" ] ? "selected" : null ?>><?php echo $rol[ "adi".$dil ]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
							<div class="form-group birimleri_goster">
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
																			<input type='checkbox' class='item_$kategori[ust_id] birim_check' id='icheck_$kategori[id]' name='birim_idler[]' value='$kategori[id]' $secili  onclick='event.stopPropagation();'>
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
																			<input type='checkbox' data-id='$kategori[id]' class='kategori item_$kategori[ust_id] birim_check' id='icheck_$kategori[id]' name='birim_idler[]' value='$kategori[id]' $secili   onclick='event.stopPropagation();sec(this)'>
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
                            <script>
                                var select = document.getElementById('rol_id');
                                <?php if( isset($tek_personel['rol_id'] )){ ?>
                                    select.value = "<?php echo $tek_personel['rol_id'];  ?>";
                                <?php }?>
                                select.dispatchEvent(new Event('change'));

                                function rol_degistir(eleman){
                                    if( eleman.value == "1" ){
                                        $('.birimleri_goster').css('display','none');
                                        $('.birim_check').prop('checked', false);
                                    }else{
                                        $('.birimleri_goster').css('display','block');
                                    }
                                }

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
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo dil_cevir( "İptal", $dizi_dil, $sistem_dil ); ?></button>
                    <button modul= 'personelIsDeneyimiBilgileri' yetki_islem="kaydet" type="submit" class="btn btn-success"><?php echo dil_cevir( "Kaydet", $dizi_dil, $sistem_dil ); ?></button>
                </div>
            </form>
        </div>

    </div>
</div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-3">
            <div class="card card-gray-dark" >
              <div data-card-widget="collapse" class="card-header btn" style="">
                <h3 class="card-title"><?php echo dil_cevir( "Demografik Bilgiler", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
                <div class="card-body">
                    <div class="text-center p-1">
                    <img class="profile-user-img img-fluid img-circle"
                        src="resimler/personel_resimler/<?php echo $personel_foto; ?>"
                        alt="User profile picture">
                    </div>
                    <?php if( $tek_personel[ 'uyruk_id' ] == 113 ){ ?>
                    <h3 class="profile-username text-center"><?php echo $tek_personel[ "soyadi".$dil ]; ?> <?php echo $tek_personel[ "adi".$dil ]; ?> <?php echo $tek_personel[ "baba_adi".$dil ]; ?></h3>
                    <?php }else{ ?>
                    <h3 class="profile-username text-center"><?php echo $tek_personel[ "adi".$dil ]; ?> <?php echo $tek_personel[ "soyadi".$dil ]; ?></h3>
                    <?php } ?>
                    <p class="text-muted text-center"><?php echo $tek_personel[ "personel_nitelik_adi".$dil ]; ?></p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Baba Adı", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "baba_adi".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "IIN No", $dizi_dil, $sistem_dil ); ?></b> 
                            <?php if( $_SESSION['super'] == 1 AND ($_SESSION[ 'kullanici_id' ] == 19 OR $_SESSION[ 'kullanici_id' ] == 35) ){ ?>
                            <span class="float-right"><?php echo $tek_personel[ "in_no" ]; ?></span>
                            <?php }else{ ?>
                            <span class="float-right">************</span>
                            <?php } ?>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Vatandaşlık No", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "vatandaslik_no" ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Doğum Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($tek_personel[ 'dogum_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Doğum Yeri", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "dogum_yeri".$dil ]; ?></span>
                        </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Doğduğu Ülke", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><?php echo $tek_personel[ "dogdugu_ulke".$dil ]; ?></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Uyruk", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><?php echo $tek_personel[ "uyruk".$dil ]; ?></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Ulus", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><?php echo $tek_personel[ "ulus".$dil ]; ?></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Cinsiyet", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><?php echo ($tek_personel[ "cinsiyet" ] == 1 ) ? dil_cevir( "Kadın", $dizi_dil, $sistem_dil ): dil_cevir( "Erkek", $dizi_dil, $sistem_dil ) ; ?></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Kan Grubu", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><?php echo $tek_personel[ "kan_grubu"]; ?></span>
                                </li>
                        <div class="collapse" id="collapseExample">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Medeni Durum", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><?php echo ($tek_personel[ "medeni_durumu" ] == 1 ) ? dil_cevir( "Bekar", $dizi_dil, $sistem_dil ): dil_cevir( "Evli", $dizi_dil, $sistem_dil ) ; ?></span>
                                </li>
                                <?php if( $tek_personel[ "engel_durumu" ] == 2 ){ ?>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Engel Durumu", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><?php echo ($tek_personel[ "engel_durumu" ] == 1 ) ? dil_cevir( "Yok", $dizi_dil, $sistem_dil ): dil_cevir( "Var", $dizi_dil, $sistem_dil ) ; ?></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Engel Türü", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><?php echo $tek_personel[ "engel_turu".$dil ]; ?></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Engellilik Belgesi", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><a href="belgeler/<?php echo $tek_personel[ "engel_belgesi" ]; ?>" target="_blank"><?php echo ($tek_personel[ "engel_belgesi" ] != "" ) ? dil_cevir( "İndir", $dizi_dil, $sistem_dil ): "" ; ?></a></span>
                                </li>
                                <?php } ?>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Vatandaşlık Belgesi", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><a href="belgeler/<?php echo $tek_personel[ "vatandaslik_belgesi" ]; ?>" target="_blank"><?php echo ($tek_personel[ "vatandaslik_belgesi" ] != "" ) ? dil_cevir( "İndir", $dizi_dil, $sistem_dil ): "" ; ?></a></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Doğum Belgesi", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><a href="belgeler/<?php echo $tek_personel[ "dogum_belgesi" ]; ?>" target="_blank"><?php echo ($tek_personel[ "dogum_belgesi" ] != "" ) ? dil_cevir( "İndir", $dizi_dil, $sistem_dil ): "" ; ?></a></span>
                                </li>
                                <?php if( $tek_personel[ "uyruk_id" ] != 113 ){ ?>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Oturma İzin Belgesi", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><a href="belgeler/<?php echo $tek_personel[ "oturma_izin_belgesi" ]; ?>" target="_blank"><?php echo ($tek_personel[ "oturma_izin_belgesi" ] != "" ) ? dil_cevir( "İndir", $dizi_dil, $sistem_dil ): "" ; ?></a></span>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </ul>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                </div>
                <div class="card-footer">
                  <button modul= 'personelDemografikBilgiler' yetki_islem="duzenle" type="button" class="btn btn-dark btn-sm" onclick="$('#demografik_bilgiler').modal('show');"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></button>
                </div>
            </div>
          </div>
          <div class="col-md-3">
            <!-- Form Element sizes -->
            <div class="card card-purple" >
              <div data-card-widget="collapse" class="card-header btn renk1"  >
                <h3 class="card-title"><?php echo dil_cevir( "İletişim Bilgileri", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- /.card-header renk1 -->
              <!-- form start -->
                <div class="card-body">
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "GSM 1", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "gsm1" ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "GSM 2", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "gsm2" ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "İş Telefonu", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "is_telefonu" ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Dahili Telefon", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "dahili" ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?> 1</b> 
                            <span class="float-right"><?php echo $tek_personel[ "email" ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?> 2</b> 
                            <span class="float-right"><?php echo $tek_personel[ "email2" ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "İş Adresi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "is_adresi".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Bina Adı", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "bina_adi".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Kat No", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "kat_no" ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Oda No", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "oda_no" ]; ?></span>
                        </li>
                        <div class="collapse" id="collapseExample4">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Orcid URL", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><a href="<?php echo $tek_personel[ "orcid" ]; ?>" target="_blank"><?php echo $tek_personel[ "orcid" ]; ?></a></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Avesis URL", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><a href="<?php echo $tek_personel[ "avesis" ]; ?>" target="_blank"><?php echo $tek_personel[ "avesis" ]; ?></a></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Google Scholar URL", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><a href="<?php echo $tek_personel[ "scholar" ]; ?>" target="_blank"><?php echo $tek_personel[ "scholar" ]; ?></a></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Ev Adresi", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><?php echo $tek_personel[ "ev_adresi".$dil ]; ?></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Araç Plaka", $dizi_dil, $sistem_dil ); ?> 1</b> 
                                    <span class="float-right"><?php echo $tek_personel[ "arac_plaka1" ]; ?></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Araç Plaka", $dizi_dil, $sistem_dil ); ?> 2</b> 
                                    <span class="float-right"><?php echo $tek_personel[ "arac_plaka2" ]; ?></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Araç Plaka", $dizi_dil, $sistem_dil ); ?> 3</b> 
                                    <span class="float-right"><?php echo $tek_personel[ "arac_plaka3" ]; ?></span>
                                </li>
                                <li class="list-group-item list-group-item-action pt-2 pb-2">
                                    <b><?php echo dil_cevir( "Yerleşim Yeri Belgesi", $dizi_dil, $sistem_dil ); ?></b> 
                                    <span class="float-right"><a href="belgeler/<?php echo $tek_personel[ "yerlesim_yeri_belgesi" ]; ?>" target="_blank"><?php echo ($tek_personel[ "yerlesim_yeri_belgesi" ] != "" ) ? dil_cevir( "İndir", $dizi_dil, $sistem_dil ): "" ; ?></a></span>
                                </li>
                            </ul>
                        </div>
                    </ul>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample4">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button modul= 'personelIletisimBilgileri' yetki_islem="duzenle" type="button" class="btn bg-purple btn-sm" onclick="$('#iletisim_bilgileri').modal('show');"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></button>
                </div>
            </div>
            <div class="card card-danger">
              <div data-card-widget="collapse" class="card-header btn renk2">
                <h3 class="card-title"><?php echo dil_cevir( "Eğitim Bilgileri", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <!-- <a  onclick='event.stopPropagation();' modul= 'personelEgitimBilgileri' yetki_islem="duzenle" href="?modul=personelEgitimBilgileri&personel_id=<?php echo $personel_id; ?>" class="btn btn-tool"  ><i class="fas fa-edit"></i></a> -->

                </div>
              </div>
                <div class="card-body">
                    <?php $sira=0; foreach( $egitim_bilgileri AS $result ){ $sira++; 
                        if( $sira == 2 ){
                            echo "<div class='collapse' id='collapseExample2'>";
                        }
                    ?>
                    <li class="list-group-item list-group-item-action pt-2 pb-2 border-0 text-center text-red">
                        <b><?php echo $result[ "egitim_duzeyi_adi".$dil ]; ?></b>
                    </li>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2 <?php echo !in_array( $result[ "egitim_duzeyi_id" ], array(17,18,19) ) ? "d-none": ""; ?>">
                            <b><?php echo dil_cevir( "Belge Adı", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "belge_adi".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Ülke", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "ulke_adi".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2 <?php echo !in_array( $result[ "egitim_duzeyi_id" ], array(15,16,17,18,19) ) ? "d-none": ""; ?>">
                            <b><?php echo dil_cevir( "Kurum Adı", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "kurum_adi".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2 <?php echo !in_array( $result[ "egitim_duzeyi_id" ], array(15) ) ? "d-none": ""; ?>">
                            <b><?php echo dil_cevir( "Doçentlik Alanı", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "docentlik_alani".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2 <?php echo !in_array( $result[ "egitim_duzeyi_id" ], array(1,2,3,4,5,6,7,8,9,10,11,12,13,14) ) ? "d-none": ""; ?>">
                            <b><?php echo dil_cevir( "Okul", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "okul_adi".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2 <?php echo !in_array( $result[ "egitim_duzeyi_id" ], array(1,2,3,4,5,6,7,8,9,10,11,12,13,14) ) ? "d-none": ""; ?>">
                            <b><?php echo dil_cevir( "Fakülte/Enstitü", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "fakulte".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2 <?php echo !in_array( $result[ "egitim_duzeyi_id" ], array(1,2,3,4,5,6,7,8,9,10,11,12,13,14) ) ? "d-none": ""; ?>">
                            <b><?php echo dil_cevir( "Bölüm/Anabilim Dalı", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "bolum".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2 <?php echo !in_array( $result[ "egitim_duzeyi_id" ], array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,18) ) ? "d-none": ""; ?>">
                            <b><?php echo dil_cevir( "Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'baslama_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2 <?php echo !in_array( $result[ "egitim_duzeyi_id" ], array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,18) ) ? "d-none": ""; ?>">
                            <b><?php echo dil_cevir( "Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'bitis_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2 <?php echo !in_array( $result[ "egitim_duzeyi_id" ], array(15,16,17 ,19) ) ? "d-none": ""; ?>">
                            <b><?php echo dil_cevir( "Belge Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'belge_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Belge", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><a href="belgeler/<?php echo $result[ "belge" ]; ?>"><?php echo dil_cevir( "İndir", $dizi_dil, $sistem_dil ); ?> <i class="fas fa-file-pdf"></i></a></span>
                        </li>
                    </ul>
                    <?php 
                        if( $sira > 1 and $sira == count( $egitim_bilgileri ) ){
                            echo "</div>";
                        } 
                    ?>
                    <?php } ?>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                    
                </div>
                <div class="card-footer">
                  <a modul= 'personelEgitimBilgileri' yetki_islem="duzenle" href="?modul=personelEgitimBilgileri&personel_id=<?php echo $personel_id; ?>" class="btn btn-danger btn-sm "  ><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></a>
                </div>
            </div>
            <!-- Input addon -->
            <div class="card card-primary" >
              <div data-card-widget="collapse" class="card-header btn renk3">
                <h3 class="card-title"><?php echo dil_cevir( "İdari Görevler", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- /.card-header renk1 -->
              <!-- form start -->
                <div class="card-body">
                    <?php $sira=0; foreach( $gorevler AS $result ){ $sira++; 
                        if( $sira == 3 ){
                            echo "<div class='collapse' id='collapseExample11'>";
                        }
                    ?>
                    <li class="list-group-item list-group-item-action pt-2 pb-2 border-0 text-center text-red">
                        <b><?php echo $result[ "gorev_adi".$dil ]; ?></b>
                    </li>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Birim", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "birim_adi".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Açıklama", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ 'gorev_aciklama'.$dil ]; ?></span>
                        </li>
                    </ul>
                    <?php 
                        if( $sira > 2 and $sira == count( $gorevler ) ){
                            echo "</div>";
                        } 
                    ?>
                    <?php } ?>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample11" role="button" aria-expanded="false" aria-controls="collapseExample2">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a modul= 'personelGorevBilgileri' yetki_islem="duzenle" href="?modul=personelGorevBilgileri&personel_id=<?php echo $personel_id; ?>" class="btn btn-primary btn-sm"  ><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></a>
                </div>
            </div>
            <!-- general form elements disabled -->
            <div class="card card-orange" >
              <div data-card-widget="collapse" class="card-header btn renk4">
                <h3 class="card-title text-white"><?php echo dil_cevir( "Ştat Bilgileri", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus text-white"></i></button>
                </div>
              </div>
              <!-- /.card-header renk1 -->
              <!-- form start -->
                <div class="card-body">
                    <?php $sira=0; foreach( $statlar AS $result ){ $sira++; 
                        if( $sira == 2 ){
                            echo "<div class='collapse' id='collapseExample10'>";
                        }
                    ?>
                    <li class="list-group-item list-group-item-action pt-2 pb-2 border-0 text-center text-red">
                        <b><?php echo $result[ "egitim_ogretim_yili" ]; ?></b>
                    </li>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Birim", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "birim_adi".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "İstihdam Türü", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "istihdam_turu".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'baslama_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'bitis_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Belge", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><a href="belgeler/<?php echo $result[ "belge" ]; ?>" target="_blank"><?php echo ($result[ "belge" ] != "" ) ? dil_cevir( "İndir", $dizi_dil, $sistem_dil ): "" ; ?></a></span>
                        </li>
                    </ul>
                    <?php 
                        if( $sira > 1 and $sira == count( $statlar ) ){
                            echo "</div>";
                        } 
                    ?>
                    <?php } ?>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample10" role="button" aria-expanded="false" aria-controls="collapseExample2">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a modul= 'personelStatBilgileri' yetki_islem="duzenle" href="?modul=personelStatBilgileri&personel_id=<?php echo $personel_id; ?>" class="btn bg-orange btn-sm "  ><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></a>
                </div>
            </div>
            <!-- general form elements disabled -->
            <div class="card card-danger" >
              <div data-card-widget="collapse" class="card-header btn renk5">
                <h3 class="card-title"><?php echo dil_cevir( "Ödüller", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- /.card-header renk1 -->
              <!-- form start -->
                <div class="card-body">
                    <?php $sira=0; foreach( $oduller AS $result ){ $sira++; 
                        if( $sira == 2 ){
                            echo "<div class='collapse' id='collapseExample13'>";
                        }
                    ?>
                    <li class="list-group-item list-group-item-action pt-2 pb-2 border-0 text-center text-red">
                        <b><?php echo $result[ "odul_adi".$dil ]; ?></b>
                    </li>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Ödül Türü", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "odul_turu".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Ödülü Veren Kurum", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "odulu_veren_kurum".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Ödül Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'odul_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Ödül Belgesi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><a href="belgeler/<?php echo $result[ "belge" ]; ?>" target="_blank"><?php echo ($result[ "belge" ] != "" ) ? dil_cevir( "İndir", $dizi_dil, $sistem_dil ): "" ; ?></a></span>
                        </li>
                    </ul>
                    <?php 
                        if( $sira > 1 and $sira == count( $oduller ) ){
                            echo "</div>";
                        } 
                    ?>
                    <?php } ?>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample13" role="button" aria-expanded="false" aria-controls="collapseExample13">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a modul= 'personelOdulBilgileri' yetki_islem="duzenle" href="?modul=personelOdulBilgileri&personel_id=<?php echo $personel_id; ?>" class="btn btn-danger btn-sm"  ><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></a>
                </div>
            </div>
            <!-- /.card -->
            <form class="form-horizontal was-validated" action = "_modul/personelDetay/sifreSEG.php" method = "POST" enctype="multipart/form-data" oninput='sifre_tekrar.setCustomValidity(sifre_tekrar.value != sifre.value ? "<?php echo dil_cevir( "Şifreler eşleşmiyor.", $dizi_dil, $sistem_dil ); ?>" : "")'>
            <div class="card card-purple" >
              <div data-card-widget="collapse" class="card-header btn renk6">
                <h3 class="card-title"><?php echo dil_cevir( "Şifre Değiştir", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- /.card-header renk1 -->
              <!-- form start -->
                    <div class="card-body">
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Yeni Şifre", $dizi_dil, $sistem_dil ); ?></label>
                                <input type="hidden" name="islem" value="guncelle">
                                <input type="hidden" name="personel_id" value="<?php echo $personel_id; ?>">
                                <input required type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="<?php echo dil_cevir( "Şifre en az 8 karakterden oluşmalı ve içinde en az bir rakam, bir büyük, bir küçük karakter içermelidir.", $dizi_dil, $sistem_dil ); ?>" placeholder="" class="form-control form-control-sm" name ="sifre"  autocomplete="off">
                                <div class="invalid-feedback">
                                    <?php echo dil_cevir( "Şifre en az 8 karakterden oluşmalı ve içinde en az bir rakam, bir büyük, bir küçük karakter içermelidir.", $dizi_dil, $sistem_dil ); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Yeni Şifre Tekrar", $dizi_dil, $sistem_dil ); ?></label>
                                <input required type="password" placeholder="" class="form-control form-control-sm" name ="sifre_tekrar"  autocomplete="off">
                                <div class="invalid-feedback">
                                    <?php echo dil_cevir( "Şifreler eşleşmiyor.", $dizi_dil, $sistem_dil ); ?>
                                </div>                            
                            </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button modul= 'personelSifreIslemleri' yetki_islem="kaydet" type="submit" class="btn bg-purple btn-sm"><span class="fa fa-save"></span> <?php echo dil_cevir( "Kaydet", $dizi_dil, $sistem_dil ); ?></button>
                    </div>
            </div>
            </form>


          </div>
          <div class="col-md-3">

            <div class="card card-olive" >
              <div data-card-widget="collapse" class="card-header btn renk7">
                <h3 class="card-title"><?php echo dil_cevir( "Pasaport Bilgileri", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Pasaport ID", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "pasaport_no" ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Pasaport Alış Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($tek_personel[ 'pasaport_alis_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Pasaport Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($tek_personel[ 'pasaport_bitis_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Pasaportun Alındığı Ülke", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "p_ulke".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Pasaportu Veren Kurum", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "pasaportu_veren_kurum".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Pasaport Belgesi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><a href="belgeler/<?php echo $tek_personel[ "pasaport_dosya" ]; ?>"><?php echo dil_cevir( "İndir", $dizi_dil, $sistem_dil ); ?></a></span>
                        </li>
                    </ul>
              </div>
                <div class="card-footer">
                  <button modul= 'personelPasaportBilgileri' yetki_islem="duzenle" type="button" class="btn bg-olive btn-sm" onclick="$('#pasaport_bilgileri').modal('show');"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></button>
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card card-orange" >
              <div data-card-widget="collapse" class="card-header btn renk8">
                <h3 class="card-title text-white"><?php echo dil_cevir( "Doçent / Profesör Bilgileri", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus text-white"></i></button>
                </div>
              </div>
              <!-- /.card-header renk1 -->
              <!-- form start -->
                <div class="card-body">
                    <?php $sira=0; foreach( $akademik_bilgiler AS $result ){ $sira++; 
                        unset($uzmanlik_alanlari2);
                        unset($uzmanlik_alanlari3);
                        unset($uzmanlik_alanlari4);
                        $uzmanlik_alanlari2 = explode(",", $result[ 'uzmanlik_alan_idler' ]);
                        foreach( $uzmanlik_alanlari2 as $uzmanlik_alani_id ){
                            $uzmanlik_alanlari = $vt->selectSingle( $SQL_personel_uzmanlik_alanlari, array( $uzmanlik_alani_id ) )[ 2 ];	
                            $uzmanlik_alanlari3[]    = '<span class="badge badge-success">'.$uzmanlik_alanlari['kodu']." - ".$uzmanlik_alanlari['adi'].'</span>';
                            $uzmanlik_alanlari3_kz[] = '<span class="badge badge-success">'.$uzmanlik_alanlari['kodu']." - ".$uzmanlik_alanlari['adi_kz'].'</span>';
                            $uzmanlik_alanlari3_en[] = '<span class="badge badge-success">'.$uzmanlik_alanlari['kodu']." - ".$uzmanlik_alanlari['adi_en'].'</span>';
                            $uzmanlik_alanlari3_ru[] = '<span class="badge badge-success">'.$uzmanlik_alanlari['kodu']." - ".$uzmanlik_alanlari['adi_ru'].'</span>';
                        }
                        $uzmanlik_alanlari4['adi'] = implode(" ", $uzmanlik_alanlari3);
                        $uzmanlik_alanlari4['adi_kz'] = implode(" ", $uzmanlik_alanlari3_kz);
                        $uzmanlik_alanlari4['adi_en'] = implode(" ", $uzmanlik_alanlari3_en);
                        $uzmanlik_alanlari4['adi_ru'] = implode(" ", $uzmanlik_alanlari3_ru);

                        if( $sira == 2 ){
                            echo "<div class='collapse' id='collapseExample14'>";
                        }
                    ?>

                    <li class="list-group-item list-group-item-action pt-2 pb-2 border-0 text-center text-red">
                        <b><?php echo $result[ "akademik_unvan" ]; ?></b>
                    </li>
                    <ul class="list-group list-group-unbordered mb-3">
                        <?php if( $result[ 'akademik_unvan_id' ] == 2 ){ ?>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Doçentlik Alanı", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ 'docentlik_alani'.$dil ]; ?></span>
                        </li>
                        <?php } ?>
                        <!-- <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Bilimsel Alanı", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ 'bilimsel_alani'.$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Uzmanlık Alanı", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $uzmanlik_alanlari4['adi'.$dil]; ?></span>
                        </li> -->
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Belgeyi Veren Kurum", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "kurum_adi".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Belge Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'belge_tarihi' ] )); ?></span>
                        </li>

                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Belge", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><a href="belgeler/<?php echo $result[ "belge" ]; ?>" target="_blank"><?php echo ($result[ "belge" ] != "" ) ? dil_cevir( "İndir", $dizi_dil, $sistem_dil ): "" ; ?></a></span>
                        </li>
                    <?php 
                        if( $sira > 1 and $sira == count( $akademik_bilgiler ) ){
                            echo "</div>";
                        } 
                    ?>
                    <?php } ?>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample14" role="button" aria-expanded="false" aria-controls="collapseExample14">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a modul= 'personelAkademikUnvanBilgileri' yetki_islem="duzenle"  href="?modul=personelAkademikUnvanBilgileri&personel_id=<?php echo $personel_id; ?>" class="btn bg-orange btn-sm" style="color:white !important;" >
                    <?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
                  </a>
                </div>
            </div>

            <div class="card card-danger" >
              <div data-card-widget="collapse" class="card-header btn renk9">
                <h3 class="card-title"><?php echo dil_cevir( "Sözleşme Bilgileri", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
                <div class="card-body">
                    <?php $sira=0; foreach( $sozlesmeler AS $result ){ $sira++; 
                        if( $sira == 2 ){
                            echo "<div class='collapse' id='collapseExample7'>";
                        }
                    ?>
                    <li class="list-group-item list-group-item-action pt-2 pb-2 border-0 text-center text-red">
                        <b><?php echo $result[ "egitim_ogretim_yili" ]; ?></b>
                    </li>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Sözleşme Türü", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "sozlesme_turu".$dil ]; ?></span>
                        </li>
                        <?php if( $result[ 'sozlesme_turu_id' ] == 1 ){ ?>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "İstihdam Türü", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "istihdam_turu".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Hizmet Türü", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "hizmet_turu".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'baslama_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'bitis_tarihi' ] )); ?></span>
                        </li>
                        <?php } ?>
                        <?php if( $result[ 'sozlesme_turu_id' ] == 2 ){ ?>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "İşten Ayrılma Nedeni", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "isten_cikis_nedeni".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "İşten Çıkış Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'isten_ayrilma_tarihi' ] )); ?></span>
                        </li>
                        <?php } ?>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Buyruk", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><a href="belgeler/<?php echo $result[ "belge" ]; ?>" target="_blank"><?php echo ($result[ "belge" ] != "" ) ? dil_cevir( "İndir", $dizi_dil, $sistem_dil ): "" ; ?></a></span>
                        </li>
                    </ul>
                    <?php 
                        if( $sira > 1 and $sira == count( $sozlesmeler ) ){
                            echo "</div>";
                        } 
                    ?>
                    <?php } ?>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample7" role="button" aria-expanded="false" aria-controls="collapseExample2">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                </div>
                <div class="card-footer">
                  <a modul= 'personelSozlesmeBilgileri' yetki_islem="duzenle" href="?modul=personelSozlesmeBilgileri&personel_id=<?php echo $personel_id; ?>" class="btn btn-danger btn-sm"  ><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></a>
                </div>
            </div>
            <!-- /.card -->
            <div class="card card-teal" >
              <div data-card-widget="collapse" class="card-header btn renk10">
                <h3 class="card-title"><?php echo dil_cevir( "İzin Bilgileri", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- /.card-header renk1 -->
              <!-- form start -->
                <div class="card-body">
                    <?php $sira=0; foreach( $izinler AS $result ){ $sira++; 
                        if( $sira == 2 ){
                            echo "<div class='collapse' id='collapseExample5'>";
                        }
                    ?>
                    <li class="list-group-item list-group-item-action pt-2 pb-2 border-0 text-center text-red">
                        <b><?php echo $result[ "egitim_ogretim_yili" ]; ?></b>
                    </li>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "İzin Türü", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "izin_turu".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "İzin Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'baslama_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "İzin Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'bitis_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "İzin Belgesi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><a href="belgeler/<?php echo $result[ "belge" ]; ?>" target="_blank"><?php echo ($result[ "belge" ] != "" ) ? dil_cevir( "İndir", $dizi_dil, $sistem_dil ): "" ; ?></a></span>
                        </li>
                    </ul>
                    <?php 
                        if( $sira > 1 and $sira == count( $izinler ) ){
                            echo "</div>";
                        } 
                    ?>
                    <?php } ?>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample5" role="button" aria-expanded="false" aria-controls="collapseExample2">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a modul= 'personelIzinBilgileri' yetki_islem="duzenle" href="?modul=personelIzinBilgileri&personel_id=<?php echo $personel_id; ?>" class="btn bg-teal btn-sm"  ><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></a>

                </div>
            </div>

            <div class="card card-info" >
              <div data-card-widget="collapse" class="card-header btn renk11">
                <h3 class="card-title"><?php echo dil_cevir( "Emekli Bilgileri", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- /.card-header renk1 -->
              <!-- form start -->
                <div class="card-body">
                    <?php $sira=0; foreach( $emekli_bilgileri AS $result ){ $sira++; 
                        if( $sira == 2 ){
                            echo "<div class='collapse' id='collapseExample8'>";
                        }
                    ?>
                    <li class="list-group-item list-group-item-action pt-2 pb-2 border-0 text-center text-red">
                        <b><?php echo $result[ "egitim_ogretim_yili" ]; ?></b>
                    </li>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Emeklilik Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'emeklilik_tarihi' ] )); ?></span>
                        </li>

                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Emeklilik Belgesi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><a href="belgeler/<?php echo $result[ "belge" ]; ?>" target="_blank"><?php echo ($result[ "belge" ] != "" ) ? dil_cevir( "İndir", $dizi_dil, $sistem_dil ): "" ; ?></a></span>
                        </li>
                    </ul>
                    <?php 
                        if( $sira > 1 and $sira == count( $emekli_bilgileri ) ){
                            echo "</div>";
                        } 
                    ?>
                    <?php } ?>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample8" role="button" aria-expanded="false" aria-controls="collapseExample2">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a modul= 'personelEmekliBilgileri' yetki_islem="duzenle" href="?modul=personelEmekliBilgileri&personel_id=<?php echo $personel_id; ?>" class="btn btn-info btn-sm"  ><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></a>
                </div>
            </div>

            <div class="card card-olive" >
              <div data-card-widget="collapse" class="card-header btn renk17">
                <h3 class="card-title"><?php echo dil_cevir( "Birim Yetkileri", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Rol", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $tek_personel[ "rol_adi" ]; ?></span>
                        </li>
							<div class="form-group birimleri_goster">
								<label  class="control-label"><?php echo dil_cevir( "Birimler", $dizi_dil, $sistem_dil ); ?></label>
								<div class="overflow-auto" >
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
														
														if( in_array( $kategori['id'], explode( ",", $gelen_birim_id ) ) ){
															$secili = "checked";
														}else{
															$secili = "";
														}

														if( $kategori['kategori'] == 0){
															$html .= "
																	<tr>
																		<td class=' bg-renk7' >
																			<input disabled type='checkbox' class='item_$kategori[ust_id] birim_check' id='icheck_$kategori[id]' name='birim_idler[]' value='$kategori[id]' $secili  onclick='event.stopPropagation();'>
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
																			<input disabled type='checkbox' data-id='$kategori[id]' class='kategori item_$kategori[ust_id] birim_check' id='icheck_$kategori[id]' name='birim_idler[]' value='$kategori[id]' $secili   onclick='event.stopPropagation();sec(this)'>
																			$kategori[adi]
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
											if( count( $birim_agacilar2 ) ) 
												echo kategoriListele4($birim_agacilar2,0,0, $vt, $tek_personel[ "birim_idler" ], $ust_id_dizi, $sistem_dil);
											

										?>
									</tbody>
									</table>
								</div>
							</div>

                    </ul>
              </div>
                <div class="card-footer">
                  <button modul= 'personelBirimYetkileri' yetki_islem="duzenle" type="button" class="btn bg-olive btn-sm" onclick="$('#birim_yetkileri').modal('show');"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></button>
                </div>
              <!-- /.card-body -->
            </div>

            <!-- /.card -->
            <!-- general form elements -->
            <!-- Input addon -->

          </div>
          <div class="col-md-3">

            <div class="card card-info" >
              <div data-card-widget="collapse" class="card-header btn renk12">
                <h3 class="card-title"><?php echo dil_cevir( "İş Deneyimi", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "İlk İşe Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($tek_personel[ 'ilk_ise_baslama_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "AYU İşe Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($tek_personel[ 'ayu_ise_baslama_tarihi' ] )); ?></span>
                        </li>
                        <?php if( $tek_personel['personel_nitelik_id'] == 1 or $tek_personel['personel_nitelik_id'] == 3 ){ ?>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Öğretmenliğe Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($tek_personel[ 'ogretmenlik_baslama_tarihi' ] )); ?></span>
                        </li>
                        <?php } ?>
                    </ul>
              </div>
                <div class="card-footer">
                  <button modul= 'personelIsDeneyimiBilgileri' yetki_islem="duzenle" type="button" class="btn bg-info btn-sm" onclick="$('#is_deneyimi_bilgileri').modal('show');"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></button>
                </div>
              <!-- /.card-body -->
            </div>
            <div class="card card-purple">
              <div data-card-widget="collapse" class="card-header btn renk13">
                <h3 class="card-title text-white"><?php echo dil_cevir( "Asıl Kadro Yeri", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- /.card-header renk1 -->
              <!-- form start -->
                <div class="card-body">
                    <?php $sira=0; foreach( $calisma_yeri_bilgileri AS $result ){ $sira++; 
                        unset($uzmanlik_alanlari2);
                        unset($uzmanlik_alanlari3);
                        unset($uzmanlik_alanlari4);
                        $uzmanlik_alanlari2 = explode(",", $result[ 'uzmanlik_alan_idler' ]);
                        foreach( $uzmanlik_alanlari2 as $uzmanlik_alani_id ){
                            $uzmanlik_alanlari = $vt->selectSingle( $SQL_personel_uzmanlik_alanlari, array( $uzmanlik_alani_id ) )[ 2 ];	
                            $uzmanlik_alanlari3[]    = '<span class="badge badge-success">'.$uzmanlik_alanlari['kodu']." - ".$uzmanlik_alanlari['adi'].'</span>';
                            $uzmanlik_alanlari3_kz[] = '<span class="badge badge-success">'.$uzmanlik_alanlari['kodu']." - ".$uzmanlik_alanlari['adi_kz'].'</span>';
                            $uzmanlik_alanlari3_en[] = '<span class="badge badge-success">'.$uzmanlik_alanlari['kodu']." - ".$uzmanlik_alanlari['adi_en'].'</span>';
                            $uzmanlik_alanlari3_ru[] = '<span class="badge badge-success">'.$uzmanlik_alanlari['kodu']." - ".$uzmanlik_alanlari['adi_ru'].'</span>';
                        }
                        $uzmanlik_alanlari4['adi'] = implode(" ", $uzmanlik_alanlari3);
                        $uzmanlik_alanlari4['adi_kz'] = implode(" ", $uzmanlik_alanlari3_kz);
                        $uzmanlik_alanlari4['adi_en'] = implode(" ", $uzmanlik_alanlari3_en);
                        $uzmanlik_alanlari4['adi_ru'] = implode(" ", $uzmanlik_alanlari3_ru);


                        if( $sira == 2 ){
                            echo "<div class='collapse' id='collapseExample3'>";
                        }
                    ?>

                    <li class="list-group-item list-group-item-action pt-2 pb-2 border-0 text-center text-red">
                        <b><?php echo $result[ "egitim_ogretim_yili" ]; ?></b>
                    </li>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Birim", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "birim_adi".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Personel Türü", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ 'personel_nitelik'.$dil ]; ?></span>
                        </li>
                        <?php if( $result[ 'personel_nitelik_id' ] == 1 OR $result[ 'personel_nitelik_id' ] == 3 ){ ?>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Akademik Kadro Tipi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ 'akademik_kadro_tipi'.$dil ]; ?></span>
                        </li>
                        <?php }else{ ?>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "İdari Kadro Tipi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ 'idari_kadro_tipi'.$dil ]; ?></span>
                        </li>
                        <?php } ?>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Akademik Kadro Derecesi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ 'akademik_derece'.$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Akademik Unvanı", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ 'akademik_unvan'.$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'baslama_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'bitis_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Bilimsel Alanı", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ 'bilimsel_alani'.$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Uzmanlık Alanı", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $uzmanlik_alanlari4['adi'.$dil]; ?></span>
                        </li>

                    </ul>
                    <?php 
                        if( $sira > 1 and $sira == count( $calisma_yeri_bilgileri ) ){
                            echo "</div>";
                        } 
                    ?>
                    <?php } ?>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a modul="personelCalismaYeriBilgileri" yetki_islem="duzenle" href="?modul=personelCalismaYeriBilgileri&personel_id=<?php echo $personel_id; ?>" class="btn bg-purple btn-sm" style="color:white !important;" >
                    <?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
                  </a>
                </div>
            </div>
            <div class="card card-purple" >
              <div data-card-widget="collapse" class="card-header btn renk14">
                <h3 class="card-title"><?php echo dil_cevir( "Buyruk Bilgileri", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- /.card-header renk1 -->
              <!-- form start -->
                <div class="card-body">
                    <?php $sira=0; foreach( $buyruklar AS $result ){ $sira++; 
                        if( $sira == 2 ){
                            echo "<div class='collapse' id='collapseExample9'>";
                        }
                    ?>
                    <li class="list-group-item list-group-item-action pt-2 pb-2 border-0 text-center text-red">
                        <b><?php echo $result[ "egitim_ogretim_yili" ]; ?></b>
                    </li>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Buyruk Türü", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "buyruk_turu".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Buyruk No", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "buyruk_no" ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Buyruk Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'buyruk_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Buyruk Belgesi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><a href="belgeler/<?php echo $result[ "belge" ]; ?>" target="_blank"><?php echo ($result[ "belge" ] != "" ) ? dil_cevir( "İndir", $dizi_dil, $sistem_dil ): "" ; ?></a></span>
                        </li>
                    </ul>
                    <?php 
                        if( $sira > 1 and $sira == count( $buyruklar ) ){
                            echo "</div>";
                        } 
                    ?>
                    <?php } ?>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample9" role="button" aria-expanded="false" aria-controls="collapseExample2">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a modul= 'personelBuyrukBilgileri' yetki_islem="duzenle" href="?modul=personelBuyrukBilgileri&personel_id=<?php echo $personel_id; ?>" class="btn bg-purple btn-sm"  ><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></a>
                </div>
            </div>

            <div class="card card-olive" >
              <div data-card-widget="collapse" class="card-header btn renk15">
                <h3 class="card-title"><?php echo dil_cevir( "Sertifika ve Staj Bilgileri", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- /.card-header renk1 -->
              <!-- form start -->
                <div class="card-body">
                    <?php $sira=0; foreach( $sertifika_bilgileri AS $result ){ $sira++; 
                        if( $sira == 2 ){
                            echo "<div class='collapse' id='collapseExample12'>";
                        }
                    ?>
                    <li class="list-group-item list-group-item-action pt-2 pb-2 border-0 text-center text-red">
                        <b><?php echo $result[ "adi".$dil ]; ?></b>
                    </li>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Ülke", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "ulke_adi".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Kurum", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $result[ "kurum_adi".$dil ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'baslama_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($result[ 'bitis_tarihi' ] )); ?></span>
                        </li>

                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Belge", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><a href="belgeler/<?php echo $result[ "belge" ]; ?>" target="_blank"><?php echo ($result[ "belge" ] != "" ) ? dil_cevir( "İndir", $dizi_dil, $sistem_dil ): "" ; ?></a></span>
                        </li>
                    </ul>
                    <?php 
                        if( $sira > 1 and $sira == count( $sertifika_bilgileri ) ){
                            echo "</div>";
                        } 
                    ?>
                    <?php } ?>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample12" role="button" aria-expanded="false" aria-controls="collapseExample12">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a modul= 'personelSertifikaBilgileri' yetki_islem="duzenle" href="?modul=personelSertifikaBilgileri&personel_id=<?php echo $personel_id; ?>" class="btn bg-olive btn-sm"  ><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></a>
                </div>
            </div>
            <!-- /.card -->
            <div class="card card-secondary" >
              <div data-card-widget="collapse" class="card-header btn renk16">
                <h3 class="card-title"><?php echo dil_cevir( "Vize Bilgileri", $dizi_dil, $sistem_dil ); ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool kucult" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- /.card-header renk1 -->
              <!-- form start -->
                <div class="card-body">
                    <?php $sira=0; foreach( $vizeler AS $vize ){ $sira++; 
                        if( $sira == 2 ){
                            echo "<div class='collapse' id='collapseExample6'>";
                        }
                    ?>
                    <li class="list-group-item list-group-item-action pt-2 pb-2 border-0 text-center text-red">
                        <b><?php echo $vize[ "egitim_ogretim_yili" ]; ?></b>
                    </li>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Eğitim Öğretim Yılı", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $vize[ "egitim_ogretim_yili" ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Belgeyi Veren Kurum", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $vize[ "belgeyi_veren_kurum" ]; ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Vize Başlama Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($vize[ 'baslama_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Vize Bitiş Tarihi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><?php echo $fn->tarihVer(($vize[ 'bitis_tarihi' ] )); ?></span>
                        </li>
                        <li class="list-group-item list-group-item-action pt-2 pb-2">
                            <b><?php echo dil_cevir( "Vize Belgesi", $dizi_dil, $sistem_dil ); ?></b> 
                            <span class="float-right"><a href="belgeler/<?php echo $vize[ "belge" ]; ?>"><?php echo dil_cevir( "İndir", $dizi_dil, $sistem_dil ); ?> <i class="fas fa-file-pdf"></i></a></span>
                        </li>
                    </ul>
                    <?php 
                        if( $sira > 1 and $sira == count( $vizeler ) ){
                            echo "</div>";
                        } 
                    ?>
                    <?php } ?>
                    <a class="d-flex justify-content-center" data-toggle="collapse" href="#collapseExample6" role="button" aria-expanded="false" aria-controls="collapseExample2">
                        <?php echo dil_cevir( "Tümünü Göster", $dizi_dil, $sistem_dil ); ?>
                    </a>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a modul= 'personelVizeBilgileri' yetki_islem="duzenle" href="?modul=personelVizeBilgileri&personel_id=<?php echo $personel_id; ?>" class="btn btn-secondary btn-sm"  ><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></a>
                </div>
            </div>








          </div>

          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
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
		$('#pasaport_alis_tarihi').datetimepicker({
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
		$('#pasaport_bitis_tarihi').datetimepicker({
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
		$('#ilk_ise_baslama_tarihi').datetimepicker({
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
		$('#ayu_ise_baslama_tarihi').datetimepicker({
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
		$('#ogretmenlik_baslama_tarihi').datetimepicker({
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

<script>
    $('.modalAc').on("click", function(e) { 
        var modal 		= $(this).data("modal");

        var kategori_ad = $(this).data("kategori_ad_duzenle");
        var modal 		= $(this).data("modal");
        var kategori 	= $(this).data("kategori");
        var grup	 	= $(this).data("grup_duzenle");
        var islem 		= $(this).data("islem");
        var birim_agaci_id = $(this).data("id");

        if ( kategori == 1 ) {
            document.getElementById("kategori_mi_duzenle").checked = true;
        }else{
            document.getElementById("kategori_mi_duzenle").checked = false;
        }

        if ( grup == 1 ) {
            document.getElementById("grup_duzenle").checked = true;
        }else{
            document.getElementById("grup_duzenle").checked = false;
        }

        document.getElementById("birim_agaci_id").value 		 	= birim_agaci_id;
        document.getElementById("kategori_ad_duzenle").value 	= kategori_ad;
        document.getElementById("islem").value 					= islem;
            
        $('#'+ modal).modal( "show" );
    });
</script>
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
				document.getElementById("demografik_bilgiler_adi").value            = document.getElementById("demografik_bilgiler_gizli_adi"+dil).value           
				document.getElementById("demografik_bilgiler_soyadi").value         = document.getElementById("demografik_bilgiler_gizli_soyadi"+dil).value        
				document.getElementById("demografik_bilgiler_engel_turu").value     = document.getElementById("demografik_bilgiler_gizli_engel_turu"+dil).value    
				document.getElementById("demografik_bilgiler_baba_adi").value       = document.getElementById("demografik_bilgiler_gizli_baba_adi"+dil).value      
				document.getElementById("demografik_bilgiler_dogum_yeri").value     = document.getElementById("demografik_bilgiler_gizli_dogum_yeri"+dil).value    
				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				window.editor.data.set(document.getElementsByName("ozgecmis"+dil)[0].value);
			<?php } ?>
		}
	</script>
	<script>
		var select2 = document.getElementById('dil2');
		<?php if( isset($_REQUEST['dil'] )){ ?>
			select2.value = "<?php echo $_REQUEST['dil'];  ?>";
		<?php }else{ ?>
			select2.value = "<?php echo $sistem_dil;  ?>";
		<?php } ?>

		<?php if( isset($_REQUEST['sistem_dil'] )){ ?>
			select2.value = "<?php echo $_REQUEST['sistem_dil'];  ?>";
		<?php } ?>

		select2.dispatchEvent(new Event('change'));

		function dil_degistir2(eleman){
			//alert("<?php echo $islem; ?>");
			if( eleman.value == "_tr" ) dil = ""; else dil = eleman.value;
			<?php if( $islem == "guncelle" ){ ?>
				document.getElementById("iletisim_bilgileri_is_adresi").value            = document.getElementById("iletisim_bilgileri_gizli_is_adresi"+dil).value           
				document.getElementById("iletisim_bilgileri_ev_adresi").value            = document.getElementById("iletisim_bilgileri_gizli_ev_adresi"+dil).value        
				document.getElementById("iletisim_bilgileri_bina_adi").value             = document.getElementById("iletisim_bilgileri_gizli_bina_adi"+dil).value    
				//document.getElementById("editor").value = document.getElementsByName("icerik"+dil)[0].value;
				window.editor.data.set(document.getElementsByName("ozgecmis"+dil)[0].value);
			<?php } ?>
		}
	</script>
    <script>
        if( document.getElementsByName("engel_durumu")[0].value == 1 ){
            $('.engel_bilgileri').css('display','none');
        }else if( document.getElementsByName("engel_durumu")[0].value == 2 ){
            $('.engel_bilgileri').css('display','block');
        }else{
            $('.engel_bilgileri').css('display','none');
        }

        function egitim_bilgileri_degistir(eleman){
            if( eleman.value == "1" ){
                $('.engel_bilgileri').css('display','none');
            }else if( eleman.value == "2" ){
                $('.engel_bilgileri').css('display','block');
            }else{
                $('.engel_bilgileri').css('display','none');
            }
        }
    </script>

<script>
    $( ".kucult" ).trigger( "click" );
</script>
<script>
<?php if( $_SESSION['super'] == 1 ){ ?>
   $('form').find(':input,:radio,:checkbox').removeAttr('required');
<?php } ?>
</script>