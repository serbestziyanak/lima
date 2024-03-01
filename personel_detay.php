<?php  

$SQL_personel_detay = <<< SQL
SELECT
     gk.adi as gorev
    ,gk.adi_kz as gorev_kz
    ,gk.adi_en as gorev_en
    ,gk.adi_ru as gorev_ru
    ,g.gorev_aciklama
    ,g.gorev_aciklama_kz
    ,g.gorev_aciklama_en
    ,g.gorev_aciklama_ru
    ,p.*
    ,u.adi as unvan
    ,u.adi_kz as unvan_kz
    ,u.adi_en as unvan_en
    ,u.adi_ru as unvan_ru
FROM 
    tb_personeller AS p
LEFT JOIN tb_gorevler AS g ON p.id = g.personel_id
LEFT JOIN tb_unvanlar as u ON p.unvan_id = u.id
LEFT JOIN tb_gorev_kategorileri AS gk ON g.gorev_kategori_id = gk.id
WHERE
  g.birim_id = 1 AND p.id = ?
SQL;

$SQL_birim_sayfa_sss = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfa_icerikleri_sss
WHERE
  sayfa_id = ? 
SQL;

$SQL_birim_sayfa_personel = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfa_icerikleri_personeller
WHERE
  sayfa_id = ? 
SQL;

@$personel_bilgileri         = $vt->selectSingle($SQL_personel_detay, array( $_REQUEST['personel_id'] ) )[ 2 ];
@$sayfa_sssler       = $vt->select($SQL_birim_sayfa_sss, array( $sayfa_id ) )[ 2 ];
@$sayfa_personeller  = $vt->select($SQL_birim_sayfa_personel, array( $sayfa_id ) )[ 2 ];

if( $personel_bilgileri['id'] < 1 ){
    header('Location: /404/');
}
    if( $birim_sayfa_bilgileri['kategori'] == 1 ){
        @$alt_menuler = $vt->select($SQL_alt_sayfalari_getir, array( $birim_sayfa_bilgileri['id'] ) )[ 2 ];
        $birim_sayfa_adi = $birim_sayfa_bilgileri['adi'.$dil];
        $birim_sayfa_kisa_ad = $birim_sayfa_bilgileri['kisa_ad'];
        $birim_sayfa_id = $birim_sayfa_bilgileri['id'];
    }else{
        @$alt_menuler = $vt->select($SQL_alt_sayfalari_getir, array( $birim_sayfa_bilgileri['ust_id'] ) )[ 2 ];
        @$birim_sayfa_bilgileri_id = $vt->selectSingle($SQL_birim_sayfa_bilgileri_id, array( $birim_sayfa_bilgileri['ust_id'] ) )[ 2 ];
        $birim_sayfa_adi = $birim_sayfa_bilgileri_id['adi'.$dil];
        $birim_sayfa_kisa_ad = $birim_sayfa_bilgileri_id['kisa_ad'];
        $birim_sayfa_id = $birim_sayfa_bilgileri_id['id'];
    }

    $personel_gorev = $personel_bilgileri['gorev'.$dil] ;
    if( $personel_bilgileri['gorev'.$dil] == "" ){
        if( $personel_bilgileri['gorev'] != "" ) 
            $personel_gorev = $personel_bilgileri['gorev'] ;
        elseif( $personel_bilgileri['gorev_kz'] != "" )
            $personel_gorev = $personel_bilgileri['gorev_kz'] ;
        elseif( $personel_bilgileri['gorev_en'] != "" )
            $personel_gorev = $personel_bilgileri['gorev_en'] ;
        else
            $personel_gorev = $personel_bilgileri['gorev_ru'] ;
    }
    
    if( $personel_bilgileri['gorev_aciklama'.$dil] != "" ){
        $personel_gorev = $personel_bilgileri['gorev_aciklama'.$dil] ;
    }
?>
        <!--=====================================-->
        <!--=       Breadcrumb Area Start      =-->
        <!--=====================================-->

        <div class="edu-breadcrumb-area breadcrumb-style-3 bg-image" style="background-image: url(assets/images/bg/bg-image-37.webp);">
            <div class="container">
                <div class="breadcrumb-inner">
                    <ul class="edu-breadcrumb">
                        <?php $sira = 0; foreach( $sayfa_ust_bilgiler_dizi as $sayfa_ust_bilgi_dizi ){
                            $sira++; 
                            if( $sira == count( $sayfa_ust_bilgiler_dizi ) ){
                        ?>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $sayfa_ust_bilgi_dizi["adi".$dil]; ?></li>
                        <?php }else{ ?>
                        <li class="breadcrumb-item"><a href="<?php echo $_REQUEST['dil']."/".$sayfa_ust_bilgi_dizi["id"]."/".$sayfa_ust_bilgi_dizi["kisa_ad"]; ?>"><?php echo $sayfa_ust_bilgi_dizi["adi".$dil]; ?></a></li>
                        <li class="separator"><i class="icon-angle-right"></i></li>
                        <?php } ?>
                        <?php } ?>
                        <!-- <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="separator"><i class="icon-angle-right"></i></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo @$birim_sayfa_bilgileri['adi'.$dil]; ?></li> -->
                    </ul>
                    <div class="page-title">
                        <h1 class="title"><?php echo $personel_gorev; ?></h1>
                    </div>
                    <ul class="course-meta">
                        <li><i class="icon-58"></i><?php echo $birim_sayfa_adi; ?></li>
                        <li><i class="icon-59"></i><?php echo strtoupper($_REQUEST['dil']); ?></li>
                        <li class="course-rating">
                            <div class="rating">
                                <i class="icon-23"></i>
                                <i class="icon-23"></i>
                                <i class="icon-23"></i>
                                <i class="icon-23"></i>
                                <i class="icon-23"></i>
                            </div>
                            <span class="rating-count"></span>
                        </li>
                    </ul>
                </div>
            </div>
            <ul class="shape-group">
                <li class="shape-1">
                    <span></span>
                </li>
                <li class="shape-2 scene"><img data-depth="2" src="assets/images/about/shape-13.png" alt="shape"></li>
                <li class="shape-3 scene"><img data-depth="-2" src="assets/images/about/shape-15.png" alt="shape"></li>
                <li class="shape-4">
                    <span></span>
                </li>
                <li class="shape-5 scene"><img data-depth="2" src="assets/images/about/shape-07.png" alt="shape"></li>
            </ul>
        </div>
        <div class="edu-team-details-area section-gap-equal" style="padding: 35px 0 120px;">
            <div class="container">
            <!-- Fontawesome Icon -->
            <link rel="stylesheet" href="https://test.ayu.edu.kz/birimler/assets/css/fontawesome.min.css">
            <!-- Magnific Popup -->
            <!-- Theme Custom CSS -->
            <link rel="stylesheet" href="assets/css/team.css">
                <div class="team-details-about-info">
                    <div class="row gx-40">
                        <div class="col-lg-4 position-relative">
                            <div class="team-details-thumb">
                                <img src="admin/resimler/personel_resimler/<?php echo $personel_bilgileri['foto']; ?>" alt="team image">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="about-box">
                                <div class="about-info">
                                    <h5 class="title"><?php echo $personel_bilgileri['unvan'.$dil]." ".$personel_bilgileri['adi'.$dil]." ".$personel_bilgileri['soyadi'.$dil]; ?></h5>
                                    <p class="desig"><?php echo $personel_gorev; ?></p>
                                </div>
                                <div class="th-social style2">
                                    <a target="_blank" href="<?php echo $genel_ayarlar['facebook']; ?>"><i class="fab fa-facebook-f"></i></a>
                                    <a target="_blank" href="<?php echo $genel_ayarlar['twitter']; ?>"><i class="fab fa-twitter"></i></a>
                                    <a target="_blank" href="<?php echo $genel_ayarlar['instagram']; ?>"><i class="fab fa-instagram"></i></a>
                                    <a target="_blank" href="<?php echo $genel_ayarlar['linkedin']; ?>"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                            <p>
                                <?php echo nl2br($personel_bilgileri['profil_kisa_aciklama'.$dil]); ?>
                            </p>
                            <!--div class="about-quality">
                                <div class="quality-box">
                                    <span class="quality-text">Course: 4</span>
                                    <span class="quality-text">Students: 50</span>
                                </div>
                                <div class="quality-box">
                                    <span class="quality-text">Reviews:</span>
                                    <div class="course-rating">
                                        <div class="star-rating" role="img" aria-label="Rated 4.00 out of 5">
                                            <span style="width:79%">Rated <strong class="rating">4.00</strong> out of 5</span>
                                        </div>
                                        4.00 (70)
                                    </div>
                                </div>
                                <div class="quality-box">
                                    <span class="quality-text">Experiance:</span>
                                    <span class="quality-text">10 Years</span>
                                </div>
                            </div-->
                            <div class="about-contact-wrap" style="border-top: 1px solid #ECF1F9;border-bottom: 1px solid #ECF1F9;padding: 25px 0px;">
                                <div class="about-contact">
                                    <div class="about-contact-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="about-contact-details">
                                        <span class="about-contact-subtitle"><?php echo dil_cevir( "Telefon", $dizi_dil, $_REQUEST["dil"] ); ?>:</span>
                                        <h6 class="about-contact-title" style="font-size:16px;">
                                            <a href="tel:<?php echo $personel_bilgileri['is_telefonu']; ?>"><?php echo $personel_bilgileri['is_telefonu']; ?></a>
                                        </h6>
                                    </div>
                                </div>
                                <div class="about-contact">
                                    <div class="about-contact-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="about-contact-details">
                                        <span class="about-contact-subtitle"><?php echo dil_cevir( "Email", $dizi_dil, $_REQUEST["dil"] ); ?>:</span>
                                        <h6 class="about-contact-title" style="font-size:16px;">
                                            <a href="mailto:<?php echo $personel_bilgileri['email']; ?>"><?php echo $personel_bilgileri['email']; ?></a>
                                        </h6>
                                    </div>
                                </div>
                                <div class="about-contact">
                                    <div class="about-contact-icon">
                                        <i class="fa-solid fa-chair"></i>
                                    </div>
                                    <div class="about-contact-details">
                                        <span class="about-contact-subtitle"><?php echo dil_cevir( "Oda No", $dizi_dil, $_REQUEST["dil"] ); ?>:</span>
                                        <h6 class="about-contact-title" style="font-size:16px;">
                                            <?php echo $personel_bilgileri['oda_no']; ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-top">
                    <div class="row">
                        <?php  
                        if( $personel_bilgileri["ozgecmis".$dil] != "" ){
                            $col1 = "8";
                            $col2 = "4";
                            $col3 = "12";
                        ?>
                        <div class="col-lg-<?php echo $col1; ?>">
                            <!-- <h3 class="title h4 fw-semibold mt-n1">Biography</h3> -->
                            <p>
                                <?php echo $personel_bilgileri["ozgecmis".$dil]; ?>
                            </p>
                            <!--div class="row gy-4 mb-60">
                                <div class="col-md-4">
                                    <div class="skill-card">
                                        <h4 class="skill-card-number"><span class="counter-number">100</span>%</h4>
                                        <p class="skill-card-title">Professional Teacher</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="skill-card">
                                        <h4 class="skill-card-number"><span class="counter-number">22</span></h4>
                                        <p class="skill-card-title">Best Teacher Awards Win </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="skill-card">
                                        <h4 class="skill-card-number"><span class="counter-number">10</span></h4>
                                        <p class="skill-card-title">Government Certificate</p>
                                    </div>
                                </div>
                            </div-->
                        </div>
                        <?php 
                        }else{
                            $col1 = "12";
                            $col2 = "12";
                            $col3 = "6";
                        } 
                        ?>
                        <div class="col-lg-<?php echo $col2; ?>">
                            <form method="POST" class="th-team-form bg-smoke mt-50 mt-lg-0">
                                <input type="hidden" name="to_email" value="<?php echo $personel_bilgileri['email']; ?>">
                                <div class="form-title mb-30 text-center">
                                    <h3 class="fw-semibold mt-n1"><?php echo dil_cevir( "Bize Yazın", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                                    <p><?php echo dil_cevir( "Aşağıdaki formu doldurarak bize mesaj gönderebilirsiniz.", $dizi_dil, $_REQUEST["dil"] ); ?></p>
                                </div>
                                <div class="row">
                                    <div class="col-<?php echo $col3; ?> pb-4">
                                        <div class="form-group">
                                            <input type="text" name="name" placeholder="<?php echo dil_cevir( "Adı Soyadı", $dizi_dil, $_REQUEST["dil"] ); ?>" class="form-control style-white">
                                            <i class="fal fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="col-<?php echo $col3; ?> pb-4">
                                        <div class="form-group">
                                            <input type="mail" name="email" placeholder="<?php echo dil_cevir( "E - Posta", $dizi_dil, $_REQUEST["dil"] ); ?>" class="form-control style-white">
                                            <i class="fal fa-envelope"></i>
                                        </div>
                                    </div>
                                    <div class="col-<?php echo $col3; ?> pb-4">
                                        <input type="text" name="subject" placeholder="<?php echo dil_cevir( "Konu", $dizi_dil, $_REQUEST["dil"] ); ?>" class="form-control style-white">
                                    </div>
                                    <div class="col-<?php echo $col3; ?> pb-4">
                                        <div class="form-group">
                                            <input type="number" name="number" placeholder="<?php echo dil_cevir( "Telefon", $dizi_dil, $_REQUEST["dil"] ); ?>" class="form-control style-white">
                                            <i class="fal fa-phone-flip"></i>
                                        </div>
                                    </div>
                                    <div class="col-12 pb-4">
                                        <div class="form-group">
                                            <textarea placeholder="<?php echo dil_cevir( "Mesaj", $dizi_dil, $_REQUEST["dil"] ); ?>" name="message" class="form-control style-white"></textarea>
                                            <i class="fal fa-pencil"></i>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="th-btn w-100" type="button" onclick="gonder();"><?php echo dil_cevir( "Mesaj Gönder", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="fas fa-arrow-right ms-2"></i></button>
                                    </div>
                                    <div class="col-12">
                                        <div id="mesaj" class="text-success pt-4"></mesaj>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
    

        </div>
<script>
	function gonder() {
		$.ajax( {
			 url	: "mail.php"
			,type	: "POST"
			,data	: $('form').serialize()
			,success	: function( sonuc ) {
				$( "#mesaj" ).html( sonuc );
			}
			,error		: function() {
				$( "#mesaj" ).html( "Mesaj Gönderilemedi" ); 
			}
		} );
	}
</script>